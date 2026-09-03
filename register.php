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

    <title>Register - NSBM EventHub</title>

    <link rel="stylesheet" href="css/style.css">

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

<body class="auth-page">

<div class="auth-navbar">

    <div class="logo">
        NSBM <span>EventHub</span>
    </div>

</div>

<div class="auth-wrapper">

    <div class="auth-card">

        <h1>Create Account</h1>

        <p class="subtitle">
            Register for your NSBM EventHub account
        </p>

        <p><?php echo $message; ?></p>

        <form
            name="form1"
            method="POST"
            action=""
            onsubmit="return validateForm()"
        >

            <label>Name</label>

            <input
                type="text"
                name="name"
                placeholder="Enter your name"
            >

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
            >

            <input
                type="submit"
                value="Register"
            >

        </form>

        <div class="auth-bottom">

            Already have an account?

            <a href="login.php">
                Login here
            </a>

        </div>

    </div>

</div>

</body>

</html>