<?php
include '../config/db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}
$id = $_GET['id'];
$conn->query("UPDATE post SET is_deleted = 1 WHERE post_id = $id");
header("Location: admin-dashboard.php");
