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
    <title>Manage Categories</title>
</head>

<body>

<h1>Manage Categories</h1>

<p><?php echo $message; ?></p>

<form method="POST" action="">

    <label>Category Name:</label><br>
    <input type="text" name="category_name" required>

    <br><br>

    <input type="submit" value="Add Category">

</form>

<br>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Category Name</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
        </tr>

    <?php } ?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</body>

</html>