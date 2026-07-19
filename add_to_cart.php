<?php
session_start();
include("includes/db.php");

function getUserIp() {
    $ip_address = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ip_address = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ip_address = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ip_address = $_SERVER['REMOTE_ADDR'];
    else
        $ip_address = 'UNKNOWN';
    return $ip_address;
}

if(isset($_POST['product_id'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $size = isset($_POST['size']) ? mysqli_real_escape_string($con, $_POST['size']) : 'Standard';
    $ip_add = getUserIp();
    
    $check_cart = "SELECT * FROM cart WHERE p_id='$product_id' AND ip_add='$ip_add'";
    $run_check = mysqli_query($con, $check_cart);
    
    if(mysqli_num_rows($run_check) > 0) {
        $update_cart = "UPDATE cart SET qty = qty + $quantity WHERE p_id='$product_id' AND ip_add='$ip_add'";
        mysqli_query($con, $update_cart);
    } else {
        $insert_cart = "INSERT INTO cart (p_id, ip_add, qty, size) VALUES ('$product_id', '$ip_add', '$quantity', '$size')";
        mysqli_query($con, $insert_cart);
    }
    
    // Get updated cart data
    $select_cart = "SELECT SUM(qty) as total_items FROM cart WHERE ip_add='$ip_add'";
    $run_cart = mysqli_query($con, $select_cart);
    $row_cart = mysqli_fetch_array($run_cart);
    $total_items = $row_cart['total_items'] ?? 0;
    
    echo json_encode(['status' => 'success', 'cart_count' => $total_items]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No product selected']);
}
?>