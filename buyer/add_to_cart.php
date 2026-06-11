<?php
session_start();
include("../includes/db.php");

$product_id = $_GET['id'];

$product_query = mysqli_query($conn, "SELECT * FROM products WHERE product_id='$product_id'");
$product = mysqli_fetch_assoc($product_query);

if($product['stock'] <= 0){
    header("Location: ../product.php?id=$product_id");
    exit();
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if(isset($_SESSION['cart'][$product_id])){
    if($_SESSION['cart'][$product_id] < $product['stock']){
        $_SESSION['cart'][$product_id]++;
    }
} else {
    $_SESSION['cart'][$product_id] = 1;
}

header("Location: cart.php");
exit();
?>