<?php
$host = 'localhost';
$dbname = 'garanti_takip'; // Veritabanı adın
$username = 'root';        // XAMPP varsayılan kullanıcı adı
$password = '';            // XAMPP'de genelde şifre yoktur

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>