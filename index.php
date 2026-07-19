<?php
require_once 'ai_helper.php';
include("includes/db.php");
include("functions/functions.php");
?>
<?php include("header.php"); ?>

<style>
/* ============================================
   HOME PAGE - FULLY CENTERED
   ============================================ */

/* ----- Reset Container ----- */
.hero-section,
.products-section,
.deals-section,
.newsletter-section {
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 20px;
    padding-right: 20px;
}

/* ----- Hero / Slider ----- */
.hero-section {
    margin-top: 20px;
    margin-bottom: 40px;
    text-align: center;
}

.hero-section .hero-title {
    text-align: center;
    font-size: 32px;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 25px;
}

.hero-section .hero-title span {
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.slider-wrapper {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    max-width: 100%;
    margin: 0 auto;
}

.slider-wrapper .slide {
    display: none;
    width: 100%;
    height: 400px;
}

.slider-wrapper .slide.active {
    display: block;
}

.slider-wrapper .slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.9);
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.slider-btn:hover {
    background: #ff523b;
    color: #fff;
}

.slider-btn.prev { left: 15px; }
.slider-btn.next { right: 15px; }

.slider-dots {
    text-align: center;
    padding: 15px 0 5px;
}

.slider-dots .dot {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #ddd;
    margin: 0 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slider-dots .dot.active {
    background: #ff523b;
    transform: scale(1.2);
}

/* ----- Section Headers (Centered) ----- */
.section-header {
    text-align: center !important;
    margin-bottom: 35px;
    width: 100%;
}

.section-header .badge {
    display: inline-block;
    padding: 5px 18px;
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    color: #fff;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
}

.section-header h2 {
    font-size: 30px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0;
}

.section-header h2 span {
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-header p {
    color: #6c757d;
    font-size: 16px;
    margin-top: 5px;
}

/* ----- Products Grid (Centered) ----- */
.products-section {
    margin-top: 40px;
    margin-bottom: 40px;
    text-align: center;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 20px;
    max-width: 1400px;
    margin: 0 auto !important;
    justify-items: center;
    align-items: stretch;
}

/* ----- Product Card ----- */
.product-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    transition: all 0.4s ease;
    border: 1px solid #f0f0f0;
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 280px;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 40px rgba(255,82,59,0.10);
    border-color: rgba(255,82,59,0.15);
}

.product-card .image-wrap {
    position: relative;
    padding-top: 100%;
    background: #f8f9fa;
    overflow: hidden;
}

.product-card .image-wrap img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .image-wrap img {
    transform: scale(1.05);
}

.product-card .image-wrap .badge {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 3px 12px;
    border-radius: 50px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    color: #fff;
    z-index: 2;
}

.product-card .image-wrap .badge.new {
    background: linear-gradient(135deg, #00b894, #00a381);
}

.product-card .image-wrap .badge.sale {
    background: linear-gradient(135deg, #fdcb6e, #f39c12);
}

.product-card .image-wrap .quick-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 2;
    opacity: 0;
    transform: translateX(15px);
    transition: all 0.3s ease;
}

.product-card:hover .quick-actions {
    opacity: 1;
    transform: translateX(0);
}

.product-card .image-wrap .quick-actions button {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: none;
    background: #fff;
    color: #2d3436;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 13px;
}

.product-card .image-wrap .quick-actions button:hover {
    background: #ff523b;
    color: #fff;
}

.product-card .info {
    padding: 14px 16px 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-card .info .category {
    font-size: 11px;
    color: #adb5bd;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-bottom: 4px;
}

.product-card .info .title {
    font-size: 14px;
    font-weight: 600;
    color: #2d3436;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 36px;
    margin-bottom: 6px;
}

.product-card .info .title a {
    color: #2d3436;
    text-decoration: none;
}

.product-card .info .title a:hover {
    color: #ff523b;
}

.product-card .info .price-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid #f1f2f6;
}

.product-card .info .price-row .current {
    font-size: 18px;
    font-weight: 700;
    color: #ff523b;
}

.product-card .add-btn {
    width: 100%;
    padding: 8px;
    margin-top: 10px;
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.product-card .add-btn:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 18px rgba(255,82,59,0.25);
}

/* ----- AI Section (Centered) ----- */
.ai-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 50px 20px;
    border-radius: 20px;
    margin: 30px auto !important;
    max-width: 1400px;
    text-align: center !important;
}

/* ----- Latest This Week Header ----- */
.latest-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    max-width: 1400px;
    margin: 0 auto 30px;
    padding: 0 20px;
}

