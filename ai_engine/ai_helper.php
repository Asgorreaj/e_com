<?php
/**
 * Shopixia AI Recommendation Helper
 * Include this file in index.php and details.php
 */

define('AI_API_URL', 'http://localhost:5000');

/**
 * Call the AI Flask API with error handling
 */
function ai_api_call($endpoint) {
    // প্রথমে চেক করুন সার্ভার চালু আছে কিনা
    if (!is_ai_server_running()) {
        return null;
    }
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => AI_API_URL . $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_FOLLOWLOCATION => true,
    ]);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // যদি error হয় বা response খালি হয়
    if ($error || !$response || $http_code != 200) {
        error_log("AI API Error: " . $error . " - HTTP Code: " . $http_code);
        return null;
    }
    
    $data = json_decode($response, true);
    
    // চেক করুন ডেটা সঠিক ফরম্যাটে আছে কিনা
    if (isset($data['products']) && is_array($data['products'])) {
        return $data['products'];
    }
    
    return null;
}

/**
 * Check if AI server is running
 */
function is_ai_server_running() {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => AI_API_URL . '/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 2,
        CURLOPT_CONNECTTIMEOUT => 2,
        CURLOPT_NOBODY         => true,
    ]);
    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ($http_code == 200 || $http_code == 404);
}

/**
 * Get personalised recommendations for a logged-in user
 */
function get_ai_recommendations($user_id, $n = 6) {
    if (empty($user_id)) {
        return null;
    }
    return ai_api_call("/recommend?user_id=" . intval($user_id) . "&n=" . intval($n));
}

/**
 * Get similar products (for product detail page)
 */
function get_similar_products($product_id, $n = 6) {
    if (empty($product_id)) {
        return null;
    }
    return ai_api_call("/similar?product_id=" . intval($product_id) . "&n=" . intval($n));
}

/**
 * Get popular products (fallback for guests)
 */
function get_popular_ai($n = 6) {
    return ai_api_call("/popular?n=" . intval($n));
}
?>