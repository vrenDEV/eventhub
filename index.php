<?php

session_start();
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] == "admin") {
    header("Location: admin/dashboard.php");
    exit();
}

$category = "";

if (isset($_GET["category"])) {
    $category = $_GET["category"];
}

if ($category == "") {

    $sql = "SELECT events.*, categories.category_name
            FROM events
            LEFT JOIN categories
            ON events.category_id = categories.id
            WHERE event_date >= CURDATE()
            ORDER BY event_date ASC";

} else {

    $sql = "SELECT events.*, categories.category_name
            FROM events
            LEFT JOIN categories
            ON events.category_id = categories.id
            WHERE event_date >= CURDATE()
            AND category_id='$category'
            ORDER BY event_date ASC";
}

$result = $conn->query($sql);

$categoryResult = $conn->query("SELECT * FROM categories");
$announcementResult = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html>

<head>
    <title>NSBM EventHub</title>
</head>

<body>

<h1>NSBM EventHub</h1>

<h3>Welcome <?php echo $_SESSION["name"]; ?></h3>

<a href="my_schedule.php">My Event Schedule</a>
<a href="logout.php">Logout</a>

<hr>

<h2>Search Events</h2>

<form method="GET" action="">

    <label>Category:</label>

    <select name="category">

        <option value="">All Categories</option>

        <?php while ($cat = $categoryResult->fetch_assoc()) { ?>

            <option value="<?php echo $cat["id"]; ?>">
                <?php echo $cat["category_name"]; ?>
            </option>

        <?php } ?>

    </select>

    <input type="submit" value="Search">

</form>

<br>

<h2>Announcements</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>Title</th>
        <th>Message</th>
        <th>Date</th>
    </tr>

    <?php while ($announcement = $announcementResult->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $announcement["title"]; ?></td>
            <td><?php echo $announcement["message"]; ?></td>
            <td><?php echo $announcement["created_at"]; ?></td>
        </tr>

    <?php } ?>

</table>

<br>

<h2>Upcoming Events</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Description</th>
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
            <td><?php echo $row["description"]; ?></td>
            <td><?php echo $row["event_date"]; ?></td>
            <td><?php echo $row["event_time"]; ?></td>
            <td><?php echo $row["location"]; ?></td>

            <td>
                <a href="register_event.php?id=<?php echo $row["id"]; ?>">Register</a>
            </td>
        </tr>

    <?php } ?>

</table>

</body>

</html>