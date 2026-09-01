<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT registrations.id,
               users.name,
               users.email,
               events.title,
               registrations.registered_at
        FROM registrations
        JOIN users
        ON registrations.user_id = users.id
        JOIN events
        ON registrations.event_id = events.id
        ORDER BY registrations.registered_at DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>View Registrations</title>
</head>

<body>

<h1>Event Registrations</h1>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Student Name</th>
        <th>Email</th>
        <th>Event</th>
        <th>Registered At</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["registered_at"]; ?></td>
        </tr>

    <?php } ?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</body>

</html>