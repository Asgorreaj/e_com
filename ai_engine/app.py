"""
StyleHub AI Recommendation Engine
===================================
Hybrid Recommendation System:
  - Content-Based Filtering (product similarity by category + price)
  - Collaborative Filtering (user order history similarity)

Run:  python app.py
API:  GET http://localhost:5000/recommend?user_id=5&n=6
      GET http://localhost:5000/similar?product_id=21&n=6
      GET http://localhost:5000/popular?n=6
"""

from flask import Flask, request, jsonify
import mysql.connector
import numpy as np
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.preprocessing import MinMaxScaler
import json

app = Flask(__name__)

# ── Database connection ──────────────────────────────────────────
DB_CONFIG = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "e_com"
}

def get_db():
    return mysql.connector.connect(**DB_CONFIG)

# ── Load all products from DB ─────────────────────────────────────
def load_products():
    db = get_db()
    cursor = db.cursor(dictionary=True)
    cursor.execute("""
        SELECT p.product_id, p.product_title, p.product_price,
               p.product_img1, p.product_keyword,
               p.cat_id, p.p_cat_id,
               c.cat_title
        FROM products p
        LEFT JOIN categories c ON p.cat_id = c.cat_id
        WHERE p.product_id IS NOT NULL
    """)
    products = cursor.fetchall()
    cursor.close()
    db.close()
    return products

# ── Load user's order history ─────────────────────────────────────
def load_user_orders(user_id):
    db = get_db()
    cursor = db.cursor(dictionary=True)
    cursor.execute("""
        SELECT co.product_id, co.qty
        FROM customer_order co
        WHERE co.customer_id = %s
    """, (user_id,))
    orders = cursor.fetchall()
    cursor.close()
    db.close()
    return orders

# ── Build product feature matrix (Content-Based) ──────────────────
def build_feature_matrix(products):
    """
    Features per product:
      - Normalised price
      - One-hot encoded cat_id (up to 20 categories)
      - One-hot encoded p_cat_id (up to 30 sub-categories)
    """
    if not products:
        return np.array([]), []

    product_ids = [p["product_id"] for p in products]
    
    # Price feature (normalised)
    prices = np.array([[float(p["product_price"] or 0)] for p in products])
    scaler = MinMaxScaler()
    prices_norm = scaler.fit_transform(prices)

    # Category one-hot
    all_cats   = list(set(p["cat_id"]   or 0 for p in products))
    all_p_cats = list(set(p["p_cat_id"] or 0 for p in products))

    cat_matrix   = np.zeros((len(products), len(all_cats)))
    p_cat_matrix = np.zeros((len(products), len(all_p_cats)))

    for i, p in enumerate(products):
        if p["cat_id"] in all_cats:
            cat_matrix[i][all_cats.index(p["cat_id"])] = 1
        if p["p_cat_id"] in all_p_cats:
            p_cat_matrix[i][all_p_cats.index(p["p_cat_id"])] = 1

    # Combine features: price(1) + category(n) + sub-category(m)
    feature_matrix = np.hstack([prices_norm, cat_matrix, p_cat_matrix])
    return feature_matrix, product_ids

# ── Content-Based: similar products ──────────────────────────────
def content_based_recommend(target_product_ids, all_products, n=6):
    """Given a list of product_ids (user's history), find similar unseen products."""
    feature_matrix, product_ids = build_feature_matrix(all_products)
    
    if feature_matrix.size == 0:
        return []

    # Get indices of target products
    target_indices = [
        product_ids.index(pid)
        for pid in target_product_ids
        if pid in product_ids
    ]
    
    if not target_indices:
        return []

    # Mean feature vector of user's purchased products
    user_profile = feature_matrix[target_indices].mean(axis=0).reshape(1, -1)

    # Cosine similarity between user profile and all products
    similarities = cosine_similarity(user_profile, feature_matrix)[0]

    # Sort by similarity, exclude already-seen products
    scored = sorted(
        [(product_ids[i], similarities[i]) for i in range(len(product_ids))
         if product_ids[i] not in target_product_ids],
        key=lambda x: x[1],
        reverse=True
    )

    return [pid for pid, score in scored[:n]]

# ── Collaborative: users who bought X also bought Y ──────────────
def collaborative_recommend(user_id, all_products, n=6):
    """
    Simple item-based collaborative filtering:
    Find other users who bought the same products, 
    then recommend what they bought that this user hasn't.
    """
    db = get_db()
    cursor = db.cursor(dictionary=True)

    # Get current user's product history
    cursor.execute(
        "SELECT DISTINCT product_id FROM customer_order WHERE customer_id = %s",
        (user_id,)
    )
    user_products = {row["product_id"] for row in cursor.fetchall()}

    if not user_products:
        cursor.close()
        db.close()
        return []

    # Find other users who bought any of those products
    fmt = ",".join(["%s"] * len(user_products))
    cursor.execute(f"""
        SELECT DISTINCT customer_id FROM customer_order
        WHERE product_id IN ({fmt}) AND customer_id != %s
    """, (*user_products, user_id))
    similar_users = [row["customer_id"] for row in cursor.fetchall()]

    if not similar_users:
        cursor.close()
        db.close()
        return []

    # Get products those users bought (that current user hasn't)
    fmt2 = ",".join(["%s"] * len(similar_users))
    cursor.execute(f"""
        SELECT product_id, COUNT(*) as freq
        FROM customer_order
        WHERE customer_id IN ({fmt2})
        GROUP BY product_id
        ORDER BY freq DESC
    """, tuple(similar_users))
    
    collab_products = [
        row["product_id"] for row in cursor.fetchall()
        if row["product_id"] not in user_products
    ]

    cursor.close()
    db.close()
    return collab_products[:n]

