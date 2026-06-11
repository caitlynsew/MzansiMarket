<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("includes/db.php");
include("includes/header.php");
?>

<section class="mzansi-hero">

    <div class="hero-content">

        <h1>
            Buy & Sell <br>
            Safely in <span>Mzansi</span>
        </h1>

        <p>
            Your trusted local marketplace for quality products,
            verified sellers and secure shopping.
        </p>

        <div class="hero-buttons">

            <a href="#products" class="hero-btn gold">
                Shop Now
            </a>

            <a href="seller/add_product.php" class="hero-btn outline">
                Sell Now
            </a>

        </div>

    </div>

</section>

<?php

$product_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM products")
);

$user_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM users")
);

$order_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM orders")
);

?>

<div class="row mb-5 mt-5">

    <div class="col-md-4 mb-3">

        <div class="card text-center shadow">

            <div class="card-body">

                <h1><?php echo $product_count; ?></h1>

                <p class="text-muted mb-0">
                    Products Listed
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card text-center shadow">

            <div class="card-body">

                <h1><?php echo $user_count; ?></h1>

                <p class="text-muted mb-0">
                    Registered Users
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card text-center shadow">

            <div class="card-body">

                <h1><?php echo $order_count; ?></h1>

                <p class="text-muted mb-0">
                    Orders Placed
                </p>

            </div>

        </div>

    </div>

</div>

<h2 class="mb-4">Recently Added</h2>

<div class="row mb-5">

<?php

$recent_sql = "SELECT * FROM products
               ORDER BY created_at DESC
               LIMIT 3";

$recent_result = mysqli_query($conn, $recent_sql);

while($recent = mysqli_fetch_assoc($recent_result)){
?>

<div class="col-lg-4 col-md-6 mb-5">

    <div class="market-card">

        <div class="market-image">

            <img src="uploads/<?php echo $recent['image']; ?>">

            <span class="product-badge">
                NEW
            </span>

        </div>

        <div class="market-body">

            <p class="market-category">
                <?php echo $recent['category']; ?>
            </p>

            <h4>
                <?php echo $recent['product_name']; ?>
            </h4>

            <h3>
                R<?php echo $recent['price']; ?>
            </h3>

           <a href="product.php?id=<?php echo $recent['product_id']; ?>"
              class="recent-view-btn">
               View Product
           </a>

        </div>

    </div>

</div>

<?php } ?>

</div>


<div class="shop-controls">

    <form method="GET" class="shop-filter-form">

        <input type="text"
               name="search"
               placeholder="Search products..."
               value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

        <select name="category">

            <option value="all">All Categories</option>

            <option value="Clothing">
                Clothing
            </option>

            <option value="Electronics">
                Electronics
            </option>

            <option value="Food">
                Food
            </option>

            <option value="Furniture">
                Furniture
            </option>

            <option value="Other">
                Other
            </option>

        </select>

        <select name="sort">

            <option value="">
                Sort Products
            </option>

            <option value="low_high">
                Price: Low to High
            </option>

            <option value="high_low">
                Price: High to Low
            </option>

            <option value="newest">
                Newest First
            </option>

        </select>

        <button type="submit">
            Apply
        </button>

    </form>

</div>

<h2 id="products" class="mt-4 mb-4">
    Available Products
</h2>

<div class="row">

<?php

$limit = 6;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $limit;

$order_by = "created_at DESC";

if(isset($_GET['sort'])){

    if($_GET['sort'] == "low_high"){
        $order_by = "price ASC";
    }

    if($_GET['sort'] == "high_low"){
        $order_by = "price DESC";
    }

    if($_GET['sort'] == "newest"){
        $order_by = "created_at DESC";
    }
}

$sql = "SELECT * FROM products
        ORDER BY $order_by
        LIMIT $start, $limit";

if(isset($_GET['search']) && $_GET['search'] != ""){

    $search = $_GET['search'];

    $sql = "SELECT * FROM products
            WHERE product_name LIKE '%$search%'
            OR category LIKE '%$search%'
            ORDER BY $order_by
            LIMIT $start, $limit";
}

if(isset($_GET['category']) &&
   $_GET['category'] != "" &&
   $_GET['category'] != "all"){

    $category = $_GET['category'];

    $sql = "SELECT * FROM products
            WHERE category='$category'
            ORDER BY $order_by
            LIMIT $start, $limit";
}

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>

<div class="col-lg-4 col-md-6 mb-5">

    <div class="market-card">

        <div class="market-image">

            <img src="uploads/<?php echo $row['image']; ?>">

            <span class="product-badge">
                NEW
            </span>

            <a href="buyer/add_to_wishlist.php?id=<?php echo $row['product_id']; ?>"
               class="wishlist-btn">
                ♡
            </a>

        </div>

        <div class="market-body">

            <p class="market-category">
                <?php echo $row['category']; ?>
            </p>

            <h4>
                <?php echo $row['product_name']; ?>
            </h4>

            <p class="market-description">
                <?php echo substr($row['description'],0,80); ?>...
            </p>

            <div class="market-price-row">

                <h3>
                    R<?php echo $row['price']; ?>
                </h3>

                <span class="stock-text">
                    <?php echo $row['stock']; ?> left
                </span>

            </div>

            <div class="market-buttons">

                <a href="product.php?id=<?php echo $row['product_id']; ?>"
                   class="details-btn">
                    View
                </a>

                <a href="buyer/add_to_cart.php?id=<?php echo $row['product_id']; ?>"
                   class="cart-btn">
                    Add to Cart
                </a>

            </div>

        </div>

    </div>

</div>

<?php } ?>

</div>

<?php

$total_products_query = mysqli_query(
    $conn,
    "SELECT * FROM products"
);

$total_products = mysqli_num_rows($total_products_query);

$total_pages = ceil($total_products / $limit);

?>

<nav>

<ul class="pagination justify-content-center">

<?php for($i = 1; $i <= $total_pages; $i++){ ?>

    <li class="page-item <?php if($page == $i) echo 'active'; ?>">

        <a class="page-link"
           href="index.php?page=<?php echo $i; ?>">

           <?php echo $i; ?>

        </a>

    </li>

<?php } ?>

</ul>

</nav>

<?php
include("includes/footer.php");
?>