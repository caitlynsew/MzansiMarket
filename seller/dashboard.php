<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

$product_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM products WHERE seller_id='$seller_id'")
);

$total_stock_result = mysqli_query(
    $conn,
    "SELECT SUM(stock) AS total_stock FROM products WHERE seller_id='$seller_id'"
);

$total_stock_row = mysqli_fetch_assoc($total_stock_result);
$total_stock = $total_stock_row['total_stock'] ?? 0;

$recent_products = mysqli_query(
    $conn,
    "SELECT * FROM products WHERE seller_id='$seller_id' ORDER BY created_at DESC LIMIT 3"
);
?>

<div class="dashboard-hero">

    <div>
        <p class="market-category">Seller Dashboard</p>

        <h1>
            Welcome, <?php echo $_SESSION['fullname']; ?>
        </h1>

        <p>
            Manage your product listings, update stock, and grow your local marketplace presence.
        </p>
    </div>

    <a href="add_product.php" class="dashboard-main-btn">
        + Add Product
    </a>

</div>

<div class="dashboard-stats">

    <div class="dash-stat-card">
        <h2><?php echo $product_count; ?></h2>
        <p>Products Listed</p>
    </div>

    <div class="dash-stat-card">
        <h2><?php echo $total_stock; ?></h2>
        <p>Total Stock</p>
    </div>

    <div class="dash-stat-card">
        <h2>Seller</h2>
        <p>Account Type</p>
    </div>

</div>

<div class="dashboard-actions">

    <a href="add_product.php" class="dash-action-card">
        <h3>Add Product</h3>
        <p>Create a new listing for buyers to view.</p>
    </a>

    <a href="my_products.php" class="dash-action-card">
        <h3>My Products</h3>
        <p>Edit, delete, and manage your current products.</p>
    </a>

    <a href="../logout.php" class="dash-action-card danger">
        <h3>Logout</h3>
        <p>End your current seller session securely.</p>
    </a>

</div>

<h2 class="mt-5 mb-4">Recently Added Products</h2>

<div class="row">

<?php while($product = mysqli_fetch_assoc($recent_products)){ ?>

<div class="col-lg-4 col-md-6 mb-4">

    <div class="market-card">

        <div class="market-image">
            <img src="../uploads/<?php echo $product['image']; ?>">
            <span class="product-badge">SELLER</span>
        </div>

        <div class="market-body">

            <p class="market-category">
                <?php echo $product['category']; ?>
            </p>

            <h4>
                <?php echo $product['product_name']; ?>
            </h4>

            <div class="market-price-row">
                <h3>R<?php echo $product['price']; ?></h3>

                <span class="stock-text">
                    <?php echo $product['stock']; ?> left
                </span>
            </div>

            <a href="edit_product.php?id=<?php echo $product['product_id']; ?>"
               class="cart-btn">
                Edit Product
            </a>

        </div>

    </div>

</div>

<?php } ?>

</div>

<?php
include("../includes/footer.php");
?>