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

    <title>View Registrations - NSBM EventHub</title>

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

        <h1>Event Registrations</h1>

        <p>
            View all students who have registered for university events.
        </p>

        <br>

        <table>

            <tr>

                <th>ID</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Event</th>
                <th>Registered At</th>
                <th>Action</th>

            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo $row["id"]; ?>
                    </td>

                    <td>
                        <?php echo $row["name"]; ?>
                    </td>

                    <td>
                        <?php echo $row["email"]; ?>
                    </td>

                    <td>
                        <?php echo $row["title"]; ?>
                    </td>

                    <td>
                        <?php echo $row["registered_at"]; ?>
                    </td>

                    <td>

                        <a
                            class="delete-btn"
                            href="delete_registration.php?id=<?php echo $row["id"]; ?>"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>

</html>