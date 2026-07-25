<?php
session_start();
include("includes/db.php");
include("functions/functions.php");
?>
<?php include("header.php"); ?>

<?php
if(isset($_GET['pro_id'])){
    $pro_id = $_GET['pro_id'];
    $get_product = "SELECT * FROM products WHERE product_id='$pro_id'";
    $run_product = mysqli_query($con, $get_product);
    $row_product = mysqli_fetch_array($run_product);
    
    if($row_product){
        $p_cat_id = $row_product['p_cat_id'];
        $p_title = $row_product['product_title'];
        $p_price = $row_product['product_price'];
        $p_desc = $row_product['product_desc'];
        $p_img1 = $row_product['product_img1'];
        $p_img2 = $row_product['product_img2'];
        $p_img3 = $row_product['product_img3'];
        
        // Get category name
        $get_p_cat = "SELECT p_cat_title FROM product_category WHERE p_cat_id='$p_cat_id'";
        $run_p_cat = mysqli_query($con, $get_p_cat);
        $row_p_cat = mysqli_fetch_array($run_p_cat);
        $p_cat_title = isset($row_p_cat['p_cat_title']) ? $row_p_cat['p_cat_title'] : 'Uncategorized';
    }
}
?>

<style>
/* ============================================
   PRODUCT DETAILS PAGE - MODERN DESIGN
   ============================================ */
.details-wrapper {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

/* Breadcrumb */
.breadcrumb-custom {
    background: #f8f9fa;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.breadcrumb-custom a {
    color: #ff523b;
    text-decoration: none;
}

.breadcrumb-custom span {
    color: #6c757d;
}

/* Product Grid */
.product-details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    background: #fff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

/* Product Images */
.product-images {
    position: relative;
}

.main-image {
    width: 100%;
    aspect-ratio: 1/1;
    border-radius: 12px;
    overflow: hidden;
    background: #f8f9fa;
    border: 1px solid #f0f0f0;
}

.main-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.main-image:hover img {
    transform: scale(1.03);
}

.thumbnail-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-top: 15px;
}

.thumbnail-grid .thumb {
    aspect-ratio: 1/1;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.thumbnail-grid .thumb.active {
    border-color: #ff523b;
}

.thumbnail-grid .thumb:hover {
    border-color: #ff523b;
}

.thumbnail-grid .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info */
.product-info h1 {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.product-info .category {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 15px;
}

.product-info .category a {
    color: #ff523b;
    text-decoration: none;
}

.product-info .price {
    font-size: 32px;
    font-weight: 700;
    color: #ff523b;
    margin-bottom: 15px;
}

.product-info .price .original {
    font-size: 20px;
    color: #adb5bd;
    text-decoration: line-through;
    margin-left: 12px;
    font-weight: 400;
}

.product-info .price .discount {
    font-size: 16px;
    background: #ff523b;
    color: #fff;
    padding: 2px 12px;
    border-radius: 50px;
    margin-left: 10px;
    font-weight: 600;
}

.product-info .rating {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.product-info .rating .stars {
    color: #fdcb6e;
    font-size: 18px;
}

.product-info .rating .review-count {
    color: #6c757d;
    font-size: 14px;
}

.product-info .description {
    color: #2d3436;
    font-size: 15px;
    line-height: 1.7;
    margin-bottom: 25px;
    padding: 15px 0;
    border-top: 1px solid #f1f2f6;
    border-bottom: 1px solid #f1f2f6;
}

/* Form */
.product-info .form-group {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}

.product-info .form-group label {
    font-weight: 600;
    color: #2d3436;
    font-size: 14px;
    min-width: 100px;
}

.product-info .form-group select {
    padding: 10px 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 14px;
    background: #f8f9fa;
    color: #2d3436;
    cursor: pointer;
    transition: all 0.3s ease;
    flex: 1;
    max-width: 200px;
}

.product-info .form-group select:focus {
    border-color: #ff523b;
    outline: none;
    box-shadow: 0 0 0 3px rgba(255,82,59,0.08);
}

/* Add to Cart Button */
.add-to-cart-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-top: 10px;
}

.add-to-cart-btn:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(255,82,59,0.3);
}

.add-to-cart-btn i {
    font-size: 20px;
}

/* Product Meta */
.product-meta {
    display: flex;
    gap: 20px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #f1f2f6;
    flex-wrap: wrap;
}

.product-meta .meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-size: 14px;
}

