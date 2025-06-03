<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Garanti ve Fatura Takip Sistemi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .hero {
            padding: 60px 20px;
            text-align: center;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 80px;
            border-radius: 15px;
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2rem;
            color: #555;
        }
        .btn-group {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="hero">
        <h1>🧾 Garanti ve Fatura Takip Sistemi</h1>
        <p>📦 Aldığın ürünlerin fatura ve garanti süresini unutma! <br>
        Takibini buradan kolayca yapabilirsin.</p>

        <div class="btn-group">
            <a href="login.php" class="btn btn-primary btn-lg">Giriş Yap</a>
            <a href="register.php" class="btn btn-outline-secondary btn-lg">Kayıt Ol</a>
        </div>
    </div>
</div>

</body>
</html>