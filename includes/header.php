<!DOCTYPE html>
<html>
<head>
    <title>MzansiMarket</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
   
</head>

<body>

<div class="top-strip">
    <span>🇿🇦 Proudly South African</span>
    <span>Buy Local. Sell Local. Grow Mzansi.</span>
    <span>Help & Support</span>
</div>

<nav class="main-header">
    <div class="logo-box">
        <div class="africa-icon">♢</div>
        <div>
            <a href="/index.php" class="brand-name">
                Mzansi<span>Market</span>
            </a>
            <p>Buy & Sell Safely</p>
        </div>
    </div>

    <form method="GET" action="/index.php" class="header-search">
        <input type="text" name="search" placeholder="Search for products, categories or sellers...">

        <select name="category">
            <option value="all">All Categories</option>
            <option value="Clothing">Clothing</option>
            <option value="Electronics">Electronics</option>
            <option value="Food">Food</option>
            <option value="Furniture">Furniture</option>
            <option value="Other">Other</option>
        </select>

        <button type="submit">🔍</button>
    </form>

    <div class="header-actions">
        <a href="/buyer/wishlist.php">♡ Wishlist</a>
        <a href="/buyer/cart.php">🛒 Cart</a>

        <?php if(isset($_SESSION['user_id'])){ ?>
            <a href="/logout.php" class="gold-btn">Logout</a>
        <?php } else { ?>
            <a href="/login.php" class="gold-btn">Sign In</a>
        <?php } ?>
    </div>
</nav>

<nav class="nav-bar">
    <a href="/index.php">Home</a>
    <a href="/index.php">Products</a>
    <a href="/buyer/orders.php">Orders</a>
    <a href="/buyer/wishlist.php">Wishlist</a>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'seller'){ ?>
        <a href="/seller/dashboard.php">Seller Dashboard</a>
    <?php } ?>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){ ?>
        <a href="/admin/dashboard.php">Admin</a>
    <?php } ?>

    <a href="/seller/add_product.php" class="sell-link">Sell Your Product</a>
</nav>

<div class="container-fluid page-wrapper">