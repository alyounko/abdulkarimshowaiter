<?php
// templates/hubs/privacy.php
$content_html = $content->content ?? '';
$content_html = preg_replace('/<!--.*?-->/s', '', $content_html);
$content_html = fix_content_images($content_html);
$content_html = fix_content_dashes($content_html);
$content_html = fix_images_to_picture($content_html);
?>
<section class="privacy-hero py-5">
    <div class="container text-center">
        <div class="title-divider mx-auto mb-3"><span></span><i class="fas fa-shield-halved"></i><span></span></div>
        <h1 class="privacy-title brand-font display-4">سياسة الخصوصية</h1>
        <p class="privacy-subtitle mt-3 fs-5">نحن نحمي معلوماتك الشخصية</p>
        <p class="text-muted mt-2">إليك كيف نجمع البيانات، نستخدمها، ونحافظ عليها بأمان.</p>
    </div>
</section>

<section class="privacy-body py-5">
    <div class="container">
        <div class="privacy-panel shadow-sm rounded-4 p-4 p-lg-5">
            <div class="privacy-content">
                <?php echo $content_html; ?>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-gold rounded-pill px-4">
                <i class="fas fa-arrow-right ms-2"></i> العودة للرئيسية
            </a>
        </div>
    </div>
</section>