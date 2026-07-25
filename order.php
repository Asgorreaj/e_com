<?php
session_start();
include("includes/db.php");
include("functions/functions.php");

// চেক করুন ইউজার লগইন আছে কিনা
if (!isset($_SESSION['customer_email'])) {
    echo "<script>alert('Please login first!')</script>";
    echo "<script>window.open('checkout.php','_self')</script>";
    exit();
}

// customer_id পেতে
if (isset($_GET['c_id'])) {
    $customer_id = $_GET['c_id'];
} else {
    $session_email = $_SESSION['customer_email'];
    $select_customer = "SELECT customer_id FROM customers WHERE customer_email='$session_email'";
    $run_customer = mysqli_query($con, $select_customer);
    $row_customer = mysqli_fetch_array($run_customer);
    $customer_id = $row_customer['customer_id'];
}

// Payment method
$payment_method = isset($_GET['payment']) ? $_GET['payment'] : 'offline';

$ip_add = getUserIp();
$status = "pending";
$invoice_no = mt_rand();

$select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add'";
$run_cart = mysqli_query($con, $select_cart);

if(mysqli_num_rows($run_cart) > 0) {
    while ($row_cart = mysqli_fetch_array($run_cart)) {
        $pro_id = $row_cart['p_id'];
        $size = $row_cart['size'];
        $qty = $row_cart['qty'];
        
        $get_product = "SELECT * FROM products WHERE product_id='$pro_id'";
        $run_pro = mysqli_query($con, $get_product);
        $row_pro = mysqli_fetch_array($run_pro);
        
        if($row_pro) {
            $sub_total = $row_pro['product_price'] * $qty;
            
            $insert_customer_order = "INSERT INTO customer_order 
                (customer_id, product_id, due_amount, invoice_no, qty, size, order_date, order_status) 
                VALUES ('$customer_id','$pro_id','$sub_total','$invoice_no','$qty','$size',NOW(),'$status')";
            $run_cust_order = mysqli_query($con, $insert_customer_order);
        }
    }
    
    // Clear cart after order
    $delete_cart = "DELETE FROM cart WHERE ip_add='$ip_add'";
    mysqli_query($con, $delete_cart);
    
    // Payment method message
    $payment_msg = ($payment_method == 'paypal') ? 'via PayPal' : 'by Cash/Bank Transfer';
    
    echo "<script>alert('✅ Your order has been submitted successfully! Order #$invoice_no\\nPayment: $payment_msg')</script>";
    echo "<script>window.open('customer/my_account.php?my_order','_self')</script>";
} else {
    echo "<script>alert('Your cart is empty!')</script>";
    echo "<script>window.open('index.php','_self')</script>";
}
?>