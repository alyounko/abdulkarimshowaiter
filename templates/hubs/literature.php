<?php
// templates/hubs/literature.php
// Expects: $pdo
$sections = [
    ['title' => 'المقالات', 'slug' => 'articles', 'img' => '2025/02/photo_2025-02-02_22-15-19-1.jpg', 'desc' => 'مجموعة من المقالات من قلم د. عبد الكريم الشويطر'],
    ['title' => 'الدواوين', 'slug' => 'dawawin',  'img' => '2025/02/photo_2025-02-02_22-15-15-1.jpg', 'desc' => 'مجموعة من الدواوين من قلم د. عبد الكريم الشويطر'],
    ['title' => 'الكتب',    'slug' => 'books',     'img' => '2025/02/photo_2025-02-02_22-14-56.jpg', 'desc' => 'مؤلفات الدكتور عبدالكريم الشويطر'],
    ['title' => 'مختاراتي',  'slug' => 'poems',     'img' => '2025/02/photo_2025-02-02_22-15-22.jpg', 'desc' => 'مختارات من الشعر العربي'],
];
?>
<section class="literature-hero py-5">
    <div class="container text-center">
        <h1 class="literature-title">مجموعة أعمال د.عبد الكريم الشويطر الأدبية</h1>
        <p class="literature-lead">اكتشف اليوم أعماله الأدبية المصنفة بعناية، من المقالات الإنسانية إلى الدواوين والكتب
            المختارة.</p>
        <div class="title-divider mx-auto"><span></span><i class="fas fa-book-open"></i><span></span></div>
    </div>
</section>

<div class="container my-5">
    <div class="lit-hub-wrapper">
        <div class="row g-4 justify-content-center">
            <?php foreach ($sections as $sec): ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <a href="page.php?slug=<?php echo $sec['slug']; ?>" class="hub-card literature-card">
                        <div class="hub-card-img" style="background-image:url('<?php echo $sec['img']; ?>')">
                            <div class="hub-card-overlay">
                                <span class="hub-card-label"><?php echo $sec['title']; ?></span>
                            </div>
                        </div>
                        <div class="hub-card-body">
                            <h3><?php echo $sec['title']; ?></h3>
                            <p><?php echo $sec['desc']; ?></p>
                            <span class="hub-card-btn">عرض القسم</span>
                        </div>
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