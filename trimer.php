<?php 
session_start();
include("includes/db.php");  
include("functions/functions.php");
?>
<?php include("header.php"); ?>

<style>
/* ============================================
   SHOP PAGE - MODERN WITH DROPDOWN SIDEBAR
   ============================================ */

/* ----- Variables ----- */
:root {
    --primary: #ff523b;
    --primary-dark: #e0452f;
    --secondary: #1b4353;
    --secondary-light: #2a6a80;
    --accent: #fdcb6e;
    --bg-light: #f8f9fa;
    --text-dark: #1a1a2e;
    --text-gray: #6c757d;
    --white: #ffffff;
    --shadow: 0 8px 30px rgba(0,0,0,0.08);
    --radius: 12px;
    --transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

/* ----- Container ----- */
.shop-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

/* ----- Breadcrumb ----- */
.breadcrumb-custom {
    background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
    padding: 14px 24px;
    border-radius: var(--radius);
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.breadcrumb-custom a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-size: 14px;
    transition: var(--transition);
}

.breadcrumb-custom a:hover {
    color: var(--accent);
}

.breadcrumb-custom span {
    color: var(--white);
    font-size: 14px;
    font-weight: 600;
}

.breadcrumb-custom .separator {
    color: rgba(255,255,255,0.4);
}

/* ============================================
   SIDEBAR TOGGLE (Mobile)
   ============================================ */
.sidebar-toggle {
    display: none;
    width: 100%;
    padding: 12px 18px;
    background: var(--white);
    border: 2px solid var(--primary);
    border-radius: var(--radius);
    color: var(--primary);
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    margin-bottom: 15px;
    align-items: center;
    justify-content: space-between;
}

.sidebar-toggle:hover {
    background: var(--primary);
    color: var(--white);
}

.sidebar-toggle i {
    font-size: 18px;
    transition: var(--transition);
}

.sidebar-toggle.active i {
    transform: rotate(180deg);
}

/* ============================================
   SHOP GRID
   ============================================ */
.shop-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 30px;
    margin-top: 10px;
}

/* ============================================
   SIDEBAR - MODERN WITH DROPDOWN
   ============================================ */
.shop-sidebar {
    position: sticky;
    top: 90px;
    height: fit-content;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.sidebar-card {
    background: var(--white);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0,0,0,0.04);
}

.sidebar-card .card-header {
    padding: 14px 18px;
    background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
    color: var(--white);
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    user-select: none;
    transition: var(--transition);
}

.sidebar-card .card-header:hover {
    background: linear-gradient(135deg, var(--secondary-light), var(--secondary));
}

.sidebar-card .card-header i:first-child {
    margin-right: 10px;
    color: var(--accent);
}

.sidebar-card .card-header .toggle-icon {
    transition: var(--transition);
    font-size: 14px;
}

.sidebar-card .card-header.active .toggle-icon {
    transform: rotate(180deg);
}

.sidebar-card .card-body {
    padding: 6px 0;
    overflow: hidden;
    max-height: 500px;
    transition: max-height 0.4s ease, opacity 0.3s ease;
    opacity: 1;
}

.sidebar-card .card-body.collapsed {
    max-height: 0;
    opacity: 0;
    padding: 0;
}

.sidebar-card .card-body .menu-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 18px;
    color: var(--text-dark);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: var(--transition);
    border-bottom: 1px solid #f5f5f5;
}

.sidebar-card .card-body .menu-item:last-child {
    border-bottom: none;
}

.sidebar-card .card-body .menu-item:hover {
    background: rgba(255,82,59,0.06);
    color: var(--primary);
    padding-left: 24px;
}

.sidebar-card .card-body .menu-item.active {
    background: rgba(255,82,59,0.1);
    color: var(--primary);
    border-left: 3px solid var(--primary);
}

.sidebar-card .card-body .menu-item .badge {
    background: #e9ecef;
    color: var(--text-gray);
    padding: 2px 10px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
}

.sidebar-card .card-body .menu-item:hover .badge {
    background: var(--primary);
    color: var(--white);
}

