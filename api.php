<?php
require_once 'includes/db.php';

header('Content-Type: application/json');

$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Fetch posts/pages securely
$stmt = $pdo->prepare("SELECT title, slug, excerpt, content, published_date FROM content WHERE (post_type = 'page' OR post_type = 'post') AND status = 'publish' AND slug NOT IN ('articles', 'about', 'contact-us', 'privacy-policy', 'literature-works', 'poems', 'art-works', 'interviews', 'books', 'dawawin') ORDER BY published_date DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($items as &$item) {
    // Safely generate an excerpt if missing
    if (empty($item['excerpt'])) {
        $text = strip_tags($item['content']);
        $text = preg_replace('/عودة[^\n]*\n?/', '', $text);
        $text = preg_replace('/^\s*\n+/', '', $text);
        $text = trim($text);
        $item['excerpt'] = mb_substr($text, 0, 150) . '...';
    } else {
        $item['excerpt'] = strip_tags($item['excerpt']);
    }
    
    // Formatting date
    if ($item['published_date']) {
        $item['published_date'] = date('Y/m/d', strtotime($item['published_date']));
    }
    
    unset($item['content']); // Don't send full content in API
}

echo json_encode($items);
?>
