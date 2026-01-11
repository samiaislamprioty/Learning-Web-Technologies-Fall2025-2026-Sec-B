<?php
session_start();
require_once '../Models/db.php';

$err = "";
$success = "";

if(isset($_SESSION["err"])){
  $err = $_SESSION["err"];
  unset($_SESSION["err"]);
}

if(isset($_SESSION["success"])){
  $success = $_SESSION["success"];
  unset($_SESSION["success"]);
}

if(isset($_POST["submit"])){

  $email = $_REQUEST["email"];
  $pass  = $_REQUEST["password"];

  if($email=="" || $pass==""){
    $_SESSION["err"] = "Please fill all fields.";
    header("Location: forgot.php");
    exit;
  }

  $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $res = $stmt->get_result();
  $user = $res->fetch_assoc();

  if(!$user){
    $_SESSION["err"] = "No account found. Please register first.";
    header("Location: forgot.php");
    exit;
  }

  $up = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
  $up->bind_param("ss", $pass, $email);

  if($up->execute()){
    $_SESSION["success"] = "Password updated. Please login.";
    header("Location: login.php");
    exit;
  }else{
    $_SESSION["err"] = "Failed. Try again.";
    header("Location: forgot.php");
    exit;
  }
}else{
  // just show page
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../assets/style.css">
  <script src="../assets/script.js" defer></script>
</head>
<body>
<div class="container">
  <h2>Forgot Password</h2>

  <?php if ($err): ?>
    <p class="note" style="color:red;"><?php echo htmlspecialchars($err); ?></p>
  <?php endif; ?>
  <?php if ($success): ?>
    <p class="note" style="color:green;"><?php echo htmlspecialchars($success); ?></p>
  <?php endif; ?>

  <form method="POST" onsubmit="return forgotValidate()">
    <input type="text" id="forEmail" name="email" placeholder="Email">
    <p class="error-text" id="forEmailError"></p>

    <div class="password-wrapper">
      <input type="password" id="forPass" name="password" placeholder="New Password">
      <span class="eye-icon" onclick="togglePassword('forPass')">👁</span>
    </div>
    <p class="error-text" id="forPassError"></p>

    <button class="btn" type="submit">Update Password</button>
  </form>

  <div class="small-link">
    Back to <a href="login.php">Login</a>
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
