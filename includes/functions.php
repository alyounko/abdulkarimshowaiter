<?php
// includes/functions.php

function get_all_content($pdo, $post_type = 'page', $limit = 50)
{
    $stmt = $pdo->prepare("SELECT * FROM content WHERE post_type = :type AND status = 'publish' ORDER BY published_date DESC LIMIT :limit");
    $stmt->bindValue(':type', $post_type, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_content_by_slug($pdo, $slug)
{
    $stmt = $pdo->prepare("SELECT * FROM content WHERE slug = :slug LIMIT 1");
    $stmt->execute(['slug' => $slug]);
    return $stmt->fetch();
}

function get_content_by_id($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM content WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function format_arabic_date($date_string)
{
    if (!$date_string)
        return '';
    return date('Y/m/d', strtotime($date_string));
}

// -----------------------------------------------------------------------
// Main navigation — ONLY the top-level items from the original WordPress
// navigation block (post_id 152). Letter pages are intentionally excluded.
// -----------------------------------------------------------------------
function get_menu_pages($pdo)
{
    static $cache = null;
    if ($cache !== null) return $cache;

    $main_slugs = [
        'about',            // نبذة عن المؤلف
        'literature-works', // الأعمال الأدبية
        'art-works',        // الأعمال الفنية
        'interviews',       // مقابلات مرئية
        'contact-us',       // تواصل معنا
        'privacy-policy',   // سياسة الخصوصية
    ];

    $placeholders = implode(',', array_fill(0, count($main_slugs), '?'));
    $stmt = $pdo->prepare(
        "SELECT title, slug FROM content
         WHERE slug IN ($placeholders) AND post_type='page' AND status='publish'"
    );
    $stmt->execute($main_slugs);
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Re-sort to match original menu order
    $indexed = [];
    foreach ($rows as $row) {
        $indexed[$row->slug] = $row;
    }
    $sorted = [];
    foreach ($main_slugs as $s) {
        if (isset($indexed[$s]))
            $sorted[] = $indexed[$s];
    }
    $cache = $sorted;
    return $sorted;
}

// Generate <picture> element with WebP source and original fallback
function picture($src, $alt = '', $class = '', $attrs = '') {
    $webp = preg_replace('/\.(png|jpe?g)$/i', '.webp', $src);
    $ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
    $mime = $ext === 'jpg' || $ext === 'jpeg' ? 'image/jpeg' : 'image/' . $ext;
    $classAttr = $class ? ' class="' . htmlspecialchars($class) . '"' : '';
    return '<picture>'
        . '<source srcset="' . htmlspecialchars($webp) . '" type="image/webp">'
        . '<source srcset="' . htmlspecialchars($src) . '" type="' . $mime . '">'
        . '<img src="' . htmlspecialchars($src) . '" alt="' . htmlspecialchars($alt) . '"' . $classAttr . ' ' . $attrs . '>'
        . '</picture>';
}
function fix_content_images($html)
{
    $html = preg_replace(
        '#https?://(?:abdulkarimshowaiter\.wordpress\.com|i0\.wp\.com|i1\.wp\.com|i2\.wp\.com)/wp-content/uploads/(\d{4}/\d{2}/[^"\s?]+)(?:\?[^"\s]*)?#',
        '$1',
        $html
    );
    $html = preg_replace(
        '/<img(?![^>]*\sloading=)/i',
        '<img loading="lazy"',
        $html
    );
    return $html;
}

// Convert <img> src to <picture> with WebP source and fallback
function fix_images_to_picture($html)
{
    return preg_replace_callback(
        '/<img\s+([^>]*?)src=["\']([^"\']+)["\']([^>]*?)>/i',
        function ($m) {
            $before = $m[1];
            $src = $m[2];
            $after = $m[3];
            
            // Skip if already inside a <picture> or has srcset
            if (stripos($before . $after, 'srcset') !== false) return $m[0];
            
            // Skip YouTube thumbnails (external)
            if (strpos($src, 'img.youtube.com') !== false) return $m[0];
            
            // Skip data: URIs
            if (strpos($src, 'data:') === 0) return $m[0];
            
            $webp = preg_replace('/\.(png|jpe?g)$/i', '.webp', $src);
            $ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
            $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : 'image/' . $ext;
            
            return '<picture>'
                . '<source srcset="' . htmlspecialchars($webp) . '" type="image/webp">'
                . '<source srcset="' . htmlspecialchars($src) . '" type="' . $mime . '">'
                . '<img ' . $before . 'src="' . htmlspecialchars($src) . '"' . $after . '>';
        },
        $html
    );
}

function fix_content_links($html)
{
    $html = preg_replace(
        '#https?://abdulkarimshowaiter\.wordpress\.com/([a-zA-Z0-9_-]+)/?#',
        'page.php?slug=$1',
        $html
    );
    return $html;
}

function fix_content_buttons($html)
{
    $html = preg_replace('/<div class="wp-block-buttons[^"]*">[\s\S]*?<\/div>\s*<\/div>\s*/', '', $html);
    // Remove WordPress spacers
    $html = preg_replace('/<div style="height:\d+px" aria-hidden="true" class="wp-block-spacer"><\/div>\s*/', '', $html);
    // Remove <!-- wp:block {"ref":512} /--> (WordPress navigation block ref)
    $html = preg_replace('/<!--\s*wp:block\s*\{[^}]*\}\s*\/-->\s*/', '', $html);
    // Remove leftover WordPress comments
    $html = preg_replace('/<!--.*?-->/s', '', $html);
    // Clean <br> inside author/date paragraphs
    $html = preg_replace('/(<p class="has-text-align-center[^"]*"[^>]*>)<br>/', '$1', $html);
    // Wrap author name and date at the end in a styled div
    // Use [^<]* instead of [\s\S]*? to avoid PREG_BACKTRACK_LIMIT_ERROR on large content
    $html = preg_replace(
        '/(<p class="has-text-align-center[^"]*"[^>]*>[^<]*<\/p>\s*)+$/',
        '<div class="article-author">$0</div>',
        $html
    );
    return $html;
}

// Fix dashes after Arabic text — wrap dash in LTR span to keep it on the right side
function fix_content_dashes($html)
{
    // Handle: -</strong> (dash before closing strong tag)
    $html = preg_replace(
        '/-(<\/strong>)/',
        '<span dir="ltr">-</span>$1',
        $html
    );
    // Handle: عربي- (dash directly after Arabic character)
    $html = preg_replace(
        '/([\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}])-/u',
        '$1<span dir="ltr">-</span>',
        $html
    );
    return $html;
}

// Make book names clickable (linked to download) while keeping the download button
function fix_book_links($html)
{
    // Pattern 1: h3.is-service-name followed by wp-block-file
    $html = preg_replace_callback(
        '/<h3([^>]*is-service-name[^>]*)>(.*?)<\/h3>\s*(?:<!--.*?-->\s*)*<div class="wp-block-file">(.*?)<\/div>/s',
        function ($m) {
            $title = strip_tags($m[2]);
            $fileContent = $m[3];
            if (preg_match('/href="([^"]*)"/', $fileContent, $urlMatch)) {
                $url = $urlMatch[1];
                return '<h3' . $m[1] . '><a href="' . htmlspecialchars($url) . '" style="text-decoration:none;color:inherit;">' . htmlspecialchars(trim($title)) . '</a></h3>' . "\n<div class=\"wp-block-file\">" . $fileContent . '</div>';
            }
            return $m[0];
        },
        $html
    );

    // Pattern 2: p.has-text-align-center followed by wp-block-file
    $html = preg_replace_callback(
        '/<p class="has-text-align-center"><strong>([^<]+)<\/strong><\/p>\s*(?:<!--.*?-->\s*)*<div class="wp-block-file">(.*?)<\/div>/s',
        function ($m) {
            $title = $m[1];
            $fileContent = $m[2];
            if (preg_match('/href="([^"]*)"/', $fileContent, $urlMatch)) {
                $url = $urlMatch[1];
                return '<p class="has-text-align-center" style="font-family:Amiri,serif;font-size:1.2rem;font-weight:700;color:var(--primary-color);margin:0.75rem 0 0.5rem;"><a href="' . htmlspecialchars($url) . '" style="text-decoration:none;color:inherit;">' . htmlspecialchars(trim($title)) . '</a></p>' . "\n<div class=\"wp-block-file\">" . $fileContent . '</div>';
            }
            return $m[0];
        },
        $html
    );

    return $html;
}

// Detect if a slug maps to a special hub page
function get_hub_type($slug)
{
    $hubs = [
        'literature-works' => 'literature',
        'poems' => 'poems',
        'art-works' => 'art',
        'interviews' => 'interviews',
        'about' => 'about',
        'contact-us' => 'contact',
        'privacy-policy' => 'privacy',
        'books' => 'books',
        'dawawin' => 'dawawin',
    ];
    return isset($hubs[$slug]) ? $hubs[$slug] : false;
}

// Convert remote WordPress URL → local path
function localise_url($url) {
    if (preg_match('#/wp-content/uploads/(\d{4}/\d{2}/[^?"\s]+)#', $url, $matches)) {
        return $matches[1];
    }
    return $url;
}

// Render the Poems hub (مختارات من الشعر العربي) — used by render_poems_hub only (kept for back-compat)
function render_poems_hub($pdo)
{
    $stmt = $pdo->prepare(
        "SELECT title, slug FROM content
         WHERE post_type='page' AND status='publish'
         AND (slug LIKE 'poems%' OR title LIKE '%حرف%')
         AND slug != 'poems'
         ORDER BY post_id ASC"
    );
    $stmt->execute();
    $letters = $stmt->fetchAll();

    ob_start();
    ?>
    <div class="poems-hub-wrapper">
        <div class="poems-hub-intro text-center mb-5">
            <div class="intro-badge mb-3">مقدمة وإطلالة المختارات الشعرية</div>
            <h1 class="poems-main-title">مختارات من الشعر العربي</h1>
            <p class="poems-subtitle">مختارات من الشعر العربي كما انتقاها د. عبد الكريم الشويطر</p>
            <div class="title-divider"><span></span><i class="fas fa-feather-pointed"></i><span></span></div>
        </div>
        <div class="row g-3 justify-content-center">
            <?php foreach ($letters as $i => $letter): ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="page.php?slug=<?php echo htmlspecialchars($letter->slug); ?>" class="letter-card">
                        <span class="letter-number"><?php echo $i + 1; ?></span>
                        <span
                            class="letter-name"><?php echo htmlspecialchars(str_replace('حرف_', '', $letter->title)); ?></span>
                        <i class="fas fa-chevron-left letter-icon"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// Render the Literature hub (الأعمال الأدبية)
function render_literature_hub($pdo)
{
    $sections = [
        ['title' => 'المقالات', 'slug' => 'articles', 'img' => '2025/02/photo_2025-02-02_22-15-15-1.webp', 'desc' => 'مجموعة من المقالات من قلم د. عبد الكريم الشويطر'],
        ['title' => 'الدواوين', 'slug' => 'dawawin', 'img' => '2025/02/photo_2025-02-02_22-15-19-1.webp', 'desc' => 'مجموعة من الدواوين من قلم د. عبد الكريم الشويطر'],
        ['title' => 'الكتب', 'slug' => 'books', 'img' => '2025/02/photo_2025-02-02_22-15-22.webp', 'desc' => 'مؤلفات الدكتور عبدالكريم الشويطر'],
        ['title' => 'مختاراتي', 'slug' => 'poems', 'img' => '2025/02/photo_2025-02-02_22-15-19-1.webp', 'desc' => 'مختارات من الشعر العربي'],
    ];

    ob_start();
    ?>
    <div class="lit-hub-wrapper">
        <div class="text-center mb-5">
            <h1 class="lit-hub-title">الأعمال الأدبية</h1>
            <div class="title-divider"><span></span><i class="fas fa-book-open"></i><span></span></div>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($sections as $sec): ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <a href="page.php?slug=<?php echo $sec['slug']; ?>" class="hub-card">
                        <div class="hub-card-img bg-lazy" data-bg="<?php echo $sec['img']; ?>">
                            <div class="hub-card-overlay">
                                <span class="hub-card-label"><?php echo $sec['title']; ?></span>
                            </div>
                        </div>
                        <div class="hub-card-body">
                            <h3><?php echo $sec['title']; ?></h3>
                            <p><?php echo $sec['desc']; ?></p>
                            <span class="hub-card-btn">اقرأ الصفحة &larr;</span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>