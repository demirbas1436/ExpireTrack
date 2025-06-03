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
    <title>Kayıt Ol - Garanti Takip</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card shadow p-4" style="width: 100%; max-width: 400px;">
    <h2 class="mb-3 text-center">📝 Kayıt Ol</h2>

    <?php
    if (isset($_SESSION["register_error"])) {
        echo '<div class="alert alert-danger">'.$_SESSION["register_error"].'</div>';
        unset($_SESSION["register_error"]);
    }
    ?>

    <form action="register_process.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Ad Soyad</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-Posta</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Şifre</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Şifre Tekrar</label>
            <input type="password" class="form-control" name="confirm_password" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Kayıt Ol</button>
    </form>

    <div class="mt-3 text-center">
        <a href="login.php">Zaten hesabınız var mı? Giriş Yap</a>
    </div>
</div>

</body>
</html>