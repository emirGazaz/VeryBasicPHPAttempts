<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "world_data";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
