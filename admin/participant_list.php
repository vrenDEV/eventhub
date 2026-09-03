<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$event_id = "";

if (isset($_GET["event_id"])) {
    $event_id = $_GET["event_id"];
}

$eventResult = $conn->query("SELECT * FROM events ORDER BY event_date ASC");

if ($event_id != "") {

    $sql = "SELECT users.name,
                   users.email,
                   events.title
            FROM registrations
            JOIN users
            ON registrations.user_id = users.id
            JOIN events
            ON registrations.event_id = events.id
            WHERE events.id='$event_id'";

    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Participant List - NSBM EventHub</title>

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

        <h1>Participant List</h1>

        <p>
            Select an event to view the students registered for it.
        </p>

        <div class="form-container">

            <form method="GET" action="">

                <label>Select Event</label>

                <select name="event_id">

                    <option value="">Select Event</option>

                    <?php while ($event = $eventResult->fetch_assoc()) { ?>

                        <option value="<?php echo $event["id"]; ?>">

                            <?php echo $event["title"]; ?>

                        </option>

                    <?php } ?>

                </select>

                <br><br>

                <input
                    type="submit"
                    value="View Participants"
                >

            </form>

        </div>


        <?php if ($event_id != "") { ?>

            <br>

            <table>

                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Event</th>
                </tr>

                <?php while ($row = $result->fetch_assoc()) { ?>

                    <tr>

                        <td>
                            <?php echo $row["name"]; ?>
                        </td>

                        <td>
                            <?php echo $row["email"]; ?>
                        </td>

                        <td>
                            <?php echo $row["title"]; ?>
                        </td>

                    </tr>

                <?php } ?>

            </table>

        <?php } ?>

    </div>

</div>

</body>

</html>