<?php
session_start();
if (!isset($_SESSION['customer_email'])) {
    echo "<script>window.open('../checkout.php','_self')</script>";
    exit();
}

include("../includes/db.php");
include("../functions/functions.php");
?>
<?php include("../header.php"); ?>

<style>
.order-details-wrapper {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

.order-details-card {
    background: #fff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f1f2f6;
    margin-bottom: 25px;
}

.order-header h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a2e;
}

.order-header .order-status {
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
}

.order-header .order-status.pending {
    background: #ffc107;
    color: #212529;
}

.order-header .order-status.complete {
    background: #00b894;
    color: #fff;
}

.order-header .order-status.cancelled {
    background: #dc3545;
    color: #fff;
}

.order-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 12px;
}

.order-info-grid .info-item {
    display: flex;
    flex-direction: column;
}

.order-info-grid .info-item .label {
    font-size: 12px;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.order-info-grid .info-item .value {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin-top: 2px;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.order-table th {
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

.order-table td {
    padding: 15px 10px;
    border-bottom: 1px solid #f1f2f6;
    vertical-align: middle;
}

.order-table .product-cell {
    display: flex;
    align-items: center;
    gap: 15px;
}

.order-table .product-cell img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
    background: #f8f9fa;
}

.order-table .product-cell .product-name {
    font-weight: 600;
    color: #2d3436;
    font-size: 14px;
}

.order-table .product-cell .product-name a {
    color: #2d3436;
    text-decoration: none;
}

.order-table .size-badge {
    display: inline-block;
    padding: 2px 10px;
    background: #e9ecef;
    border-radius: 50px;
    font-size: 12px;
    color: #495057;
}

.order-total-section {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #f1f2f6;
}

.order-total-section .total-box {
    min-width: 250px;
}

.order-total-section .total-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 15px;
    color: #2d3436;
}

.order-total-section .total-row.grand-total {
    font-size: 20px;
    font-weight: 700;
    color: #ff523b;
    border-top: 2px solid #f1f2f6;
    padding-top: 15px;
    margin-top: 5px;
}

.back-btn {
    display: inline-block;
    padding: 10px 24px;
    background: #e9ecef;
    color: #2d3436;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    margin-top: 15px;
}

.back-btn:hover {
    background: #dee2e6;
}

.breadcrumb-custom {
    background: #f8f9fa;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
}

.breadcrumb-custom a {
    color: #ff523b;
    text-decoration: none;
}

.breadcrumb-custom span {
    color: #6c757d;
}

@media (max-width: 768px) {
    .order-info-grid {
        grid-template-columns: 1fr 1fr;
    }
    .order-table {
        display: block;
        overflow-x: auto;
    }
    .order-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .order-total-section {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .order-details-card {
        padding: 20px 15px;
    }
    .order-info-grid {
        grid-template-columns: 1fr;
        padding: 15px;
    }
    .order-table .product-cell img {
        width: 40px;
        height: 40px;
    }
}
</style>

<div class="order-details-wrapper">
    <div class="breadcrumb-custom">
        <a href="../index.php">Home</a> / 
        <a href="my_account.php?my_order">My Orders</a> / 
        <span>Order Details</span>
    </div>

    <?php
    if(isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $session_email = $_SESSION['customer_email'];
        
        $get_customer = "SELECT customer_id FROM customers WHERE customer_email='$session_email'";
        $run_customer = mysqli_query($con, $get_customer);
        $row_customer = mysqli_fetch_array($run_customer);
        $customer_id = $row_customer['customer_id'];
        
        $get_order = "SELECT * FROM customer_order WHERE order_id='$order_id' AND customer_id='$customer_id'";
        $run_order = mysqli_query($con, $get_order);
        
        if(mysqli_num_rows($run_order) > 0) {
            $row_order = mysqli_fetch_array($run_order);
            $invoice_no = $row_order['invoice_no'];
            $order_status = $row_order['order_status'];
            $order_date = $row_order['order_date'];
            $total_amount = 0;
            
            $get_products = "SELECT co.*, p.product_title, p.product_img1, p.product_price 
                            FROM customer_order co 
                            JOIN products p ON co.product_id = p.product_id 
                            WHERE co.invoice_no='$invoice_no' AND co.customer_id='$customer_id'";
            $run_products = mysqli_query($con, $get_products);
            
            $status_class = 'pending';
            if(strtolower($order_status) == 'complete' || strtolower($order_status) == 'completed') {
                $status_class = 'complete';
            } elseif(strtolower($order_status) == 'cancelled') {
                $status_class = 'cancelled';
            }
    ?>

    <div class="order-details-card">
        
        <div class="order-header">
            <h2>📦 Order #<?php echo $order_id; ?></h2>
            <span class="order-status <?php echo $status_class; ?>">
                <?php echo ucfirst($order_status); ?>
            </span>
        </div>
        
        <div class="order-info-grid">
            <div class="info-item">
                <span class="label">Order ID</span>
                <span class="value">#<?php echo $order_id; ?></span>
            </div>
            <div class="info-item">
                <span class="label">Invoice No</span>
                <span class="value">#<?php echo $invoice_no; ?></span>
            </div>
            <div class="info-item">
                <span class="label">Order Date</span>
                <span class="value"><?php echo date('d M Y, h:i A', strtotime($order_date)); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Payment Status</span>
                <span class="value"><?php echo ($order_status == 'pending') ? 'Pending' : 'Paid'; ?></span>
            </div>
        </div>
        
        <h3 style="font-size:18px;font-weight:700;color:#1a1a2e;margin-bottom:15px;">🛍️ Items in this Order</h3>
        
        <table class="order-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Size</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row_product = mysqli_fetch_array($run_products)) {
                    $pro_title = $row_product['product_title'];
                    $pro_img1 = $row_product['product_img1'];
                    $pro_price = $row_product['product_price'];
                    $qty = $row_product['qty'];
                    $size = $row_product['size'];
                    $sub_total = $pro_price * $qty;
                    $total_amount += $sub_total;
                ?>
                <tr>
                    <td>
                        <div class="product-cell">
                            <img src="../admin_area/product_images/<?php echo $pro_img1; ?>" alt="<?php echo $pro_title; ?>">
                            <span class="product-name">
                                <a href="../details.php?pro_id=<?php echo $row_product['product_id']; ?>">
                                    <?php echo $pro_title; ?>
                                </a>
                            </span>
                        </div>
                    </td>
                    <td>£<?php echo number_format($pro_price, 2); ?></td>
                    <td><?php echo $qty; ?></td>
                    <td><span class="size-badge"><?php echo $size ?: 'Standard'; ?></span></td>
                    <td>£<?php echo number_format($sub_total, 2); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <div class="order-total-section">
            <div class="total-box">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>£<?php echo number_format($total_amount, 2); ?></span>
                </div>
                <div class="total-row">
                    <span>Shipping</span>
                    <span>£0.00</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total</span>
                    <span>£<?php echo number_format($total_amount, 2); ?></span>
                </div>
            </div>
        </div>
        
        <a href="my_account.php?my_order" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <?php
        } else {
            echo '<div style="text-align:center;padding:40px;color:#6c757d;">
                    <i class="fas fa-exclamation-circle" style="font-size:48px;display:block;margin-bottom:15px;color:#dee2e6;"></i>
                    <h3>Order Not Found</h3>
                    <p>This order does not exist or you do not have permission to view it.</p>
                    <a href="my_account.php?my_order" class="back-btn">Back to Orders</a>
                  </div>';
        }
    } else {
        echo '<div style="text-align:center;padding:40px;color:#6c757d;">
                <i class="fas fa-exclamation-circle" style="font-size:48px;display:block;margin-bottom:15px;color:#dee2e6;"></i>
                <h3>No Order Selected</h3>
                <p>Please select an order to view details.</p>
                <a href="my_account.php?my_order" class="back-btn">Back to Orders</a>
              </div>';
    }
    ?>
</div>

<?php include("../includes/footer.php"); ?>