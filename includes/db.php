<?php

$conn = mysqli_connect(
    "my_database_host",
    "my_database_username",
    "my_database_password",
    "my_database_name"
);if(!$conn){
    die("Database connection failed");
}

?>
