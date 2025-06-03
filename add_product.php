<?php
session_start();
require_once 'includes/db.php';

// Giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id        = $_SESSION['user_id'];
    $product_name   = trim($_POST['product_name']);
    $brand          = trim($_POST['brand']);
    $purchase_date  = $_POST['purchase_date'];
    $warranty_month = intval($_POST['warranty_period']);
    $invoice_number = trim($_POST['invoice_number']);
    $notes          = trim($_POST['notes']);

    // Dosya yükleme işlemi
    $invoice_file_path = null;
    if (isset($_FILES['invoice_file']) && $_FILES['invoice_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName  = basename($_FILES['invoice_file']['name']);
        $filePath  = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($_FILES['invoice_file']['tmp_name'], $filePath)) {
            $invoice_file_path = $filePath;
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO products 
            (user_id, product_name, brand, purchase_date, warranty_period, invoice_number, notes, invoice_file) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $user_id,
            $product_name,
            $brand,
            $purchase_date,
            $warranty_month,
            $invoice_number,
            $notes,
            $invoice_file_path
        ]);

        $_SESSION['success'] = "Ürün başarıyla eklendi!";
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        $message = "Hata: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Ürün Ekle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
        <h3 class="mb-4 text-center">➕ Yeni Ürün Ekle</h3>

        <?php if (!empty($message)): ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Ürün Adı</label>
                <input type="text" class="form-control" name="product_name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Marka</label>
                <input type="text" class="form-control" name="brand">
            </div>

            <div class="mb-3">
                <label class="form-label">Fatura Tarihi</label>
                <input type="date" class="form-control" name="purchase_date">
            </div>

            <div class="mb-3">
                <label class="form-label">Garanti Süresi (Ay)</label>
                <input type="number" class="form-control" name="warranty_period">
            </div>

            <div class="mb-3">
                <label class="form-label">Fatura No</label>
                <input type="text" class="form-control" name="invoice_number">
            </div>

            <div class="mb-3">
                <label class="form-label">Not</label>
                <textarea class="form-control" name="notes" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Fatura Dosyası (PDF, JPG, PNG)</label>
                <input type="file" class="form-control" name="invoice_file" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <button type="submit" class="btn btn-primary w-100">Kaydet</button>
        </form>

        <div class="mt-3 text-center">
            <a href="dashboard.php" class="btn btn-sm btn-secondary">← Geri Dön</a>
        </div>
    </div>
</div>
</body>
</html>