<?php

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

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Events - NSBM EventHub</title>

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

        <div class="section-title">

            <h1>Manage Events</h1>

            <a href="add_event.php" class="btn">
                Add New Event
            </a>

        </div>

        <br>

        <table>

            <tr>

                <th>ID</th>

                <th>Title</th>

                <th>Category</th>

                <th>Date</th>

                <th>Time</th>

                <th>Location</th>

                <th>Action</th>

            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo $row["id"]; ?>
                    </td>

                    <td>
                        <?php echo $row["title"]; ?>
                    </td>

                    <td>
                        <?php echo $row["category_name"]; ?>
                    </td>

                    <td>
                        <?php echo $row["event_date"]; ?>
                    </td>

                    <td>
                        <?php echo $row["event_time"]; ?>
                    </td>

                    <td>
                        <?php echo $row["location"]; ?>
                    </td>

                    <td>

                        <a
                            class="edit-btn"
                            href="edit_event.php?id=<?php echo $row["id"]; ?>"
                        >
                            Edit
                        </a>

                        <a
                            class="delete-btn"
                            href="delete_event.php?id=<?php echo $row["id"]; ?>"
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