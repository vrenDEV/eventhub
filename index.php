<?php

session_start();
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] == "admin") {
    header("Location: admin/dashboard.php");
    exit();
}

$category = "";

if (isset($_GET["category"])) {
    $category = $_GET["category"];
}

if ($category == "") {

    $sql = "SELECT events.*, categories.category_name
            FROM events
            LEFT JOIN categories
            ON events.category_id = categories.id
            WHERE event_date >= CURDATE()
            ORDER BY event_date ASC";

} else {

    $sql = "SELECT events.*, categories.category_name
            FROM events
            LEFT JOIN categories
            ON events.category_id = categories.id
            WHERE event_date >= CURDATE()
            AND category_id='$category'
            ORDER BY event_date ASC";
}

$result = $conn->query($sql);

$categoryResult = $conn->query("SELECT * FROM categories");

$announcementResult = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");

?>

<!DOCTYPE html>

<html>

<head>

    <title>NSBM EventHub</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="navbar">

    <div class="logo">
        NSBM <span>EventHub</span>
    </div>

    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="#events">Events</a>

        <a href="#announcements">Announcements</a>

        <a href="my_schedule.php">My Schedule</a>

        <a href="logout.php">Logout</a>

    </div>

</div>


<section class="hero">

    <div class="hero-content">

        <h1>
            Discover. Join. Experience.
            <br>
            <span>Campus Events.</span>
        </h1>

        <p>
            NSBM EventHub is your one stop platform to discover upcoming
            university events, connect with students and stay updated.
        </p>

        <a href="#events" class="btn">Browse Events</a>

    </div>

</section>


<section class="features">

    <div class="feature-box">

        <h3>Explore Events</h3>

        <p>
            Discover exciting events happening around the university.
        </p>

    </div>


    <div class="feature-box">

        <h3>Join & Connect</h3>

        <p>
            Register for events and connect with fellow students.
        </p>

    </div>


    <div class="feature-box">

        <h3>Stay Updated</h3>

        <p>
            Get the latest announcements and event updates.
        </p>

    </div>

</section>


<section class="section" id="announcements">

    <div class="section-title">

        <h2>Latest <span class="green-text">Announcements</span></h2>

    </div>

    <?php while ($announcement = $announcementResult->fetch_assoc()) { ?>

        <div class="announcement-box">

            <h3>
                <?php echo $announcement["title"]; ?>
            </h3>

            <p>
                <?php echo $announcement["message"]; ?>
            </p>

            <small>
                <?php echo $announcement["created_at"]; ?>
            </small>

        </div>

    <?php } ?>

</section>


<section class="section" id="events">

    <div class="section-title">

        <h2>Upcoming <span class="green-text">Events</span></h2>

    </div>


    <div class="search-box">

        <form method="GET" action="">

            <label>Search by Category:</label>

            <select name="category">

                <option value="">All Categories</option>

                <?php while ($cat = $categoryResult->fetch_assoc()) { ?>

                    <option value="<?php echo $cat["id"]; ?>">

                        <?php echo $cat["category_name"]; ?>

                    </option>

                <?php } ?>

            </select>

            <br><br>

            <input type="submit" value="Search">

        </form>

    </div>


    <div class="event-grid">

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="event-card">

                <div class="event-content">

                    <span class="category">
                        <?php echo $row["category_name"]; ?>
                    </span>

                    <h3>
                        <?php echo $row["title"]; ?>
                    </h3>

                    <p>
                        <?php echo $row["description"]; ?>
                    </p>

                    <p class="event-info">
                        Date: <?php echo $row["event_date"]; ?>
                    </p>

                    <p class="event-info">
                        Time: <?php echo $row["event_time"]; ?>
                    </p>

                    <p class="event-info">
                        Location: <?php echo $row["location"]; ?>
                    </p>

                    <br>

                    <a
                        class="btn"
                        href="register_event.php?id=<?php echo $row["id"]; ?>"
                    >
                        Register
                    </a>

                </div>

            </div>

        <?php } ?>

    </div>

</section>


<div class="footer">

    © 2026 NSBM EventHub

</div>

</body>

</html>