.sidebar-card .card-body .menu-item i {
    margin-right: 10px;
    width: 18px;
    text-align: center;
    color: var(--text-gray);
    font-size: 14px;
}

.sidebar-card .card-body .menu-item:hover i {
    color: var(--primary);
}

.sidebar-card .card-body .menu-item.sub {
    padding-left: 38px;
    font-size: 13px;
}

/* Special Offers Card */
.sidebar-card.special .card-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
}

/* ============================================
   PRODUCTS SECTION
   ============================================ */
.products-section {
    background: var(--white);
    border-radius: var(--radius);
    padding: 25px;
    box-shadow: var(--shadow);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 12px;
}

.section-header h3 {
    font-size: 24px;
    font-weight: 800;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-header h3 i {
    color: var(--primary);
}

.section-header .product-count {
    color: var(--text-gray);
    font-size: 14px;
    background: var(--bg-light);
    padding: 6px 16px;
    border-radius: 50px;
    font-weight: 600;
}

/* ============================================
   PRODUCT GRID
   ============================================ */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
}

/* ============================================
   PRODUCT CARD
   ============================================ */
.product-card {
    background: var(--white);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    transition: var(--transition);
    border: 1px solid #f0f0f0;
    position: relative;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 40px rgba(255,82,59,0.10);
    border-color: rgba(255,82,59,0.12);
}

.product-card .image-wrap {
    position: relative;
    padding-top: 100%;
    background: var(--bg-light);
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

/* Badge */
.product-card .badge-sale {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: var(--white);
    padding: 3px 12px;
    border-radius: 50px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    z-index: 2;
}

/* Quick Actions */
.product-card .quick-actions {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 2;
    opacity: 0;
    transform: translateX(15px);
    transition: var(--transition);
}

.product-card:hover .quick-actions {
    opacity: 1;
    transform: translateX(0);
}

.product-card .quick-actions button {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: none;
    background: var(--white);
    color: var(--text-dark);
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    cursor: pointer;
    transition: var(--transition);
    font-size: 13px;
}

.product-card .quick-actions button:hover {
    background: var(--primary);
    color: var(--white);
    transform: scale(1.1);
}

/* Product Info */
.product-card .info {
    padding: 14px 16px 16px;
}

.product-card .info .category {
    font-size: 11px;
    color: var(--text-gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-bottom: 4px;
}

.product-card .info .title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 36px;
    margin-bottom: 6px;
}

.product-card .info .title a {
    color: var(--text-dark);
    text-decoration: none;
    transition: var(--transition);
}

.product-card .info .title a:hover {
    color: var(--primary);
}

.product-card .info .price-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-top: 10px;
    border-top: 1px solid #f1f2f6;
}

.product-card .info .price-row .current {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary);
}

.product-card .info .price-row .original {
    font-size: 13px;
    color: var(--text-gray);
    text-decoration: line-through;
}

/* Buttons */
.product-card .btn-group {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}

.product-card .btn-group .btn {
    flex: 1;
    padding: 8px 10px;
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-align: center;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.product-card .btn-group .btn-view {
    background: var(--bg-light);
    color: var(--text-dark);
}

.product-card .btn-group .btn-view:hover {
    background: #e9ecef;
}

.product-card .btn-group .btn-cart {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: var(--white);
}

.product-card .btn-group .btn-cart:hover {
    transform: scale(1.04);
    box-shadow: 0 6px 20px rgba(255,82,59,0.25);
}

/* ============================================
   PAGINATION
   ============================================ */
.pagination-wrap {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid #f1f2f6;
}

.pagination-wrap .pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    padding: 0;
    flex-wrap: wrap;
}

.pagination-wrap .pagination li a {
    display: block;
    padding: 8px 16px;
    background: var(--bg-light);
    color: var(--text-dark);
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: var(--transition);
    border: 1px solid #f0f0f0;
}

.pagination-wrap .pagination li a:hover {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

.pagination-wrap .pagination li a.active {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    grid-column: 1/-1;
}

.empty-state i {
    font-size: 64px;
    color: #dee2e6;
    margin-bottom: 20px;
    display: block;
}

.empty-state h3 {
    font-size: 24px;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--text-gray);
    font-size: 16px;
}

