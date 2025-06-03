<?php
$filename = $_GET['file'] ?? '';
$path = __DIR__ . '/uploads/' . basename($filename);

if (!file_exists($path)) {
    http_response_code(404);
    echo "Dosya bulunamadı.";
    exit;
}

$mime = mime_content_type($path);
header('Content-Type: ' . $mime);
header('Content-Disposition: inline; filename="' . basename($path) . '"');
readfile($path);
exit;