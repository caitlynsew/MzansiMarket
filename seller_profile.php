<?php
session_start();
include("includes/db.php");
include("includes/header.php");

$seller_id = $_GET['id'];

$seller_sql = "SELECT * FROM users
               WHERE user_id='$seller_id'
               AND role='seller'";

$seller_result = mysqli_query($conn, $seller_sql);
$seller = mysqli_fetch_assoc($seller_result);

$product_sql = "SELECT * FROM products
                WHERE seller_id='$seller_id'";

$product_result = mysqli_query($conn, $product_sql);
$product_count = mysqli_num_rows($product_result);
?>

<div class="seller-profile-hero">

    <div>
        <p class="market-category">Seller Profile</p>

        <h1><?php echo $seller['fullname']; ?></h1>

        <?php if($seller['verified'] == 'yes'){ ?>
            <span class="verified-badge">Verified Seller</span>
        <?php } else { ?>
            <span class="unverified-badge">Unverified Seller</span>
        <?php } ?>
    </div>

    <div class="seller-stat-box">
        <h2><?php echo $product_count; ?></h2>
        <p>Products Listed</p>
    </div>

</div>

<h2 class="mt-5 mb-4">Products by <?php echo $seller['fullname']; ?></h2>

<div class="row">

<?php while($product = mysqli_fetch_assoc($product_result)){ ?>

<div class="col-lg-4 col-md-6 mb-5">

    <div class="market-card">

        <div class="market-image">
            <img src="uploads/<?php echo $product['image']; ?>">
            <span class="product-badge">SELLER</span>
        </div>

        <div class="market-body">

            <p class="market-category">
                <?php echo $product['category']; ?>
            </p>

            <h4><?php echo $product['product_name']; ?></h4>

            <div class="market-price-row">
                <h3>R<?php echo $product['price']; ?></h3>

                <span class="stock-text">
                    <?php echo $product['stock']; ?> left
                </span>
            </div>

            <a href="product.php?id=<?php echo $product['product_id']; ?>"
               class="cart-btn">
                View Product
            </a>

        </div>

    </div>

</div>

<?php } ?>

</div>

<?php
include("includes/footer.php");
?>