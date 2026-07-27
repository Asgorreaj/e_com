<?php
session_start();
include("includes/db.php");
include("functions/functions.php");

$ip_add = getUserIp();

if (isset($_POST['product_id'])) {
    $p_id = mysqli_real_escape_string($con, $_POST['product_id']);
    
    // Database থেকে Cart Item মুছে ফেলা
    $delete_cart = "DELETE FROM cart WHERE p_id='$p_id' AND ip_add='$ip_add'";
    $run_delete = mysqli_query($con, $delete_cart);

    // আপডেট হওয়া কার্ট আইটেম সংখ্যা বের করা
    $get_items = "SELECT * FROM cart WHERE ip_add='$ip_add'";
    $run_items = mysqli_query($con, $get_items);
    $count = mysqli_num_rows($run_items);

    if ($run_delete) {
        echo json_encode([
            'status' => 'success', 
            'message' => 'Item removed from cart', 
            'cart_count' => $count
        ]);
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Could not remove item'
        ]);
    }
}
?>