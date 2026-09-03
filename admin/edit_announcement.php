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

    <title>Edit Announcement - NSBM EventHub</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="admin-layout">

    <div class="sidebar">

        <h2>NSBM EventHub</h2>

        <p>Admin Panel</p>

        <br>

        <a href="dashboard.php">Dashboard</a>
        <a href="events.php">Manage Events</a>
        <a href="categories.php">Manage Categories</a>
        <a href="registrations.php">View Registrations</a>
        <a href="participant_list.php">Participant List</a>
        <a href="announcements.php">Announcements</a>
        <a href="../logout.php">Logout</a>

    </div>


    <div class="admin-content">

        <h1>Edit Announcement</h1>

        <p><?php echo $message; ?></p>

        <div class="form-container">

            <form method="POST" action="">

                <label>Title</label>

                <input
                    type="text"
                    name="title"
                    value="<?php echo $announcement["title"]; ?>"
                    required
                >

                <br><br>

                <label>Message</label>

                <textarea
                    name="message"
                    required
                ><?php echo $announcement["message"]; ?></textarea>

                <br><br>

                <input
                    type="submit"
                    value="Update Announcement"
                >

            </form>

        </div>

        <a href="announcements.php" class="btn">
            Back to Announcements
        </a>

    </div>

</div>

</body>

</html>