<?php

session_start();
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT registrations.id AS registration_id,
               events.*,
               categories.category_name
        FROM registrations
        JOIN events
        ON registrations.event_id = events.id
        LEFT JOIN categories
        ON events.category_id = categories.id
        WHERE registrations.user_id='$user_id'
        ORDER BY events.event_date ASC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>My Event Schedule</title>
</head>

<body>

<h1>My Event Schedule</h1>

<table border="1" cellpadding="10">

    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
            <td><?php echo $row["event_date"]; ?></td>
            <td><?php echo $row["event_time"]; ?></td>
            <td><?php echo $row["location"]; ?></td>
            <td>
                <a href="cancel_registration.php?id=<?php echo $row["registration_id"]; ?>">
                    Cancel
                </a>
            </td>
        </tr>

    <?php } ?>

</table>

<br>

<a href="index.php">Back to Events</a>

</body>

</html>