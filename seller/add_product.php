<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['add_product'])){
    $seller_id = $_SESSION['user_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    $image = $_FILES['image']['name'];
    $tmp_image = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp_image, "../uploads/" . $image);

    $sql = "INSERT INTO products 
            (seller_id, product_name, description, price, image, category, stock)
            VALUES 
            ('$seller_id', '$product_name', '$description', '$price', '$image', '$category', '$stock')";

    if(mysqli_query($conn, $sql)){
        $success = "Product added successfully.";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-body p-4">

                <h2 class="mb-4">Add Product</h2>

                <?php if(isset($success)){ ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php } ?>

                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Description</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="stock" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="Clothing">Clothing</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Food">Food</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    <button type="submit" name="add_product" class="btn btn-dark">
                        Add Product
                    </button>

                    <a href="dashboard.php" class="btn btn-outline-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>