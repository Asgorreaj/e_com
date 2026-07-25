<?php
session_start();
include("includes/db.php");
include("functions/functions.php");
?>
<?php include("header.php"); ?>

<style>
/* ============================================
   CHECKOUT PAGE - MODERN DESIGN
   ============================================ */
.checkout-wrapper {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

.checkout-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.checkout-items {
    background: #fff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.checkout-items h3 {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f2f6;
}

.checkout-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 0;
    border-bottom: 1px solid #f1f2f6;
}

.checkout-item:last-child {
    border-bottom: none;
}

.checkout-item img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 10px;
    background: #f8f9fa;
}

.checkout-item-info {
    flex: 1;
}

.checkout-item-info h4 {
    font-size: 15px;
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 4px;
}

.checkout-item-info .item-price {
    color: #ff523b;
    font-weight: 700;
    font-size: 16px;
}

.checkout-item-info .item-qty {
    color: #6c757d;
    font-size: 13px;
}

.checkout-item .remove-item {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 18px;
    padding: 5px 10px;
    transition: all 0.3s ease;
}

.checkout-item .remove-item:hover {
    color: #c82333;
    transform: scale(1.2);
}

.checkout-summary {
    background: #fff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    position: sticky;
    top: 100px;
}

.checkout-summary h3 {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f2f6;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 15px;
    color: #2d3436;
}

.summary-row.total {
    border-top: 2px solid #f1f2f6;
    margin-top: 10px;
    padding-top: 15px;
    font-weight: 700;
    font-size: 18px;
    color: #ff523b;
}

