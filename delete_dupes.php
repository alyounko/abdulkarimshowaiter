<?php
$pdo = new PDO('sqlite:database.sqlite');
$pdo->exec("DELETE FROM content WHERE id IN (48, 185)");
echo "Deleted duplicate panels 26 and 67.\n";
