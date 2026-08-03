<?php
// templates/hubs/diwans.php
// Expects: $content (object from DB)
// Parses the WordPress-exported HTML to extract diwan data

$html = $content->content ?? '';
$html = preg_replace('/<!--.*?-->/s', '', $html);
$html = fix_content_images($html);

// Extract diwans from the content
$diwans = [];
$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR);
$xpath = new DOMXPath($doc);

$columns = $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " wp-block-column ") and not(contains(concat(" ", normalize-space(@class), " "), " wp-block-columns "))]');
foreach ($columns as $col) {
    $title = '';
    $cover = '';
    $pdf_url = '';

    $h3s = $xpath->query('.//*[contains(@class, "is-service-name")]', $col);
    if ($h3s->length > 0) {
        $title = trim($h3s->item(0)->textContent);
    } else {
        $strongs = $xpath->query('.//p[contains(@class, "has-text-align-center")]/strong', $col);
        if ($strongs->length > 0) $title = trim($strongs->item(0)->textContent);
    }

    $imgs = $xpath->query('.//*[contains(@class, "wp-block-image")]//img', $col);
    if ($imgs->length > 0) {
        $cover = $imgs->item(0)->getAttribute('src');
    }

    $links = $xpath->query('.//*[contains(@class, "wp-block-file")]//a[contains(@href, ".pdf")]', $col);
    if ($links->length > 0) {
        $pdf_url = $links->item(0)->getAttribute('href');
    }

    if ($title && $pdf_url) {
        $diwans[] = [
            'title' => $title,
            'cover' => $cover,
            'pdf_url' => $pdf_url,
        ];
    }
}
?>

<section class="diwans-hero py-5">
    <div class="container text-center">
        <h1 class="diwans-title"><?php echo htmlspecialchars($content->title); ?></h1>
        <div class="title-divider mx-auto"><span></span><i class="fas fa-feather-pointed"></i><span></span></div>
        <p class="diwans-lead">دواوين شعرية من إبداع الدكتور عبد الكريم الشويطر</p>
    </div>
</section>

<div class="container my-5">
    <div class="diwans-grid row g-4 justify-content-center">
        <?php foreach ($diwans as $i => $diwan): ?>
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="diwan-card" style="--delay: <?php echo $i * 0.1; ?>s">
                <div class="diwan-spine"></div>
                <div class="diwan-cover-wrap">
                    <?php if ($diwan['cover']): ?>
                        <?php echo picture($diwan['cover'], $diwan['title'], 'diwan-cover-img', ''); ?>
                    <?php else: ?>
                        <div class="diwan-cover-placeholder">
                            <i class="fas fa-book-open"></i>
                        </div>
                    <?php endif; ?>
                    <div class="diwan-cover-shine"></div>
                </div>
                <div class="diwan-info">
                    <h3 class="diwan-title"><?php echo htmlspecialchars($diwan['title']); ?></h3>
                    <div class="diwan-actions">
                        <a href="pdf-reader.php?file=<?php echo urlencode($diwan['pdf_url']); ?>&from=dawawin"
                           class="btn btn-read-online" aria-label="اقرأ الآن">
                            <i class="fas fa-book-reader"></i>
                            <span>اقرأ الآن</span>
                        </a>
                        <a href="download.php?file=<?php echo urlencode($diwan['pdf_url']); ?>&name=<?php echo urlencode($diwan['title'] . '.pdf'); ?>"
                           class="btn btn-download" download aria-label="تنزيل">
                            <i class="fas fa-download"></i>
                            <span>تنزيل</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($diwans)): ?>
        <div class="text-center py-5">
            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">لا توجد دواوين حالياً</p>
        </div>
    <?php endif; ?>

    <div class="text-center mt-5">
        <a href="index.php" class="btn btn-gold rounded-pill px-4">
            <i class="fas fa-arrow-right ms-2"></i> العودة للرئيسية
        </a>
    </div>
</div>
