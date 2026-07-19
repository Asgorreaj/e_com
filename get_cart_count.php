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
$select_cart = "SELECT SUM(qty) as total_items FROM cart WHERE ip_add='$ip_add'";
$run_cart = mysqli_query($con, $select_cart);
$row_cart = mysqli_fetch_array($run_cart);
$total_items = $row_cart['total_items'] ?? 0;

echo $total_items;
?>