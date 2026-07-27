<?php
$pdo = new PDO('sqlite:database.sqlite');
$art_post_id = $pdo->query("SELECT post_id FROM content WHERE slug='art-works' LIMIT 1")->fetchColumn();

$stmt = $pdo->prepare(
    "SELECT id, attachment_url FROM content
     WHERE post_parent = :pid AND post_type = 'attachment' AND attachment_url != ''
     ORDER BY post_id ASC"
);
$stmt->execute([':pid' => $art_post_id]);
$artworks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$out = "";
foreach ($artworks as $i => $art) {
    $panel = $i + 1;
    $out .= "Panel $panel | ID: {$art['id']} | {$art['attachment_url']}\n";
}
file_put_contents('panels_list.txt', $out);
