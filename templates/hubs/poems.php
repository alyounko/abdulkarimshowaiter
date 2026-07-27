<?php
// templates/hubs/poems.php
// Expects: $pdo, $page_title
?>
<div class="container my-5">
    <div class="poems-hub-wrapper">
        <div class="poems-hub-intro text-center mb-5">
            <h1 class="poems-main-title">مختارات من الشعر العربي</h1>
            <p class="poems-subtitle">مختارات من الشعر العربي كما انتقاها د. عبد الكريم الشويطر</p>
            <div class="title-divider"><span></span><i class="fas fa-feather-alt"></i><span></span></div>
        </div>

        <?php
        $stmt = $pdo->prepare(
            "SELECT title, slug FROM content
             WHERE post_type='page' AND status='publish'
             AND (slug LIKE 'poems%' OR title LIKE '%حرف%')
             AND slug != 'poems'
             ORDER BY post_id ASC"
        );
        $stmt->execute();
        $letters = $stmt->fetchAll();
        ?>

        <div class="row g-3 justify-content-center">
            <?php foreach($letters as $i => $letter): ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="page.php?slug=<?php echo htmlspecialchars($letter->slug); ?>" class="letter-card">
                    <span class="letter-number"><?php echo $i + 1; ?></span>
                    <span class="letter-name"><?php echo htmlspecialchars(preg_replace('/^(ال)?حرف_/', '', $letter->title)); ?></span>
                    <i class="fas fa-chevron-left letter-icon"></i>
                </a>
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
