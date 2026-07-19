<?php
// session_start চেক
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// functions.php include
if (!function_exists('getUserIp')) {
    include("includes/db.php");
    include("functions/functions.php");
} else {
    include("includes/db.php");
}

// বর্তমান ফোল্ডার পাথ ডিটেক্ট করুন
$current_path = dirname($_SERVER['PHP_SELF']);
$base_path = str_repeat('../', substr_count($current_path, '/') - 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopixia - Multi Vendor Ecommerce Platform</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>style.css">
    <style>
        /* ===== NAVBAR STYLES ===== */
        .header-2 {
            background-color: #1b4353 !important;
            padding: 10px 20px !important;
            position: sticky;
            top: 0;
            z-index: 20000;
            box-shadow: rgba(0, 0, 0, 0.35) 0rem .5rem 1.5rem;
        }

        .spx-nav-container {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
        }

        ul.spx-main-menu {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
            align-items: center !important;
            width: 100% !important;
        }

        ul.spx-main-menu > li {
            position: relative !important;
            display: inline-block !important;
        }

        ul.spx-main-menu > li > a {
            color: #ffffff !important;
            padding: 12px 15px !important;
            display: block !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            text-decoration: none !important;
        }

        ul.spx-main-menu > li > a:hover, 
        ul.spx-main-menu > li > a.active {
            background-color: #ff523b !important;
            color: #ffffff !important;
            border-radius: 4px !important;
        }

        ul.spx-main-menu li ul.spx-dropdown {
            display: none !important;
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            background-color: #ffffff !important;
            min-width: 220px !important;
            list-style: none !important;
            padding: 10px 0 !important;
            margin: 0 !important;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2) !important;
            z-index: 99999 !important;
            border-top: 3px solid #ff523b !important;
            border-radius: 0 0 4px 4px !important;
        }

        ul.spx-main-menu li:hover ul.spx-dropdown {
            display: block !important;
        }

        ul.spx-main-menu li ul.spx-dropdown li a {
            color: #333333 !important;
            padding: 10px 20px !important;
            display: block !important;
            font-size: 13px !important;
            text-transform: capitalize !important;
            text-decoration: none !important;
        }

        ul.spx-main-menu li ul.spx-dropdown li a:hover {
            background-color: #f8f9fa !important;
            color: #ff523b !important;
            padding-left: 25px !important;
        }

        .spx-right-menu {
            margin-left: auto !important;
            display: flex !important;
            align-items: center !important;
        }

        .spx-right-menu ul.menu-items {
            display: flex !important;
            flex-wrap: wrap !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
            align-items: center;
        }

        .spx-right-menu ul.menu-items li a {
            color: #fff !important;
            padding: 10px !important;
            font-size: 13px !important;
            text-decoration: none !important;
        }

        .spx-right-menu ul.menu-items li a:hover {
            color: #ff523b !important;
        }

        .spx-right-menu ul.menu-items li a i {
            margin-right: 5px;
        }

        .header-1 {
            background: url(<?php echo $base_path; ?>website/all/back.jpg) no-repeat;
            background-blend-mode: multiply;
            background-size: cover;
            background-position: center;
            padding: 20px 10px;
            text-align: center;
        }

        header .header-1 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            width: 100%;
            z-index: 10;
        }

        header .header-1 .logo img {
            width: 20rem;
        }

        .col-md-6.offer {
            color: #fff;
        }

        .col-md-6.offer a {
            color: #fff;
            text-decoration: none;
        }

        #pr {
            color: #ff523b !important;
            font-weight: bold;
        }

        /* Search Box */
        .navbar-form .input-group {
            display: flex;
            align-items: center;
        }

        .navbar-form .form-control {
            padding: 6px 10px;
            border: none;
            border-radius: 4px 0 0 4px;
            outline: none;
            font-size: 13px;
            width: 150px;
        }

        .navbar-form .btn-primary {
            background: #ff523b;
            border: none;
            color: white;
            padding: 7px 12px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        .navbar-form .btn-primary:hover {
            background: #e0452f;
        }

        /* ===== CART SIDEBAR ===== */
        .cart-sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999999;
        }

        .cart-sidebar-overlay.active {
            display: block;
        }

        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -450px;
            width: 420px;
            height: 100%;
            background: #ffffff;
            z-index: 1000000;
            box-shadow: -5px 0 30px rgba(0,0,0,0.2);
            transition: right 0.4s ease;
            overflow-y: auto;
            padding: 20px;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f2f6;
            margin-bottom: 20px;
        }

        .cart-sidebar-header h3 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }

        .cart-sidebar-header .close-cart {
            background: none;
            border: none;
            font-size: 28px;
            color: #6c757d;
            cursor: pointer;
        }

        .cart-sidebar-header .close-cart:hover {
            color: #ff523b;
        }

        .cart-sidebar-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f2f6;
        }

        .cart-sidebar-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            background: #f8f9fa;
        }

        .cart-sidebar-item .item-info {
            flex: 1;
        }

        .cart-sidebar-item .item-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: #2d3436;
            margin: 0 0 4px;
        }

        .cart-sidebar-item .item-info .item-price {
            color: #ff523b;
            font-weight: 700;
        }

        .cart-sidebar-footer {
            position: sticky;
            bottom: 0;
            background: #fff;
            padding: 15px 0;
            border-top: 2px solid #f1f2f6;
            margin-top: 20px;
        }

        .cart-sidebar-footer .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 15px;
        }

        .cart-sidebar-footer .total-row .total-price {
            color: #ff523b;
        }

        .cart-sidebar-footer .checkout-btn {
            display: block;
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff523b, #ff6b5a);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .cart-sidebar-footer .checkout-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(255,82,59,0.3);
        }

        .empty-cart-msg {
            text-align: center;
            padding: 40px 0;
            color: #6c757d;
        }

        .empty-cart-msg i {
            font-size: 48px;
            color: #dee2e6;
            margin-bottom: 15px;
            display: block;
        }

        .cart-success-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #00b894;
            color: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 9999999;
            transform: translateX(120%);
            transition: transform 0.4s ease;
            font-weight: 500;
            font-size: 14px;
        }

        .cart-success-notification.show {
            transform: translateX(0);
        }

        .cart-success-notification.error {
            background: #ff523b;
        }

        @media (max-width: 992px) {
            ul.spx-main-menu { flex-wrap: wrap !important; }
            .spx-right-menu { margin-left: 0 !important; width: 100% !important; }
            .spx-right-menu ul.menu-items { flex-wrap: wrap !important; justify-content: center !important; }
            ul.spx-main-menu > li > a { padding: 8px 10px !important; font-size: 12px !important; }
            .navbar-form .form-control { width: 100px !important; }
            header .header-1 { flex-direction: column !important; }
            header .header-1 .logo img { width: 15rem !important; }
            .cart-sidebar { width: 380px; right: -380px; }
        }

        @media (max-width: 768px) {
            ul.spx-main-menu { flex-direction: column !important; align-items: stretch !important; }
            ul.spx-main-menu > li { display: block !important; }
            ul.spx-main-menu > li > a { text-align: center !important; }
            .spx-right-menu ul.menu-items { flex-direction: column !important; align-items: stretch !important; }
            .spx-right-menu ul.menu-items li { display: block !important; text-align: center !important; }
            .navbar-form .input-group { justify-content: center !important; }
            .navbar-form .form-control { width: 80% !important; }
            ul.spx-main-menu li ul.spx-dropdown { position: static !important; width: 100% !important; }
            .cart-sidebar { width: 100% !important; right: -100% !important; }
        }
    </style>
