<?php
session_start();
include("includes/db.php");

include("functions/functions.php");
  ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopixia - Buy with Joy!</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- owl carousel css file cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
  <style>

    /* ===== Stylish Registration Form ===== */
    .reg-wrapper{
        width:100%;
        min-height:80vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:40px 15px;
        background:linear-gradient(135deg,#f5f7fa 0%,#eef1f5 100%);
        box-sizing:border-box;
    }

    .reg-card{
        width:100%;
        max-width:650px;
        background:#ffffff;
        border-radius:18px;
        box-shadow:0 15px 40px rgba(0,0,0,0.08);
        overflow:hidden;
        animation:fadeUp .6s ease;
    }

    @keyframes fadeUp{
        from{opacity:0; transform:translateY(25px);}
        to{opacity:1; transform:translateY(0);}
    }

    .reg-card-header{
        background:linear-gradient(135deg,#1F4556,#2C6178);
        padding:30px 20px;
        text-align:center;
        color:#fff;
    }

    .reg-card-header h2{
        margin:0;
        font-size:28px;
        font-weight:700;
        letter-spacing:.5px;
    }

    .reg-card-header p{
        margin:6px 0 0;
        font-size:14px;
        opacity:.9;
    }

    .reg-form{
        padding:35px 40px 40px;
    }

    .reg-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:18px 20px;
    }

    .reg-group{
        position:relative;
        margin-bottom:4px;
    }

    .reg-group.full{
        grid-column:1 / -1;
    }

    .reg-group label{
        display:block;
        font-size:13px;
        font-weight:600;
        color:#333;
        margin-bottom:6px;
        letter-spacing:.3px;
    }

    .reg-input-icon{
        position:relative;
    }
.reg-input-icon i{
    color:#1F4556;
    font-size:14px;
}

.reg-group input[type="text"]:focus,
.reg-group input[type="password"]:focus,
.reg-group input[type="email"]:focus{
    border-color:#1F4556;
    background:#fff;
    outline:none;
    box-shadow:0 0 0 3px rgba(31,69,86,0.12);
}

.reg-file:hover{
    border-color:#1F4556;
    background:#f3f8fa;
}

.reg-file i{
    color:#1F4556;
    font-size:18px;
}

.reg-btn{
    width:100%;
    padding:13px 0;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#1F4556,#2C6178);
    color:#fff;
    font-size:16px;
    font-weight:700;
    letter-spacing:.5px;
    cursor:pointer;
    transition:transform .2s ease, box-shadow .2s ease;
    box-shadow:0 8px 20px rgba(31,69,86,0.3);
}

.reg-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 26px rgba(31,69,86,0.4);
}

