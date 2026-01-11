<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$name = "User";
$email = "";

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
    <title>MedVerify</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <h2>MedVerify</h2>

    <p class="note"><b>Welcome:</b> <?php echo $name; ?></p>

    <?php if ($email != "") { ?>
        <p class="note"><b>Email:</b> <?php echo $email; ?></p>
    <?php } ?>

    <a class="btn" href="dashboard.php">Go to Dashboard</a>
    <br><br>
    <a class="btn" href="../Controllers/logout.php">Logout</a>
</div>

</body>
</html>
