<?php
session_start();
require_once '../Models/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == "" || $password == "") {

        $_SESSION["err"] = "Email and password required.";
        header("Location: ../Views/login.php");

    } else {

        // Sir-style: direct mysqli_query (no prepare, no bind)
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) == 1) {

            $user = mysqli_fetch_assoc($result);

            // REQUIRED because DB uses password_hash
            if (password_verify($password, $user['password_hash'])) {

                setcookie("status", "true", time() + 3000, "/");

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["first_name"] . " " . $user["last_name"];
                $_SESSION["user_email"] = $user["email"];

                header("Location: ../Views/index.php");

            } else {
                $_SESSION["err"] = "Invalid email or password.";
                header("Location: ../Views/login.php");
            }

        } else {
            $_SESSION["err"] = "Invalid email or password.";
            header("Location: ../Views/login.php");
        }
    }

} else {
    header("Location: ../Views/login.php");
}
?>