.product-meta .meta-item i {
    color: #ff523b;
}

/* You May Also Like */
.related-section {
    max-width: 1200px;
    margin: 50px auto;
    padding: 0 20px;
}

.related-section h3 {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 25px;
    padding-left: 10px;
    position: relative;
}

.related-section h3::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 28px;
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    border-radius: 4px;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
}

.related-item {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    text-align: center;
    padding: 15px;
}

.related-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.related-item img {
    width: 100%;
    height: 120px;
    object-fit: contain;
    margin-bottom: 10px;
}

.related-item h4 {
    font-size: 13px;
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 5px;
}

.related-item h4 a {
    color: #2d3436;
    text-decoration: none;
}

.related-item h4 a:hover {
    color: #ff523b;
}

.related-item .price {
    font-weight: 700;
    color: #ff523b;
    font-size: 15px;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 992px) {
    .product-details-grid {
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 20px;
    }
    
    .product-info h1 {
        font-size: 24px;
    }
    
    .product-info .price {
        font-size: 28px;
    }
}

@media (max-width: 768px) {
    .details-wrapper {
        padding: 0 15px;
        margin: 20px auto;
    }
    
    .product-details-grid {
        padding: 15px;
        border-radius: 12px;
    }
    
    .product-info h1 {
        font-size: 20px;
    }
    
    .product-info .price {
        font-size: 24px;
    }
    
    .product-info .form-group {
        flex-direction: column;
        align-items: stretch;
    }
    
    .product-info .form-group label {
        min-width: auto;
    }
    
    .product-info .form-group select {
        max-width: 100%;
    }
    
    .add-to-cart-btn {
        font-size: 16px;
        padding: 14px;
    }
    
    .related-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .thumbnail-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
    
    .product-meta {
        flex-direction: column;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .product-details-grid {
        padding: 12px;
    }
    
    .product-info h1 {
        font-size: 18px;
    }
    
    .product-info .price {
        font-size: 20px;
    }
    
    .product-info .description {
        font-size: 14px;
    }
    
    .add-to-cart-btn {
        font-size: 14px;
        padding: 12px;
    }
    
    .related-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .related-item {
        padding: 10px;
    }
    
    .related-item img {
        height: 80px;
    }
    
    .main-image {
        aspect-ratio: 1/1;
    }
}

@media (max-width: 360px) {
    .related-grid {
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    
    .related-item {
        padding: 8px;
    }
    
    .related-item h4 {
        font-size: 11px;
    }
    
    .related-item .price {
        font-size: 13px;
    }
}
</style>

<!-- ============================================
BREADCRUMB
============================================ -->
<div class="details-wrapper">
    <div class="breadcrumb-custom">
        <a href="index.php">Home</a> / 
        <a href="trimer.php">Shop</a> / 
        <span><?php echo $p_title; ?></span>
    </div>

    <!-- ============================================
    PRODUCT DETAILS
    ============================================ -->
    <div class="product-details-grid">
        
        <!-- Product Images -->
        <div class="product-images">
            <div class="main-image">
                <img id="mainProductImage" src="admin_area/product_images/<?php echo $p_img1; ?>" alt="<?php echo $p_title; ?>">
            </div>
            <div class="thumbnail-grid">
                <div class="thumb active" onclick="changeImage('admin_area/product_images/<?php echo $p_img1; ?>', this)">
                    <img src="admin_area/product_images/<?php echo $p_img1; ?>" alt="Thumb 1">
                </div>
                <?php if(!empty($p_img2)): ?>
                <div class="thumb" onclick="changeImage('admin_area/product_images/<?php echo $p_img2; ?>', this)">
                    <img src="admin_area/product_images/<?php echo $p_img2; ?>" alt="Thumb 2">
                </div>
                <?php endif; ?>
                <?php if(!empty($p_img3)): ?>
                <div class="thumb" onclick="changeImage('admin_area/product_images/<?php echo $p_img3; ?>', this)">
                    <img src="admin_area/product_images/<?php echo $p_img3; ?>" alt="Thumb 3">
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="product-info">
            <div class="category">
                Category: <a href="trimer.php?p_cat=<?php echo $p_cat_id; ?>"><?php echo $p_cat_title; ?></a>
            </div>
            
            <h1><?php echo $p_title; ?></h1>
            
            <div class="rating">
                <span class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </span>
                <span class="review-count">(24 reviews)</span>
            </div>
            
            <div class="price">
                £<?php echo number_format($p_price, 2); ?>
                <span class="original">£<?php echo number_format($p_price * 1.2, 2); ?></span>
                <span class="discount">-20%</span>
            </div>
            
            <div class="description">
                <?php echo nl2br($p_desc); ?>
            </div>
            
            <?php addCart(); ?>
            
            <form action="details.php?add_cart=<?php echo $pro_id; ?>" method="post">
                <div class="form-group">
                    <label>Quantity:</label>
                    <select name="product_qty">
                        <?php for($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Color / Size:</label>
                    <select name="product_size">
                        <option value="RED & Blue">RED & Blue</option>
                        <option value="Khaki">Khaki</option>
                        <option value="White">White</option>
                        <option value="Gray">Gray</option>
                        <option value="Blue">Blue</option>
                        <option value="Black">Black</option>
                    </select>
                </div>
                
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i> Add to Cart
                </button>
            </form>
            
            <div class="product-meta">
                <div class="meta-item">
                    <i class="fas fa-tag"></i> SKU: #PROD-<?php echo str_pad($pro_id, 5, '0', STR_PAD_LEFT); ?>
                </div>
                <div class="meta-item">
                    <i class="fas fa-box"></i> In Stock
                </div>
                <div class="meta-item">
                    <i class="fas fa-truck"></i> Free Shipping
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================
YOU MAY ALSO LIKE
============================================ -->
<section class="related-section">
    <h3>🔥 You May Also Like</h3>
    <div class="related-grid">
        <?php
        $get_related = "SELECT * FROM products WHERE p_cat_id='$p_cat_id' AND product_id != '$pro_id' ORDER BY RAND() LIMIT 6";
        $run_related = mysqli_query($con, $get_related);
        
        if(mysqli_num_rows($run_related) > 0) {
            while($row = mysqli_fetch_array($run_related)) {
                $r_id = $row['product_id'];
                $r_title = $row['product_title'];
                $r_price = $row['product_price'];
                $r_img1 = $row['product_img1'];
        ?>
        <div class="related-item">
            <a href="details.php?pro_id=<?php echo $r_id; ?>">
                <img src="admin_area/product_images/<?php echo $r_img1; ?>" alt="<?php echo $r_title; ?>">
            </a>
            <h4>
                <a href="details.php?pro_id=<?php echo $r_id; ?>">
                    <?php echo substr($r_title, 0, 20) . (strlen($r_title) > 20 ? '...' : ''); ?>
                </a>
            </h4>
            <div class="price">£<?php echo number_format($r_price, 2); ?></div>
        </div>
        <?php 
            }
        } else {
        ?>
        <div style="grid-column:1/-1;text-align:center;padding:30px;color:#6c757d;">
            <i class="fas fa-box-open" style="font-size:32px;display:block;margin-bottom:10px;color:#dee2e6;"></i>
            <p>No related products found</p>
        </div>
        <?php } ?>
    </div>
</section>

<?php include("includes/footer.php"); ?>

<script>
// ============================================
// CHANGE MAIN IMAGE ON THUMBNAIL CLICK
// ============================================
function changeImage(src, element) {
    document.getElementById('mainProductImage').src = src;
    
    // Remove active class from all thumbs
    document.querySelectorAll('.thumbnail-grid .thumb').forEach(function(thumb) {
        thumb.classList.remove('active');
    });
    
    // Add active class to clicked thumb
    element.classList.add('active');
}

// ============================================
// AUTO SLIDE FOR IMAGES
// ============================================
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    
    if (slides.length > 0) {
        if (n > slides.length) { slideIndex = 1; }
        if (n < 1) { slideIndex = slides.length; }
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        
        if (slides[slideIndex - 1]) {
            slides[slideIndex - 1].style.display = "block";
        }
        
        if (dots[slideIndex - 1]) {
            dots[slideIndex - 1].className += " active";
        }
    }
}
</script>
</body>
</html>