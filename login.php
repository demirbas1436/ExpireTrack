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
    <title>Giriş Yap - Garanti Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card shadow p-4" style="max-width: 400px; width: 100%;">
    <h2 class="mb-3 text-center">🔐 Giriş Yap</h2>

    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
    <?php endif; ?>

    <form action="login_process.php" method="post">
        <div class="mb-3">
            <label class="form-label">E-posta</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Şifre</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
    </form>

    <div class="mt-3 text-center">
        <a href="register.php">Hesabınız yok mu? Kayıt Ol</a>
    </div>
</div>

</body>
</html>