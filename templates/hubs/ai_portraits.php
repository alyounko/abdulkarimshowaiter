<?php
// templates/hubs/ai_portraits.php
// Scans AI-Refind Arts/ folder for portrait images.

$portrait_dir = __DIR__ . '/../../AI-Refind Arts';
$portraits = [];
if (is_dir($portrait_dir)) {
    $files = glob($portrait_dir . '/*.png');
    usort($files, function($a, $b) {
        return (int)pathinfo($a, PATHINFO_FILENAME) - (int)pathinfo($b, PATHINFO_FILENAME);
    });
    foreach ($files as $f) {
        $name = basename($f);
        $portraits[] = 'AI-Refind Arts/' . $name;
    }
}

$portrait_num = 1;
?>

<div class="artworks-wrapper">

    <!-- Hero Header -->
    <div class="artworks-header text-center">
        <div class="container py-5">
            <h1 class="artworks-title">تحوُّلات فنية بالذكاء الاصطناعي</h1>
            <div class="title-divider my-3">
                <span></span><i class="fas fa-wand-magic-sparkles"></i><span></span>
            </div>
            <p class="artworks-subtitle">
                بورتريهات مُتقَنة خلّفها لقاء بين فن الدكتور عبد الكريم الشويطر وإمكانيات الذكاء الاصطناعي
            </p>
            <span class="artworks-count-badge">
                <?php echo count($portraits); ?> بورتريه
            </span>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="container py-5">
        <div class="row g-3" id="artworks-grid">
            <?php foreach($portraits as $src): ?>
            <?php
                $label = 'بورتريه ' . $portrait_num++;
            ?>
            <div class="col-6 col-sm-4 col-md-3">
                <div class="artwork-card" data-src="<?php echo htmlspecialchars($src); ?>" data-label="<?php echo htmlspecialchars($label); ?>">
                    <div class="artwork-img-wrap">
                        <?php echo picture($src, $label, 'artwork-img', 'loading="lazy"'); ?>
                        <div class="artwork-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                    <p class="artwork-label"><?php echo htmlspecialchars($label); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-gold rounded-pill px-4">
                <i class="fas fa-arrow-right ms-2"></i> العودة للرئيسية
            </a>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="artwork-lightbox" class="artwork-lightbox" style="display:none;" role="dialog" aria-modal="true">
    <button class="artwork-lightbox-close" id="artwork-close"><i class="fas fa-times"></i></button>
    <button class="artwork-lightbox-nav prev" id="artwork-prev"><i class="fas fa-chevron-right"></i></button>
    <div class="artwork-lightbox-inner">
        <img src="" id="lightbox-img" alt="">
        <p id="lightbox-label"></p>
        <span id="lightbox-counter" class="lightbox-counter"></span>
        <button id="rotate-btn" class="lightbox-rotate-btn" title="تدوير"><i class="fas fa-sync-alt"></i></button>
    </div>
    <button class="artwork-lightbox-nav next" id="artwork-next"><i class="fas fa-chevron-left"></i></button>
</div>
