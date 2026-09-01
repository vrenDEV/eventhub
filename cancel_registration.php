<?php

session_start();
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];
$user_id = $_SESSION["user_id"];

$sql = "DELETE FROM registrations
        WHERE id='$id'
        AND user_id='$user_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: my_schedule.php");
    exit();
} else {
    echo "Registration could not be cancelled";
}

?>