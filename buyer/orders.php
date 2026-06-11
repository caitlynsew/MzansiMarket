<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders
        WHERE buyer_id='$buyer_id'
        ORDER BY order_date DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="orders-page">

    <div class="orders-header">

        <div>
            <p class="market-category">Order History</p>

            <h1>My Orders</h1>

            <p>
                Track your previous purchases and manage disputes.
            </p>
        </div>

    </div>

    <?php if(mysqli_num_rows($result) > 0){ ?>

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
                    <p>Total Amount</p>
                    <strong>R<?php echo $row['total_amount']; ?></strong>
                </div>

                <div>
                    <p>Order Date</p>
                    <strong>
                        <?php echo date("d M Y", strtotime($row['order_date'])); ?>
                    </strong>
                </div>

            </div>

            <div class="order-address">

                <p>Delivery Address</p>

                <span>
                    <?php echo $row['address']; ?>
                </span>

            </div>

            <div class="order-actions">

                <a href="order_details.php?id=<?php echo $row['order_id']; ?>"
                   class="details-btn">
                    View Details
                </a>

                <a href="report_dispute.php?id=<?php echo $row['order_id']; ?>"
                   class="cart-btn">
                    Report Dispute
                </a>

            </div>

        </div>

        <?php } ?>

    </div>

    <?php } else { ?>

    <div class="empty-orders">

        <h2>No Orders Yet</h2>

        <p>
            You haven’t placed any orders yet.
        </p>

        <a href="../index.php" class="cart-btn">
            Start Shopping
        </a>

    </div>

    <?php } ?>

</div>

<?php
include("../includes/footer.php");
?>