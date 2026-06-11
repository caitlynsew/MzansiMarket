<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT orders.*, users.fullname AS buyer_name
        FROM orders
        JOIN users ON orders.buyer_id = users.user_id
        ORDER BY orders.order_date DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="orders-page">

    <div class="orders-header">
        <p class="market-category">Admin Orders</p>
        <h1>Manage Orders</h1>
        <p>View customer orders and update order progress.</p>
    </div>

    <div class="orders-grid">

        <?php while($row = mysqli_fetch_assoc($result)){ ?>

        <div class="order-card">

            <div class="order-top">
                <div>
                    <p class="order-label">Order ID</p>
                    <h3>#<?php echo $row['order_id']; ?></h3>
                </div>

                <span class="order-status">
                    <?php echo $row['status']; ?>
                </span>
            </div>

            <div class="order-info">
                <div>
                    <p>Buyer</p>
                    <strong><?php echo $row['buyer_name']; ?></strong>
                </div>

                <div>
                    <p>Total</p>
                    <strong>R<?php echo $row['total_amount']; ?></strong>
                </div>
            </div>

            <div class="order-address">
                <p>Delivery Address</p>
                <span><?php echo $row['address']; ?></span>
            </div>

            <form method="POST" action="update_order_status.php">

                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">

                <select name="status" class="form-select mb-3">
                    <option value="Pending" <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
                    <option value="Processing" <?php if($row['status']=="Processing") echo "selected"; ?>>Processing</option>
                    <option value="Ready for Delivery" <?php if($row['status']=="Ready for Delivery") echo "selected"; ?>>Ready for Delivery</option>
                    <option value="Completed" <?php if($row['status']=="Completed") echo "selected"; ?>>Completed</option>
                    <option value="Cancelled" <?php if($row['status']=="Cancelled") echo "selected"; ?>>Cancelled</option>
                </select>

                <button type="submit" class="cart-btn" style="border:none; width:100%;">
                    Update Status
                </button>

            </form>

        </div>

        <?php } ?>

    </div>

</div>

<?php
include("../includes/footer.php");
?>