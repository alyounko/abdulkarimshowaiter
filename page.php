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
    'books' => 'templates/hubs/books.php',
    'dawawin' => 'templates/hubs/diwans.php',
];
$template = isset($hub_templates[$hub_type]) ? $hub_templates[$hub_type] : 'templates/hubs/standard_page.php';

// Optional extra CSS per template
$extra_css_map = [
    'interviews' => 'css/interviews.min.css',
    'art' => 'css/artworks.min.css?v=50',
    'about' => 'css/about.min.css',
    'contact' => 'css/contact.min.css',
    'privacy' => 'css/privacy.min.css',
    'literature' => 'css/literature.min.css',
    'books' => 'css/books.min.css',
    'dawawin' => 'css/diwans.min.css',
];
$extra_css = isset($extra_css_map[$hub_type]) ? $extra_css_map[$hub_type] : null;
$load_bookshelf = in_array($hub_type, ['books', 'dawawin']);

// Optional page-specific JS (loaded after main.js via footer)
$extra_js_map = [
    'interviews' => '<script src="js/interviews.min.js"></script>',
    'art' => '<script src="js/artworks.min.js"></script>',
    'contact' => '<script src="js/contact.min.js"></script>',
    'privacy' => '<script src="js/privacy.min.js"></script>',
    'literature' => '<script src="js/literature.min.js"></script>',
];
$extra_js = isset($extra_js_map[$hub_type]) ? $extra_js_map[$hub_type] : '';
$view_mode = isset($_GET['view']) ? $_GET['view'] : null;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl" <?php if ($view_mode === 'mobile') echo 'class="view-mobile"'; elseif ($view_mode === 'desktop') echo 'class="view-desktop"'; ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <title><?php echo htmlspecialchars($page_title); ?> - د.عبد الكريم الشويطر</title>
    <meta name="description" content="<?php echo htmlspecialchars($page_title); ?> - موقع الدكتور عبد الكريم الشويطر - طبيب وشاعر وفنان تشكيلي يمني.">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?> - د. عبد الكريم الشويطر">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_title); ?> - موقع الدكتور عبد الكريم الشويطر - طبيب وشاعر وفنان تشكيلي يمني.">
    <meta property="og:image" content="https://abdulkarimshowaiter.me/cropped-untitled-320-x-480-px-640-x-960-px1-1.png">
    <meta property="og:url" content="https://abdulkarimshowaiter.me/page.php?slug=<?php echo urlencode($slug); ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ar_AR">
    <meta property="og:site_name" content="د. عبد الكريم الشويطر">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?> - د. عبد الكريم الشويطر">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_title); ?> - موقع الدكتور عبد الكريم الشويطر.">
    <meta name="twitter:image" content="https://abdulkarimshowaiter.me/cropped-untitled-320-x-480-px-640-x-960-px1-1.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Tajawal:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.min.css?v=50">
    <?php if ($extra_css): ?>
        <link rel="stylesheet" href="<?php echo $extra_css; ?>">
    <?php endif; ?>
    <?php if ($load_bookshelf): ?>
        <link rel="stylesheet" href="css/bookshelf.min.css">
    <?php endif; ?>
</head>

<body>

    <?php include 'templates/navbar.php'; ?>

    <?php include $template; ?>

    <?php include 'templates/footer.php'; ?>

</body>

</html>