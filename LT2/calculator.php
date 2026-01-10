<?php
// register.php (POST to same page)

$name = "";
$email = "";
$password = "";
$confirm_password = "";

$errors = [];
$success = false;
$sanitized = [
    "name" => "",
    "email" => ""
];

function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); // sanitize for output
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // raw input (trim for checking)
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    // 1) required fields
    if ($name === "") {
        $errors["name"] = "Name is required.";
    }
    if ($email === "") {
        $errors["email"] = "Email is required.";
    }
    if ($password === "") {
        $errors["password"] = "Password is required.";
    }
    if ($confirm_password === "") {
        $errors["confirm_password"] = "Confirm Password is required.";
    }

    // 2) email format
    if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format.";
    }

    // 3) password match
    if ($password !== "" && $confirm_password !== "" && $password !== $confirm_password) {
        $errors["confirm_password"] = "Passwords do not match.";
    }

    // If no errors → sanitize + success
    if (count($errors) === 0) {
        $sanitized["name"] = clean($name);
        $sanitized["email"] = clean($email);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <style>
        body{font-family:Arial;background:#f4f6f8;}
        .container{width:420px;margin:60px auto;background:#fff;padding:20px;border-radius:8px;}
        h2{text-align:center;}
        label{display:block;margin-top:12px;}
        input{width:100%;padding:10px;margin-top:6px;box-sizing:border-box;}
        .error{color:#b00020;font-size:13px;margin-top:6px;min-height:16px;}
        .success-box{margin-top:15px;padding:12px;border-radius:6px;background:#d4edda;color:#155724;}
        .info-box{margin-top:12px;padding:12px;border-radius:6px;background:#eef2ff;}
        button{width:100%;padding:10px;margin-top:14px;border:none;background:#007bff;color:#fff;cursor:pointer;border-radius:6px;}
    </style>
</head>
<body>

<div class="container">
    <h2>User Registration</h2>

    <?php if ($success): ?>
        <div class="success-box">
            <b>Registration Successful!</b>
        </div>

        <div class="info-box">
            <p><b>Sanitized Name:</b> <?php echo $sanitized["name"]; ?></p>
            <p><b>Sanitized Email:</b> <?php echo $sanitized["email"]; ?></p>
            <p><b>Note:</b> Password is not displayed for security.</p>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <div class="error"><?php echo $errors["name"] ?? ""; ?></div>

        <label>Email</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <div class="error"><?php echo $errors["email"] ?? ""; ?></div>

        <label>Password</label>
        <input type="password" name="password" value="">
        <div class="error"><?php echo $errors["password"] ?? ""; ?></div>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" value="">
        <div class="error"><?php echo $errors["confirm_password"] ?? ""; ?></div>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
