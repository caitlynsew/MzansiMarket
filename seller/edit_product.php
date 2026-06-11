<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$product_id = $_GET['id'];
$seller_id = $_SESSION['user_id'];

$sql = "SELECT * FROM products 
        WHERE product_id='$product_id' 
        AND seller_id='$seller_id'";

$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if(isset($_POST['update_product'])){
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $update = "UPDATE products SET
                product_name='$product_name',
                description='$description',
                price='$price',
                category='$category'
               WHERE product_id='$product_id'
               AND seller_id='$seller_id'";

    if(mysqli_query($conn, $update)){
        header("Location: my_products.php");
        exit();
    } else {
        $error = "Error updating product.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card shadow">
            <div class="card-body p-4">

                <h2 class="mb-4">Edit Product</h2>

                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control"
                               value="<?php echo $product['product_name']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Description</label>
                        <textarea name="description" class="form-control" rows="4" required><?php echo $product['description']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" step="0.01"
                               value="<?php echo $product['price']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="Clothing" <?php if($product['category']=="Clothing") echo "selected"; ?>>Clothing</option>
                            <option value="Electronics" <?php if($product['category']=="Electronics") echo "selected"; ?>>Electronics</option>
                            <option value="Food" <?php if($product['category']=="Food") echo "selected"; ?>>Food</option>
                            <option value="Furniture" <?php if($product['category']=="Furniture") echo "selected"; ?>>Furniture</option>
                            <option value="Other" <?php if($product['category']=="Other") echo "selected"; ?>>Other</option>
                        </select>
                    </div>

                    <button type="submit" name="update_product" class="btn btn-dark">
                        Update Product
                    </button>

                    <a href="my_products.php" class="btn btn-outline-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>

    </div>
</div>

<?php
include("../includes/footer.php");
?>