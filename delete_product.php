<?php
require_once "includes/db.php";
require_once "includes/auth.php";

if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET["id"];
$user_id = $_SESSION["user_id"];

// Kullanıcıya ait mi kontrol et
$stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);

header("Location: dashboard.php");
exit;