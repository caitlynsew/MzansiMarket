<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$user_id = $_GET['id'];

$sql = "UPDATE users 
        SET verified='yes' 
        WHERE user_id='$user_id' 
        AND role='seller'";

if(mysqli_query($conn, $sql)){
    header("Location: users.php");
    exit();
} else {
    echo "Error verifying seller: " . mysqli_error($conn);
}
?>