<?php
session_start();
include("includes/db.php");
include("functions/functions.php");
?>
<?php include("header.php"); ?>

<style>
/* ============================================
   CUSTOMER LOGIN PAGE
   ============================================ */
.login-wrapper {
    max-width: 500px;
    margin: 50px auto;
    padding: 0 20px;
}

.login-box {
    background: #fff;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.login-box h2 {
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.login-box .subtitle {
    text-align: center;
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 25px;
}

.login-box .form-group {
    margin-bottom: 18px;
}

.login-box .form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 5px;
}

.login-box .form-group input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
    color: #2d3436;
}

.login-box .form-group input:focus {
    border-color: #ff523b;
    background: #fff;
    outline: none;
    box-shadow: 0 0 0 4px rgba(255,82,59,0.08);
}

.login-box .login-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.login-box .login-btn:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(255,82,59,0.25);
}

.login-box .divider-text {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 18px 0;
    color: #aaa;
    font-size: 13px;
}

.login-box .divider-text::before,
.login-box .divider-text::after {
    content: "";
    flex: 1;
    border-bottom: 1px solid #eee;
}

.login-box .divider-text span {
    padding: 0 12px;
}

.login-box .admin-login-btn {
    display: block;
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    background: #1b4353;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
}

.login-box .admin-login-btn:hover {
    background: #2a6a80;
    transform: scale(1.02);
}

.login-box .register-link {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: #6c757d;
}

.login-box .register-link a {
    color: #ff523b;
    font-weight: 600;
    text-decoration: none;
}

.login-box .register-link a:hover {
    text-decoration: underline;
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

@media (max-width: 480px) {
    .login-box {
        padding: 25px 20px;
    }
    .login-box h2 {
        font-size: 22px;
    }
}
</style>

<!-- ============================================
BREADCRUMB
============================================ -->
<div class="breadcrumb">
    <a href="index.php">Home</a> / <span>Customer Login</span>
</div>

<!-- ============================================
CUSTOMER LOGIN FORM
============================================ -->
<div class="login-wrapper">
    <div class="login-box">
        <h2>🔐 Customer Login</h2>
        <p class="subtitle">Login to your account to continue shopping</p>
        
        <?php
        // Customer Login logic
        if(isset($_POST['customer_login'])) {
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            
            $select_customer = "SELECT * FROM customers WHERE customer_email='$email' AND customer_pass='$password'";
            $run_customer = mysqli_query($con, $select_customer);
            $count = mysqli_num_rows($run_customer);
            
            if($count > 0) {
                $_SESSION['customer_email'] = $email;
                echo "<script>alert('Login successful! Welcome back.')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            } else {
                echo "<div style='background:#ff523b;color:#fff;padding:12px;border-radius:8px;margin-bottom:15px;text-align:center;'>
                        ❌ Invalid email or password. Please try again.
                      </div>";
            }
        }
        ?>
        
        <form action="" method="post">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" name="customer_login" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Customer Login
            </button>
        </form>
        
        <div class="divider-text"><span>OR</span></div>
        
        <!-- Admin Login Button -->
        <a href="admin_area/login.php" class="admin-login-btn">
            <i class="fas fa-user-shield"></i> Admin Login
        </a>
        
        <div class="register-link">
            Don't have an account? <a href="customer_registration.php">Register here</a>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>