<?php
/**
 * StyleHub AI Recommendation Helper
 * Include this file in index.php and details.php
 * 
 * Usage:
 *   $recs = get_ai_recommendations($customer_id, 6);
 *   $similar = get_similar_products($product_id, 6);
 *   $popular = get_popular_products(6);
 */

define('AI_API_URL', 'http://localhost:5000');

/**
 * Call the AI Flask API
 */
function ai_api_call($endpoint) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => AI_API_URL . $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 3, // 3 second timeout - won't block page if AI is down
        CURLOPT_CONNECTTIMEOUT => 2,
    ]);
    $response = curl_exec($ch);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($error || !$response) return null;
    $data = json_decode($response, true);
    return $data['products'] ?? null;
}

/**
 * Get personalised recommendations for a logged-in user
 */
function get_ai_recommendations($user_id, $n = 6) {
    return ai_api_call("/recommend?user_id=" . intval($user_id) . "&n=" . intval($n));
}

/**
 * Get similar products (for product detail page)
 */
function get_similar_products($product_id, $n = 6) {
    return ai_api_call("/similar?product_id=" . intval($product_id) . "&n=" . intval($n));
}

/**
 * Get popular products (fallback for guests)
 */
function get_popular_ai($n = 6) {
    return ai_api_call("/popular?n=" . intval($n));
}

/**
 * Render a recommendation section as HTML cards
 * 
 * @param array  $products   Array of product data from AI API
 * @param string $section_id HTML id for the section
 */
function render_ai_section($products, $section_id = 'ai-recs') {
    if (empty($products)) return;
    ?>
    <div class="ai-rec-card-grid" id="<?php echo htmlspecialchars($section_id); ?>">
        <?php foreach ($products as $product): ?>
        <div class="ai-rec-card">
            <a href="details.php?pro_id=<?php echo intval($product['product_id']); ?>">
                <div class="ai-rec-img-wrap">
                    <img 
                        src="admin_area/product_images/<?php echo htmlspecialchars($product['product_img1']); ?>" 
                        alt="<?php echo htmlspecialchars($product['product_title']); ?>"
                        onerror="this.src='website/all/placeholder.png'"
                    >
                </div>
                <div class="ai-rec-info">
                    <p class="ai-rec-title"><?php echo htmlspecialchars($product['product_title']); ?></p>
                    <p class="ai-rec-price">£<?php echo number_format((float)$product['product_price'], 2); ?></p>
                </div>
            </a>
            <a href="details.php?pro_id=<?php echo intval($product['product_id']); ?>" class="ai-rec-btn">
                View Product
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
}
?>
