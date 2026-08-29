<?php

include "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$password', 'student')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful";
    } else {
        $message = "Registration failed";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>

<h1>Student Registration</h1>

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

    <input type="submit" value="Register">

</form>

<br>

<a href="login.php">Login</a>

</body>

</html>