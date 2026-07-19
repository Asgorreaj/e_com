# StyleHub AI Recommendation Engine — Setup Guide

## What this does
- Analyses customer order history from your MySQL database
- Recommends personalised products using Hybrid AI (Collaborative + Content-Based Filtering)
- Falls back to popular/trending products for new/guest users
- Runs as a separate Python server alongside your PHP project

---

## STEP 1 — Install Python dependencies
Open a terminal/CMD in this folder and run:

```
pip install -r requirements.txt
```

---

## STEP 2 — Check your database connection
Open `app.py` and check the DB_CONFIG section:

```python
DB_CONFIG = {
    "host": "localhost",
    "user": "root",
    "password": "",       # change if your MySQL has a password
    "database": "e_com"   # your database name
}
```

---

## STEP 3 — Start the AI server
```
python app.py
```

You should see:
```
StyleHub AI Recommendation Engine
Running at http://localhost:5000
```

Keep this terminal open while using the website.

---

## STEP 4 — Add to your PHP project

Copy these files into your E_COM project root (same folder as index.php):

| File | Where to put it |
|------|-----------------|
| `ai_helper.php` | E_COM/ (root) |
| `ai_styles.css` | Append contents to E_COM/style.css |

Then edit `index.php`:

**At the very top (after `<?php`):**
```php
require_once 'ai_helper.php';
```

**Somewhere in the page body (e.g. after "Latest This Week" section):**
```php
<?php
// Copy and paste the full contents of index_ai_section.php here
?>
```

---

## STEP 5 — Test it works

Visit in your browser:
- http://localhost:5000/health
- http://localhost:5000/popular?n=6
- http://localhost:5000/recommend?user_id=29&n=6
- http://localhost:5000/similar?product_id=21&n=6

Each should return JSON with product data.

---

## How the AI works (for your IPR/report)

1. **Content-Based Filtering**: Each product is represented as a feature vector
   (price, category, sub-category). Cosine similarity finds similar products.

2. **Collaborative Filtering**: Finds other users who bought the same products,
   then recommends what they also bought.

3. **Hybrid Model**: CF results (60%) + CB results (40%) merged together.
   Falls back to popular products if no history exists.

4. **3-second timeout**: If the AI server is down, PHP falls back to MySQL
   automatically — the website never breaks.

---

## API Endpoints

| Endpoint | Use |
|----------|-----|
| GET /recommend?user_id=5&n=6 | Personalised recs for logged-in user |
| GET /similar?product_id=21&n=6 | Similar products (product detail page) |
| GET /popular?n=6 | Popular products (guest users) |
| GET /health | Check if server is running |
