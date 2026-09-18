from flask import Flask, jsonify, request
from flask_cors import CORS
import mysql.connector
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)
CORS(app)

# Database connection
def get_db_connection():
    try:
        return mysql.connector.connect(
            host='localhost',
            user='root',
            password='',
            database='e_com',
            charset='utf8mb4'
        )
    except Exception as e:
        print(f"Database connection error: {e}")
        return None


# ---------------------------------------------------------------
# Content-Based helper: builds a numeric feature vector for every
# product using scikit-learn (MinMaxScaler + one-hot encoding),
# then uses cosine_similarity to find the closest products.
# ---------------------------------------------------------------
def build_product_feature_matrix(cursor):
    cursor.execute("SELECT product_id, product_price, cat_id, p_cat_id FROM products")
    rows = cursor.fetchall()
    df = pd.DataFrame(rows)

    if df.empty:
        return None, None

    # Fill missing category values so one-hot encoding doesn't break
    df['cat_id'] = df['cat_id'].fillna(0).astype(int)
    df['p_cat_id'] = df['p_cat_id'].fillna(0).astype(int)
    df['product_price'] = df['product_price'].fillna(0).astype(float)

    # 1) Normalize price to 0-1 with scikit-learn's MinMaxScaler
    scaler = MinMaxScaler()
    price_scaled = scaler.fit_transform(df[['product_price']])

    # 2) One-hot encode category & subcategory
    cat_dummies = pd.get_dummies(df['cat_id'], prefix='cat')
    pcat_dummies = pd.get_dummies(df['p_cat_id'], prefix='pcat')

    # 3) Combine into one feature matrix. Category/subcategory are weighted
    #    much higher than price so cosine_similarity groups products by
    #    "what kind of product it is" first, and only uses price as a
    #    tie-breaker within the same category (avoids matching a cheap
    #    grooming item to an unrelated cheap skincare item just on price).
    CATEGORY_WEIGHT = 5.0
    feature_matrix = np.hstack([
        price_scaled,                          # weight 1
        cat_dummies.values * CATEGORY_WEIGHT,  # weight 5
        pcat_dummies.values * CATEGORY_WEIGHT, # weight 5
    ])

    return df['product_id'].values, feature_matrix


# Minimum cosine similarity score for a product to count as "genuinely
# relevant" content-based match. With CATEGORY_WEIGHT=5, a same-category
# product scores close to 1.0, while a different-category product scores
# close to 0. 0.3 comfortably separates "same/related category" from
# "just happens to have a similar price".
CB_SIMILARITY_THRESHOLD = 0.3


def get_similar_product_ids(cursor, product_id, n):
    """Uses cosine_similarity on the scikit-learn feature matrix to find
    up to n genuinely similar products. Returns fewer than n (even zero)
    if that's all that's actually relevant — never pads with unrelated
    products just to hit the count."""
    product_ids, feature_matrix = build_product_feature_matrix(cursor)
    if product_ids is None or product_id not in product_ids:
        return []

    idx = np.where(product_ids == product_id)[0][0]

    # Cosine similarity between this product's vector and every other product
    sims = cosine_similarity(feature_matrix[idx].reshape(1, -1), feature_matrix)[0]

    # Rank all products by similarity score, excluding itself and anything
    # below the relevance threshold
    ranked_idx = np.argsort(sims)[::-1]
    ranked_idx = [
        i for i in ranked_idx
        if product_ids[i] != product_id and sims[i] >= CB_SIMILARITY_THRESHOLD
    ]

    return [int(product_ids[i]) for i in ranked_idx[:n]]


