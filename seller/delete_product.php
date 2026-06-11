<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$product_id = $_GET['id'];
$seller_id = $_SESSION['user_id'];

$sql = "DELETE FROM products 
        WHERE product_id='$product_id' 
        AND seller_id='$seller_id'";

if(mysqli_query($conn, $sql)){
    header("Location: my_products.php");
    exit();
} else {
    echo "Error deleting product: " . mysqli_error($conn);
}
?>