<?php
include '../config/db.php';

if($_SESSION['role'] !== 'admin') die("Access denied");

$id = $_GET['id'];
$conn->query("DELETE FROM post WHERE post_id=$id");

header("Location: admin-dashboard.php");