/* ============================================
   RESPONSIVE
   ============================================ */

/* Tablet */
@media (max-width: 992px) {
    .shop-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .shop-sidebar {
        position: static;
    }
    
    .sidebar-toggle {
        display: flex !important;
    }
    
    .shop-sidebar {
        display: none;
    }
    
    .shop-sidebar.open {
        display: flex;
    }
    
    .product-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Mobile */
@media (max-width: 768px) {
    .shop-container {
        padding: 15px;
    }
    
    .product-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .products-section {
        padding: 18px;
    }
    
    .section-header h3 {
        font-size: 20px;
    }
    
    .breadcrumb-custom {
        padding: 12px 16px;
        border-radius: 10px;
    }
    
    .breadcrumb-custom a,
    .breadcrumb-custom span {
        font-size: 13px;
    }
    
    .sidebar-card .card-header {
        padding: 12px 16px;
        font-size: 14px;
    }
    
    .sidebar-card .card-body .menu-item {
        padding: 8px 14px;
        font-size: 13px;
    }
    
    .sidebar-card .card-body .menu-item.sub {
        padding-left: 32px;
        font-size: 12px;
    }
    
    .product-card .quick-actions {
        opacity: 1 !important;
        transform: translateX(0) !important;
    }
    
    .product-card .quick-actions button {
        width: 30px;
        height: 30px;
        font-size: 12px;
    }
}

/* Mobile Small */
@media (max-width: 480px) {
    .shop-container {
        padding: 10px;
    }
    
    .product-grid {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    
    .products-section {
        padding: 12px;
    }
    
    .section-header h3 {
        font-size: 18px;
    }
    
    .section-header .product-count {
        font-size: 12px;
        padding: 4px 12px;
    }
    
    .product-card .info {
        padding: 10px 12px 12px;
    }
    
    .product-card .info .title {
        font-size: 12px;
        min-height: 30px;
    }
    
    .product-card .info .price-row .current {
        font-size: 15px;
    }
    
    .product-card .btn-group {
        flex-direction: column;
        gap: 4px;
    }
    
    .product-card .btn-group .btn {
        font-size: 11px;
        padding: 6px 8px;
    }
    
    .breadcrumb-custom {
        padding: 10px 14px;
    }
    
    .breadcrumb-custom a,
    .breadcrumb-custom span {
        font-size: 12px;
    }
    
    .pagination-wrap .pagination li a {
        padding: 5px 10px;
        font-size: 12px;
    }
    
    .sidebar-toggle {
        padding: 10px 14px;
        font-size: 14px;
    }
}

/* Dark Mode */
@media (prefers-color-scheme: dark) {
    :root {
        --bg-light: #1a1a2e;
        --white: #1e1e2f;
        --text-dark: #e8e8e8;
        --text-gray: #adb5bd;
    }
    
    .product-card {
        border-color: rgba(255,255,255,0.05);
    }
    
    .product-card .info .price-row {
        border-top-color: rgba(255,255,255,0.05);
    }
    
    .product-card .info .title a {
        color: #e8e8e8;
    }
    
    .sidebar-card .card-body .menu-item {
        border-bottom-color: rgba(255,255,255,0.04);
    }
    
    .pagination-wrap {
        border-top-color: rgba(255,255,255,0.05);
    }
    
    .pagination-wrap .pagination li a {
        background: #2a2a40;
        color: #e8e8e8;
        border-color: rgba(255,255,255,0.05);
    }
    
    .product-card .btn-group .btn-view {
        background: #2a2a40;
        color: #e8e8e8;
    }
    
    .sidebar-toggle {
        background: #1e1e2f;
        border-color: #ff523b;
        color: #ff523b;
    }
}
</style>

<!-- ============================================
SHOP PAGE CONTENT
============================================ -->
<div class="shop-container">

    <!-- Breadcrumb -->
    <div class="breadcrumb-custom">
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <span class="separator">/</span>
        <span>Shop</span>
        <?php if(isset($_GET['cat_id'])): 
            $cat_id = $_GET['cat_id'];
            $cat_query = "SELECT cat_title FROM categories WHERE cat_id='$cat_id'";
            $cat_result = mysqli_query($con, $cat_query);
            $cat_row = mysqli_fetch_array($cat_result);
        ?>
            <span class="separator">/</span>
            <span><?php echo $cat_row['cat_title']; ?></span>
        <?php endif; ?>
        <?php if(isset($_GET['p_cat'])): 
            $p_cat_id = $_GET['p_cat'];
            $p_cat_query = "SELECT p_cat_title FROM product_category WHERE p_cat_id='$p_cat_id'";
            $p_cat_result = mysqli_query($con, $p_cat_query);
            $p_cat_row = mysqli_fetch_array($p_cat_result);
        ?>
            <span class="separator">/</span>
            <span><?php echo $p_cat_row['p_cat_title']; ?></span>
        <?php endif; ?>
    </div>

    <!-- Sidebar Toggle (Mobile) -->
    <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
        <span><i class="fas fa-filter"></i> Filter Categories</span>
        <i class="fas fa-chevron-down"></i>
    </button>

    <!-- Shop Grid -->
    <div class="shop-grid">

        <!-- Sidebar -->
        <div class="shop-sidebar" id="shopSidebar">
            
            <!-- Categories Dropdown -->
            <div class="sidebar-card">
                <div class="card-header" onclick="toggleDropdown(this)">
                    <span><i class="fas fa-th-list"></i> Categories</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
                <div class="card-body">
                    <?php
                    $get_cats = "SELECT * FROM categories ORDER BY cat_title ASC";
                    $run_cats = mysqli_query($con, $get_cats);
                    while($row_cats = mysqli_fetch_array($run_cats)){
                        $cat_id = $row_cats['cat_id'];
                        $cat_title = $row_cats['cat_title'];
                        
                        $count_query = "SELECT COUNT(*) as total FROM products WHERE cat_id='$cat_id'";
                        $count_result = mysqli_query($con, $count_query);
                        $count_row = mysqli_fetch_array($count_result);
                        $total = $count_row['total'];
                    ?>
                    <a href="trimer.php?cat_id=<?php echo $cat_id; ?>" class="menu-item <?php echo (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat_id) ? 'active' : ''; ?>">
                        <span><i class="fas fa-folder"></i> <?php echo $cat_title; ?></span>
                        <span class="badge"><?php echo $total; ?></span>
                    </a>
                    <?php } ?>
                </div>
            </div>
            
            <!-- Product Categories Dropdown -->
            <div class="sidebar-card">
                <div class="card-header" onclick="toggleDropdown(this)">
                    <span><i class="fas fa-tags"></i> Product Categories</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
                <div class="card-body">
                    <?php
                    $get_p_cats = "SELECT * FROM product_category ORDER BY p_cat_title ASC";
                    $run_p_cats = mysqli_query($con, $get_p_cats);
                    while($row_p_cats = mysqli_fetch_array($run_p_cats)){
                        $p_cat_id = $row_p_cats['p_cat_id'];
                        $p_cat_title = $row_p_cats['p_cat_title'];
                        
                        $count_query = "SELECT COUNT(*) as total FROM products WHERE p_cat_id='$p_cat_id'";
                        $count_result = mysqli_query($con, $count_query);
                        $count_row = mysqli_fetch_array($count_result);
                        $total = $count_row['total'];
                        
                        if($total == 0) continue;
                    ?>
                    <a href="trimer.php?p_cat=<?php echo $p_cat_id; ?>" class="menu-item sub <?php echo (isset($_GET['p_cat']) && $_GET['p_cat'] == $p_cat_id) ? 'active' : ''; ?>">
                        <span><i class="fas fa-tag"></i> <?php echo $p_cat_title; ?></span>
                        <span class="badge"><?php echo $total; ?></span>
                    </a>
                    <?php } ?>
                </div>
            </div>
            
            <!-- Special Offers Dropdown -->
            <div class="sidebar-card special">
                <div class="card-header" onclick="toggleDropdown(this)">
                    <span><i class="fas fa-fire"></i> Special Offers</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
                <div class="card-body">
                    <a href="trimer.php" class="menu-item">
                        <span><i class="fas fa-bolt"></i> Flash Sale</span>
                        <span class="badge" style="background:var(--primary);color:#fff;">🔥</span>
                    </a>
                    <a href="trimer.php" class="menu-item">
                        <span><i class="fas fa-percent"></i> Discounted Items</span>
                        <span class="badge" style="background:var(--primary);color:#fff;">-20%</span>
                    </a>
                    <a href="trimer.php" class="menu-item">
                        <span><i class="fas fa-gem"></i> New Arrivals</span>
                        <span class="badge" style="background:#00b894;color:#fff;">✨</span>
                    </a>
                </div>
            </div>
            
        </div>

        <!-- Products -->
        <div class="products-section">
            
            <div class="section-header">
                <h3><i class="fas fa-store"></i> All Products</h3>
                <span class="product-count">
                    <?php
                    $count_query = "SELECT COUNT(*) as total FROM products";
                    $count_result = mysqli_query($con, $count_query);
                    $count_row = mysqli_fetch_array($count_result);
                    echo $count_row['total'] . ' products';
                    ?>
                </span>
            </div>

            <div class="product-grid">
                <?php
                // Category Filter
                if(isset($_GET['p_cat'])){
                    $p_cat_id = $_GET['p_cat'];
                    $get_products = "SELECT * FROM products WHERE p_cat_id='$p_cat_id' ORDER BY product_id DESC";
                    $run_products = mysqli_query($con, $get_products);
                } elseif(isset($_GET['cat_id'])){
                    $cat_id = $_GET['cat_id'];
                    $get_products = "SELECT * FROM products WHERE cat_id='$cat_id' ORDER BY product_id DESC";
                    $run_products = mysqli_query($con, $get_products);
                } else {
                    // Pagination
                    $per_page = 12;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $start_from = ($page - 1) * $per_page;
                    
                    $get_products = "SELECT * FROM products ORDER BY product_id DESC LIMIT $start_from, $per_page";
                    $run_products = mysqli_query($con, $get_products);
                }
                
                if(mysqli_num_rows($run_products) > 0) {
                    while($row = mysqli_fetch_array($run_products)) {
                        $pro_id = $row['product_id'];
                        $pro_title = $row['product_title'];
                        $pro_price = $row['product_price'];
                        $pro_img1 = $row['product_img1'];
                        
                        // Get category name
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
                        <span class="badge-sale">🔥 Sale</span>
                        <div class="quick-actions">
                            <button onclick="addToWishlist(<?php echo $pro_id; ?>)" title="Wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button onclick="quickView(<?php echo $pro_id; ?>)" title="Quick View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="info">
                        <div class="category"><?php echo htmlspecialchars($cat_name); ?></div>
                        <div class="title">
                            <a href="details.php?pro_id=<?php echo $pro_id; ?>">
                                <?php echo htmlspecialchars($pro_title); ?>
                            </a>
                        </div>
                        <div class="price-row">
                            <span class="current">£<?php echo number_format($pro_price, 2); ?></span>
                            <span class="original">£<?php echo number_format($pro_price * 1.2, 2); ?></span>
                        </div>
                        <div class="btn-group">
                            <a href="details.php?pro_id=<?php echo $pro_id; ?>" class="btn btn-view">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <button class="btn btn-cart" onclick="addToCart(<?php echo $pro_id; ?>)">
                                <i class="fas fa-shopping-bag"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                } else {
                ?>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>No Products Found</h3>
                    <p>Try adjusting your filters or search for something else.</p>
                </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <?php if(!isset($_GET['p_cat']) && !isset($_GET['cat_id'])): ?>
            <div class="pagination-wrap">
                <ul class="pagination">
                    <?php
                    $total_query = "SELECT COUNT(*) as total FROM products";
                    $total_result = mysqli_query($con, $total_query);
                    $total_row = mysqli_fetch_array($total_result);
                    $total_records = $total_row['total'];
                    $total_pages = ceil($total_records / $per_page);
                    
                    if($total_pages > 1) {
                        echo '<li><a href="trimer.php?page=1" class="' . (($page == 1) ? 'active' : '') . '">First</a></li>';
                        for($i = 1; $i <= $total_pages; $i++) {
                            $active = ($i == $page) ? 'active' : '';
                            echo '<li><a href="trimer.php?page='.$i.'" class="'.$active.'">'.$i.'</a></li>';
                        }
                        echo '<li><a href="trimer.php?page='.$total_pages.'" class="' . (($page == $total_pages) ? 'active' : '') . '">Last</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script>
// ============================================
// SIDEBAR TOGGLE (Mobile)
// ============================================
function toggleSidebar() {
    const sidebar = document.getElementById('shopSidebar');
    const toggle = document.getElementById('sidebarToggle');
    
    sidebar.classList.toggle('open');
    toggle.classList.toggle('active');
    
    const icon = toggle.querySelector('i:last-child');
    if(sidebar.classList.contains('open')) {
        icon.style.transform = 'rotate(180deg)';
    } else {
        icon.style.transform = 'rotate(0deg)';
    }
}

// ============================================
// DROPDOWN TOGGLE (Sidebar Cards)
// ============================================
function toggleDropdown(element) {
    const card = element.closest('.sidebar-card');
    const body = card.querySelector('.card-body');
    const icon = element.querySelector('.toggle-icon');
    
    body.classList.toggle('collapsed');
    element.classList.toggle('active');
    
    if(body.classList.contains('collapsed')) {
        icon.style.transform = 'rotate(-90deg)';
    } else {
        icon.style.transform = 'rotate(0deg)';
    }
}

// ============================================
// AUTO CLOSE SIDEBAR ON LINK CLICK (Mobile)
// ============================================
document.querySelectorAll('.sidebar-card .menu-item').forEach(item => {
    item.addEventListener('click', function() {
        if(window.innerWidth <= 992) {
            const sidebar = document.getElementById('shopSidebar');
            const toggle = document.getElementById('sidebarToggle');
            sidebar.classList.remove('open');
            toggle.classList.remove('active');
            const icon = toggle.querySelector('i:last-child');
            icon.style.transform = 'rotate(0deg)';
        }
    });
});

// ============================================
// ADD TO CART - AJAX
// ============================================
function addToCart(productId) {
    const btn = document.querySelector(`button[onclick*="addToCart(${productId})"]`);
    if (!btn) return;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
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
            showNotification('✅ ' + data.message, 'success');
            document.getElementById('cart-count').textContent = data.cart_count;
            if(typeof loadCartSidebar === 'function') {
                loadCartSidebar();
            }
            if(typeof openCartSidebar === 'function') {
                setTimeout(() => openCartSidebar(), 500);
            }
        } else {
            showNotification('❌ ' + data.message, 'error');
        }
    })
    .catch(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showNotification('❌ Failed to add to cart', 'error');
    });
}

// ============================================
// WISHLIST
// ============================================
function addToWishlist(productId) {
    fetch('add_to_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}`
    })
    .then(() => showNotification('❤️ Added to wishlist!', 'success'))
    .catch(() => showNotification('Please login to add to wishlist.', 'error'));
}

// ============================================
// QUICK VIEW
// ============================================
function quickView(productId) {
    window.location.href = 'details.php?pro_id=' + productId;
}

// ============================================
// NOTIFICATION
// ============================================
function showNotification(message, type = 'success') {
    const colors = {
        success: '#00b894',
        error: '#ff523b',
        info: '#0984e3'
    };
    
    const existing = document.querySelector('.shop-notification');
    if(existing) existing.remove();
    
    const notification = document.createElement('div');
    notification.className = 'shop-notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed; top: 20px; right: 20px;
        background: ${colors[type] || '#2d3436'};
        color: #fff; padding: 15px 25px;
        border-radius: 12px; z-index: 9999999;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        font-weight: 500; font-size: 14px;
        max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        font-family: 'Open Sans', sans-serif;
    `;
    document.body.appendChild(notification);
    
    requestAnimationFrame(() => {
        notification.style.transform = 'translateX(0)';
    });
    
    setTimeout(() => {
        notification.style.transform = 'translateX(120%)';
        setTimeout(() => notification.remove(), 400);
    }, 3000);
}
</script>
</body>
</html>