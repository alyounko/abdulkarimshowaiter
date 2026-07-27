<?php
$pdo = new PDO('sqlite:database.sqlite');
$stmt = $pdo->query("SELECT slug, title FROM content WHERE post_type = 'page'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
