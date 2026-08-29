<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT events.*, categories.category_name
        FROM events
        LEFT JOIN categories
        ON events.category_id = categories.id";
$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
</head>

<body>

    <h1>Manage Events</h1>

    <a href="add_event.php">Add New Event</a>

    <br><br>

    <table border="1" cellpadding="10">

        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
        ?>

        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
            <td><?php echo $row["event_date"]; ?></td>
            <td><?php echo $row["event_time"]; ?></td>
            <td><?php echo $row["location"]; ?></td>

            <td>
                <a href="edit_event.php?id=<?php echo $row["id"]; ?>">Edit</a>
                |
                <a href="delete_event.php?id=<?php echo $row["id"]; ?>">Delete</a>
            </td>
        </tr>

        <?php
        }
        ?>

    </table>

    <br>

    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>