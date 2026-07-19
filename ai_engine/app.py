from flask import Flask, jsonify, request
from flask_cors import CORS
import mysql.connector
import random
import json

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

@app.route('/')
def home():
    return jsonify({
        'status': 'running', 
        'message': 'AI Recommendation Engine',
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
        
        # ইউজারের অর্ডার থেকে ক্যাটাগরি বের করুন
        cursor.execute("""
            SELECT DISTINCT p.cat_id, p.p_cat_id 
            FROM customer_order co 
            JOIN products p ON co.product_id = p.product_id 
            WHERE co.customer_id = %s
            ORDER BY co.order_date DESC
            LIMIT 10
        """, (user_id,))
        
        user_categories = cursor.fetchall()
        print(f"User categories found: {len(user_categories)}")
        
        if user_categories:
            cat_ids = [str(c['cat_id']) for c in user_categories if c['cat_id']]
            p_cat_ids = [str(c['p_cat_id']) for c in user_categories if c['p_cat_id']]
            
            query = "SELECT * FROM products WHERE "
            conditions = []
            params = []
            
            if cat_ids:
                placeholders = ','.join(['%s'] * len(cat_ids))
                conditions.append(f"cat_id IN ({placeholders})")
                params.extend(cat_ids)
            if p_cat_ids:
                placeholders = ','.join(['%s'] * len(p_cat_ids))
                conditions.append(f"p_cat_id IN ({placeholders})")
                params.extend(p_cat_ids)
            
            if conditions:
                query += " OR ".join(conditions) + f" ORDER BY RAND() LIMIT {n}"
                cursor.execute(query, params)
            else:
                query = f"SELECT * FROM products ORDER BY RAND() LIMIT {n}"
                cursor.execute(query)
        else:
            query = f"SELECT * FROM products ORDER BY RAND() LIMIT {n}"
            cursor.execute(query)
        
        products = cursor.fetchall()
        print(f"Products found: {len(products)}")
        
        cursor.close()
        conn.close()
        
        return jsonify({'products': products})
        
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
        
        return jsonify({'products': products})
        
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
        
        # প্রোডাক্টের ক্যাটাগরি বের করুন
        cursor.execute("SELECT cat_id, p_cat_id FROM products WHERE product_id = %s", (product_id,))
        product = cursor.fetchone()
        
        if product:
            query = "SELECT * FROM products WHERE product_id != %s"
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
        else:
            query = f"SELECT * FROM products WHERE product_id != %s ORDER BY RAND() LIMIT {n}"
            cursor.execute(query, (product_id,))
        
        products = cursor.fetchall()
        print(f"Similar products found: {len(products)}")
        
        cursor.close()
        conn.close()
        
        return jsonify({'products': products})
        
    except Exception as e:
        print(f"Error in similar: {str(e)}")
        return jsonify({'products': [], 'error': str(e)})

if __name__ == '__main__':
    print("=" * 50)
    print("  Shopixia AI Recommendation Engine")
    print("  Running at http://localhost:5000")
    print("  Endpoints:")
    print("    GET /recommend?user_id=5&n=6")
    print("    GET /similar?product_id=21&n=6")
    print("    GET /popular?n=6")
    print("=" * 50)
    app.run(host='0.0.0.0', port=5000, debug=True)