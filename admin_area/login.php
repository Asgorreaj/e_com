<?php
session_start();
include("../includes/db.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Shopixia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/login.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Open Sans', sans-serif;
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .admin-login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        .admin-login-box {
            background: #fff;
            border-radius: 16px;
            padding: 40px 35px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        }
        .admin-login-box .logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .admin-login-box .logo i {
            font-size: 48px;
            color: #1b4353;
        }
        .admin-login-box .logo h3 {
            color: #1b4353;
            font-size: 24px;
            margin-top: 5px;
        }
        .admin-login-box .logo p {
            color: #6c757d;
            font-size: 14px;
        }
        .admin-login-box .form-group {
            margin-bottom: 18px;
        }
        .admin-login-box .form-group label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: #333;
            margin-bottom: 5px;
        }
        .admin-login-box .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        .admin-login-box .form-group input:focus {
            border-color: #1b4353;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(27,67,83,0.08);
        }
        .admin-login-box .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1b4353, #2a6a80);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .admin-login-box .login-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(27,67,83,0.3);
        }
        .admin-login-box .back-link {
            text-align: center;
            margin-top: 15px;
        }
        .admin-login-box .back-link a {
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
        }
        .admin-login-box .back-link a:hover {
            color: #1b4353;
        }
        .error-msg {
            background: #ff523b;
            color: #fff;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="admin-login-wrapper">
    <div class="admin-login-box">
        <div class="logo">
            <i class="fa fa-shopping-bag"></i>
            <h3>Shopixia Admin</h3>
            <p>Login to manage your store</p>
        </div>

        <?php
        if(isset($_POST['admin_login'])){
            $admin_email = mysqli_real_escape_string($con, $_POST['admin_email']);
            $admin_pass = mysqli_real_escape_string($con, $_POST['admin_pass']);
            
            $get_admin = "SELECT * FROM admins WHERE admin_email='$admin_email' AND admin_pass='$admin_pass'";
            $run_admin = mysqli_query($con, $get_admin);
            $count = mysqli_num_rows($run_admin);
            
            if($count == 1){
                $_SESSION['admin_email'] = $admin_email;
                echo "<script>alert('Welcome Admin!')</script>";
                echo "<script>window.open('index.php?dashboard','_self')</script>";
            } else {
                echo "<div class='error-msg'>❌ Invalid Email or Password</div>";
            }
        }
        ?>

        <form action="" method="post">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="admin_email" placeholder="Enter admin email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="admin_pass" placeholder="Enter password" required>
            </div>
            <button type="submit" name="admin_login" class="login-btn">
                <i class="fa fa-sign-in"></i> Admin Login
            </button>
        </form>

        <div class="back-link">
            <a href="../index.php"><i class="fa fa-arrow-left"></i> Back to Shop</a>
        </div>
    </div>
</div>

</body>
</html>