.reg-login-link a{
    color:#1F4556;
    font-weight:600;
    text-decoration:none;
}

    .reg-group input[type="text"]:focus,
    .reg-group input[type="password"]:focus,
    .reg-group input[type="email"]:focus{
        border-color:#1F4556;
        background:#fff;
        outline:none;
        box-shadow:0 0 0 3px rgba(255,87,34,0.12);
    }

    .reg-file{
        display:flex;
        align-items:center;
        gap:10px;
        border:1.5px dashed #d8d8d8;
        border-radius:10px;
        padding:10px 14px;
        background:#fafafa;
        transition:all .25s ease;
        cursor:pointer;
    }

    .reg-file:hover{
        border-color:#1F4556;
        background:#fff5f0;
    }

    .reg-file i{
        color:#1F4556;
        font-size:18px;
    }

    .reg-file input[type="file"]{
        border:none;
        background:transparent;
        padding:0;
        font-size:13px;
        flex:1;
    }

    .reg-submit-wrap{
        text-align:center;
        margin-top:28px;
    }

    .reg-btn{
        width:100%;
        padding:13px 0;
        border:none;
        border-radius:10px;
        background:linear-gradient(135deg,#1F4556,#2C6178);
        color:#fff;
        font-size:16px;
        font-weight:700;
        letter-spacing:.5px;
        cursor:pointer;
        transition:transform .2s ease, box-shadow .2s ease;
        box-shadow:0 8px 20px rgba(255,87,34,0.3);
    }

    .reg-btn:hover{
        transform:translateY(-2px);
        box-shadow:0 12px 26px rgba(255,87,34,0.4);
    }

    .reg-btn:active{
        transform:translateY(0);
    }

    .reg-login-link{
        text-align:center;
        margin-top:18px;
        font-size:13.5px;
        color:#666;
    }

    .reg-login-link a{
        color:#1F4556;
        font-weight:600;
        text-decoration:none;
    }

    .reg-login-link a:hover{
        text-decoration:underline;
    }

    /* Responsive */
    @media (max-width: 640px){
        .reg-grid{
            grid-template-columns:1fr;
        }
        .reg-form{
            padding:28px 20px 30px;
        }
        .reg-card-header{
            background:linear-gradient(135deg,#173746,#1F4556);
            padding:30px 20px;
            text-align:center;
            color:#fff;
        }
    }

  </style>
 
</head>
<body>

<!-- header section starts  -->

<header>

<div class="header-1">

    <a href="index.php" class="logo" > <img src="website/all/logo5.svg" alt="Logo image" class="hidden-xs">  </a>
                               
<div class="col-md-6 offer">
    <a href="#" class="btn btn-sucess btn-sm">
        <?php

        if (!isset($_SESSION['customer_email'])){
        echo "Welcome Guest";
      }else{
      echo "Welcome: " .$_SESSION['customer_email'] . "";
    }


        ?>
    </a>
<a id="pr" href="#"> Shopping Cart Total Price: $ <?php totalPrice(); ?>, Total Items <?php item(); ?></a>
</div>
  
</div>

<div class="header-2">
   

<nav class="navbar"> 


     <ul >
      
            <li><a  href="index.php">HOME</a></li>
            <li><a  href="trimer.php">SHOP</a></li>
        <li><a href="contactus.php">CONTACT</a></li>
       <div class="col-md-6">
        <ul class="menu">
            <li>
                         <div class="collapse clearfix" id="search">
                             <form class="navbar-form" method="get" action="result.php">
                                 <div class="input-group">
                                     <input type="text" name="user_query" placeholder="search" class="form-control" required="">
                                     <button type="submit" value="search" name="search" class="btn btn-primary">
                                         <i class="fa fa-search"></i>
                                     </button>
                                 </div>
                             </form>
                         </div>
                   </li>



                <li>
                  <a href="cart.php" class="">
                    <i class="fa fa-shopping-cart"></i>
                      <span><?php item(); ?> items in cart</span>
                        </a>
                </li>
                   

                   <li>
                   <a class="active" href="#customer_registration.php"><i class="fa fa-user-plus"></i>Register</a></li>
                   <li>
                   <?php

                    if (!isset($_SESSION['customer_email'])){
                    echo "<a href='checkout.php'>My Account</a>";

                         } else{
                    
                    echo "<a href='customer/my_account.php?my_order'>My Account</a>";
                
                         }

                    ?></li> 
                     
                   <li>
                   <a href="cart.php"><i class="fa fa-shopping-cart"></i>Goto Cart</a></li>
                    
                   <li>
                    <?php

                    if (!isset($_SESSION['customer_email'])){
                    echo "<a href='checkout.php'>Login</a>";

                         } else{
                    
                    echo "<a href='logout.php'>Logout</a>";
                
                         }

                    ?>


                   </li>
             </ul>
       </div>
</ul>



</nav></div></header>

<!-- header section End  -->

<section class="content" id="content">
  <div class="container">
    <div class="col-md-12">
      <ul class="breadcrumb">
     
        <li><span>Customer Registration</span></li>
        

      </ul>

    </div>
</div></section>  

<!-- ===== Stylish Registration Form Starts ===== -->
<div class="reg-wrapper">
  <div class="reg-card">

      <div class="reg-card-header">
        <h2><i class="fa fa-user-plus"></i> Register A New Account</h2>
        <p>Join Shopixia and start shopping with joy!</p>
      </div>

      <form action="customer_registration.php" method="post" enctype="multipart/form-data" class="reg-form">

          <div class="reg-grid">

              <div class="reg-group">
                <label>Customer Name</label>
                <div class="reg-input-icon">
                    <i class="fa fa-user"></i>
                    <input type="text" name="c_name" required placeholder="Full name">
                </div>
              </div>

              <div class="reg-group">
                <label>Customer Email</label>
                <div class="reg-input-icon">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="c_email" required placeholder="you@example.com">
                </div>
              </div>

              <div class="reg-group">
                <label>Customer Password</label>
                <div class="reg-input-icon">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="c_password" required placeholder="Password">
                </div>
              </div>

              <div class="reg-group">
                <label>Country</label>
                <div class="reg-input-icon">
                    <i class="fa fa-globe"></i>
                    <input type="text" name="c_country" required placeholder="Country">
                </div>
              </div>

              <div class="reg-group">
                <label>City</label>
                <div class="reg-input-icon">
                    <i class="fa fa-city"></i>
                    <input type="text" name="c_city" required placeholder="City">
                </div>
              </div>

              <div class="reg-group">
                <label>Contact Number</label>
                <div class="reg-input-icon">
                    <i class="fa fa-phone"></i>
                    <input type="text" name="c_contact" required placeholder="Phone number">
                </div>
              </div>

              <div class="reg-group full">
                <label>Address</label>
                <div class="reg-input-icon">
                    <i class="fa fa-map-marker-alt"></i>
                    <input type="text" name="c_address" required placeholder="Full address">
                </div>
              </div>

              <div class="reg-group full">
                <label>Profile Image</label>
                <div class="reg-file">
                    <i class="fa fa-image"></i>
                    <input type="file" name="c_image" required accept="image/*">
                </div>
              </div>

          </div>

          <div class="reg-submit-wrap">
            <button type="submit" name="submit" class="reg-btn">
              <i class="fa fa-user-plus"></i> Register Now
            </button>
            <div class="reg-login-link">
                Already have an account? <a href="checkout.php">Login here</a>
            </div>
          </div>

      </form>

  </div>
</div>
<!-- ===== Stylish Registration Form Ends ===== -->

     <!-- footer section starts  -->
   <?php
      include("includes/footer.php");  
      ?>
<!-- footer section   -->

</body></html>

<?php 

if (isset($_POST['submit'])) {
  $c_name=$_POST['c_name'];
  $c_email=$_POST['c_email'];
  $c_password=$_POST['c_password'];
  $c_country=$_POST['c_country'];
  $c_city=$_POST['c_city'];
  $c_contact=$_POST['c_contact'];
  $c_address=$_POST['c_address'];
  $c_image=$_FILES['c_image']['name'];
    $c_tmp_image=$_FILES['c_image']['tmp_name'];
    $c_ip=getUserIp();

    move_uploaded_file($c_tmp_image, "customer/customer_images/$c_image");
    $insert_customer="insert into customers (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, customer_address, customer_image, customer_ip) values('$c_name','$c_email','$c_password','$c_country','$c_city','$c_contact','$c_address','$c_image','$c_ip')";
    $run_customer=mysqli_query($con,$insert_customer);
    $sel_cart="select * from cart where ip_add='$c_ip'";
    $run_cart=mysqli_query($con,$sel_cart);
    $check_cart=mysqli_num_rows($run_cart);
    if($check_cart>0){
    $_SESSION['customer_email']=$c_email;
    echo "<script>alert('you have been registered successfully')</script>";
    echo "<script>window.open('checkout.php','_self')</script>";
  }else {
    $_SESSION['customer_email']=$c_email;
    echo "<script>alert('you have been registered successfully')</script>";
    echo "<script>window.open('index.php','_self')</script>"; 
}
}


?>