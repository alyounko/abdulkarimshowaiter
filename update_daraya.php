<?php
$pdo = new PDO('sqlite:C:/wamp64/www/abdulkarimshowaiter/database.sqlite');
$content = file_get_contents(__DIR__ . '/daraya_content.html');
$u = $pdo->prepare("UPDATE content SET content = ? WHERE slug = ?");
$u->execute([$content, '%d8%af%d8%b1%d8%a7%d8%b3%d8%a9_%d9%86%d9%82%d8%af%d9%8a%d8%a9']);
echo "تم التحديث!";
