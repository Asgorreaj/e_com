<?php 
session_start();
if (!isset($_SESSION['customer_email'])) {
  echo "<script>window.open('../checkout.php','_self')</script>";
} else {
  include("../includes/db.php");  
  include("../functions/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopixia - My Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        /* ============================================
           MY ACCOUNT PAGE - MODERN DESIGN
           ============================================ */
        .account-wrapper {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
        }

        /* Breadcrumb */
        .breadcrumb-custom {
            background: #f8f9fa;
            padding: 12px 20px;
            border-radius: 8px;
            max-width: 1400px;
            margin: 20px auto 0;
            padding: 0 20px;
        }

        .breadcrumb-custom span {
            color: #6c757d;
            font-size: 14px;
        }

        /* Sidebar */
        .account-sidebar {
            background: #ffffff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .account-sidebar .profile-img {
            text-align: center;
            margin-bottom: 20px;
        }

        .account-sidebar .profile-img img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ff523b;
            padding: 3px;
        }

        .account-sidebar .profile-name {
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 5px;
        }

        .account-sidebar .profile-email {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .account-sidebar .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .account-sidebar .sidebar-menu li {
            border-bottom: 1px solid #f1f2f6;
        }

        .account-sidebar .sidebar-menu li:last-child {
            border-bottom: none;
        }

        .account-sidebar .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #2d3436;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .account-sidebar .sidebar-menu li a:hover {
            background: #f8f9fa;
            color: #ff523b;
        }

        .account-sidebar .sidebar-menu li a.active {
            background: rgba(255,82,59,0.08);
            color: #ff523b;
        }

        .account-sidebar .sidebar-menu li a i {
            width: 20px;
            text-align: center;
            color: #6c757d;
        }

        .account-sidebar .sidebar-menu li a:hover i {
            color: #ff523b;
        }

        /* Main Content */
        .account-content {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .account-content .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f2f6;
        }

        /* Orders Table */
        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            text-align: left;
            padding: 12px 10px;
            background: #f8f9fa;
            font-size: 13px;
            font-weight: 700;
            color: #2d3436;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }

        .orders-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f1f2f6;
            font-size: 14px;
            color: #2d3436;
        }

        .orders-table .status-pending {
            display: inline-block;
            padding: 3px 12px;
            background: #ffc107;
            color: #212529;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .orders-table .status-complete {
            display: inline-block;
            padding: 3px 12px;
            background: #00b894;
            color: #fff;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .orders-table .status-cancelled {
            display: inline-block;
            padding: 3px 12px;
            background: #dc3545;
            color: #fff;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .orders-table .view-btn {
            padding: 5px 15px;
            background: #ff523b;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .orders-table .view-btn:hover {
            background: #e0452f;
            transform: scale(1.02);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
            display: block;
        }

        .empty-state h3 {
            font-size: 24px;
            color: #2d3436;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6c757d;
            font-size: 16px;
        }

        .empty-state .shop-btn {
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

        .empty-state .shop-btn:hover {
            background: #e0452f;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .account-wrapper {
                grid-template-columns: 1fr;
            }
            .account-sidebar {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .orders-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            .account-content {
                padding: 20px 15px;
            }
            .account-sidebar {
                padding: 20px 15px;
            }
            .account-sidebar .profile-img img {
                width: 80px;
                height: 80px;
            }
        }

        @media (max-width: 480px) {
            .account-content .page-title {
                font-size: 20px;
            }
            .orders-table th,
            .orders-table td {
                padding: 8px 6px;
                font-size: 12px;
            }
            .account-sidebar .sidebar-menu li a {
                font-size: 13px;
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>

<!-- ============================================
HEADER - Include from parent
============================================ -->
<?php include("../header.php"); ?>

<!-- ============================================
BREADCRUMB
============================================ -->
<div class="breadcrumb-custom">
    <span>🏠 My Account</span>
</div>

<!-- ============================================
ACCOUNT SECTION
============================================ -->
<div class="account-wrapper">
    
    <!-- Sidebar -->
    <div class="account-sidebar">
        <?php
        $session_email = $_SESSION['customer_email'];
        $select_customer = "SELECT * FROM customers WHERE customer_email='$session_email'";
        $run_customer = mysqli_query($con, $select_customer);
        $row_customer = mysqli_fetch_array($run_customer);
        ?>
        
        <div class="profile-img">
            <img src="customer_images/<?php echo $row_customer['customer_image']; ?>" 
                 alt="<?php echo $row_customer['customer_name']; ?>">
        </div>
        <div class="profile-name"><?php echo $row_customer['customer_name']; ?></div>
        <div class="profile-email"><?php echo $row_customer['customer_email']; ?></div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="my_account.php?my_order" class="<?php echo isset($_GET['my_order']) ? 'active' : ''; ?>">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </a>
            </li>
            <li>
                <a href="my_account.php?pay_offline" class="<?php echo isset($_GET['pay_offline']) ? 'active' : ''; ?>">
                    <i class="fas fa-credit-card"></i> Pay Offline
                </a>
            </li>
            <li>
                <a href="my_account.php?edit_act" class="<?php echo isset($_GET['edit_act']) ? 'active' : ''; ?>">
                    <i class="fas fa-user-edit"></i> Edit Account
                </a>
            </li>
            <li>
                <a href="my_account.php?change_pass" class="<?php echo isset($_GET['change_pass']) ? 'active' : ''; ?>">
                    <i class="fas fa-key"></i> Change Password
                </a>
            </li>
            <li>
                <a href="my_account.php?delete_ac" class="<?php echo isset($_GET['delete_ac']) ? 'active' : ''; ?>" 
                   onclick="return confirm('Are you sure you want to delete your account?')">
                    <i class="fas fa-trash-alt"></i> Delete Account
                </a>
            </li>
            <li>
                <a href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="account-content">
        <?php
        // My Orders
        if (isset($_GET['my_order'])) {
            ?>
            <h2 class="page-title">📦 My Orders</h2>
            
            <?php
            $customer_id = $row_customer['customer_id'];
            $select_orders = "SELECT * FROM customer_order WHERE customer_id='$customer_id' ORDER BY order_id DESC";
            $run_orders = mysqli_query($con, $select_orders);
            $count_orders = mysqli_num_rows($run_orders);
            
            if($count_orders > 0) {
            ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Invoice No</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row_order = mysqli_fetch_array($run_orders)) {
                        $order_id = $row_order['order_id'];
                        $invoice_no = $row_order['invoice_no'];
                        $product_id = $row_order['product_id'];
                        $qty = $row_order['qty'];
                        $due_amount = $row_order['due_amount'];
                        $order_status = $row_order['order_status'];
                        $order_date = $row_order['order_date'];
                        
                        // Get product title
                        $get_pro = "SELECT product_title FROM products WHERE product_id='$product_id'";
                        $run_pro = mysqli_query($con, $get_pro);
                        $row_pro = mysqli_fetch_array($run_pro);
                        $product_title = $row_pro['product_title'] ?? 'Unknown';
                        
                        $status_class = 'status-pending';
                        if(strtolower($order_status) == 'complete' || strtolower($order_status) == 'completed') {
                            $status_class = 'status-complete';
                        } elseif(strtolower($order_status) == 'cancelled') {
                            $status_class = 'status-cancelled';
                        }
                    ?>
                    <tr>
                        <td>#<?php echo $order_id; ?></td>
                        <td><?php echo $invoice_no; ?></td>
                        <td><?php echo substr($product_title, 0, 20) . (strlen($product_title) > 20 ? '...' : ''); ?></td>
                        <td><?php echo $qty; ?></td>
                        <td>£<?php echo number_format($due_amount, 2); ?></td>
                        <td>
                            <span class="<?php echo $status_class; ?>">
                                <?php echo ucfirst($order_status); ?>
                            </span>
                        </td>
                        <td><?php echo date('d M Y', strtotime($order_date)); ?></td>
                        <td>
                            <a href="../details.php?pro_id=<?php echo $product_id; ?>" class="view-btn">
                                View
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php 
            } else { 
            ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet. Start shopping!</p>
                <a href="../index.php" class="shop-btn">Start Shopping</a>
            </div>
            <?php 
            }
        }
        
        // Pay Offline
        elseif (isset($_GET['pay_offline'])) {
            ?>
            <h2 class="page-title">💳 Pay Offline</h2>
            <div style="padding:20px;background:#f8f9fa;border-radius:12px;">
                <h4 style="color:#1a1a2e;margin-bottom:15px;">Bank Transfer Details</h4>
                <p><strong>Bank Name:</strong> Shopixia Bank</p>
                <p><strong>Account Name:</strong> Shopixia Ecommerce</p>
                <p><strong>Account Number:</strong> 1234-5678-9012</p>
                <p><strong>Sort Code:</strong> 12-34-56</p>
                <p style="color:#6c757d;font-size:14px;margin-top:15px;border-top:1px solid #e9ecef;padding-top:15px;">
                    <i class="fas fa-info-circle"></i> After payment, please send the screenshot to support@shopixia.com
                </p>
            </div>
            <?php
        }
        
        // Edit Account
        elseif (isset($_GET['edit_act'])) {
            include("edit_act.php");
        }
        
        // Change Password
        elseif (isset($_GET['change_pass'])) {
            include("change_password.php");
        }
        
        // Delete Account
        elseif (isset($_GET['delete_ac'])) {
            include("delete_ac.php");
        }
        
        // Default - Show Orders
        else {
            ?>
            <h2 class="page-title">📦 My Orders</h2>
            <?php
            $customer_id = $row_customer['customer_id'];
            $select_orders = "SELECT * FROM customer_order WHERE customer_id='$customer_id' ORDER BY order_id DESC";
            $run_orders = mysqli_query($con, $select_orders);
            $count_orders = mysqli_num_rows($run_orders);
            
            if($count_orders > 0) {
            ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Invoice No</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row_order = mysqli_fetch_array($run_orders)) {
                        $order_id = $row_order['order_id'];
                        $invoice_no = $row_order['invoice_no'];
                        $product_id = $row_order['product_id'];
                        $qty = $row_order['qty'];
                        $due_amount = $row_order['due_amount'];
                        $order_status = $row_order['order_status'];
                        $order_date = $row_order['order_date'];
                        
                        $get_pro = "SELECT product_title FROM products WHERE product_id='$product_id'";
                        $run_pro = mysqli_query($con, $get_pro);
                        $row_pro = mysqli_fetch_array($run_pro);
                        $product_title = $row_pro['product_title'] ?? 'Unknown';
                        
                        $status_class = 'status-pending';
                        if(strtolower($order_status) == 'complete' || strtolower($order_status) == 'completed') {
                            $status_class = 'status-complete';
                        } elseif(strtolower($order_status) == 'cancelled') {
                            $status_class = 'status-cancelled';
                        }
                    ?>
                    <tr>
                        <td>#<?php echo $order_id; ?></td>
                        <td><?php echo $invoice_no; ?></td>
                        <td><?php echo substr($product_title, 0, 20) . (strlen($product_title) > 20 ? '...' : ''); ?></td>
                        <td><?php echo $qty; ?></td>
                        <td>£<?php echo number_format($due_amount, 2); ?></td>
                        <td>
                            <span class="<?php echo $status_class; ?>">
                                <?php echo ucfirst($order_status); ?>
                            </span>
                        </td>
                        <td><?php echo date('d M Y', strtotime($order_date)); ?></td>
                        <td>
                            <a href="../details.php?pro_id=<?php echo $product_id; ?>" class="view-btn">
                                View
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php 
            } else { 
            ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet. Start shopping!</p>
                <a href="../index.php" class="shop-btn">Start Shopping</a>
            </div>
            <?php 
            }
        }
        ?>
    </div>
</div>

<!-- ============================================
FOOTER
============================================ -->
<?php include("includes/footer.php"); ?>

<?php } ?>
</body>
</html>