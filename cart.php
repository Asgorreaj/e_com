<?php
session_start();
include("includes/db.php");
include("functions/functions.php");
?>
<?php include("header.php"); ?>

<style>
.cart-wrapper {
    max-width: 1400px;
    margin: 30px auto;
    padding: 0 20px;
}

.cart-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

.cart-items-section {
    background: #ffffff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.cart-items-section h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f2f6;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
}

.cart-table th {
    text-align: left;
    padding: 12px 10px;
    background: #f8f9fa;
    font-size: 13px;
    font-weight: 700;
    color: #2d3436;
    text-transform: uppercase;
    border-bottom: 2px solid #e9ecef;
}

.cart-table td {
    padding: 15px 10px;
    border-bottom: 1px solid #f1f2f6;
    vertical-align: middle;
}

.cart-table .product-cell {
    display: flex;
    align-items: center;
    gap: 15px;
}

.cart-table .product-cell img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 10px;
    background: #f8f9fa;
}

.cart-table .product-cell .product-name {
    font-weight: 600;
    color: #2d3436;
    font-size: 14px;
}

.cart-table .product-cell .product-name a {
    color: #2d3436;
    text-decoration: none;
}

.cart-table .qty-input {
    width: 60px;
    padding: 6px 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
    text-align: center;
    font-size: 14px;
}

.cart-table .price {
    font-weight: 600;
    color: #ff523b;
    font-size: 15px;
}

.cart-table .subtotal {
    font-weight: 700;
    color: #ff523b;
    font-size: 16px;
}

.cart-table .remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 18px;
    padding: 5px;
}

.cart-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #f1f2f6;
    flex-wrap: wrap;
    gap: 15px;
}

.cart-actions .btn {
    padding: 10px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.cart-actions .btn-continue {
    background: #e9ecef;
    color: #2d3436;
}

.cart-actions .btn-checkout {
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    color: #fff;
}

.order-summary {
    background: #ffffff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    position: sticky;
    top: 100px;
}

.order-summary h3 {
    font-size: 20px;
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

.empty-cart .shop-btn {
    display: inline-block;
    padding: 12px 30px;
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    color: #fff;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    margin-top: 15px;
}

@media (max-width: 768px) {
    .cart-grid { grid-template-columns: 1fr; }
    .order-summary { position: static; }
    .cart-table { display: block; overflow-x: auto; }
    .cart-actions { flex-direction: column; }
    .cart-actions .btn { justify-content: center; }
}
</style>

<!-- ============================================
CART PAGE CONTENT
============================================ -->
<section class="cart-wrapper">
    <div class="cart-grid">
        
        <!-- Cart Items -->
        <div class="cart-items-section">
            <h2>🛒 Shopping Cart <span class="cart-count">(<?php echo item(); ?> items)</span></h2>
            
            <?php
            $ip_add = getUserIp();
            $select_cart = "SELECT c.*, p.product_title, p.product_img1, p.product_price 
                            FROM cart c 
                            JOIN products p ON c.p_id = p.product_id 
                            WHERE c.ip_add='$ip_add'";
            $run_cart = mysqli_query($con, $select_cart);
            $count = mysqli_num_rows($run_cart);
            
            if($count > 0) {
            ?>
            
            <form action="cart.php" method="post">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Size</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        while($row_cart = mysqli_fetch_array($run_cart)) {
                            $pro_id = $row_cart['p_id'];
                            $pro_size = $row_cart['size'];
                            $pro_qty = $row_cart['qty'];
                            $p_title = $row_cart['product_title'];
                            $p_img1 = $row_cart['product_img1'];
                            $p_price = $row_cart['product_price'];
                            $sub_total = $p_price * $pro_qty;
                            $total += $sub_total;
                        ?>
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <img src="admin_area/product_images/<?php echo $p_img1; ?>" alt="<?php echo $p_title; ?>">
                                    <span class="product-name">
                                        <a href="details.php?pro_id=<?php echo $pro_id; ?>">
                                            <?php echo $p_title; ?>
                                        </a>
                                    </span>
                                </div>
                            </td>
                            <td class="price">£<?php echo number_format($p_price, 2); ?></td>
                            <td>
                                <input type="number" name="qty[<?php echo $pro_id; ?>]" 
                                       value="<?php echo $pro_qty; ?>" 
                                       min="1" max="10" 
                                       class="qty-input">
                            </td>
                            <td>
                                <span class="size-badge"><?php echo $pro_size ?: 'Standard'; ?></span>
                            </td>
                            <td class="subtotal">£<?php echo number_format($sub_total, 2); ?></td>
                            <td>
                                <button type="submit" name="remove" value="<?php echo $pro_id; ?>" 
                                        class="remove-btn" title="Remove item">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <div class="cart-actions">
                    <a href="index.php" class="btn btn-continue">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                    <a href="checkout.php" class="btn btn-checkout">
                        Proceed to Checkout <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </form>
            
            <?php 
            } else { 
            ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-bag"></i>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any items yet.</p>
                <a href="index.php" class="shop-btn">
                    <i class="fas fa-store"></i> Start Shopping
                </a>
            </div>
            <?php } ?>
        </div>
        
        <!-- Order Summary -->
        <div class="order-summary">
            <h3>📋 Order Summary</h3>
            
            <?php if($count > 0 && isset($total)) { ?>
            <div class="summary-row">
                <span class="label">Subtotal</span>
                <span>£<?php echo number_format($total, 2); ?></span>
            </div>
            <div class="summary-row">
                <span class="label">Shipping</span>
                <span>£0.00</span>
            </div>
            <div class="summary-row">
                <span class="label">Tax</span>
                <span>£0.00</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>£<?php echo number_format($total, 2); ?></span>
            </div>
            <?php } else { ?>
            <div style="text-align:center;padding:20px 0;">
                <i class="fas fa-box" style="font-size:48px;color:#dee2e6;display:block;margin-bottom:15px;"></i>
                <p style="color:#6c757d;">Add items to see summary</p>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php include("includes/footer.php"); ?>