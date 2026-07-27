<?php
// templates/hubs/privacy.php
$content_html = $content->content ?? '';
$content_html = preg_replace('/<!--.*?-->/s', '', $content_html);
$content_html = fix_content_images($content_html);
$content_html = fix_content_dashes($content_html);
?>
<section class="privacy-hero py-5">
    <div class="container text-center">
        <h1 class="privacy-title">سياسة الخصوصية</h1>
        <h2 class="privacy-subtitle">نحن نحمي معلوماتك الشخصية</h2>
        <p class="privacy-subtitle">إليك كيف نجمع البيانات، نستخدمها، ونحافظ عليها بأمان.</p>
    </div>
</section>

<section class="privacy-body py-5">
    <div class="container">
        <div class="privacy-panel shadow-sm rounded-4 p-4 p-lg-5">
            <div class="privacy-content">
                <?php echo $content_html; ?>
            </div>
        </div>
    </div>
</section>