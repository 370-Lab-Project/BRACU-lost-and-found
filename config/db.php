<?php
$host = "localhost";
$user = "root";
$password = ""; 
$database = "bracu_lost_found";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
?>
