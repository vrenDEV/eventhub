<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $announcement = $_POST["message"];

    $sql = "INSERT INTO announcements (title, message)
            VALUES ('$title', '$announcement')";

    if ($conn->query($sql) === TRUE) {
        $message = "Announcement added successfully";
    } else {
        $message = "Announcement could not be added";
    }
}

$result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Announcements - NSBM EventHub</title>

    <link rel="stylesheet" href="../css/style.css">

    <script>

    function validateForm() {

        if (document.form1.title.value.length == 0) {
            window.alert("Please enter the announcement title");
            return false;
        }

        if (document.form1.message.value.length == 0) {
            window.alert("Please enter the announcement message");
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

        <h1>Manage Announcements</h1>

        <p>
            Create and manage announcements for students.
        </p>

        <p><?php echo $message; ?></p>


        <div class="form-container">

            <form
                name="form1"
                method="POST"
                action=""
                onsubmit="return validateForm()"
            >

                <label>Announcement Title</label>

                <input
                    type="text"
                    name="title"
                    placeholder="Enter announcement title"
                >

                <br><br>

                <label>Message</label>

                <textarea
                    name="message"
                    placeholder="Enter announcement message"
                ></textarea>

                <br><br>

                <input
                    type="submit"
                    value="Add Announcement"
                >

            </form>

        </div>


        <br>

        <table>

            <tr>

                <th>ID</th>
                <th>Title</th>
                <th>Message</th>
                <th>Date</th>
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
                        <?php echo $row["message"]; ?>
                    </td>

                    <td>
                        <?php echo $row["created_at"]; ?>
                    </td>

                    <td>

                        <a
                            class="edit-btn"
                            href="edit_announcement.php?id=<?php echo $row["id"]; ?>"
                        >
                            Edit
                        </a>

                        <a
                            class="delete-btn"
                            href="delete_announcement.php?id=<?php echo $row["id"]; ?>"
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