def get_recommendations_for_user(cursor, user_id, n):
    """Builds a 'user profile vector' by averaging the feature vectors of
    products the user has already purchased, then uses cosine_similarity
    to rank not-yet-purchased products against that profile. Only returns
    products above the relevance threshold — if the user's history only
    matches 3 relevant products, this returns 3, not n padded with junk."""
    cursor.execute("""
        SELECT DISTINCT product_id FROM customer_order
        WHERE customer_id = %s
        ORDER BY order_date DESC
        LIMIT 10
    """, (user_id,))
    purchased = [r['product_id'] for r in cursor.fetchall()]

    if not purchased:
        return []

    product_ids, feature_matrix = build_product_feature_matrix(cursor)
    if product_ids is None:
        return []

    purchased_idx = [i for i, pid in enumerate(product_ids) if pid in purchased]
    if not purchased_idx:
        return []

    # Average feature vector of everything the user has bought = their "profile"
    user_profile = feature_matrix[purchased_idx].mean(axis=0).reshape(1, -1)

    sims = cosine_similarity(user_profile, feature_matrix)[0]
    ranked_idx = np.argsort(sims)[::-1]
    ranked_idx = [
        i for i in ranked_idx
        if product_ids[i] not in purchased and sims[i] >= CB_SIMILARITY_THRESHOLD
    ]

    return [int(product_ids[i]) for i in ranked_idx[:n]]


def fetch_products_by_ids(cursor, ids):
    if not ids:
        return []
    placeholders = ','.join(['%s'] * len(ids))
    cursor.execute(f"SELECT * FROM products WHERE product_id IN ({placeholders})", tuple(ids))
    rows = cursor.fetchall()
    # keep the ranking order returned by cosine_similarity
    order = {pid: i for i, pid in enumerate(ids)}
    rows.sort(key=lambda r: order.get(r['product_id'], 999))
    return rows


@app.route('/')
def home():
    return jsonify({
        'status': 'running',
        'message': 'AI Recommendation Engine (Hybrid CF + CB with scikit-learn)',
        'endpoints': {
            '/recommend?user_id=5&n=6': 'Get recommendations for user',
            '/popular?n=6': 'Get popular products',
            '/similar?product_id=21&n=6': 'Get similar products'
        }
    })


@app.route('/recommend')
def recommend():
    user_id = request.args.get('user_id', type=int)
    n = request.args.get('n', default=6, type=int)

    print(f"Recommendation request: user_id={user_id}, n={n}")

    if not user_id:
        return jsonify({'products': [], 'error': 'user_id required'})

    try:
        conn = get_db_connection()
        if not conn:
            return jsonify({'products': [], 'error': 'Database connection failed'})

        cursor = conn.cursor(dictionary=True)

        # --- Step 1: Collaborative Filtering ---
        # Find customers who bought the same products as this user,
        # then see what else those similar customers bought.
        cursor.execute("""
            SELECT co2.product_id, COUNT(*) as freq
            FROM customer_order co1
            JOIN customer_order co2
              ON co1.customer_id != co2.customer_id
             AND co1.product_id = co2.product_id
            JOIN customer_order co3
              ON co3.customer_id = co2.customer_id
            WHERE co1.customer_id = %s
              AND co3.product_id NOT IN (
                  SELECT product_id FROM customer_order WHERE customer_id = %s
              )
            GROUP BY co2.product_id
            ORDER BY freq DESC
            LIMIT %s
        """, (user_id, user_id, n))
        cf_results = cursor.fetchall()
        cf_ids = [r['product_id'] for r in cf_results]
        print(f"CF matches: {len(cf_ids)}")

        recommended_ids = list(cf_ids)
        cf_count = len(recommended_ids)
        cb_count = 0
        pop_count = 0

        # --- Step 2: Content-Based Filtering (scikit-learn) fills remaining slots ---
        if len(recommended_ids) < n:
            cb_ids = get_recommendations_for_user(cursor, user_id, n * 2)
            before = len(recommended_ids)
            for pid in cb_ids:
                if pid not in recommended_ids:
                    recommended_ids.append(pid)
                if len(recommended_ids) >= n:
                    break
            cb_count = len(recommended_ids) - before
            print(f"CB filled up to: {len(recommended_ids)}")

        # --- Step 3: Popularity fallback ONLY if there's nothing relevant at all ---
        # (i.e. brand new user with zero purchase history and zero CF/CB matches).
        # If CF+CB already found 1, 3, or 5 genuinely relevant products, we show
        # exactly that many — we do NOT pad with unrelated popular products just
        # to reach n.
        if len(recommended_ids) == 0:
            cursor.execute("""
                SELECT p.product_id, COUNT(co.product_id) as order_count
                FROM products p
                LEFT JOIN customer_order co ON p.product_id = co.product_id
                GROUP BY p.product_id
                ORDER BY order_count DESC, p.product_id DESC
                LIMIT %s
            """, (n,))
            pop_rows = cursor.fetchall()
            recommended_ids.extend([r['product_id'] for r in pop_rows])
            pop_count = len(pop_rows)
            print(f"Popularity fallback filled up to: {len(recommended_ids)}")

        products = fetch_products_by_ids(cursor, recommended_ids[:n])

        cursor.close()
        conn.close()

        # Build an honest, human-readable source label based on what actually happened
        parts = []
        if cf_count > 0:
            parts.append(f"cf({cf_count})")
        if cb_count > 0:
            parts.append(f"cb({cb_count})")
        if pop_count > 0:
            parts.append(f"popularity({pop_count})")
        source_label = "+".join(parts) if parts else "empty"

        return jsonify({
            'products': products,
            'source': source_label,
            'breakdown': {
                'collaborative_filtering': cf_count,
                'content_based_scikit_learn': cb_count,
                'popularity_fallback': pop_count
            }
        })

    except Exception as e:
        print(f"Error in recommend: {str(e)}")
        return jsonify({'products': [], 'error': str(e)})



