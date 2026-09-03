<?php

session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $category_name = $_POST["category_name"];

    $sql = "INSERT INTO categories (category_name)
            VALUES ('$category_name')";

    if ($conn->query($sql) === TRUE) {
        $message = "Category added successfully";
    } else {
        $message = "Category could not be added";
    }
}

$result = $conn->query("SELECT * FROM categories");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Categories - NSBM EventHub</title>

    <link rel="stylesheet" href="../css/style.css">

    <script>

    function validateForm() {

        if (document.form1.category_name.value.length == 0) {
            window.alert("Please enter a category name");
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

        <h1>Manage Categories</h1>

        <p><?php echo $message; ?></p>

        <div class="form-container">

            <form
                name="form1"
                method="POST"
                action=""
                onsubmit="return validateForm()"
            >

                <label>Category Name</label>

                <input
                    type="text"
                    name="category_name"
                    placeholder="Enter category name"
                >

                <br><br>

                <input
                    type="submit"
                    value="Add Category"
                >

            </form>

        </div>

        <br>

        <table>

            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo $row["id"]; ?>
                    </td>

                    <td>
                        <?php echo $row["category_name"]; ?>
                    </td>

                    <td>

                        <a
                            class="delete-btn"
                            href="delete_category.php?id=<?php echo $row["id"]; ?>"
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