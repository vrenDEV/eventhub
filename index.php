<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$category = "";

if (isset($_GET["category"])) {
    $category = $_GET["category"];
}

if ($category != "") {

    $sql = "SELECT events.*, categories.category_name
            FROM events
            LEFT JOIN categories
            ON events.category_id = categories.id
            WHERE event_date >= CURDATE()
            AND categories.id = '$category'
            ORDER BY event_date ASC";

} else {

    $sql = "SELECT events.*, categories.category_name
            FROM events
            LEFT JOIN categories
            ON events.category_id = categories.id
            WHERE event_date >= CURDATE()
            ORDER BY event_date ASC";
}

$result = $conn->query($sql);

$categoryResult = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>

<head>
    <title>NSBM EventHub</title>
</head>

<body>

    <h1>NSBM EventHub</h1>

    <h3>Welcome, <?php echo $_SESSION["name"]; ?></h3>

    <a href="logout.php">Logout</a>

    <hr>

    <h2>Search Events</h2>

    <form method="GET">

        <label>Search by Category:</label>

        <select name="category">

            <option value="">All Categories</option>

            <?php while ($cat = $categoryResult->fetch_assoc()) { ?>

                <option value="<?php echo $cat["id"]; ?>"
                    <?php if ($category == $cat["id"]) echo "selected"; ?>>

                    <?php echo $cat["category_name"]; ?>

                </option>

            <?php } ?>

        </select>

        <button type="submit">Search</button>

    </form>

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
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
            <td><?php echo $row["description"]; ?></td>
            <td><?php echo $row["event_date"]; ?></td>
            <td><?php echo $row["event_time"]; ?></td>
            <td><?php echo $row["location"]; ?></td>
        </tr>

        <?php } ?>

    </table>

</body>

</html>