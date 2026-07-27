<?php
// 1. Include database connection from admin_area/includes/db.php
include("includes/db.php");

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Product</title>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5/tinymce.min.js"></script>
    <script>tinymce.init({selector:'textarea'});</script>
</head>
<body>

<div class="row"><!--breadcrumb start-->
    <div class="col-lg-12">
        <div class="breadcrumb">
            <li class="active">
                <i class="fa fa-bar-chart"></i>
                Dashboard / Insert Product
            </li>
        </div>
    </div>
</div><!--breadcrumb End-->

<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"> Insert Product </i>
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Title</label>
                        <input type="text" name="product_title" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Category</label>
                        <select name="product_cat" class="form-control" required="">
                            <option value="">Select a Product Category</option>
                            <?php
                            $get_p_cats = "SELECT * FROM product_category";
                            $run_p_cats = mysqli_query($con, $get_p_cats);
                            while ($row = mysqli_fetch_array($run_p_cats)) {
                                $id = $row['p_cat_id'];
                                $cat_title = $row['p_cat_title'];
                                echo "<option value='$id'>$cat_title</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Categories</label>
                        <select name="cat" class="form-control" required="">
                            <option value="">Select Categories</option>
                            <?php
                            $get_cats = "SELECT * FROM categories";
                            $run_cats = mysqli_query($con, $get_cats);
                            while ($row = mysqli_fetch_array($run_cats)) {
                                $id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                echo "<option value='$id'>$cat_title</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Image 1</label>
                        <input type="file" name="product_img1" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Image 2</label>
                        <input type="file" name="product_img2" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Image 3</label>
                        <input type="file" name="product_img3" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Price</label>
                        <input type="text" name="product_price" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Keyword</label>
                        <input type="text" name="product_keyword" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Description</label>
                        <textarea name="product_desc" class="form-control" rows="6" cols="19"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit" value="Insert Product" class="btn btn-primary form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-3"></div>
</div>

</body>
</html>

<?php
if (isset($_POST['submit'])) {
    // Escaping strings to prevent syntax crashes from quotes in TinyMCE/titles
    $product_title   = mysqli_real_escape_string($con, $_POST['product_title']);
    $product_cat     = mysqli_real_escape_string($con, $_POST['product_cat']);
    $cat             = mysqli_real_escape_string($con, $_POST['cat']);
    $product_price   = mysqli_real_escape_string($con, $_POST['product_price']);
    $product_desc    = mysqli_real_escape_string($con, $_POST['product_desc']);
    $product_keyword = mysqli_real_escape_string($con, $_POST['product_keyword']);

    // Image Upload setup
    $product_img1 = $_FILES['product_img1']['name'];
    $product_img2 = $_FILES['product_img2']['name'];
    $product_img3 = $_FILES['product_img3']['name'];

    $temp_name1 = $_FILES['product_img1']['tmp_name'];
    $temp_name2 = $_FILES['product_img2']['tmp_name'];
    $temp_name3 = $_FILES['product_img3']['tmp_name'];

    move_uploaded_file($temp_name1, "product_images/$product_img1");
    move_uploaded_file($temp_name2, "product_images/$product_img2");
    move_uploaded_file($temp_name3, "product_images/$product_img3");

    // Corrected SQL variable typo and query string
    $insert_product = "INSERT INTO products (p_cat_id, cat_id, date, product_title, product_img1, product_img2, product_img3, product_price, product_desc, product_keyword) 
                       VALUES ('$product_cat', '$cat', NOW(), '$product_title', '$product_img1', '$product_img2', '$product_img3', '$product_price', '$product_desc', '$product_keyword')";

    $run_product = mysqli_query($con, $insert_product);

    if ($run_product) {
        echo "<script>alert('Product Inserted Successfully!')</script>";
        echo "<script>window.open('index.php?view_product','_self')</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "')</script>";
    }
}
?>

<?php } ?>