<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT wishlist.*, products.*
        FROM wishlist
        JOIN products
        ON wishlist.product_id = products.product_id
        WHERE wishlist.user_id='$user_id'";

$result = mysqli_query($conn, $sql);
?>

<h2 class="mb-4">My Wishlist</h2>

<div class="row">

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="col-md-4 mb-4">

    <div class="card h-100 shadow-sm">

        <img src="../uploads/<?php echo $row['image']; ?>"
             class="card-img-top"
             style="height:250px; object-fit:cover;">

        <div class="card-body">

            <h5><?php echo $row['product_name']; ?></h5>

            <p class="text-success">
                R<?php echo $row['price']; ?>
            </p>

            <a href="../product.php?id=<?php echo $row['product_id']; ?>"
               class="btn btn-dark">
                View Product
            </a>

        </div>

    </div>

</div>

<?php } ?>

</div>

<?php
include("../includes/footer.php");
?>