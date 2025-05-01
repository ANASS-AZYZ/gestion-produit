<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: produits.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
$stmt->execute([$id]);

header("Location: produits.php");
exit;
?>
