<?php
include "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$hashedPassword', 'student')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>EventHub Register</title>
</head>

<body>

    <h2>Student Registration</h2>

    <p><?php echo $message; ?></p>

    <form method="POST" action="">

        <label>Name:</label><br>
        <input type="text" name="name" required>
        <br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required>
        <br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit">Register</button>

    </form>

</body>
</html>