</head>
<body>

<!-- ===== CART SIDEBAR ===== -->
<div class="cart-sidebar-overlay" id="cartOverlay"></div>
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-sidebar-header">
        <h3>🛒 Your Cart</h3>
        <button class="close-cart" onclick="closeCartSidebar()">✕</button>
    </div>
    <div id="cartSidebarContent">
        <div class="empty-cart-msg">
            <i class="fas fa-shopping-bag"></i>
            <p>Your cart is empty</p>
            <small>Start shopping to add items</small>
        </div>
    </div>
</div>

<!-- ===== NOTIFICATION ===== -->
<div class="cart-success-notification" id="cartNotification"></div>

<!-- ===== HEADER ===== -->
<header>
    <div class="header-1">
        <a href="<?php echo $base_path; ?>index.php" class="logo"> 
            <img src="<?php echo $base_path; ?>website/all/logo5.svg" alt="Logo image" class="hidden-xs"> 
        </a>                     
        <div class="col-md-6 offer">
            <a href="#" class="btn btn-sucess btn-sm">
                <?php
                if (!isset($_SESSION['customer_email'])){
                    echo "Welcome Guest";
                } else {
                    echo "Welcome: " . $_SESSION['customer_email'];
                }
                ?>
            </a>
            <a id="pr" href="#"> Shopping Cart Total Price: £ <?php totalPrice(); ?>, Total Items <?php item(); ?></a>
        </div>
    </div>

    <div class="header-2">
        <nav class="spx-nav-container"> 
            <ul class="spx-main-menu">
                <li><a href="<?php echo $base_path; ?>index.php">HOME</a></li> 
                
                <?php 
                $get_cats = "SELECT * FROM categories";
                $run_cats = mysqli_query($con, $get_cats);
                while($row_cats = mysqli_fetch_array($run_cats)){
                    $cat_id = $row_cats['cat_id'];
                    $cat_title = $row_cats['cat_title'];
                    
                    $get_sub_cats = "SELECT * FROM product_category WHERE cat_id='$cat_id'";
                    $run_sub_cats = mysqli_query($con, $get_sub_cats);
                    $count_sub_cats = mysqli_num_rows($run_sub_cats);
                    
                    if($count_sub_cats > 0){
                        echo "
                        <li>
                            <a href='#'>$cat_title <i class='fa fa-caret-down'></i></a>
                            <ul class='spx-dropdown'>
                        ";
                        while($row_sub_cats = mysqli_fetch_array($run_sub_cats)){
                            $p_cat_id = $row_sub_cats['p_cat_id'];
                            $p_cat_title = $row_sub_cats['p_cat_title'];
                            echo "<li><a href='".$base_path."trimer.php?p_cat=$p_cat_id'>$p_cat_title</a></li>";
                        }
                        echo "
                            </ul>
                        </li>
                        ";
                    } else {
                        echo "<li><a href='".$base_path."trimer.php?cat=$cat_id'>$cat_title</a></li>";
                    }
                }
                ?>

                <li><a href="<?php echo $base_path; ?>trimer.php">PRODUCTS</a></li>
                <li><a href="<?php echo $base_path; ?>#deal">DEAL</a></li>
                <li><a href="<?php echo $base_path; ?>contactus.php">CONTACT</a></li>
                
                <li class="spx-right-menu">
                    <ul class="menu-items">
                        <li>
                            <div class="collapse clearfix" id="search">
                                <form class="navbar-form" method="get" action="<?php echo $base_path; ?>result.php">
                                    <div class="input-group">
                                        <input type="text" name="user_query" placeholder="Search" class="form-control" required>
                                        <button type="submit" value="search" name="search" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="openCartSidebar()">
                                <i class="fa fa-shopping-cart"></i>
                                <span id="cart-count"><?php echo item(); ?></span> items
                            </a>
                        </li>
                        <li><a href="<?php echo $base_path; ?>customer_registration.php"><i class="fa fa-user-plus"></i>Register</a></li>
                        <li>
                            <?php
                            if (!isset($_SESSION['customer_email'])){
                                echo "<a href='".$base_path."checkout.php'><i class='fa fa-user'></i> My Account</a>";
                            } else {
                                echo "<a href='".$base_path."customer/my_account.php?my_order'><i class='fa fa-user'></i> My Account</a>";
                            }
                            ?>
                        </li> 
                        <li>
                            <?php
                            if (!isset($_SESSION['customer_email'])){
                                echo "<a href='".$base_path."checkout.php'><i class='fa fa-sign-in-alt'></i> Login</a>";
                            } else {
                                echo "<a href='".$base_path."logout.php'><i class='fa fa-sign-out-alt'></i> Logout</a>";
                            }
                            ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
