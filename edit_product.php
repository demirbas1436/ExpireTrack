<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$product_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ürün bilgilerini al
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$product_id, $user_id]);
$product = $stmt->fetch();

if (!$product) {
    $_SESSION['error'] = "Ürün bulunamadı.";
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name   = trim($_POST['product_name']);
    $brand          = trim($_POST['brand']);
    $purchase_date  = $_POST['purchase_date'];
    $warranty_month = intval($_POST['warranty_period']);
    $invoice_number = trim($_POST['invoice_number']);
    $notes          = trim($_POST['notes']);

    // Dosya yükleme
    $invoice_file_path = $product['invoice_file']; // Varsayılan: önceki dosya
    if (isset($_FILES['invoice_file']) && $_FILES['invoice_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName  = basename($_FILES['invoice_file']['name']);
        $filePath  = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($_FILES['invoice_file']['tmp_name'], $filePath)) {
            $invoice_file_path = $filePath;

            // Eski dosyayı sil (isteğe bağlı)
            if (!empty($product['invoice_file']) && file_exists($product['invoice_file'])) {
                unlink($product['invoice_file']);
            }
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE products SET 
            product_name = ?, 
            brand = ?, 
            purchase_date = ?, 
            warranty_period = ?, 
            invoice_number = ?, 
            notes = ?, 
            invoice_file = ?
            WHERE id = ? AND user_id = ?");

        $stmt->execute([
            $product_name,
            $brand,
            $purchase_date,
            $warranty_month,
            $invoice_number,
            $notes,
            $invoice_file_path,
            $product_id,
            $user_id
        ]);

        $_SESSION['success'] = "Ürün başarıyla güncellendi.";
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        $error = "Hata: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Düzenle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
        <h3 class="mb-4 text-center">🛠️ Ürünü Düzenle</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="edit_product.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Ürün Adı</label>
                <input type="text" class="form-control" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Marka</label>
                <input type="text" class="form-control" name="brand" value="<?php echo htmlspecialchars($product['brand']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Fatura Tarihi</label>
                <input type="date" class="form-control" name="purchase_date" value="<?php echo $product['purchase_date']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Garanti Süresi (Ay)</label>
                <input type="number" class="form-control" name="warranty_period" value="<?php echo $product['warranty_period']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Fatura No</label>
                <input type="text" class="form-control" name="invoice_number" value="<?php echo htmlspecialchars($product['invoice_number']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Not</label>
                <textarea class="form-control" name="notes" rows="3"><?php echo htmlspecialchars($product['notes']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Yeni Fatura Dosyası (varsa)</label>
                <input type="file" class="form-control" name="invoice_file" accept=".pdf,.jpg,.jpeg,.png">
                <?php if (!empty($product['invoice_file'])): ?>
                    <div class="mt-2">
                        <a href="<?php echo $product['invoice_file']; ?>" target="_blank" class="btn btn-outline-secondary btn-sm">Mevcut Dosyayı Gör</a>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Güncelle</button>
        </form>

        <div class="mt-3 text-center">
            <a href="dashboard.php" class="btn btn-sm btn-secondary">← Geri Dön</a>
        </div>
    </div>
</div>
</body>
</html>