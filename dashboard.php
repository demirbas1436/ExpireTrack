<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Kullanıcı bilgilerini al
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';

// Ürünleri getir
$stmt = $conn->prepare("SELECT * FROM products WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>📁 Garanti Takip - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <<style>
    .expired {
        background-color: #f8d7da !important;
        color: #842029 !important;
    }
    .active {
        background-color: #d1e7dd !important;
        color: #0f5132 !important;
    }
</style>

</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📁 Garanti Takip</h2>
        <div>
            <span class="me-2">Merhaba, <strong><?= htmlspecialchars($user_name) ?></strong> 👋</span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Çıkış</a>
        </div>
    </div>

    <a href="add_product.php" class="btn btn-success mb-3">➕ Ürün Ekle</a>

    <?php if (empty($products)) : ?>
        <div class="alert alert-info">Henüz kayıtlı ürününüz yok. İlk ürününüzü ekleyin!</div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Ürün Adı</th>
                        <th>Marka</th>
                        <th>Satın Alma Tarihi</th>
                        <th>Garanti Bitiş</th>
                        <th>Fatura No</th>
                        <th>Not</th>
                        <th>Dosya</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) :
                        $purchaseDate = new DateTime($product['purchase_date']);
                        $warrantyMonths = (int) $product['warranty_period'];
                        $warrantyEnd = clone $purchaseDate;
                        $warrantyEnd->modify("+$warrantyMonths months");
                        $now = new DateTime();

                        $isExpired = $warrantyEnd < $now;
                        $rowClass = $isExpired ? 'expired' : 'active';
                    ?>
                        <tr>
                            <td class="<?= $rowClass ?>"><?= htmlspecialchars($product['product_name']) ?></td>
                            <td class="<?= $rowClass ?>"><?= htmlspecialchars($product['brand']) ?></td>
                            <td class="<?= $rowClass ?>"><?= $purchaseDate->format('d.m.Y') ?></td>
                            <td class="<?= $rowClass ?>">
                                <?= $warrantyEnd->format('d.m.Y') ?>
                                <?php if ($isExpired): ?>
                                    <span class="badge bg-danger ms-1">Süre Doldu 🔴</span>
                                <?php else: ?>
                                    <span class="badge bg-success ms-1">Geçerli 🟢</span>
                                <?php endif; ?>
                            </td>
                            <td class="<?= $rowClass ?>"><?= htmlspecialchars($product['invoice_number']) ?></td>
                            <td class="<?= $rowClass ?>"><?= nl2br(htmlspecialchars($product['notes'])) ?></td>
                            <td class="<?= $rowClass ?>">
                                <?php if (!empty($product['invoice_file'])): ?>
                                    <a href="view_file.php?file=<?= urlencode($product['invoice_file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Görüntüle</a>
                                <?php else: ?>
                                    <span class="text-muted">Yok</span>
                                <?php endif; ?>
                            </td>
                            <td class="<?= $rowClass ?>">
                                <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                                <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>