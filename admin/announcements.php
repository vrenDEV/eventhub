<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $announcement = $_POST["message"];

    $sql = "INSERT INTO announcements (title, message)
            VALUES ('$title', '$announcement')";

    if ($conn->query($sql) === TRUE) {
        $message = "Announcement added successfully";
    } else {
        $message = "Announcement could not be added";
    }
}

$result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Announcements</title>

    <script>

    function validateForm() {

        if (document.form1.title.value.length == 0) {
            window.alert("Please enter the announcement title");
            return false;
        }

        if (document.form1.message.value.length == 0) {
            window.alert("Please enter the announcement message");
            return false;
        }

        return true;
    }

    </script>

</head>

<body>

<h1>Manage Announcements</h1>

<p><?php echo $message; ?></p>

<form name="form1" method="POST" action="" onsubmit="return validateForm()">

    <label>Title:</label><br>
    <input type="text" name="title">

    <br><br>

    <label>Message:</label><br>
    <textarea name="message"></textarea>

    <br><br>

    <input type="submit" value="Add Announcement">

</form>

<br>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Message</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["message"]; ?></td>
            <td><?php echo $row["created_at"]; ?></td>

            <td>
                <a href="edit_announcement.php?id=<?php echo $row["id"]; ?>">Edit</a>
                |
                <a href="delete_announcement.php?id=<?php echo $row["id"]; ?>">Delete</a>
            </td>
        </tr>

    <?php } ?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</body>

</html>