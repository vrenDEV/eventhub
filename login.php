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

    <title>Login - NSBM EventHub</title>

    <link rel="stylesheet" href="css/style.css">

    <script>

    function validateForm() {

        if (document.form1.email.value.length == 0) {
            window.alert("Please enter your email");
            return false;
        }

        if (document.form1.password.value.length == 0) {
            window.alert("Please enter your password");
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

        <h1>Welcome Back!</h1>

        <p class="subtitle">
            Login to your NSBM EventHub account
        </p>

        <p><?php echo $message; ?></p>

        <form
            name="form1"
            method="POST"
            action=""
            onsubmit="return validateForm()"
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
                value="Login"
            >

        </form>


        <div class="auth-bottom">

            Don't have an account?

            <a href="register.php">
                Register here
            </a>

        </div>

    </div>

</div>

</body>

</html>