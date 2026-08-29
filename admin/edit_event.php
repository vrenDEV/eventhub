<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../includes/db.php";
$categoryResult = $conn->query("SELECT * FROM categories");

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET["id"])) {
    die("Event ID not found.");
}

$id = $_GET["id"];

$sql = "SELECT * FROM events WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    die("Event not found.");
}

$event = $result->fetch_assoc();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $description = $_POST["description"];
    $category_id = $_POST["category_id"];
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $location = $_POST["location"];
    

    $sql = "UPDATE events SET
            title='$title',
            description='$description',
            category_id='$category_id',
            event_date='$event_date',
            event_time='$event_time',
            location='$location'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Event updated successfully!";

        $sql = "SELECT * FROM events WHERE id='$id'";
        $result = $conn->query($sql);
        $event = $result->fetch_assoc();

    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Event</title>
</head>

<body>

    <h1>Edit Event</h1>

    <p><?php echo $message; ?></p>

    <form method="POST">

        <label>Event Title:</label><br>
        <input
            type="text"
            name="title"
            value="<?php echo $event["title"]; ?>"
            required
        >

        <br><br>

        <label>Description:</label><br>

        <textarea
            name="description"
            required
        ><?php echo $event["description"]; ?></textarea>

        <br><br>

        <label>Category:</label><br>

        <select name="category_id" required>

        <?php while ($category = $categoryResult->fetch_assoc()) { ?>

        <option value="<?php echo $category["id"]; ?>"
            <?php if ($category["id"] == $event["category_id"]) echo "selected"; ?>>

            <?php echo $category["category_name"]; ?>

        </option>

         <?php } ?>

        </select>

        <br><br>

        <label>Event Date:</label><br>

        <input
            type="date"
            name="event_date"
            value="<?php echo $event["event_date"]; ?>"
            required
        >

        <br><br>

        <label>Event Time:</label><br>

        <input
            type="time"
            name="event_time"
            value="<?php echo $event["event_time"]; ?>"
            required
        >

        <br><br>

        <label>Location:</label><br>

        <input
            type="text"
            name="location"
            value="<?php echo $event["location"]; ?>"
            required
        >

        <br><br>

        <button type="submit">Update Event</button>

    </form>

    <br>

    <a href="events.php">Back to Events</a>

</body>

</html>