<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

$sql = "SELECT * FROM products WHERE seller_id='$seller_id'";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>My Products</h2>

    <a href="add_product.php" class="btn btn-dark">
        Add Product
    </a>

</div>

<div class="table-responsive">

<table class="table table-bordered table-hover bg-white">

    <thead class="table-dark">

        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>

    </thead>

    <tbody>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

        <tr>

            <td>
                <img src="../uploads/<?php echo $row['image']; ?>"
                     width="80"
                     class="rounded">
            </td>

            <td>
                <?php echo $row['product_name']; ?>
            </td>

            <td>
                R<?php echo $row['price']; ?>
            </td>

            <td>
                <span class="badge bg-secondary">
                    <?php echo $row['category']; ?>
                </span>
            </td>

            <td>

                <a href="edit_product.php?id=<?php echo $row['product_id']; ?>"
                   class="btn btn-warning btn-sm">

                   Edit
                </a>

                <a href="delete_product.php?id=<?php echo $row['product_id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this product?');">

                   Delete
                </a>

            </td>

        </tr>

    <?php } ?>

    </tbody>

</table>

</div>

<?php
include("../includes/footer.php");
?>