// ============================================
// CART SIDEBAR FUNCTIONS
// ============================================
function openCartSidebar() {
    document.getElementById('cartSidebar').classList.add('open');
    document.getElementById('cartOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCartSidebar() {
    document.getElementById('cartSidebar').classList.remove('open');
    document.getElementById('cartOverlay').classList.remove('active');
    document.body.style.overflow = '';
}

// ============================================
// ADD TO CART
// ============================================
function addToCart(productId) {
    const btn = document.querySelector(`button[onclick*="addToCart(${productId})"]`);
    if (!btn) return;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
    btn.disabled = true;
    
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}&quantity=1&size=Standard`
    })
    .then(response => response.json())
    .then(data => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        if (data.status === 'success') {
            showCartNotification('✅ ' + data.message, 'success');
            document.getElementById('cart-count').textContent = data.cart_count;
            loadCartSidebar();
            setTimeout(() => openCartSidebar(), 500);
        } else {
            showCartNotification('❌ ' + data.message, 'error');
        }
    })
    .catch(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showCartNotification('❌ Failed to add to cart', 'error');
    });
}

// ============================================
// LOAD CART SIDEBAR
// ============================================
function loadCartSidebar() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_cart_items.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            try {
                var response = JSON.parse(this.responseText);
                updateCartSidebar(response.items, response.total, response.count);
            } catch(e) {}
        }
    };
    xhr.send();
}

// ============================================
// UPDATE CART SIDEBAR
// ============================================
function updateCartSidebar(items, total, count) {
    var content = '';
    if(items && items.length > 0) {
        content = '<div class="cart-sidebar-items">';
        for(var i = 0; i < items.length; i++) {
            var item = items[i];
            content += `
                <div class="cart-sidebar-item">
                    <img src="admin_area/product_images/${item.image}" alt="${item.title}">
                    <div class="item-info">
                        <h4>${item.title}</h4>
                        <div>
                            <span class="item-price">£${parseFloat(item.price).toFixed(2)}</span>
                            <span style="color:#6c757d;font-size:13px;"> × ${item.qty}</span>
                            ${item.size ? `<span style="color:#6c757d;font-size:13px;"> | Size: ${item.size}</span>` : ''}
                        </div>
                    </div>
                    <span style="font-weight:700;color:#ff523b;">£${parseFloat(item.sub_total).toFixed(2)}</span>
                </div>
            `;
        }
        content += '</div>';
        content += `
            <div class="cart-sidebar-footer">
                <div class="total-row">
                    <span>Total (${count} items):</span>
                    <span class="total-price">£${total}</span>
                </div>
                <a href="checkout.php" class="checkout-btn">
                    <i class="fas fa-credit-card"></i> Proceed to Checkout
                </a>
            </div>
        `;
    } else {
        content = `
            <div class="empty-cart-msg">
                <i class="fas fa-shopping-bag"></i>
                <p>Your cart is empty</p>
                <small>Start shopping to add items</small>
            </div>
        `;
    }
    document.getElementById('cartSidebarContent').innerHTML = content;
}

// ============================================
// CART NOTIFICATION
// ============================================
function showCartNotification(message, type = 'success') {
    var notification = document.getElementById('cartNotification');
    notification.textContent = message;
    notification.className = 'cart-success-notification';
    if(type === 'error') { notification.classList.add('error'); }
    notification.classList.add('show');
    clearTimeout(notification._timeout);
    notification._timeout = setTimeout(function() {
        notification.classList.remove('show');
    }, 3000);
}

// ============================================
// EVENT LISTENERS
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('cartOverlay').addEventListener('click', closeCartSidebar);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeCartSidebar(); }
    });
    loadCartSidebar();
});
</script>