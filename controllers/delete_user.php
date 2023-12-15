<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'database.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
$stmt->execute([$id]);
header("Location: admin_dashboard.php");
exit;
