<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "<div class='empty-cart-box'><h1>Your cart is empty</h1><a href='../index.php' class='cart-btn'>Continue Shopping</a></div>";
    include("../includes/footer.php");
    exit();
}

$total = 0;

foreach($_SESSION['cart'] as $product_id => $quantity){
    $sql = "SELECT * FROM products WHERE product_id='$product_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $subtotal = $row['price'] * $quantity;
    $total += $subtotal;
}

if(isset($_POST['place_order'])){

    $buyer_id = $_SESSION['user_id'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    $shipping_method = $_POST['shipping_method'];

    if($shipping_method == "Collection from Seller"){
       $shipping_fee = 0;
    }
    elseif($shipping_method == "Local Delivery"){
       $shipping_fee = 50;
    }
    elseif($shipping_method == "Courier Delivery"){
       $shipping_fee = 100;
    }

$grand_total = $total + $shipping_fee;

    $order_sql = "INSERT INTO orders
              (buyer_id, total_amount, fullname, phone, address, payment_method, shipping_method, shipping_fee)
              VALUES
              ('$buyer_id', '$grand_total', '$fullname', '$phone', '$address', '$payment_method', '$shipping_method', '$shipping_fee')";
    if(mysqli_query($conn, $order_sql)){

        $order_id = mysqli_insert_id($conn);

        foreach($_SESSION['cart'] as $product_id => $quantity){

            $product_sql = "SELECT * FROM products WHERE product_id='$product_id'";
            $product_result = mysqli_query($conn, $product_sql);
            $product = mysqli_fetch_assoc($product_result);

            $price = $product['price'];

            $item_sql = "INSERT INTO order_items
                         (order_id, product_id, price)
                         VALUES
                         ('$order_id', '$product_id', '$price')";

            mysqli_query($conn, $item_sql);

            $new_stock = $product['stock'] - $quantity;

            mysqli_query(
                $conn,
                "UPDATE products
                 SET stock='$new_stock'
                 WHERE product_id='$product_id'"
            );
        }

        unset($_SESSION['cart']);

        $success = "Order placed successfully! Your order status is Pending.";
    }
}
?>

<?php if(isset($success)){ ?>

<div class="checkout-success">

    <h1>Order Placed Successfully</h1>

    <p>
        Thank you for shopping with MzansiMarket. Your order has been saved.
    </p>

    <a href="orders.php" class="cart-btn">
        View My Orders
    </a>

    <a href="../index.php" class="details-btn">
        Continue Shopping
    </a>

</div>

<?php } else { ?>

<div class="checkout-page">

    <div class="checkout-header">

        <p class="market-category">Secure Checkout</p>

        <h1>Complete Your Order</h1>

        <p>
            Enter your delivery information to finalise your purchase.
        </p>

    </div>

    <div class="checkout-layout">

        <div class="checkout-form-card">

            <h2>Delivery Details</h2>

            <form method="POST">

                <label>Full Name</label>
                <input type="text" name="fullname" required>

                <label>Phone Number</label>
                <input type="text" name="phone" required>

                <label>Delivery Address</label>
                <textarea name="address" rows="5" required></textarea>

                <label>Shipping Option</label>
                <select name="shipping_method" required>
                   <option value="Collection from Seller">Collection from Seller - R0</option>
                   <option value="Local Delivery">Local Delivery - R50</option>
                   <option value="Courier Delivery">Courier Delivery - R100</option>
                </select>

                <label>Payment Method</label>
                <select name="payment_method" required>
                   <option value="Cash on Collection">Cash on Collection</option>
                   <option value="EFT">EFT</option>
                   <option value="Ozow Coming Soon">Ozow Coming Soon</option>
                   <option value="PayFast Coming Soon">PayFast Coming Soon</option>
                </select>

                <button type="submit" name="place_order">
                    Place Order
                </button>

            </form>

        </div>

        <div class="checkout-summary">

            <h2>Order Summary</h2>

            <?php
            foreach($_SESSION['cart'] as $product_id => $quantity){

                $item_sql = "SELECT * FROM products WHERE product_id='$product_id'";
                $item_result = mysqli_query($conn, $item_sql);
                $item = mysqli_fetch_assoc($item_result);

                $item_subtotal = $item['price'] * $quantity;
            ?>

            <div class="checkout-item">

                <img src="../uploads/<?php echo $item['image']; ?>">

                <div>
                    <h4><?php echo $item['product_name']; ?></h4>
                    <p>Qty: <?php echo $quantity; ?></p>
                    <strong>R<?php echo $item_subtotal; ?></strong>
                </div>

            </div>

            <?php } ?>

            <hr>

            <div class="summary-row">
             <span>Subtotal</span>
             <strong>R<?php echo number_format($total, 2); ?></strong>
            </div>

            <div class="summary-row">
             <span>Shipping</span>
             <strong id="shippingFee">R0.00</strong>
            </div>

            <div class="summary-total">
             <span>Total</span>
             <strong id="grandTotal">R<?php echo number_format($total, 2); ?></strong>
             </div>

            <p class="checkout-note">
             Payment is simulated for academic demonstration purposes.
             </p>

        </div>

    </div>

</div>

<?php } ?>

<script>
const shippingSelect = document.querySelector("select[name='shipping_method']");
const shippingFeeText = document.getElementById("shippingFee");
const grandTotalText = document.getElementById("grandTotal");

const subtotal = <?php echo $total; ?>;

function updateShippingTotal(){
    let shippingFee = 0;

    if(shippingSelect.value === "Local Delivery"){
        shippingFee = 50;
    }

    if(shippingSelect.value === "Courier Delivery"){
        shippingFee = 100;
    }

    const grandTotal = subtotal + shippingFee;

    shippingFeeText.innerText = "R" + shippingFee.toFixed(2);
    grandTotalText.innerText = "R" + grandTotal.toFixed(2);
}

shippingSelect.addEventListener("change", updateShippingTotal);
updateShippingTotal();
</script>

<?php
include("../includes/footer.php");
?>