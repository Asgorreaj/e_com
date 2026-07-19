<?php
/*
 * =====================================================
 * ADD THIS SECTION TO index.php
 * 
 * STEP 1: At the very top of index.php (after <?php tag),
 *         add this line:
 *         require_once 'ai_helper.php';
 * 
 * STEP 2: Paste the code below anywhere in index.php
 *         where you want the recommendation section to appear
 *         (e.g., after "Latest This Week" section)
 * =====================================================
 */
?>

<!-- ══ AI RECOMMENDATION SECTION ══════════════════════════════ -->
<section class="ai-rec-section">

    <div class="ai-rec-header">
        <span class="ai-rec-badge">✦ AI Powered</span>
        <h1 class="heading">
            <?php if (isset($_SESSION['customer_email'])): ?>
                <span>Recommended For You</span>
            <?php else: ?>
                <span>Trending Products</span>
            <?php endif; ?>
        </h1>
        <p class="ai-rec-subtitle">
            <?php if (isset($_SESSION['customer_email'])): ?>
                Personalised picks based on your shopping history
            <?php else: ?>
                Most popular products this week
            <?php endif; ?>
        </p>
    </div>

    <?php
    $ai_products = null;

    if (isset($_SESSION['customer_email'])) {
        // Logged-in user: get their customer_id from DB
        $session_email = $_SESSION['customer_email'];
        $q = mysqli_query($con, "SELECT customer_id FROM customers WHERE customer_email='".mysqli_real_escape_string($con, $session_email)."' LIMIT 1");
        $row = mysqli_fetch_assoc($q);
        if ($row) {
            $ai_products = get_ai_recommendations($row['customer_id'], 6);
        }
    }

    // Fallback: popular products (for guests or if AI returns empty)
    if (empty($ai_products)) {
        $ai_products = get_popular_ai(6);
    }

    // Fallback: load from MySQL directly if AI server is down
    if (empty($ai_products)) {
        $fb = mysqli_query($con, "SELECT product_id, product_title, product_price, product_img1 FROM products ORDER BY product_id DESC LIMIT 6");
        $ai_products = [];
        while ($r = mysqli_fetch_assoc($fb)) {
            $ai_products[] = $r;
        }
    }

    render_ai_section($ai_products, 'ai-recs-home');
    ?>

</section>
<!-- ══ END AI RECOMMENDATION SECTION ══════════════════════════ -->
