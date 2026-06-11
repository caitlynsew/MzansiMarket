<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$product_id = $_POST['product_id'];
$user_id = $_SESSION['user_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

$sql = "INSERT INTO reviews (product_id, user_id, rating, comment)
        VALUES ('$product_id', '$user_id', '$rating', '$comment')";

mysqli_query($conn, $sql);

header("Location: ../product.php?id=$product_id");
exit();
?>