# ── Hybrid: combine CB + CF ───────────────────────────────────────
def hybrid_recommend(user_id, n=6):
    """
    Hybrid = 60% Collaborative + 40% Content-Based
    Falls back to popular products if no history.
    """
    all_products = load_products()
    user_orders  = load_user_orders(user_id)

    if not user_orders:
        # Cold start: return popular products
        return get_popular_products(n)

    user_product_ids = [o["product_id"] for o in user_orders]

    # Get CF recommendations
    cf_recs = collaborative_recommend(user_id, all_products, n=n*2)

    # Get CB recommendations
    cb_recs = content_based_recommend(user_product_ids, all_products, n=n*2)

    # Weighted merge: CF first (60%), CB fills rest (40%)
    seen = set(user_product_ids)
    merged = []
    
    # Add CF results first
    for pid in cf_recs:
        if pid not in seen and pid not in merged:
            merged.append(pid)

    # Fill remaining slots with CB results
    for pid in cb_recs:
        if pid not in seen and pid not in merged:
            merged.append(pid)

    # If still not enough, add popular
    if len(merged) < n:
        popular = get_popular_products(n * 2)
        for pid in popular:
            if pid not in seen and pid not in merged:
                merged.append(pid)

    return merged[:n]

# ── Popular products fallback ─────────────────────────────────────
def get_popular_products(n=6):
    """Return most ordered products (fallback for new users)."""
    db = get_db()
    cursor = db.cursor(dictionary=True)
    cursor.execute("""
        SELECT product_id, COUNT(*) as order_count
        FROM customer_order
        GROUP BY product_id
        ORDER BY order_count DESC
        LIMIT %s
    """, (n,))
    rows = cursor.fetchall()
    cursor.close()
    db.close()

    if rows:
        return [r["product_id"] for r in rows]

    # If no orders at all, return first N products
    db = get_db()
    cursor = db.cursor(dictionary=True)
    cursor.execute("SELECT product_id FROM products LIMIT %s", (n,))
    rows = cursor.fetchall()
    cursor.close()
    db.close()
    return [r["product_id"] for r in rows]

# ── Enrich product IDs → full product data ────────────────────────
def enrich_products(product_ids):
    if not product_ids:
        return []
    db = get_db()
    cursor = db.cursor(dictionary=True)
    fmt = ",".join(["%s"] * len(product_ids))
    cursor.execute(f"""
        SELECT product_id, product_title, product_price, product_img1
        FROM products WHERE product_id IN ({fmt})
    """, tuple(product_ids))
    products = {r["product_id"]: r for r in cursor.fetchall()}
    cursor.close()
    db.close()
    # Return in the original ranked order
    return [products[pid] for pid in product_ids if pid in products]


# ═══════════════════════════════════════════════════════════════════
# API ENDPOINTS
# ═══════════════════════════════════════════════════════════════════

@app.route("/recommend", methods=["GET"])
def recommend():
    """
    GET /recommend?user_id=5&n=6
    Returns personalised product recommendations for a logged-in user.
    """
    user_id = request.args.get("user_id", type=int)
    n       = request.args.get("n", default=6, type=int)

    if not user_id:
        return jsonify({"error": "user_id is required"}), 400

    try:
        product_ids = hybrid_recommend(user_id, n)
        products    = enrich_products(product_ids)
        return jsonify({
            "user_id": user_id,
            "count":   len(products),
            "source":  "hybrid_cf_cb",
            "products": products
        })
    except Exception as e:
        return jsonify({"error": str(e)}), 500


@app.route("/similar", methods=["GET"])
def similar():
    """
    GET /similar?product_id=21&n=6
    Returns products similar to a given product (for product detail page).
    """
    product_id = request.args.get("product_id", type=int)
    n          = request.args.get("n", default=6, type=int)

    if not product_id:
        return jsonify({"error": "product_id is required"}), 400

    try:
        all_products = load_products()
        recs         = content_based_recommend([product_id], all_products, n)
        products     = enrich_products(recs)
        return jsonify({
            "product_id": product_id,
            "count":      len(products),
            "source":     "content_based",
            "products":   products
        })
    except Exception as e:
        return jsonify({"error": str(e)}), 500


@app.route("/popular", methods=["GET"])
def popular():
    """
    GET /popular?n=6
    Returns most popular products (used for guest/logged-out users).
    """
    n = request.args.get("n", default=6, type=int)
    try:
        product_ids = get_popular_products(n)
        products    = enrich_products(product_ids)
        return jsonify({
            "count":   len(products),
            "source":  "popular",
            "products": products
        })
    except Exception as e:
        return jsonify({"error": str(e)}), 500


@app.route("/health", methods=["GET"])
def health():
    """Health check endpoint."""
    return jsonify({"status": "ok", "engine": "StyleHub AI v1.0"})


if __name__ == "__main__":
    print("=" * 50)
    print("  StyleHub AI Recommendation Engine")
    print("  Running at http://localhost:5000")
    print("  Endpoints:")
    print("    GET /recommend?user_id=5&n=6")
    print("    GET /similar?product_id=21&n=6")
    print("    GET /popular?n=6")
    print("=" * 50)
    app.run(host="0.0.0.0", port=5000, debug=False)
