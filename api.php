<?php
require_once 'includes/db.php';

header('Content-Type: application/json');
header('Cache-Control: public, max-age=300');

$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT title, slug, excerpt, SUBSTRING(content, 1, 300) as content, published_date FROM content WHERE (post_type = 'page' OR post_type = 'post') AND status = 'publish' AND slug NOT IN ('articles', 'about', 'contact-us', 'privacy-policy', 'literature-works', 'poems', 'art-works', 'interviews', 'books', 'dawawin') ORDER BY published_date DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($items as &$item) {
    if (empty($item['excerpt'])) {
        $text = strip_tags($item['content']);
        $text = preg_replace('/عودة[^\n]*\n?/', '', $text);
        $text = preg_replace('/^\s*\n+/', '', $text);
        $text = trim($text);
        $item['excerpt'] = mb_substr($text, 0, 150) . '...';
    } else {
        $item['excerpt'] = strip_tags($item['excerpt']);
    }
    
    if ($item['published_date']) {
        $item['published_date'] = date('Y/m/d', strtotime($item['published_date']));
    }
    
    unset($item['content']);
}

echo json_encode($items);
?>
