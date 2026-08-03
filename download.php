<?php
$file = isset($_GET['file']) ? trim($_GET['file']) : '';
$name = isset($_GET['name']) ? trim($_GET['name']) : '';

if (!$file || !preg_match('#^20\d{2}/\d{2}/[^.]+\.pdf$#i', $file) || strpos($file, '..') !== false) {
    http_response_code(400);
    exit;
}

$full_path = __DIR__ . '/' . $file;
if (!file_exists($full_path)) {
    http_response_code(404);
    exit;
}

if (!$name) {
    $name = pathinfo($file, PATHINFO_FILENAME);
    $name = urldecode($name);
}
$name = preg_replace('/[^\w\u0600-\u06FF\s\-\.]/u', '', $name);
if (!preg_match('/\.pdf$/i', $name)) {
    $name .= '.pdf';
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $name . '"');
header('Content-Length: ' . filesize($full_path));
header('Cache-Control: no-cache');
readfile($full_path);
exit;