.payment-options {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.payment-btn {
    padding: 14px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    background: #fff;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    color: #2d3436;
}

.payment-btn:hover {
    border-color: #ff523b;
    background: rgba(255,82,59,0.05);
    transform: translateY(-2px);
}

.payment-btn.paypal {
    border-color: #0070ba;
    color: #0070ba;
}

.payment-btn.paypal:hover {
    background: #0070ba;
    color: #fff;
}

.payment-btn.offline {
    border-color: #00b894;
    color: #00b894;
}

.payment-btn.offline:hover {
    background: #00b894;
    color: #fff;
}

.empty-cart {
    text-align: center;
    padding: 60px 20px;
}

.empty-cart i {
    font-size: 64px;
    color: #dee2e6;
    margin-bottom: 20px;
    display: block;
}

.empty-cart h3 {
    font-size: 24px;
    color: #2d3436;
    margin-bottom: 10px;
}

.empty-cart p {
    color: #6c757d;
    font-size: 16px;
}

.empty-cart .shop-btn {
    display: inline-block;
    padding: 12px 30px;
    background: #ff523b;
    color: #fff;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    margin-top: 15px;
    transition: all 0.3s ease;
}

.empty-cart .shop-btn:hover {
    background: #e0452f;
    transform: translateY(-2px);
}

.breadcrumb {
    background: #f8f9fa;
    padding: 12px 20px;
    border-radius: 8px;
    max-width: 1200px;
    margin: 20px auto 0;
}

.breadcrumb a {
    color: #ff523b;
    text-decoration: none;
}

.breadcrumb span {
    color: #6c757d;
}

@media (max-width: 768px) {
    .checkout-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .checkout-summary {
        position: static;
    }
}

@media (max-width: 480px) {
    .checkout-items {
        padding: 15px;
    }
    .checkout-summary {
        padding: 15px;
    }
    .checkout-item img {
        width: 50px;
        height: 50px;
    }
}

/* ===== LOGIN FORM STYLES ===== */
.login-wrapper {
    width: 100%;
    min-height: 560px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    box-sizing: border-box;
    background: radial-gradient(circle at 15% 20%, rgba(35,73,92,0.06) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(255,87,34,0.06) 0%, transparent 45%),
                #fbfbfb;
}

.login-card {
    width: 100%;
    max-width: 900px;
    display: flex;
    background: #ffffff;
    border-radius: 22px;
    box-shadow: 0 20px 50px rgba(15,40,55,0.12);
    overflow: hidden;
    animation: fadeUpLogin .6s ease;
}

@keyframes fadeUpLogin {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
}

.login-brand {
    flex: 0 0 38%;
    background: linear-gradient(160deg, #23495c 0%, #1a3a4a 60%, #13313f 100%);
    color: #fff;
    padding: 50px 35px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.login-brand::before {
    content: "";
    position: absolute;
    width: 240px;
    height: 240px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
    top: -80px;
    right: -80px;
}

.login-brand::after {
    content: "";
    position: absolute;
    width: 160px;
    height: 160px;
    background: rgba(255,87,34,0.15);
    border-radius: 50%;
    bottom: -60px;
    left: -50px;
}

.login-brand-icon {
    width: 70px;
    height: 70px;
    line-height: 70px;
    text-align: center;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    font-size: 28px;
    margin-bottom: 24px;
    position: relative;
    z-index: 1;
}

.login-brand h3 {
    font-size: 24px;
    margin: 0 0 12px;
    position: relative;
    z-index: 1;
}

.login-brand p {
    font-size: 14px;
    line-height: 1.7;
    color: rgba(255,255,255,0.8);
    margin: 0;
    position: relative;
    z-index: 1;
}

.login-brand-points {
    margin-top: 28px;
    position: relative;
    z-index: 1;
}

.login-brand-points div {
    font-size: 13.5px;
    margin-bottom: 12px;
    color: rgba(255,255,255,0.85);
}

.login-brand-points i {
    color: #ff8a50;
    margin-right: 8px;
}

.login-form-panel {
    flex: 1;
    padding: 50px 45px;
}

.login-header {
    margin-bottom: 30px;
}

.login-header h2 {
    color: #1c3c4d;
    margin: 0 0 6px;
    font-size: 26px;
    font-weight: 700;
}

.login-header p {
    color: #888;
    margin: 0;
    font-size: 14px;
}

.login-card .form-group {
    margin-bottom: 20px;
    gap: 8px;
    align-items: center;
    justify-content: space-evenly;
}

.login-card label {
    display: block;
    font-weight: 600;
    margin-bottom: 7px;
    font-size: 13px;
    color: #333;
}

.login-input-icon {
    position: relative;
}

.login-input-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #23495c;
    font-size: 14px;
}

.login-card .form-control {
    width: 100%;
    height: 50px;
    border: 1.5px solid #e3e3e3;
    border-radius: 10px;
    padding: 10px 15px 10px 42px;
    box-sizing: border-box;
    font-size: 14px;
    background: #fafafa;
    transition: all .25s ease;
}

.login-card .form-control:focus {
    outline: none;
    border-color: #23495c;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(35,73,92,0.12);
}

.login-btn {
    width: 100%;
    height: 50px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #23495c, #2f6480);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 6px;
    transition: transform .2s ease, box-shadow .2s ease;
    box-shadow: 0 10px 22px rgba(35,73,92,0.28);
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(35,73,92,0.36);
}

.login-btn:active {
    transform: translateY(0);
}

.login-divider {
    display: flex;
    align-items: center;
    text-align: center;
    color: #aaa;
    font-size: 12px;
    margin: 24px 0;
}

.login-divider::before,
.login-divider::after {
    content: "";
    flex: 1;
    border-bottom: 1px solid #eee;
}

.login-divider span {
    padding: 0 12px;
}

.register-box {
    text-align: center;
}

.register-box h4 {
    font-size: 13.5px;
    color: #777;
    font-weight: 500;
    margin: 0 0 4px;
}

.register-link {
    color: #23495c;
    text-decoration: none;
    font-weight: 700;
    font-size: 14.5px;
}

.register-link:hover {
    text-decoration: underline;
}

.error-msg {
    background: #ff523b;
    color: #fff;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    text-align: center;
}

@media(max-width:768px) {
    .login-wrapper { padding: 20px 12px; }
    .login-card { flex-direction: column; max-width: 480px; }
    .login-brand { flex: none; padding: 30px 30px 26px; }
    .login-brand-points { display: none; }
    .login-form-panel { padding: 35px 28px 40px; }
}
</style>

<!-- ============================================
BREADCRUMB
============================================ -->
<div class="breadcrumb">
    <a href="index.php">Home</a> / <span>Checkout</span>
</div>

<!-- ============================================
CHECKOUT / LOGIN SECTION
============================================ -->
<section class="checkout-wrapper">

<?php
// ইউজার লগইন চেক
if (!isset($_SESSION['customer_email'])) {
    // ============================================
    // LOGIN FORM (Your existing design)
    // ============================================
?>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-brand">
            <div class="login-brand-icon">
                <i class="fa fa-shopping-bag"></i>
            </div>
            <h3>Shopixia</h3>
            <p>Buy with Joy! Sign in to track your orders, manage your cart and checkout faster.</p>
            <div class="login-brand-points">
                <div><i class="fa fa-check-circle"></i> Faster checkout</div>
                <div><i class="fa fa-check-circle"></i> Order tracking</div>
                <div><i class="fa fa-check-circle"></i> Saved cart &amp; wishlist</div>
            </div>
        </div>

        <div class="login-form-panel">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Login to continue shopping</p>
            </div>

            <?php
            if(isset($_POST['login'])){
                $customer_email = mysqli_real_escape_string($con, $_POST['c_email']);
                $customer_pass = mysqli_real_escape_string($con, $_POST['c_password']);

                $select_customers = "SELECT * FROM customers WHERE customer_email='$customer_email' AND customer_pass='$customer_pass'";
                $run_cust = mysqli_query($con, $select_customers);
                $check_customer = mysqli_num_rows($run_cust);

                if($check_customer == 0){
                    echo '<div class="error-msg">❌ Invalid Email or Password</div>';
                } else {
                    $_SESSION['customer_email'] = $customer_email;
                    
                    $get_ip = getUserIp();
                    $select_cart = "SELECT * FROM cart WHERE ip_add='$get_ip'";
                    $run_cart = mysqli_query($con, $select_cart);
                    $check_cart = mysqli_num_rows($run_cart);

                    if($check_customer == 1 && $check_cart == 0){
                        echo "<script>alert('You are logged In')</script>";
                        echo "<script>window.open('customer/my_account.php','_self')</script>";
                    } else {
                        echo "<script>alert('You are logged In')</script>";
                        echo "<script>window.open('checkout.php','_self')</script>";
                    }
                }
            }
            ?>

            <form method="post">
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="login-input-icon">
                        <i class="fa fa-envelope"></i>
                        <input type="email" name="c_email" class="form-control" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="login-input-icon">
                        <i class="fa fa-lock"></i>
                        <input type="password" name="c_password" class="form-control" placeholder="Enter your password" required>
                    </div>
                </div>

                <button type="submit" name="login" class="login-btn">
                    <i class="fa fa-sign-in"></i> Login
                </button>
            </form>

            <div class="login-divider"><span>OR</span></div>

            <div class="register-box">
                <h4>New Customer?</h4>
                <a href="customer_registration.php" class="register-link">Create Your Account</a>
                <br/>
                <h4>Admin</h4>
                <a href="admin_area/login.php" class="register-link">Login as Admin</a>
            </div>
        </div>
    </div>
</div>

<?php
} else {
    // ============================================
    // LOGGED IN - SHOW CHECKOUT
    // ============================================

$ip_add = getUserIp();

// Remove item
if(isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $delete_cart = "DELETE FROM cart WHERE p_id='$remove_id' AND ip_add='$ip_add'";
    mysqli_query($con, $delete_cart);
    echo "<script>window.open('checkout.php','_self')</script>";
}

$select_cart = "SELECT c.*, p.product_title, p.product_img1, p.product_price 
                FROM cart c 
                JOIN products p ON c.p_id = p.product_id 
                WHERE c.ip_add='$ip_add'";
$run_cart = mysqli_query($con, $select_cart);
$count_cart = mysqli_num_rows($run_cart);
?>

<div class="checkout-grid">
    
    <!-- Cart Items -->
    <div class="checkout-items">
        <h3>🛒 Your Cart Items</h3>
        
        <?php
        if($count_cart > 0) {
            $total_price = 0;
            while($row_cart = mysqli_fetch_array($run_cart)) {
                $pro_id = $row_cart['p_id'];
                $pro_qty = $row_cart['qty'];
                $pro_size = $row_cart['size'];
                $p_title = $row_cart['product_title'];
                $p_img1 = $row_cart['product_img1'];
                $p_price = $row_cart['product_price'];
                $sub_total = $p_price * $pro_qty;
                $total_price += $sub_total;
        ?>
        <div class="checkout-item">
            <img src="admin_area/product_images/<?php echo $p_img1; ?>" alt="<?php echo $p_title; ?>">
            <div class="checkout-item-info">
                <h4><?php echo $p_title; ?></h4>
                <div>
                    <span class="item-price">£<?php echo number_format($p_price, 2); ?></span>
                    <span class="item-qty"> × <?php echo $pro_qty; ?></span>
                    <?php if($pro_size != '') { ?>
                        <span class="item-qty"> | Size: <?php echo $pro_size; ?></span>
                    <?php } ?>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-weight:700;color:#ff523b;">£<?php echo number_format($sub_total, 2); ?></span>
                <a href="checkout.php?remove=<?php echo $pro_id; ?>" class="remove-item" 
                   onclick="return confirm('Are you sure you want to remove this item?')">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </div>
        <?php 
            }
        } else {
        ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-bag"></i>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any items yet.</p>
            <a href="index.php" class="shop-btn">Start Shopping →</a>
        </div>
        <?php } ?>
    </div>
    
    <!-- Order Summary & Payment -->
    <div class="checkout-summary">
        <h3>📋 Order Summary</h3>
        
        <?php if($count_cart > 0 && isset($total_price)) { ?>
        <div class="summary-row">
            <span>Subtotal</span>
            <span>£<?php echo number_format($total_price, 2); ?></span>
        </div>
        <div class="summary-row">
            <span>Shipping</span>
            <span>£0.00</span>
        </div>
        <div class="summary-row">
            <span>Tax</span>
            <span>£0.00</span>
        </div>
        <div class="summary-row total">
            <span>Total</span>
            <span>£<?php echo number_format($total_price, 2); ?></span>
        </div>
        
        <div class="payment-options">
            <h4 style="font-size:16px;color:#6c757d;margin-bottom:10px;">Select Payment Method</h4>
            
            <?php
            $session_email = $_SESSION['customer_email'] ?? '';
            if($session_email != '') {
                $select_customer = "SELECT * FROM customers WHERE customer_email='$session_email'";
                $run_cust = mysqli_query($con, $select_customer);
                $row_customer = mysqli_fetch_array($run_cust);
                $customer_id = $row_customer['customer_id'] ?? 0;
            } else {
                $customer_id = 0;
            }
            ?>
            
            <a href="order.php?c_id=<?php echo $customer_id; ?>" class="payment-btn offline">
                <i class="fas fa-money-bill-wave"></i> Pay Offline (Cash/ Bank Transfer)
            </a>
            
            <a href="#" class="payment-btn paypal" onclick="alert('PayPal payment coming soon!'); return false;">
                <i class="fab fa-paypal"></i> Pay via PayPal
            </a>
        </div>
        <?php } else { ?>
            <div style="text-align:center;padding:20px 0;">
                <i class="fas fa-box" style="font-size:48px;color:#dee2e6;margin-bottom:15px;display:block;"></i>
                <p style="color:#6c757d;font-size:15px;">Add items to your cart to see summary</p>
            </div>
        <?php } ?>
    </div>
</div>

<?php } ?>

</section>

<?php include("includes/footer.php"); ?>