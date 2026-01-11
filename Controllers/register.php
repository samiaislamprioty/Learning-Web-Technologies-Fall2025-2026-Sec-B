<?php
session_start();
require_once '../Models/db.php';

// Session message read (sir-style: no ??, no trim)
$err = "";
$success = "";

if (isset($_SESSION["err"])) {
    $err = $_SESSION["err"];
}
if (isset($_SESSION["success"])) {
    $success = $_SESSION["success"];
}

unset($_SESSION["err"]);
unset($_SESSION["success"]);

if (isset($_POST["submit"])) {

    // Direct POST values (no trim, no ??)
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob   = $_POST["dob"];
    $pass  = $_POST["password"];

    // Simple null/empty check like sir
    if ($fname == "" || $lname == "" || $email == "" || $phone == "" || $dob == "" || $pass == "") {
        $_SESSION["err"] = "Please fill all fields.";
        header("Location: register.php");
    } else {

        // Email exists check (sir-style: mysqli_query + mysqli_num_rows)
        $sqlCheck = "SELECT id FROM users WHERE email='$email'";
        $checkRes = mysqli_query($conn, $sqlCheck);

        if ($checkRes && mysqli_num_rows($checkRes) > 0) {
            $_SESSION["err"] = "Email already exists.";
            header("Location: register.php");
        } else {

            // Keep ONLY password_hash as you requested
            $passHash = password_hash($pass, PASSWORD_DEFAULT);

            // Insert (simple query)
            $sqlInsert = "INSERT INTO users (first_name, last_name, email, phone, dob, password_hash)
                          VALUES ('$fname', '$lname', '$email', '$phone', '$dob', '$passHash')";

            $status = mysqli_query($conn, $sqlInsert);

            if ($status) {
                $_SESSION["success"] = "Registration successful. Please login.";
                header("Location: ../Views/login.php");
            } else {
                $_SESSION["err"] = "Registration failed.";
                header("Location: register.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="../assets/style.css">
  <script src="../assets/script.js" defer></script>
</head>
<body>
<div class="container">
  <h2>Create Account</h2>

  <?php if ($err): ?>
    <p class="note" style="color:red;"><?php echo htmlspecialchars($err); ?></p>
  <?php endif; ?>
  <?php if ($success): ?>
    <p class="note" style="color:green;"><?php echo htmlspecialchars($success); ?></p>
  <?php endif; ?>

  <form method="POST" onsubmit="return registerValidate()">
    <input type="text" id="regFname" name="first_name" placeholder="First Name">
    <p class="error-text" id="regFnameError"></p>

    <input type="text" id="regLname" name="last_name" placeholder="Last Name">
    <p class="error-text" id="regLnameError"></p>

    <input type="text" id="regEmail" name="email" placeholder="Email">
    <p class="error-text" id="regEmailError"></p>

    <input type="text" id="regPhone" name="phone" placeholder="Phone Number">
    <p class="error-text" id="regPhoneError"></p>

    <input type="date" id="regDob" name="dob">
    <p class="error-text" id="regDobError"></p>

    <div class="password-wrapper">
      <input type="password" id="regPass" name="password" placeholder="Password" onkeyup="checkStrength(this.value)">
      <span class="eye-icon" onclick="togglePassword('regPass')">👁</span>
    </div>
    <div id="strength"></div>
    <p class="error-text" id="regPassError"></p>

    <button class="btn" type="submit" name="submit" value="1">Register</button>
  </form>

  <div class="small-link">
    Already have an account? <a href="../Views/login.php">Login</a>
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
