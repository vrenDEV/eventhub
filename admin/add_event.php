<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$categoryResult = $conn->query("SELECT * FROM categories");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $description = $_POST["description"];
    $category_id = $_POST["category_id"];
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $location = $_POST["location"];

    $sql = "INSERT INTO events
            (title, description, event_date, event_time, location, category_id)
            VALUES
            ('$title', '$description', '$event_date', '$event_time', '$location', '$category_id')";

    if ($conn->query($sql) === TRUE) {
        $message = "Event added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Event</title>
</head>

<body>

    <h1>Add New Event</h1>

    <p><?php echo $message; ?></p>

    <form method="POST">

        <label>Event Title:</label><br>
        <input type="text" name="title" required>

        <br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea>

        <br><br>

        <label>Category:</label><br>

        <select name="category_id" required>

            <option value="">Select Category</option>

            <?php while ($category = $categoryResult->fetch_assoc()) { ?>

                <option value="<?php echo $category["id"]; ?>">
                    <?php echo $category["category_name"]; ?>
                </option>

            <?php } ?>

        </select>

        <br><br>

        <label>Event Date:</label><br>
        <input type="date" name="event_date" required>

        <br><br>

        <label>Event Time:</label><br>
        <input type="time" name="event_time" required>

        <br><br>

        <label>Location:</label><br>
        <input type="text" name="location" required>

        <br><br>

        <button type="submit">Add Event</button>

    </form>

    <br>

    <a href="events.php">Back to Events</a>

</body>

</html>