<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$id = $_GET["id"];

$sql = "DELETE FROM categories WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: categories.php");
    exit();
} else {
    echo "Category could not be deleted";
}

?>