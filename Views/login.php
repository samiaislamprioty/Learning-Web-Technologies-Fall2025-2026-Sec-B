<?php
session_start();

// Sir-style: only cookie check for "already logged in"
if (isset($_COOKIE['status'])) {
    header("Location: index.php");
}

// Sir-style session message pattern (no ??)
$err = "";
$success = "";

if (isset($_SESSION["err"])) {
    $err = $_SESSION["err"];
}
if (isset($_SESSION["success"])) {
    $success = $_SESSION["success"];
}

// Sir-style: separate unset
unset($_SESSION["err"]);
unset($_SESSION["success"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="../assets/style.css">
  <script src="../assets/script.js" defer></script>
</head>
<body>
<div class="container">
  <h2>Login</h2>

  <?php if($err != ""){ ?>
    <p class="note" style="color:red;"><?php echo $err; ?></p>
  <?php } ?>

  <?php if($success != ""){ ?>
    <p class="note" style="color:green;"><?php echo $success; ?></p>
  <?php } ?>

  <form action="../Controllers/loginCheck.php" method="post" onsubmit="return loginValidate()">
    <input type="text" id="logEmail" name="email" placeholder="Email">
    <p class="error-text" id="logEmailError"></p>

    <div class="password-wrapper">
      <input type="password" id="logPass" name="password" placeholder="Password">
      <span class="eye-icon" onclick="togglePassword('logPass')">👁</span>
    </div>
    <p class="error-text" id="logPassError"></p>

    <button class="btn" type="submit" name="submit" value="1">Login</button>
  </form>

  <div class="small-link">
    <a href="forgot.php">Forgot password?</a>
  </div>
  <div class="small-link">
    Don’t have an account? <a href="../Controllers/register.php">Register</a>
  </div>
</div>

<!-- popup -->
<div class="popup" id="popup">
  <div class="popup-box">
    <p id="popupText"></p>
    <button onclick="closePopup()">OK</button>
  </div>
</div>
</body>
</html>
