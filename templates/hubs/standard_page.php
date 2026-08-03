<?php
// templates/hubs/standard_page.php
// Expects: $content (object), $page_title (string)
?>
<div class="standard-hero text-center py-4">
    <div class="container py-3">
        <div class="title-divider mx-auto mb-3"><span></span><i class="fas fa-book-open"></i><span></span></div>
        <h1 class="brand-font display-5 mb-2"><?php echo htmlspecialchars($page_title); ?></h1>
        <?php if (!empty($content->published_date)): ?>
        <span class="text-muted small">
            <i class="far fa-calendar-alt ms-1"></i>
            <?php echo format_arabic_date($content->published_date); ?>
        </span>
        <?php endif; ?>
    </div>
</div>

<div class="container pt-3 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="article-content standard-wrapper">
                <div class="content-body" data-slug="<?php echo htmlspecialchars($slug); ?>">
                    <?php
                    $html = $content->content ?? '';
                    $html = preg_replace('/<!--.*?-->/s', '', $html);
                    $html = fix_content_images($html);
                    $html = fix_content_links($html);
                    $html = fix_content_dashes($html);
                    $html = fix_book_links($html);
                    $html = fix_content_buttons($html);
                    $html = fix_images_to_picture($html);
                    echo $html;
                    ?>
                </div>

                <div class="mt-4 text-center">
                    <a href="index.php" class="btn btn-gold rounded-pill px-4 me-2" id="back-btn">
                        <i class="fas fa-arrow-right ms-2"></i> رجوع
                    </a>
                    <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">الرئيسية</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('back-btn')?.addEventListener('click', function(e) {
    e.preventDefault();
    if (window.history.length > 1) {
        window.history.back();
    } else if (document.referrer && document.referrer.indexOf(location.origin) === 0) {
        location.href = document.referrer;
    } else {
        location.href = 'index.php';
    }
});
</script>
