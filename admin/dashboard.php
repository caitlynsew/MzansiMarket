<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$product_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
$user_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$order_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));
$dispute_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM disputes"));
?>

<div class="dashboard-hero">

    <div>
        <p class="market-category">Admin Dashboard</p>

        <h1>
            Welcome, <?php echo $_SESSION['fullname']; ?>
        </h1>

        <p>
            Manage users, verify sellers, monitor orders, and review customer disputes.
        </p>
    </div>

    <a href="users.php" class="dashboard-main-btn">
        Manage Users
    </a>

</div>

<div class="dashboard-stats">

    <div class="dash-stat-card">
        <h2><?php echo $product_count; ?></h2>
        <p>Products</p>
    </div>

    <div class="dash-stat-card">
        <h2><?php echo $user_count; ?></h2>
        <p>Users</p>
    </div>

    <div class="dash-stat-card">
        <h2><?php echo $order_count; ?></h2>
        <p>Orders</p>
    </div>

</div>

<div class="dashboard-stats mt-4">

    <div class="dash-stat-card">
        <h2><?php echo $dispute_count; ?></h2>
        <p>Disputes</p>
    </div>

    <div class="dash-stat-card">
        <h2>Admin</h2>
        <p>Account Type</p>
    </div>

    <div class="dash-stat-card">
        <h2>Live</h2>
        <p>System Status</p>
    </div>

</div>

<div class="dashboard-actions">

    <a href="users.php" class="dash-action-card">
        <h3>Manage Users</h3>
        <p>View buyers and sellers, and verify seller accounts.</p>
    </a>

    <a href="orders.php" class="dash-action-card">
        <h3>Manage Orders</h3>
        <p>View customer orders and update order progress.</p>
    </a>

    <a href="disputes.php" class="dash-action-card">
        <h3>Customer Disputes</h3>
        <p>Review reported issues connected to customer orders.</p>
    </a>

    <a href="../logout.php" class="dash-action-card danger">
        <h3>Logout</h3>
        <p>End your current admin session securely.</p>
    </a>

</div>
<?php
include("../includes/footer.php");
?>