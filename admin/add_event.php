<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$message = "";

$categoryResult = $conn->query("SELECT * FROM categories");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $description = $_POST["description"];
    $category_id = $_POST["category_id"];
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $location = $_POST["location"];

    $sql = "INSERT INTO events
            (title, description, category_id, event_date, event_time, location)
            VALUES
            ('$title', '$description', '$category_id', '$event_date', '$event_time', '$location')";

    if ($conn->query($sql) === TRUE) {
        $message = "Event added successfully";
    } else {
        $message = "Event could not be added";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Event - NSBM EventHub</title>

    <link rel="stylesheet" href="../css/style.css">

    <script>

    function validateForm() {

        if (document.form1.title.value.length == 0) {
            window.alert("Please enter the event title");
            return false;
        }

        if (document.form1.description.value.length == 0) {
            window.alert("Please enter the event description");
            return false;
        }

        if (document.form1.category_id.selectedIndex == 0) {
            window.alert("Please select a category");
            return false;
        }

        if (document.form1.event_date.value.length == 0) {
            window.alert("Please select the event date");
            return false;
        }

        if (document.form1.event_time.value.length == 0) {
            window.alert("Please select the event time");
            return false;
        }

        if (document.form1.location.value.length == 0) {
            window.alert("Please enter the event location");
            return false;
        }

        return true;
    }

    </script>

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

        <h1>Add New Event</h1>

        <p><?php echo $message; ?></p>


        <div class="form-container">

            <form
                name="form1"
                method="POST"
                action=""
                onsubmit="return validateForm()"
            >

                <label>Event Title</label>

                <input
                    type="text"
                    name="title"
                    placeholder="Enter event title"
                >


                <br><br>


                <label>Description</label>

                <textarea
                    name="description"
                    placeholder="Enter event description"
                ></textarea>


                <br><br>


                <label>Category</label>

                <select name="category_id">

                    <option value="">Select Category</option>

                    <?php while ($category = $categoryResult->fetch_assoc()) { ?>

                        <option value="<?php echo $category["id"]; ?>">

                            <?php echo $category["category_name"]; ?>

                        </option>

                    <?php } ?>

                </select>


                <br><br>


                <label>Event Date</label>

                <input
                    type="date"
                    name="event_date"
                >


                <br><br>


                <label>Event Time</label>

                <input
                    type="time"
                    name="event_time"
                >


                <br><br>


                <label>Location</label>

                <input
                    type="text"
                    name="location"
                    placeholder="Enter event location"
                >


                <br><br>


                <input
                    type="submit"
                    value="Add Event"
                >

            </form>

        </div>


        <a href="events.php" class="btn">
            Back to Events
        </a>

    </div>

</div>

</body>

</html>