@app.route('/popular')
def popular():
    n = request.args.get('n', default=6, type=int)
    print(f"Popular request: n={n}")

    try:
        conn = get_db_connection()
        if not conn:
            return jsonify({'products': [], 'error': 'Database connection failed'})

        cursor = conn.cursor(dictionary=True)

        cursor.execute("""
            SELECT p.*, COUNT(co.product_id) as order_count
            FROM products p
            LEFT JOIN customer_order co ON p.product_id = co.product_id
            GROUP BY p.product_id
            ORDER BY order_count DESC, p.product_id DESC
            LIMIT %s
        """, (n,))

        products = cursor.fetchall()
        print(f"Popular products found: {len(products)}")

        cursor.close()
        conn.close()

        return jsonify({'products': products, 'source': 'popularity'})

    except Exception as e:
        print(f"Error in popular: {str(e)}")
        return jsonify({'products': [], 'error': str(e)})


@app.route('/similar')
def similar():
    product_id = request.args.get('product_id', type=int)
    n = request.args.get('n', default=6, type=int)

    print(f"Similar request: product_id={product_id}, n={n}")

    if not product_id:
        return jsonify({'products': [], 'error': 'product_id required'})

    try:
        conn = get_db_connection()
        if not conn:
            return jsonify({'products': [], 'error': 'Database connection failed'})

        cursor = conn.cursor(dictionary=True)

        # scikit-learn cosine_similarity based content matching
        similar_ids = get_similar_product_ids(cursor, product_id, n)

        if not similar_ids:
            # fallback: same category, random pick
            cursor.execute("SELECT cat_id, p_cat_id FROM products WHERE product_id = %s", (product_id,))
            product = cursor.fetchone()
            if product:
                query = "SELECT product_id FROM products WHERE product_id != %s"
                params = [product_id]
                conditions = []
                if product['cat_id']:
                    conditions.append("cat_id = %s")
                    params.append(product['cat_id'])
                if product['p_cat_id']:
                    conditions.append("p_cat_id = %s")
                    params.append(product['p_cat_id'])
                if conditions:
                    query += " AND (" + " OR ".join(conditions) + ")"
                query += f" ORDER BY RAND() LIMIT {n}"
                cursor.execute(query, params)
                similar_ids = [r['product_id'] for r in cursor.fetchall()]

        products = fetch_products_by_ids(cursor, similar_ids)

        cursor.close()
        conn.close()

        return jsonify({'products': products, 'source': 'content_based_cosine_similarity'})

    except Exception as e:
        print(f"Error in similar: {str(e)}")
        return jsonify({'products': [], 'error': str(e)})


if __name__ == '__main__':
    print("=" * 50)
    print("  Shopixia AI Recommendation Engine")
    print("  Hybrid: Collaborative Filtering + scikit-learn Content-Based")
    print("  Running at http://localhost:5000")
    print("  Endpoints:")
    print("    GET /recommend?user_id=5&n=6")
    print("    GET /similar?product_id=21&n=6")
    print("    GET /popular?n=6")
    print("=" * 50)
    app.run(host='0.0.0.0', port=5000, debug=True)