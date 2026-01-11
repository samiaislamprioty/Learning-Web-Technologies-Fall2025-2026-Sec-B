<?php
session_start();

// Sir-style session check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

// Default values
$name = "";
$email = "";

// Session data
if (isset($_SESSION["user_name"])) {
    $name = $_SESSION["user_name"];
}

if (isset($_SESSION["user_email"])) {
    $email = $_SESSION["user_email"];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <h2>Dashboard</h2>

    <p class="note"><b>Welcome:</b> <?php echo $name; ?></p>
    <p class="note"><b>Email:</b> <?php echo $email; ?></p>

    <a class="btn" href="../Controllers/logout.php">Logout</a>
</div>

</body>
</html>
