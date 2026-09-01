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
    <title>Admin Dashboard</title>
</head>

<body>

<h1>Admin Dashboard</h1>

<h3>Welcome <?php echo $_SESSION["name"]; ?></h3>

<ul>

    <li><a href="events.php">Manage Events</a></li>

    <li><a href="categories.php">Manage Categories</a></li>

    <li><a href="registrations.php">View Registrations</a></li>

    <li><a href="announcements.php">Manage Announcements</a></li>

    <li><a href="participant_list.php">Participant List</a></li>

</ul>

<a href="../logout.php">Logout</a>

</body>

</html>