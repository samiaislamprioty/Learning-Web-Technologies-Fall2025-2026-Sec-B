<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "med_verify";   // change only if your DB name is different

$conn = mysqli_connect("localhost", "root", "", "med_verify");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