.latest-header .badge {
    display: inline-block;
    padding: 5px 18px;
    background: linear-gradient(135deg, #00b894, #00a381);
    color: #fff;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.latest-header h2 {
    font-size: 30px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0;
}

.latest-header .view-all {
    color: #ff523b;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    padding: 8px 20px;
    border: 2px solid #ff523b;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.latest-header .view-all:hover {
    background: #ff523b;
    color: #fff;
}

/* ----- Best Deals (Centered) ----- */
.deals-section {
    margin-top: 40px;
    margin-bottom: 40px;
    text-align: center;
}

.deals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 18px;
    max-width: 1400px;
    margin: 0 auto !important;
    justify-items: center;
}

.deal-card {
    background: #fff;
    padding: 25px 15px 20px;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    border: 1px solid #f0f0f0;
    transition: all 0.4s ease;
    width: 100%;
    max-width: 220px;
}

.deal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    border-color: rgba(255,82,59,0.15);
}

.deal-card .icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    font-size: 24px;
}

.deal-card h4 {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.deal-card p {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 12px;
}

.deal-card .deal-link {
    font-size: 13px;
    font-weight: 600;
    color: #ff523b;
    text-decoration: none;
    transition: all 0.3s ease;
}

.deal-card .deal-link:hover {
    color: #e0452f;
}

/* ----- Newsletter (Centered) ----- */
.newsletter-section {
    margin-top: 40px;
    margin-bottom: 40px;
    padding: 50px 20px;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    border-radius: 20px;
    text-align: center;
    color: #fff;
}

.newsletter-section h2 {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 8px;
}

.newsletter-section p {
    font-size: 16px;
    opacity: 0.8;
    margin-bottom: 25px;
}

.newsletter-section form {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    max-width: 600px;
    margin: 0 auto;
    justify-content: center;
}

.newsletter-section form input,
.newsletter-section form textarea {
    flex: 1;
    min-width: 200px;
    padding: 12px 16px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    background: rgba(255,255,255,0.1);
    color: #fff;
}

.newsletter-section form input::placeholder,
.newsletter-section form textarea::placeholder {
    color: rgba(255,255,255,0.6);
}

.newsletter-section form textarea {
    width: 100%;
    min-width: 100%;
    resize: vertical;
}

.newsletter-section form .btn-submit {
    padding: 12px 35px;
    background: #ff523b;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.newsletter-section form .btn-submit:hover {
    background: #e0452f;
    transform: scale(1.02);
}

/* ----- Responsive ----- */
@media (max-width: 1200px) {
    .products-grid { grid-template-columns: repeat(4, 1fr); }
}

@media (max-width: 992px) {
    .products-grid { grid-template-columns: repeat(3, 1fr); }
    .section-header h2 { font-size: 26px; }
    .latest-header h2 { font-size: 26px; }
    .slider-wrapper .slide { height: 300px; }
}

@media (max-width: 768px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
    .section-header h2 { font-size: 22px; }
    .latest-header h2 { font-size: 22px; }
    .latest-header { flex-direction: column; align-items: flex-start; }
    .slider-wrapper .slide { height: 220px; }
    .slider-btn { width: 35px; height: 35px; font-size: 16px; }
    .deals-grid { grid-template-columns: repeat(2, 1fr); }
    .newsletter-section h2 { font-size: 24px; }
    .product-card .quick-actions { opacity: 1 !important; transform: translateX(0) !important; }
}

@media (max-width: 480px) {
    .products-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
    .hero-section { padding: 0 10px; }
    .products-section { padding: 0 10px; }
    .deals-section { padding: 0 10px; }
    .newsletter-section { padding: 30px 15px; }
    .section-header h2 { font-size: 18px; }
    .latest-header h2 { font-size: 18px; }
    .slider-wrapper .slide { height: 180px; }
    .product-card .info { padding: 10px 12px 12px; }
    .product-card .info .title { font-size: 12px; min-height: 30px; }
    .product-card .info .price-row .current { font-size: 14px; }
    .product-card .add-btn { font-size: 11px; padding: 6px; }
    .deal-card { padding: 18px 10px 15px; }
    .deal-card .icon { width: 45px; height: 45px; font-size: 18px; }
    .newsletter-section h2 { font-size: 20px; }
}
</style>

<!-- ============================================
HERO / SLIDER SECTION
============================================ -->
<section class="hero-section">
    <div class="hero-title">Top Picks & <span>Best Deals</span></div>
    <div class="slider-wrapper">
        <?php
        $get_slider = "SELECT * FROM slider";
        $run_slider = mysqli_query($con, $get_slider);
        $slide_count = 0;
        while ($row = mysqli_fetch_array($run_slider)) {
            $slider_name = $row['slider_name'];
            $slider_image = $row['slider_image'];
            $slider_url = $row['slider_url'];
            $slide_count++;
            $active = ($slide_count == 1) ? 'active' : '';
            echo "<div class='slide $active' data-index='$slide_count'>
                <a href='$slider_url'><img src='admin_area/slider_images/$slider_image' alt='$slider_name'></a>
            </div>";
        }
        ?>
        <button class="slider-btn prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="slider-btn next" onclick="changeSlide(1)">&#10095;</button>
    </div>
    <div class="slider-dots">
        <?php for($i = 1; $i <= $slide_count; $i++): ?>
            <span class="dot <?php echo ($i == 1) ? 'active' : ''; ?>" onclick="goToSlide(<?php echo $i; ?>)"></span>
        <?php endfor; ?>
    </div>
</section>

<!-- ============================================
AI RECOMMENDATION SECTION - CENTERED
============================================ -->
<section class="ai-section">
    <div class="section-header">
        <span class="badge"><i class="fas fa-robot"></i> AI Powered</span>
        <h2><?php echo isset($_SESSION['customer_email']) ? '✨ Recommended For You' : '🔥 Most Popular'; ?></h2>
        <p><?php echo isset($_SESSION['customer_email']) ? 'Personalised based on your shopping history' : 'Best selling items this week'; ?></p>
    </div>
    <div class="products-grid">
        <?php
        $ai_products = null;
        try {
            if(isset($_SESSION['customer_email'])){
                $session_email = $_SESSION['customer_email'];
                $q = mysqli_query($con, "SELECT customer_id FROM customers WHERE customer_email='".mysqli_real_escape_string($con,$session_email)."' LIMIT 1");
                $row = mysqli_fetch_assoc($q);
                if($row){ $ai_products = get_ai_recommendations($row['customer_id'], 6); }
            }
            if(empty($ai_products)){ $ai_products = get_popular_ai(6); }
            if(empty($ai_products)){
                $fb = mysqli_query($con, "SELECT * FROM products ORDER BY product_id DESC LIMIT 6");
                $ai_products = [];
                while($r = mysqli_fetch_assoc($fb)){ $ai_products[] = $r; }
            }
        } catch (Exception $e) {
            $fb = mysqli_query($con, "SELECT * FROM products ORDER BY product_id DESC LIMIT 6");
            $ai_products = [];
            while($r = mysqli_fetch_assoc($fb)){ $ai_products[] = $r; }
        }

        if(!empty($ai_products)){
            foreach($ai_products as $product){
                $pro_id = $product['product_id'];
                $pro_title = $product['product_title'];
                $pro_price = $product['product_price'];
                $pro_img1 = $product['product_img1'];

                $cat_name = 'Uncategorized';
                $cat_query = "SELECT c.cat_title FROM product_category pc JOIN categories c ON pc.cat_id = c.cat_id WHERE pc.p_cat_id = (SELECT p_cat_id FROM products WHERE product_id='$pro_id' LIMIT 1) LIMIT 1";
                $cat_result = mysqli_query($con, $cat_query);
                if($cat_result){ $cat_data = mysqli_fetch_assoc($cat_result); $cat_name = $cat_data['cat_title'] ?? 'Uncategorized'; }
        ?>
        <div class="product-card">
            <div class="image-wrap">
                <img src="admin_area/product_images/<?php echo $pro_img1; ?>" alt="<?php echo htmlspecialchars($pro_title); ?>" loading="lazy">
                <div class="quick-actions">
                    <button onclick="addToWishlist(<?php echo $pro_id; ?>)" title="Wishlist"><i class="far fa-heart"></i></button>
                    <button onclick="quickView(<?php echo $pro_id; ?>)" title="Quick View"><i class="fas fa-eye"></i></button>
                </div>
            </div>
            <div class="info">
                <div class="category"><?php echo htmlspecialchars($cat_name); ?></div>
                <div class="title"><a href="details.php?pro_id=<?php echo $pro_id; ?>"><?php echo htmlspecialchars($pro_title); ?></a></div>
                <div class="price-row"><span class="current">£<?php echo number_format($pro_price, 2); ?></span></div>
                <button class="add-btn" onclick="addToCart(<?php echo $pro_id; ?>)"><i class="fas fa-shopping-bag"></i> Add to Cart</button>
            </div>
        </div>
        <?php }
        } else { ?>
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:#6c757d;">
                <i class="fas fa-box-open" style="font-size:48px;display:block;margin-bottom:15px;color:#dee2e6;"></i>
                <p>No products found</p>
            </div>
        <?php } ?>
    </div>
</section>

<!-- ============================================
LATEST THIS WEEK - CENTERED
============================================ -->
<section class="products-section">
    <div class="latest-header">
        <div>
            <span class="badge">🆕 New Arrivals</span>
            <h2>Latest This Week</h2>
        </div>
        <a href="trimer.php" class="view-all">View All →</a>
    </div>
    <div class="products-grid">
        <?php
        $get_latest = "SELECT * FROM products ORDER BY product_id DESC LIMIT 6";
        $run_latest = mysqli_query($con, $get_latest);
        
        if(mysqli_num_rows($run_latest) > 0) {
            while($row = mysqli_fetch_array($run_latest)) {
                $pro_id = $row['product_id'];
                $pro_title = $row['product_title'];
                $pro_price = $row['product_price'];
                $pro_img1 = $row['product_img1'];
                
                $cat_name = 'Uncategorized';
                $cat_query = "SELECT c.cat_title FROM product_category pc 
                              JOIN categories c ON pc.cat_id = c.cat_id 
                              WHERE pc.p_cat_id = (SELECT p_cat_id FROM products WHERE product_id='$pro_id' LIMIT 1) LIMIT 1";
                $cat_result = mysqli_query($con, $cat_query);
                if($cat_result){ 
                    $cat_data = mysqli_fetch_assoc($cat_result); 
                    $cat_name = $cat_data['cat_title'] ?? 'Uncategorized'; 
                }
        ?>
        <div class="product-card">
            <div class="image-wrap">
                <img src="admin_area/product_images/<?php echo $pro_img1; ?>" alt="<?php echo htmlspecialchars($pro_title); ?>" loading="lazy">
                <span class="badge new">✨ New</span>
                <div class="quick-actions">
                    <button onclick="addToWishlist(<?php echo $pro_id; ?>)" title="Wishlist"><i class="far fa-heart"></i></button>
                    <button onclick="quickView(<?php echo $pro_id; ?>)" title="Quick View"><i class="fas fa-eye"></i></button>
                </div>
            </div>
            <div class="info">
                <div class="category"><?php echo htmlspecialchars($cat_name); ?></div>
                <div class="title"><a href="details.php?pro_id=<?php echo $pro_id; ?>"><?php echo htmlspecialchars($pro_title); ?></a></div>
                <div class="price-row"><span class="current">£<?php echo number_format($pro_price, 2); ?></span></div>
                <button class="add-btn" onclick="addToCart(<?php echo $pro_id; ?>)"><i class="fas fa-shopping-bag"></i> Add to Cart</button>
            </div>
        </div>
        <?php 
            }
        } else { 
        ?>
        <div style="grid-column:1/-1;text-align:center;padding:40px;color:#6c757d;">
            <i class="fas fa-box-open" style="font-size:48px;display:block;margin-bottom:15px;color:#dee2e6;"></i>
            <p>No products available</p>
        </div>
        <?php } ?>
    </div>
</section>

<!-- ============================================
BEST DEALS
============================================ -->
<section class="deals-section">
    <div class="section-header">
        <span class="badge" style="background:linear-gradient(135deg,#fdcb6e,#f39c12);">🔥 Hot Offers</span>
        <h2>Best <span>Deals</span></h2>
        <p>Exclusive offers & discounts just for you</p>
    </div>
    <div class="deals-grid">
        <?php
        $get_boxes = "SELECT * FROM boxes_section ORDER BY box_id ASC";
        $run_box = mysqli_query($con, $get_boxes);
        $colors = ['#FF6B6B','#4ECDC4','#FFE66D','#A8E6CF','#FF8A5C','#6C5CE7'];
        $i = 0;
        
        if(mysqli_num_rows($run_box) > 0) {
            while($row = mysqli_fetch_array($run_box)) {
                $color = $colors[$i % count($colors)];
                $i++;
        ?>
        <div class="deal-card">
            <div class="icon" style="background:<?php echo $color; ?>15;color:<?php echo $color; ?>;">
                <i class="fas <?php echo $row['box_icon']; ?>"></i>
            </div>
            <h4><?php echo htmlspecialchars($row['box_title']); ?></h4>
            <p><?php echo htmlspecialchars($row['box_desc']); ?></p>
            <a href="#" class="deal-link">Shop Now →</a>
        </div>
        <?php }
        } else {
            $default_deals = [
                ['fa-truck', 'Free Shipping', 'On orders over £50', '#FF6B6B'],
                ['fa-gift', 'Gift Cards', 'Available in store', '#4ECDC4'],
                ['fa-percent', 'Flash Sale', 'Up to 70% off', '#FFE66D'],
                ['fa-star', 'Premium Quality', '100% authentic', '#A8E6CF']
            ];
            foreach($default_deals as $deal){ ?>
        <div class="deal-card">
            <div class="icon" style="background:<?php echo $deal[3]; ?>15;color:<?php echo $deal[3]; ?>;">
                <i class="fas <?php echo $deal[0]; ?>"></i>
            </div>
            <h4><?php echo $deal[1]; ?></h4>
            <p><?php echo $deal[2]; ?></p>
            <a href="#" class="deal-link">Shop Now →</a>
        </div>
        <?php }} ?>
    </div>
</section>

<!-- ============================================
NEWSLETTER
============================================ -->
<section class="newsletter-section">
    <h2>📧 Newsletter</h2>
    <p>Get In Touch For Latest Discounts And Updates</p>
    <form action="contactus.php" method="post">
        <input type="text" placeholder="Enter Your Name" required>
        <input type="email" placeholder="Enter Your Email" required>
        <textarea placeholder="Enter Your Message" rows="3"></textarea>
        <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Subscribe</button>
    </form>
</section>

<?php include("includes/footer.php"); ?>

<script>
// ============================================
// SLIDER
// ============================================
let currentSlide = 1;
const totalSlides = <?php echo $slide_count; ?>;

function showSlide(n) {
    const slides = document.querySelectorAll('.slider-wrapper .slide');
    const dots = document.querySelectorAll('.slider-dots .dot');
    if (n > totalSlides) currentSlide = 1;
    if (n < 1) currentSlide = totalSlides;
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === currentSlide - 1) slide.classList.add('active');
    });
    dots.forEach((dot, i) => {
        dot.classList.remove('active');
        if (i === currentSlide - 1) dot.classList.add('active');
    });
}

function changeSlide(n) { showSlide(currentSlide += n); }
function goToSlide(n) { showSlide(currentSlide = n); }
setInterval(() => changeSlide(1), 5000);

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
// WISHLIST & QUICK VIEW
// ============================================
function addToWishlist(productId) {
    fetch('add_to_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}`
    })
    .then(() => showCartNotification('❤️ Added to wishlist!', 'success'))
    .catch(() => showCartNotification('Please login to add to wishlist.', 'error'));
}

function quickView(productId) {
    window.location.href = 'details.php?pro_id=' + productId;
}
</script>
</body>
</html>