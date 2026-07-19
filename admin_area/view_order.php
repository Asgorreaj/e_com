<?php 
include("includes/db.php"); 
include("functions/functions.php");

// Delete Order
if(isset($_GET['delete_order'])){
    $delete_id = $_GET['delete_order'];
    $delete_order = "DELETE FROM customer_order WHERE order_id='$delete_id'";
    $run_delete = mysqli_query($con, $delete_order);
    if($run_delete){
        echo "<script>alert('Order has been deleted successfully!')</script>";
        echo "<script>window.open('index.php?view_order','_self')</script>";
    }
}

// Update Order Status
if(isset($_POST['update_status'])){
    $order_id = $_POST['order_id'];
    $new_status = mysqli_real_escape_string($con, $_POST['order_status']);
    
    $update_query = "UPDATE customer_order SET order_status='$new_status' WHERE order_id='$order_id'";
    $run_update = mysqli_query($con, $update_query);
    
    if($run_update){
        echo "<script>alert('Order status updated successfully!')</script>";
        echo "<script>window.open('index.php?view_order','_self')</script>";
    } else {
        echo "<script>alert('Failed to update order status!')</script>";
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class="fa fa-shopping-cart"></i> View Orders
            <small style="color:#6c757d;font-size:14px;font-weight:400;">Manage all customer orders</small>
        </h1>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Order No:</th>
                        <th>Customer Email:</th>
                        <th>Invoice No:</th>
                        <th>Product Title</th>
                        <th>Qty:</th>
                        <th>Size:</th>
                        <th>Order Date:</th>
                        <th>Total Amount:</th>
                        <th>Order Status:</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $get_orders = "SELECT * FROM customer_order ORDER BY order_id DESC";
                    $run_orders = mysqli_query($con, $get_orders);
                    $count = mysqli_num_rows($run_orders);
                    
                    if($count > 0){
                        while($row_orders = mysqli_fetch_array($run_orders)){
                            $order_id = $row_orders['order_id'];
                            $customer_id = $row_orders['customer_id'];
                            $invoice_no = $row_orders['invoice_no'];
                            $product_id = $row_orders['product_id'];
                            $qty = $row_orders['qty'];
                            $size = $row_orders['size'];
                            $order_date = $row_orders['order_date'];
                            $due_amount = $row_orders['due_amount'];
                            $order_status = $row_orders['order_status'];
                            
                            // Customer email fetch
                            $get_customer = "SELECT customer_email FROM customers WHERE customer_id='$customer_id'";
                            $run_customer = mysqli_query($con, $get_customer);
                            $row_customer = mysqli_fetch_array($run_customer);
                            $customer_email = isset($row_customer['customer_email']) ? $row_customer['customer_email'] : 'Unknown Customer';
                            
                            // Product title fetch
                            $get_product = "SELECT product_title FROM products WHERE product_id='$product_id'";
                            $run_product = mysqli_query($con, $get_product);
                            $row_product = mysqli_fetch_array($run_product);
                            $product_title = isset($row_product['product_title']) ? $row_product['product_title'] : 'Product Deleted';
                    ?>
                    <tr>
                        <td><?php echo $order_id; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $invoice_no; ?></td>
                        <td><?php echo $product_title; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $size ?: 'Standard'; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($order_date)); ?></td>
                        <td>£<?php echo number_format($due_amount, 2); ?></td>
                        <td>
                            <?php 
                            $status_class = 'label-warning';
                            if(strtolower($order_status) == 'complete' || strtolower($order_status) == 'completed'){
                                $status_class = 'label-success';
                            } elseif(strtolower($order_status) == 'pending'){
                                $status_class = 'label-warning';
                            } elseif(strtolower($order_status) == 'cancelled'){
                                $status_class = 'label-danger';
                            } elseif(strtolower($order_status) == 'processing'){
                                $status_class = 'label-info';
                            }
                            ?>
                            <span class="label <?php echo $status_class; ?>"><?php echo ucfirst($order_status); ?></span>
                        </td>
                        <td>
                            <!-- Update Status Button (Modal) -->
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal<?php echo $order_id; ?>" style="margin-bottom:5px;">
                                <i class="fa fa-edit"></i> Update
                            </button>
                            
                            <!-- Delete Button -->
                            <a href="index.php?view_order&delete_order=<?php echo $order_id; ?>" 
                               onclick="return confirm('Are you sure you want to delete this order?')"
                               class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </a>
                            
                            <!-- Update Status Modal -->
                            <div class="modal fade" id="updateModal<?php echo $order_id; ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background:#1b4353;color:#fff;">
                                            <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
                                            <h4 class="modal-title">
                                                <i class="fa fa-edit"></i> Update Order Status
                                            </h4>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <p><strong>Order #<?php echo $order_id; ?></strong></p>
                                                <p><strong>Customer:</strong> <?php echo $customer_email; ?></p>
                                                <p><strong>Product:</strong> <?php echo $product_title; ?></p>
                                                <p><strong>Total:</strong> £<?php echo number_format($due_amount, 2); ?></p>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Order Status</label>
                                                    <select name="order_status" class="form-control" required>
                                                        <option value="pending" <?php echo ($order_status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="processing" <?php echo ($order_status == 'processing') ? 'selected' : ''; ?>>Processing</option>
                                                        <option value="complete" <?php echo ($order_status == 'complete') ? 'selected' : ''; ?>>Complete</option>
                                                        <option value="cancelled" <?php echo ($order_status == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" name="update_status" class="btn btn-primary">
                                                    <i class="fa fa-save"></i> Update Status
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else { 
                    ?>
                    <tr>
                        <td colspan="10" style="text-align:center;padding:30px;">
                            <i class="fa fa-shopping-cart" style="font-size:48px;color:#ddd;display:block;margin-bottom:10px;"></i>
                            <h4>No Orders Found</h4>
                            <p>There are no orders in the system yet.</p>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .label {
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    .label-warning { background: #f0ad4e; color: #fff; }
    .label-success { background: #5cb85c; color: #fff; }
    .label-danger { background: #d9534f; color: #fff; }
    .label-info { background: #5bc0de; color: #fff; }
    
    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary { background: #337ab7; color: #fff; }
    .btn-primary:hover { background: #286090; }
    .btn-danger { background: #d9534f; color: #fff; }
    .btn-danger:hover { background: #c9302c; }
    .btn-default { background: #e0e0e0; color: #333; }
    .btn-default:hover { background: #d0d0d0; }
    
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 99999;
    }
    .modal-dialog {
        max-width: 500px;
        margin: 100px auto;
    }
    .modal-content {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }
    .modal-header .close {
        float: right;
        font-size: 24px;
        background: none;
        border: none;
        cursor: pointer;
    }
    .modal-body {
        padding: 20px;
    }
    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        text-align: right;
    }
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .table th {
        background: #1b4353;
        color: #fff;
        padding: 12px 10px;
        text-align: left;
        font-size: 13px;
    }
    .table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
        vertical-align: middle;
    }
    .table tr:hover {
        background: #f5f5f5;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .page-header {
        margin: 0 0 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #eee;
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
    }
    
    @media (max-width: 768px) {
        .table th, .table td {
            padding: 8px 6px;
            font-size: 12px;
        }
        .page-header {
            font-size: 20px;
        }
        .modal-dialog {
            margin: 50px 15px;
        }
    }
</style>

<!-- Bootstrap JS for Modal (if not already included) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $('.modal').modal({
        show: false
    });
});
</script>