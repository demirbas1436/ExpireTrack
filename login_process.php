<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "E-posta ve şifre alanları zorunludur.";
        header("Location: login.php");
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['login_error'] = "Geçersiz e-posta veya şifre.";
            header("Location: login.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['login_error'] = "Veritabanı hatası: " . $e->getMessage();
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}