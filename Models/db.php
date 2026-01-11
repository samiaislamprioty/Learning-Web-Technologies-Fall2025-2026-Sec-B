<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "med_verify";  

$conn = mysqli_connect("localhost", "root", "", "med_verify");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
