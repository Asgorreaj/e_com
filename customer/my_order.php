<?php
$session_email = $_SESSION['customer_email'];
$get_customer = "SELECT customer_id FROM customers WHERE customer_email='$session_email'";
$run_customer = mysqli_query($con, $get_customer);
$row_customer = mysqli_fetch_array($run_customer);
$customer_id = $row_customer['customer_id'];

$select_orders = "SELECT * FROM customer_order WHERE customer_id='$customer_id' ORDER BY order_id DESC";
$run_orders = mysqli_query($con, $select_orders);

if(mysqli_num_rows($run_orders) > 0) {
?>
<style>
.orders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.orders-table th {
    text-align: left;
    padding: 12px 10px;
    background: #f8f9fa;
    font-weight: 700;
    color: #2d3436;
    border-bottom: 2px solid #e9ecef;
}

.orders-table td {
    padding: 12px 10px;
    border-bottom: 1px solid #f1f2f6;
    vertical-align: middle;
}

.status-pending {
    display: inline-block;
    padding: 3px 12px;
    background: #ffc107;
    color: #212529;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
}

.status-complete {
    display: inline-block;
    padding: 3px 12px;
    background: #00b894;
    color: #fff;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
}

.status-cancelled {
    display: inline-block;
    padding: 3px 12px;
    background: #dc3545;
    color: #fff;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
}

.view-btn {
    display: inline-block;
    padding: 5px 15px;
    background: #ff523b;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.view-btn:hover {
    background: #e0452f;
}

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
}

@media (max-width: 768px) {
    .orders-table {
        display: block;
        overflow-x: auto;
        font-size: 12px;
    }
    .orders-table th, .orders-table td {
        padding: 8px 6px;
    }
}
</style>

<div style="overflow-x:auto;">
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
                    <!-- ✅ IMPORTANT: এখানে লিংক order_details.php তে যাচ্ছে -->
                    <a href="order_details.php?order_id=<?php echo $order_id; ?>" class="view-btn">
                        <i class="fas fa-eye"></i> View
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php 
} else { 
?>
<div class="empty-state">
    <i class="fas fa-box-open"></i>
    <h3>No Orders Yet</h3>
    <p>You haven't placed any orders yet. Start shopping!</p>
    <a href="../index.php" class="shop-btn">Start Shopping</a>
</div>
<?php } ?>