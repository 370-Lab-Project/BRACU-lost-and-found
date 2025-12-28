<?php
include '../config/db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}
$id = $_GET['id'];
$conn->query("UPDATE users SET is_banned = 0 WHERE user_id = $id");
header("Location: admin-dashboard.php");
