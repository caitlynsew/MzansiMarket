<?php
session_start();

$product_id = $_GET['id'];
$action = $_GET['action'];

if(isset($_SESSION['cart'][$product_id])){

    if($action == "increase"){
        $_SESSION['cart'][$product_id]++;
    }

    if($action == "decrease"){

        $_SESSION['cart'][$product_id]--;

        if($_SESSION['cart'][$product_id] <= 0){
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

header("Location: cart.php");
exit();
?>