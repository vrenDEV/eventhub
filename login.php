<?php

session_start();
include "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = $user["role"];

            if ($user["role"] == "admin") {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }

            exit();

        } else {
            $message = "Incorrect password";
        }

    } else {
        $message = "User not found";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>

<h1>Login</h1>

<p><?php echo $message; ?></p>

<form method="POST" action="">

    <label>Email:</label><br>
    <input type="email" name="email" required>

    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required>

    <br><br>

    <input type="submit" value="Login">

</form>

<br>

<a href="register.php">Create Account</a>

</body>

</html>