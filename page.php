<?php
ob_start();
session_start();
/**
 * page.php — Template Dispatcher
 * Resolves the slug, determines the page type, and includes the correct template.
 */
require_once 'includes/db.php';
require_once 'includes/functions.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : null;
$content = $slug ? get_content_by_slug($pdo, $slug) : null;

if (!$content) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1 style='text-align:center;margin-top:80px;font-family:Amiri,serif;'>عذراً، الصفحة غير موجودة (404)</h1>";
    echo "<p style='text-align:center;'><a href='index.php'>العودة للرئيسية</a></p>";
    exit;
}

$menu_pages = get_menu_pages($pdo);
$hub_type = get_hub_type($slug);
$page_title = urldecode($content->title);
$current_slug = $slug;

// Map hubs to their templates
$hub_templates = [
    'poems' => 'templates/hubs/poems.php',
    'literature' => 'templates/hubs/literature.php',
    'interviews' => 'templates/hubs/interviews.php',
    'art' => 'templates/hubs/art_works.php',
    'about' => 'templates/hubs/about.php',
    'contact' => 'templates/hubs/contact.php',
    'privacy' => 'templates/hubs/privacy.php',
];
$template = isset($hub_templates[$hub_type]) ? $hub_templates[$hub_type] : 'templates/hubs/standard_page.php';

// Optional extra CSS per template
$extra_css_map = [
    'interviews' => 'css/interviews.css',
    'art' => 'css/artworks.css',
    'about' => 'css/about.css',
    'contact' => 'css/contact.css',
    'privacy' => 'css/privacy.css',
    'literature' => 'css/literature.css',
];
$extra_css = isset($extra_css_map[$hub_type]) ? $extra_css_map[$hub_type] : null;

// Optional page-specific JS (loaded after main.js via footer)
$extra_js_map = [
    'interviews' => '<script src="js/interviews.js"></script>',
    'art' => '<script src="js/artworks.js"></script>',
    'about' => '<script src="js/about.js"></script>',
    'contact' => '<script src="js/contact.js"></script>',
    'privacy' => '<script src="js/privacy.js"></script>',
    'literature' => '<script src="js/literature.js"></script>',
];
$extra_js = isset($extra_js_map[$hub_type]) ? $extra_js_map[$hub_type] : '';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - د.عبد الكريم الشويطر</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css?v=42">
    <?php if ($extra_css): ?>
        <link rel="stylesheet" href="<?php echo $extra_css; ?>">
    <?php endif; ?>
</head>

<body>

    <?php include 'templates/navbar.php'; ?>

    <?php include $template; ?>

    <?php include 'templates/footer.php'; ?>

</body>

</html>