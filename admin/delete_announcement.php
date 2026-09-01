<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$id = $_GET["id"];

$sql = "DELETE FROM announcements WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: announcements.php");
    exit();
} else {
    echo "Announcement could not be deleted";
}

?>