<?php
// templates/hubs/art_works.php
// Dynamically loads all artwork images from the database (children of art-works page).
// Images are served from local 2025/ folder — no WordPress CDN dependency.

$art_post_id = $pdo->query("SELECT post_id FROM content WHERE slug='art-works' LIMIT 1")->fetchColumn();

$artworks = [];
if ($art_post_id) {
    $stmt = $pdo->prepare(
        "SELECT id, title, attachment_url FROM content
         WHERE post_parent = :pid AND post_type = 'attachment' AND attachment_url != ''
         ORDER BY post_id ASC"
    );
    $stmt->execute([':pid' => $art_post_id]);
    $artworks = $stmt->fetchAll(PDO::FETCH_OBJ);
}

$painting_num = 1;
?>

<div class="artworks-wrapper">

    <!-- Hero Header -->
    <div class="artworks-header text-center">
        <div class="container py-5">
            <h1 class="artworks-title">الأعمال الفنية</h1>
            <div class="title-divider my-3">
                <span></span><i class="fas fa-palette"></i><span></span>
            </div>
            <p class="artworks-subtitle">
                لوحات فنية تشكيلية من إبداع الطبيب الشاعر الفنان د. عبد الكريم الشويطر
            </p>
            <span class="artworks-count-badge">
                <?php echo count($artworks); ?> لوحة
            </span>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="container py-5">
        <div class="row g-3" id="artworks-grid">
            <?php foreach($artworks as $art): ?>
            <?php
                $local_src = localise_url($art->attachment_url);
                $label     = 'لوحة ' . $painting_num++;
            ?>
            <div class="col-6 col-sm-4 col-md-3">
                <div class="artwork-card" data-src="<?php echo htmlspecialchars($local_src); ?>" data-label="<?php echo htmlspecialchars($label); ?>">
                    <div class="artwork-img-wrap">
                        <img src="<?php echo htmlspecialchars($local_src); ?>"
                             alt="<?php echo htmlspecialchars($label); ?>"
                             class="artwork-img" loading="lazy">
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
            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
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
        <button id="rotate-btn" class="lightbox-rotate-btn" title="تدوير"><i class="fas fa-sync-alt"></i></button>
    </div>
    <button class="artwork-lightbox-nav next" id="artwork-next"><i class="fas fa-chevron-left"></i></button>
</div>
