<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM announcements WHERE id='$id'";
$result = $conn->query($sql);
$announcement = $result->fetch_assoc();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $announcement_message = $_POST["message"];

    $sql = "UPDATE announcements SET
            title='$title',
            message='$announcement_message'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Announcement updated successfully";

        $sql = "SELECT * FROM announcements WHERE id='$id'";
        $result = $conn->query($sql);
        $announcement = $result->fetch_assoc();

    } else {
        $message = "Announcement could not be updated";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Announcement</title>
</head>

<body>

<h1>Edit Announcement</h1>

<p><?php echo $message; ?></p>

<form method="POST" action="">

    <label>Title:</label><br>
    <input type="text" name="title"
           value="<?php echo $announcement["title"]; ?>" required>

    <br><br>

    <label>Message:</label><br>

    <textarea name="message" required><?php echo $announcement["message"]; ?></textarea>

    <br><br>

    <input type="submit" value="Update Announcement">

</form>

<br>

<a href="announcements.php">Back to Announcements</a>

</body>

</html>