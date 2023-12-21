<?php
$host = 'b9gp9hhvp1doyw8dhare-mysql.services.clever-cloud.com"';
$user = 'u8ls8buzz3rg3han';
$password = 'TvKNrpiH5QZdRBykr9ce';
$database = 'b9gp9hhvp1doyw8dhare';

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$result = $connection->query("SELECT * FROM students");

$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
$connection->close();
header('Content-Type: application/json');
echo json_encode($students);
?>
