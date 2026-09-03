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

    <title>My Schedule - NSBM EventHub</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="navbar">

    <div class="logo">
        NSBM <span>EventHub</span>
    </div>

    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="index.php#events">Events</a>

        <a href="index.php#announcements">Announcements</a>

        <a href="my_schedule.php">My Schedule</a>

        <a href="logout.php">Logout</a>

    </div>

</div>


<section class="section">

    <div class="section-title">

        <h2>My Event <span class="green-text">Schedule</span></h2>

    </div>

    <p>
        Welcome <?php echo $_SESSION["name"]; ?>. These are the events you have registered for.
    </p>

    <br>

    <table>

        <tr>

            <th>Event</th>
            <th>Category</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Action</th>

        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>

            <tr>

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
                        class="cancel-btn"
                        href="cancel_registration.php?id=<?php echo $row["registration_id"]; ?>"
                    >
                        Cancel Registration
                    </a>

                </td>

            </tr>

        <?php } ?>

    </table>

    <br><br>

    <a href="index.php" class="btn">
        Back to Events
    </a>

</section>


<div class="footer">

    © 2026 NSBM EventHub

</div>

</body>

</html>