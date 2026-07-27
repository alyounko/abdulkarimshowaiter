<?php
// templates/hubs/standard_page.php
// Expects: $content (object), $page_title (string)
?>
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="article-content">
                <div class="text-center mb-4 pb-3 border-bottom">
                    <h1 class="mb-2"><?php echo htmlspecialchars($page_title); ?></h1>
                    <?php if (!empty($content->published_date)): ?>
                    <span class="text-muted small">
                        <i class="far fa-calendar-alt ms-1"></i>
                        <?php echo format_arabic_date($content->published_date); ?>
                    </span>
                    <?php endif; ?>
                </div>

                <div class="content-body" data-slug="<?php echo htmlspecialchars($slug); ?>" style="font-size:1.1rem; line-height:2.1;">
                    <?php
                    $html = $content->content ?? '';
                    $html = preg_replace('/<!--.*?-->/s', '', $html);
                    $html = fix_content_images($html);
                    $html = fix_content_links($html);
                    $html = fix_content_dashes($html);
                    $html = fix_book_links($html);
                    $html = fix_content_buttons($html);
                    echo $html;
                    ?>
                </div>

                <div class="mt-3 text-center">
                    <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4 me-2" id="back-btn">
                        <i class="fas fa-arrow-right ms-2"></i> رجوع
                    </a>
                    <a href="index.php" class="btn btn-gold rounded-pill px-4">الرئيسية</a>
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
