<?php
// contact.php

// ---------- Helper: sanitize ----------
function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); // safe output
    return $data;
}

$name = "";
$email = "";
$subject = "";
$message = "";

$errors = [];
$success = false;

$sentData = [
    "name" => "",
    "email" => "",
    "subject" => "",
    "message" => "",
    "attachment" => "No file uploaded"
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get inputs
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    // ---------- Validation ----------
    // Required: name
    if ($name === "") {
        $errors["name"] = "Name is required.";
    }

    // Required: email + format
    if ($email === "") {
        $errors["email"] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format.";
    }

    // Subject dropdown required (General/Support/Feedback)
    $allowedSubjects = ["General", "Support", "Feedback"];
    if ($subject === "") {
        $errors["subject"] = "Subject is required.";
    } elseif (!in_array($subject, $allowedSubjects)) {
        $errors["subject"] = "Invalid subject selected.";
    }

    // Message min 10 chars
    if ($message === "") {
        $errors["message"] = "Message is required.";
    } elseif (strlen($message) < 10) {
        $errors["message"] = "Message must be at least 10 characters.";
    }

    // ---------- Attachment Validation (optional) ----------
    // Allowed types + max size
    $allowedTypes = ["image/jpeg", "image/png", "application/pdf"];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (isset($_FILES["attachment"]) && $_FILES["attachment"]["name"] !== "") {

        if ($_FILES["attachment"]["error"] !== 0) {
            $errors["attachment"] = "File upload error.";
        } else {
            $fileType = $_FILES["attachment"]["type"];
            $fileSize = $_FILES["attachment"]["size"];

            if (!in_array($fileType, $allowedTypes)) {
                $errors["attachment"] = "Invalid file type. Allowed: JPG, PNG, PDF.";
            } elseif ($fileSize > $maxSize) {
                $errors["attachment"] = "File too large. Max 2MB allowed.";
            }
        }
    }

    // ---------- If Valid ----------
    if (count($errors) === 0) {

        // Sanitize all inputs
        $sentData["name"] = clean($name);
        $sentData["email"] = clean($email);
        $sentData["subject"] = clean($subject);
        $sentData["message"] = clean($message);

        // Handle attachment display (optional)
        if (isset($_FILES["attachment"]) && $_FILES["attachment"]["name"] !== "") {
            $sentData["attachment"] = clean($_FILES["attachment"]["name"]);
        }

        // Simulate email sending success
        $success = true;

        // Clear form (requirement: clear form or redirect)
        $name = "";
        $email = "";
        $subject = "";
        $message = "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <style>
        body{font-family:Arial;background:#f4f6f8;}
        .container{width:520px;margin:50px auto;background:#fff;padding:20px;border-radius:8px;}
        h2{text-align:center;}
        label{display:block;margin-top:12px;}
        input, select, textarea{width:100%;padding:10px;margin-top:6px;box-sizing:border-box;}
        .error{color:#b00020;font-size:13px;margin-top:6px;min-height:16px;}
        .successBox{margin-top:15px;padding:12px;border-radius:6px;background:#d4edda;color:#155724;}
        .dataBox{margin-top:12px;padding:12px;border-radius:6px;background:#eef2ff;}
        button{width:100%;padding:10px;margin-top:14px;border:none;background:#007bff;color:#fff;cursor:pointer;border-radius:6px;}
    </style>
</head>
<body>

<div class="container">
    <h2>Contact Us</h2>

    <?php if ($success): ?>
        <div class="successBox">
            <b>Email sent successfully!</b>
        </div>

        <div class="dataBox">
            <p><b>Name:</b> <?php echo $sentData["name"]; ?></p>
            <p><b>Email:</b> <?php echo $sentData["email"]; ?></p>
            <p><b>Subject:</b> <?php echo $sentData["subject"]; ?></p>
            <p><b>Message:</b> <?php echo nl2br($sentData["message"]); ?></p>
            <p><b>Attachment:</b> <?php echo $sentData["attachment"]; ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">

        <label>Name *</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <div class="error"><?php echo $errors["name"] ?? ""; ?></div>

        <label>Email *</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <div class="error"><?php echo $errors["email"] ?? ""; ?></div>

        <label>Subject *</label>
        <select name="subject">
            <option value="">-- Select --</option>
            <option value="General"  <?php if($subject==="General")  echo "selected"; ?>>General</option>
            <option value="Support"  <?php if($subject==="Support")  echo "selected"; ?>>Support</option>
            <option value="Feedback" <?php if($subject==="Feedback") echo "selected"; ?>>Feedback</option>
        </select>
        <div class="error"><?php echo $errors["subject"] ?? ""; ?></div>

        <label>Message * (min 10 characters)</label>
        <textarea name="message" rows="5"><?php echo htmlspecialchars($message); ?></textarea>
        <div class="error"><?php echo $errors["message"] ?? ""; ?></div>

        <label>Attachment (optional) - JPG/PNG/PDF (Max 2MB)</label>
        <input type="file" name="attachment">
        <div class="error"><?php echo $errors["attachment"] ?? ""; ?></div>

        <button type="submit">Send</button>
    </form>
</div>

</body>
</html>
