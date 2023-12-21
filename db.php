<?php
$servername = "b9gp9hhvp1doyw8dhare-mysql.services.clever-cloud.com";
$username = "u8ls8buzz3rg3han";
$password = "TvKNrpiH5QZdRBykr9ce";
$dbname = "b9gp9hhvp1doyw8dhare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
