<?php

session_start();
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$event_id = $_GET["id"];

$sql = "SELECT * FROM registrations
        WHERE user_id='$user_id'
        AND event_id='$event_id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo "You have already registered for this event";

} else {

    $sql = "INSERT INTO registrations (user_id, event_id)
            VALUES ('$user_id', '$event_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Event registration successful";
    } else {
        echo "Event registration failed";
    }
}

?>

<br><br>

<a href="index.php">Back to Events</a>