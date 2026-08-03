<?php
// templates/hubs/books.php
// Expects: $content (object from DB)
// Parses the WordPress-exported HTML to extract book data

$html = $content->content ?? '';
$html = preg_replace('/<!--.*?-->/s', '', $html);
$html = fix_content_images($html);

// Extract books from the content
$books = [];
$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR);
$xpath = new DOMXPath($doc);

$columns = $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " wp-block-column ") and not(contains(concat(" ", normalize-space(@class), " "), " wp-block-columns "))]');
foreach ($columns as $col) {
    $title = '';
    $cover = '';
    $pdf_url = '';

    // Extract title from h3.is-service-name or strong inside p
    $h3s = $xpath->query('.//*[contains(@class, "is-service-name")]', $col);
    if ($h3s->length > 0) {
        $title = trim($h3s->item(0)->textContent);
    } else {
        $strongs = $xpath->query('.//p[contains(@class, "has-text-align-center")]/strong', $col);
        if ($strongs->length > 0) $title = trim($strongs->item(0)->textContent);
    }

    // Extract cover image
    $imgs = $xpath->query('.//*[contains(@class, "wp-block-image")]//img', $col);
    if ($imgs->length > 0) {
        $cover = $imgs->item(0)->getAttribute('src');
    }

    // Extract PDF link
    $links = $xpath->query('.//*[contains(@class, "wp-block-file")]//a[contains(@href, ".pdf")]', $col);
    if ($links->length > 0) {
        $pdf_url = $links->item(0)->getAttribute('href');
    }

    if ($title && $pdf_url) {
        $books[] = [
            'title'   => $title,
            'cover'   => $cover,
            'pdf_url' => $pdf_url,
        ];
    }
}
?>

<section class="books-hero py-5">
    <div class="container text-center">
        <h1 class="books-title"><?php echo htmlspecialchars($content->title); ?></h1>
        <div class="title-divider mx-auto"><span></span><i class="fas fa-book"></i><span></span></div>
        <p class="books-lead">مجموعة من المؤلفات والكتب من إبداع الدكتور عبد الكريم الشويطر</p>
    </div>
</section>

<div class="container my-5">
    <div class="books-grid row g-4 justify-content-center">
        <?php foreach ($books as $i => $book): ?>
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="book-card" style="--delay: <?php echo $i * 0.1; ?>s">
                <div class="book-spine"></div>
                <div class="book-cover-wrap">
                    <?php if ($book['cover']): ?>
                        <?php echo picture($book['cover'], $book['title'], 'book-cover-img', ''); ?>
                    <?php else: ?>
                        <div class="book-cover-placeholder">
                            <i class="fas fa-book-open"></i>
                        </div>
                    <?php endif; ?>
                    <div class="book-cover-shine"></div>
                </div>
                <div class="book-info">
                    <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <div class="book-actions">
                        <a href="pdf-reader.php?file=<?php echo urlencode($book['pdf_url']); ?>"
                           class="btn btn-read-online" aria-label="اقرأ الآن">
                            <i class="fas fa-book-reader"></i>
                            <span>اقرأ الآن</span>
                        </a>
                        <a href="download.php?file=<?php echo urlencode($book['pdf_url']); ?>&name=<?php echo urlencode($book['title'] . '.pdf'); ?>"
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

    <?php if (empty($books)): ?>
        <div class="text-center py-5">
            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">لا توجد كتب حالياً</p>
        </div>
    <?php endif; ?>

    <div class="text-center mt-5">
        <a href="index.php" class="btn btn-gold rounded-pill px-4">
            <i class="fas fa-arrow-right ms-2"></i> العودة للرئيسية
        </a>
    </div>
</div>
