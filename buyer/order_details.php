<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$order_id = $_GET['id'];
$buyer_id = $_SESSION['user_id'];

$order_sql = "SELECT * FROM orders 
              WHERE order_id='$order_id' 
              AND buyer_id='$buyer_id'";
$order_result = mysqli_query($conn, $order_sql);
$order = mysqli_fetch_assoc($order_result);

$items_sql = "SELECT order_items.*, products.product_name, products.image
              FROM order_items
              JOIN products ON order_items.product_id = products.product_id
              WHERE order_items.order_id='$order_id'";
$items_result = mysqli_query($conn, $items_sql);
?>

<h2 class="mb-4">Order Details</h2>

<div class="card shadow mb-4">
    <div class="card-body">
        <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
        <p><strong>Total:</strong> R<?php echo $order['total_amount']; ?></p>
        <p><strong>Name:</strong> <?php echo $order['fullname']; ?></p>
        <p><strong>Phone:</strong> <?php echo $order['phone']; ?></p>
        <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
        <p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
    </div>
</div>

<h4>Products Bought</h4>

<div class="table-responsive">
<table class="table table-bordered bg-white">

<thead class="table-dark">
<tr>
    <th>Image</th>
    <th>Product</th>
    <th>Price</th>
</tr>
</thead>

<tbody>
<?php while($item = mysqli_fetch_assoc($items_result)){ ?>
<tr>
    <td>
        <img src="../uploads/<?php echo $item['image']; ?>" width="70" class="rounded">
    </td>
    <td><?php echo $item['product_name']; ?></td>
    <td>R<?php echo $item['price']; ?></td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

<a href="orders.php" class="btn btn-dark">Back to Orders</a>

<?php
include("../includes/footer.php");
?>