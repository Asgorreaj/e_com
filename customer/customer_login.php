<style>

.login-wrapper{
    width:100%;
    min-height:560px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 20px;
    box-sizing:border-box;
    background:
        radial-gradient(circle at 15% 20%, rgba(35,73,92,0.06) 0%, transparent 45%),
        radial-gradient(circle at 85% 80%, rgba(255,87,34,0.06) 0%, transparent 45%),
        #fbfbfb;
}

.login-card{
    width:100%;
    max-width:900px;
    display:flex;
    background:#ffffff;
    border-radius:22px;
    box-shadow:0 20px 50px rgba(15,40,55,0.12);
    overflow:hidden;
    animation:fadeUpLogin .6s ease;
}

@keyframes fadeUpLogin{
    from{opacity:0; transform:translateY(25px);}
    to{opacity:1; transform:translateY(0);}
}

/* ===== Left brand panel ===== */
.login-brand{
    flex:0 0 38%;
    background:linear-gradient(160deg,#23495c 0%,#1a3a4a 60%,#13313f 100%);
    color:#fff;
    padding:50px 35px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    position:relative;
    overflow:hidden;
}

.login-brand::before{
    content:"";
    position:absolute;
    width:240px;
    height:240px;
    background:rgba(255,255,255,0.06);
    border-radius:50%;
    top:-80px;
    right:-80px;
}

.login-brand::after{
    content:"";
    position:absolute;
    width:160px;
    height:160px;
    background:rgba(255,87,34,0.15);
    border-radius:50%;
    bottom:-60px;
    left:-50px;
}

.login-brand-icon{
    width:70px;
    height:70px;
    line-height:70px;
    text-align:center;
    border-radius:50%;
    background:rgba(255,255,255,0.12);
    font-size:28px;
    margin-bottom:24px;
    position:relative;
    z-index:1;
}

.login-brand h3{
    font-size:24px;
    margin:0 0 12px;
    position:relative;
    z-index:1;
}

.login-brand p{
    font-size:14px;
    line-height:1.7;
    color:rgba(255,255,255,0.8);
    margin:0;
    position:relative;
    z-index:1;
}

.login-brand-points{
    margin-top:28px;
    position:relative;
    z-index:1;
}

.login-brand-points div{
    font-size:13.5px;
    margin-bottom:12px;
    color:rgba(255,255,255,0.85);
}

.login-brand-points i{
    color:#ff8a50;
    margin-right:8px;
}

/* ===== Right form panel ===== */
.login-form-panel{
    flex:1;
    padding:50px 45px;
}

.login-header{
    margin-bottom:30px;
}

.login-header h2{
    color:#1c3c4d;
    margin:0 0 6px;
    font-size:26px;
    font-weight:700;
}

.login-header p{
    color:#888;
    margin:0;
    font-size:14px;
}

.login-card .form-group{
    margin-bottom:20px;
	gap:8px;
	align-items:center;
    justify-content: space-evenly;
}

.login-card label{
    display:block;
    font-weight:600;
    margin-bottom:7px;
    font-size:13px;
    color:#333;
}

.login-input-icon{
    position:relative;
}

.login-input-icon i{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:#23495c;
    font-size:14px;
}

.login-card .form-control{
    width:100%;
    height:50px;
    border:1.5px solid #e3e3e3;
    border-radius:10px;
    padding:10px 15px 10px 42px;
    box-sizing:border-box;
    font-size:14px;
    background:#fafafa;
    transition:all .25s ease;
}

.login-card .form-control:focus{
    outline:none;
    border-color:#23495c;
    background:#fff;
    box-shadow:0 0 0 3px rgba(35,73,92,0.12);
}

.login-btn{
    width:100%;
    height:50px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#23495c,#2f6480);
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    margin-top:6px;
    transition:transform .2s ease, box-shadow .2s ease;
    box-shadow:0 10px 22px rgba(35,73,92,0.28);
}

.login-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 28px rgba(35,73,92,0.36);
}

.login-btn:active{
    transform:translateY(0);
}

.login-divider{
    display:flex;
    align-items:center;
    text-align:center;
    color:#aaa;
    font-size:12px;
    margin:24px 0;
}

.login-divider::before,
.login-divider::after{
    content:"";
    flex:1;
    border-bottom:1px solid #eee;
}

.login-divider span{
    padding:0 12px;
}

.register-box{
    text-align:center;
}

.register-box h4{
    font-size:13.5px;
    color:#777;
    font-weight:500;
    margin:0 0 4px;
}

.register-link{
    color:#23495c;
    text-decoration:none;
    font-weight:700;
    font-size:14.5px;
}

.register-link:hover{
    text-decoration:underline;
}

@media(max-width:768px){

    .login-wrapper{
        padding:20px 12px;
    }

    .login-card{
        flex-direction:column;
        max-width:480px;
    }

    .login-brand{
        flex:none;
        padding:30px 30px 26px;
    }

    .login-brand-points{
        display:none;
    }

    .login-form-panel{
        padding:35px 28px 40px;
    }

}

</style>

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

            <form method="post">

                <div class="form-group">
                    <label>Email Address</label>
                    <div class="login-input-icon">
                        <i class="fa fa-envelope"></i>
                        <input
                            type="email"
                            name="c_email"
                            class="form-control"
                            placeholder="Enter your email"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="login-input-icon">
                        <i class="fa fa-lock"></i>
                        <input
                            type="password"
                            name="c_password"
                            class="form-control"
                            placeholder="Enter your password"
                            required
                        >
                    </div>
                </div>

                <button
                    type="submit"
                    name="login"
                    class="login-btn">
                    <i class="fa fa-sign-in"></i> Login
                </button>

            </form>

            <div class="login-divider"><span>OR</span></div>

            <div class="register-box">
                <h4>New Customer?</h4>
                <a
                    href="customer_registration.php"
                    class="register-link">
                    Create Your Account
                </a>
                <br/>
                <h4>Admin</h4>
                <a
                    href="admin_area/login.php"
                    class="register-link">
                    Login as Admin
                </a>
            </div>

        </div>

    </div>

</div>

<?php

if(isset($_POST['login'])){

    $customer_email = $_POST['c_email'];
    $customer_pass  = $_POST['c_password'];

    $select_customers = "select * from customers
    where customer_email='$customer_email'
    AND customer_pass='$customer_pass'";

    $run_cust = mysqli_query($con,$select_customers);

    $get_ip = getUserIp();

    $check_customer = mysqli_num_rows($run_cust);

    $select_cart = "select * from cart where ip_add='$get_ip'";

    $run_cart = mysqli_query($con,$select_cart);

    $check_cart = mysqli_num_rows($run_cart);

    if($check_customer == 0){

        echo "<script>alert('Password or Email Wrong')</script>";
        exit();

    }

    if($check_customer == 1 && $check_cart == 0){

        $_SESSION['customer_email'] = $customer_email;

        echo "<script>alert('You are logged In')</script>";

        echo "<script>
        window.open('customer/my_account.php','_self')
        </script>";

    }else{

        $_SESSION['customer_email'] = $customer_email;

        echo "<script>alert('You are logged In')</script>";

        echo "<script>
        window.open('checkout.php','_self')
        </script>";

    }

}

?>