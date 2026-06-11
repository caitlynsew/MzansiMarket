<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
?>

<div class="empty-cart-box">

    <h1>Your cart is empty</h1>

    <p>
        Browse products and add items to your shopping cart.
    </p>

    <a href="../index.php" class="cart-btn">
        Continue Shopping
    </a>

</div>

<?php
include("../includes/footer.php");
exit();
}

$total = 0;
?>

<div class="cart-page">

    <div class="cart-header">

        <div>
            <p class="market-category">Shopping Cart</p>
            <h1>Your Cart</h1>
        </div>

        <a href="../index.php" class="details-btn">
            Continue Shopping
        </a>

    </div>

    <div class="cart-layout">

        <div class="cart-items">

            <?php
            foreach($_SESSION['cart'] as $product_id => $quantity){

                $sql = "SELECT * FROM products WHERE product_id='$product_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $subtotal = $row['price'] * $quantity;
                $total += $subtotal;
            ?>

            <div class="cart-item-card" style="display:grid !important; grid-template-columns:100px 1fr !important; gap:15px !important; align-items:center !important;">

                <img src="../uploads/<?php echo $row['image']; ?>"
                     style="width:90px !important; height:90px !important; object-fit:cover !important; border-radius:10px !important;">

                <div class="cart-item-info">

                    <p class="market-category">
                        <?php echo $row['category']; ?>
                    </p>

                    <h3>
                        <?php echo $row['product_name']; ?>
                    </h3>

                    <p>
                        R<?php echo $row['price']; ?> each
                    </p>

                    <div class="quantity-controls">

                        <a href="update_quantity.php?id=<?php echo $product_id; ?>&action=decrease">
                            -
                        </a>

                        <span>
                            <?php echo $quantity; ?>
                        </span>

                        <a href="update_quantity.php?id=<?php echo $product_id; ?>&action=increase">
                            +
                        </a>

                    </div>

                </div>

                <div class="cart-item-total">

                    <h3>
                        R<?php echo $subtotal; ?>
                    </h3>

                    <a href="remove_from_cart.php?id=<?php echo $product_id; ?>">
                        Remove
                    </a>

                </div>

            </div>

            <?php } ?>

        </div>

        <div class="cart-summary">

            <h2>Order Summary</h2>

            <div class="summary-row">
                <span>Subtotal</span>
                <strong>R<?php echo $total; ?></strong>
            </div>

            <div class="summary-row">
                <span>Delivery</span>
                <strong>Calculated later</strong>
            </div>

            <hr>

            <div class="summary-total">
                <span>Total</span>
                <strong>R<?php echo $total; ?></strong>
            </div>

            <a href="checkout.php" class="checkout-btn">
                Proceed to Checkout
            </a>

        </div>

    </div>

</div>

<?php
include("../includes/footer.php");
?>