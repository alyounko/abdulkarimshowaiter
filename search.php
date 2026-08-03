<?php
require_once 'includes/db.php';

header('Content-Type: application/json');

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
if (mb_strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

$search = '%' . $query . '%';

$stmt = $pdo->prepare("
    SELECT title, slug, 
           SUBSTRING(content, 1, 500) as content,
           post_type
    FROM content 
    WHERE status = 'publish' 
      AND (title LIKE :q1 OR content LIKE :q2)
    ORDER BY 
        CASE WHEN title LIKE :q3 THEN 0 ELSE 1 END,
        published_date DESC
    LIMIT 15
");
$stmt->execute([':q1' => $search, ':q2' => $search, ':q3' => $search]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = [];
foreach ($results as $row) {
    $text = strip_tags($row['content']);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);

    $excerpt = mb_substr($text, 0, 200);
    if (mb_strlen($text) > 200) $excerpt .= '...';

    $url = 'page.php?slug=' . urlencode($row['slug']);
    if ($row['post_type'] === 'page' && in_array($row['slug'], ['about', 'contact-us', 'privacy-policy'])) {
        $url = 'page.php?slug=' . urlencode($row['slug']);
    }

    $output[] = [
        'title' => $row['title'],
        'url'   => $url,
        'excerpt' => $excerpt,
    ];
}

echo json_encode($output);
