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

    <script>

    function validateForm() {

        if (document.form1.name.value.length == 0) {
            window.alert("Please enter your name");
            return false;
        }

        if (document.form1.email.value.length == 0) {
            window.alert("Please enter your email");
            return false;
        }

        if (document.form1.password.value.length < 6) {
            window.alert("Password should be at least 6 characters");
            return false;
        }

        return true;
    }

    </script>

</head>

<body>

<h1>Student Registration</h1>

<p><?php echo $message; ?></p>

<form name="form1" method="POST" action="" onsubmit="return validateForm()">

    <label>Name:</label><br>
    <input type="text" name="name">

    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email">

    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password">

    <br><br>

    <input type="submit" value="Register">

</form>

<br>

<a href="login.php">Login</a>

</body>

</html>