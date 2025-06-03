<?php
session_start();
require_once 'includes/db.php'; // $pdo bağlantısı burada tanımlı olmalı

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $name             = trim($_POST['name']);
    $email            = trim($_POST['email']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Temel kontroller
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['register_error'] = "Lütfen tüm alanları doldurunuz.";
        header("Location: register.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Geçerli bir e-posta adresi giriniz.";
        header("Location: register.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Şifreler eşleşmiyor.";
        header("Location: register.php");
        exit;
    }

    try {
        // E-posta daha önce kayıtlı mı?
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['register_error'] = "Bu e-posta adresi zaten kayıtlı!";
            header("Location: register.php");
            exit;
        }

        // Parolayı hashle
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Kullanıcıyı kaydet
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);

        $_SESSION['success'] = "Kayıt başarılı! Giriş yapabilirsiniz.";
        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['register_error'] = "Veritabanı hatası: " . $e->getMessage();
        header("Location: register.php");
        exit;
    }

} else {
    header("Location: register.php");
    exit;
}