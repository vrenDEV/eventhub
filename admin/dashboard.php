<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard - NSBM EventHub</title>

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

        <h1>Admin Dashboard</h1>

        <p>
            Welcome <?php echo $_SESSION["name"]; ?>
        </p>

        <br>

        <div class="dashboard-cards">

            <div class="dashboard-card">

                <h2>Manage Events</h2>

                <p>
                    Create, edit and delete university events.
                </p>

                <a href="events.php" class="btn">
                    Manage Events
                </a>

            </div>


            <div class="dashboard-card">

                <h2>Categories</h2>

                <p>
                    Create and manage event categories.
                </p>

                <a href="categories.php" class="btn">
                    Manage Categories
                </a>

            </div>


            <div class="dashboard-card">

                <h2>Registrations</h2>

                <p>
                    View students registered for events.
                </p>

                <a href="registrations.php" class="btn">
                    View Registrations
                </a>

            </div>


            <div class="dashboard-card">

                <h2>Announcements</h2>

                <p>
                    Create and manage event announcements.
                </p>

                <a href="announcements.php" class="btn">
                    Manage Announcements
                </a>

            </div>


            <div class="dashboard-card">

                <h2>Participant List</h2>

                <p>
                    View participants registered for each event.
                </p>

                <a href="participant_list.php" class="btn">
                    Participant List
                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>