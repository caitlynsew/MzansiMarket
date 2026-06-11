<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$order_id = $_POST['order_id'];
$status = $_POST['status'];

$sql = "UPDATE orders
        SET status='$status'
        WHERE order_id='$order_id'";

mysqli_query($conn, $sql);

header("Location: orders.php");
exit();
?>