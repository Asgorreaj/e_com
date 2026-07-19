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

$ip_add = getUserIp();
$select_cart = "SELECT c.*, p.product_price 
                FROM cart c 
                JOIN products p ON c.p_id = p.product_id 
                WHERE c.ip_add='$ip_add'";
$run_cart = mysqli_query($con, $select_cart);
$total = 0;

while($row = mysqli_fetch_array($run_cart)) {
    $total += $row['product_price'] * $row['qty'];
}

echo number_format($total, 2);
?>