<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
require_once 'includes/db.php';
require_once 'includes/functions.php';

$menu_pages = get_menu_pages($pdo);
$art_post_id = $pdo->query("SELECT post_id FROM content WHERE slug='art-works' LIMIT 1")->fetchColumn();
$art_count = 0;
if ($art_post_id) {
    $art_count = $pdo->prepare("SELECT COUNT(*) FROM content WHERE post_parent = :pid AND post_type = 'attachment' AND attachment_url != ''");
    $art_count->execute([':pid' => $art_post_id]);
    $art_count = $art_count->fetchColumn();
}
?>
<!DOCTYPE html>
<?php
$view_mode = isset($_GET['view']) ? $_GET['view'] : null;
if ($view_mode === 'mobile' || $view_mode === 'desktop') {
    $_SESSION['view_mode'] = $view_mode;
} elseif (isset($_GET['view']) && $_GET['view'] === 'natural') {
    unset($_SESSION['view_mode']);
    $view_mode = null;
} elseif ($view_mode === null && isset($_SESSION['view_mode'])) {
    $view_mode = $_SESSION['view_mode'];
}
?>
<html lang="ar" dir="rtl" <?php if ($view_mode === 'mobile') echo 'class="view-mobile"'; elseif ($view_mode === 'desktop') echo 'class="view-desktop"'; ?>>
<head>
    <meta charset="UTF-8">
    <?php echo viewport_meta_tag($view_mode); ?>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <title>موقع د.عبد الكريم الشويطر</title>
    <meta name="description" content="موقع الدكتور عبد الكريم الشويطر - طبيب وشاعر وفنان تشكيلي يمني. كتب، دواوين شعر، مقالات، ولوحات فنية.">
    <meta property="og:title" content="د. عبد الكريم الشويطر - طبيب وشاعر وفنان تشكيلي">
    <meta property="og:description" content="موقع الدكتور عبد الكريم الشويطر - طبيب وشاعر وفنان تشكيلي يمني. كتب، دواوين شعر، مقالات، ولوحات فنية.">
    <meta property="og:image" content="https://abdulkarimshowaiter.me/cropped-untitled-320-x-480-px-640-x-960-px1-1.png">
    <meta property="og:url" content="https://abdulkarimshowaiter.me/">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ar_AR">
    <meta property="og:site_name" content="د. عبد الكريم الشويطر">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="د. عبد الكريم الشويطر - طبيب وشاعر وفنان تشكيلي">
    <meta name="twitter:description" content="موقع الدكتور عبد الكريم الشويطر - طبيب وشاعر وفنان تشكيلي يمني. كتب، دواوين شعر، مقالات، ولوحات فنية.">
    <meta name="twitter:image" content="https://abdulkarimshowaiter.me/cropped-untitled-320-x-480-px-640-x-960-px1-1.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Tajawal:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.min.css?v=52">
</head>
<body class="home-page">

<!-- Scroll Progress Bar -->
<div class="scroll-progress" id="scrollProgress">
    <i class="fas fa-feather-pointed scroll-pen-icon"></i>
</div>
<div class="scroll-particles" id="scrollParticles"></div>

<?php include 'templates/navbar.php'; ?>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="hero-bg parallax-window"></div>
    <div class="container h-100 d-flex flex-column justify-content-end align-items-start pb-5 reveal-scale">
        <div class="hero-glass-panel shadow-lg text-center" id="hero-panel" style="max-width: 520px; margin-bottom: 5px;">
            <button class="hero-close-btn" id="hero-close" aria-label="إغلاق">&times;</button>
            <h1 class="display-3 brand-font fw-bold hero-title mb-3">د. عبد الكريم الشويطر</h1>
            <p class="lead fw-medium fs-3 text-primary-custom hero-typing-wrap">
                <span id="heroTyping"></span><span class="typing-cursor">|</span>
            </p>
            <p class="hero-subtext mt-3">اكتشف كتابات، قصائد، ومقالات الدكتور عبد الكريم الشويطر بعيداً عن قيود المنصات التجارية.</p>
            <a href="#about" class="btn btn-gold mt-4 rounded-pill px-4 py-2 fs-5 shadow smooth-scroll d-inline-flex align-items-center gap-2">
                اكتشف المزيد <i class="fas fa-chevron-down slide-down-anim"></i>
            </a>
        </div>
    </div>
</section>

<!-- About Preview Section -->
<section id="about" class="about-preview-section py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0 text-center text-lg-end position-relative reveal-left">
                <div class="about-img-frame shadow-xl">
                    <?php echo picture('2025/01/untitled-320-x-480-px-640-x-960-px.png', 'د. عبد الكريم الشويطر', 'img-fluid rounded-4 about-img parallax-img', 'loading="lazy"'); ?>
                    <div class="decorative-border"></div>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5 text-center text-lg-start px-4 px-lg-0 reveal-right">
                <h2 class="section-title mb-3 brand-font display-4 text-primary-custom">نبذة</h2>
                <div class="title-divider justify-content-center justify-content-lg-start mb-4">
                    <span></span><i class="fas fa-leaf"></i><span class="d-none d-lg-block"></span>
                </div>
                <p class="lead text-muted lh-lg mb-4 text-justify fs-5">
                    تلقى علومه الأساسية في مدينة إب والثانوية في القاهرة وتعز. رُشح لدراسة العلوم الطبية إلى براغ جامعة تشارلس في عام ١٩٧٠ ضمن أوائل الطلبة. حصل على البكالوريوس في الطب والجراحة بتاريخ ١٩٧٨/٦/٢٦.
                </p>
                <p class="lead text-muted lh-lg mb-4 text-justify fs-5">
                    بعد عودته إلى اليمن، بدأ حياته العملية في صنعاء ضمن قطاع الصحة المدرسية، وأجرى مسحاً طبياً شاملاً مع الفريق الطبي على جميع مدارس العاصمة (بنين وبنات).
                </p>
                <a href="page.php?slug=about" class="btn btn-outline-primary-custom rounded-pill px-4 py-2 mt-2 fw-bold hover-lift">اقرأ السيرة الذاتية كاملة <i class="fas fa-arrow-left ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counter Section -->
<section class="stats-section py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-lg-3 reveal-up delay-1">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-pen-nib"></i></div>
                    <div class="stat-number" data-target="40">0</div>
                    <div class="stat-label">عاماً من الإبداع</div>
                </div>
            </div>
            <div class="col-6 col-lg-3 reveal-up delay-2">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                    <div class="stat-number" data-target="10">0</div>
                    <div class="stat-label">كتاب مطبوع</div>
                </div>
            </div>
            <div class="col-6 col-lg-3 reveal-up delay-3">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-feather-pointed"></i></div>
                    <div class="stat-number" data-target="500">0</div>
                    <div class="stat-label">قصيدة ونابغة</div>
                </div>
            </div>
            <div class="col-6 col-lg-3 reveal-up delay-1">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-palette"></i></div>
                    <div class="stat-number" data-target="<?php echo $art_count; ?>">0</div>
                    <div class="stat-label">لوحة فنية</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hubs Section -->
<section class="hubs-section py-5 bg-light-pattern bg-lazy" data-bg="arabic-pattern.webp">
    <div class="container py-5">
        <div class="text-center mb-5 reveal-up">
            <h2 class="section-title brand-font display-4 text-primary-custom">الأعمال الأدبية والفنية</h2>
            <div class="title-divider mx-auto mb-4">
                <span></span><i class="fas fa-gem"></i><span></span>
            </div>
            <p class="text-muted fs-5">نوافذ تطل على إبداعات الدكتور في مختلف المجالات</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Literature -->
            <div class="col-md-6 col-lg-5 reveal-up delay-1">
                <a href="page.php?slug=literature-works" class="hub-preview-card text-decoration-none d-block shadow-lg rounded-4 overflow-hidden position-relative group">
                    <div class="hub-img-wrap overflow-hidden position-relative">
                        <?php echo picture('2025/02/5-1.webp', 'الأدب', 'img-fluid w-100 hub-zoom', 'loading="lazy"'); ?>
                        <div class="hub-overlay d-flex flex-column align-items-center justify-content-center">
                            <h3 class="brand-font text-white display-6 fw-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.8); letter-spacing: 1px;">الأدب</h3>
                        </div>
                    </div>
                    <div class="hub-preview-body text-center p-4 bg-white">
                        <p class="text-muted mb-0 fs-5">تصفح المجموعات الشعرية والأعمال الأدبية، حيث تتجلى الكلمة وتزهر المعاني.</p>
                        <span class="btn btn-gold rounded-pill mt-3 px-4 py-2 opacity-0 btn-reveal">استكشف <i class="fas fa-arrow-left ms-1"></i></span>
                    </div>
                </a>
            </div>
            <!-- Artworks -->
            <div class="col-md-6 col-lg-5 reveal-up delay-2">
                <a href="page.php?slug=art-works" class="hub-preview-card text-decoration-none d-block shadow-lg rounded-4 overflow-hidden position-relative group">
                    <div class="hub-img-wrap overflow-hidden position-relative">
                        <?php echo picture('2025/01/untitled-design31.png', 'الفن التشكيلي', 'img-fluid w-100 hub-zoom', 'loading="lazy"'); ?>
                        <div class="hub-overlay d-flex flex-column align-items-center justify-content-center">
                            <h3 class="brand-font text-white display-6 fw-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.8); letter-spacing: 1px;">الفن التشكيلي</h3>
                        </div>
                    </div>
                    <div class="hub-preview-body text-center p-4 bg-white">
                        <p class="text-muted mb-0 fs-5">لوحات فنية تشكيلية من إبداع الطبيب الشاعر الفنان، تعبر عن جماليات الطبيعة والوجدان.</p>
                        <span class="btn btn-gold rounded-pill mt-3 px-4 py-2 opacity-0 btn-reveal">استكشف <i class="fas fa-arrow-left ms-1"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Parallax Quote Section (Scroll-Pinned) -->
<div class="quote-pin-wrapper" id="quotePinWrapper">
    <section class="parallax-quote-section" id="quoteSection">
        <div class="parallax-quote-bg bg-lazy" data-bg="arabic-pattern.webp"></div>
        <div class="parallax-quote-overlay"></div>
        <div class="quote-content">
            <i class="fas fa-quote-right quote-icon mb-4"></i>
            <div class="quote-carousel" id="quoteCarousel">
                <blockquote class="quote-text brand-font quote-slide active">
                    أنا لست أزعمُ، أنني إلاّ فتىً ولدتهُ أمٌّ، إسمها إبُّ الجميلة
                </blockquote>
                <blockquote class="quote-text brand-font quote-slide">
                    لغتنا العربية هي كائن حي، والحروف ما هي إلا رموز شخصيات وقاموس مشاعر وأحاسيس
                </blockquote>
                <blockquote class="quote-text brand-font quote-slide">
                    جوهر التفكير عندنا هو العاطفة، أو إن شئت فقل الحب، حب الشيء الذي نفكر فيه
                </blockquote>
            </div>
            <div class="quote-dots" id="quoteDots">
                <span class="quote-dot active" data-index="0"></span>
                <span class="quote-dot" data-index="1"></span>
                <span class="quote-dot" data-index="2"></span>
            </div>
            <div class="quote-progress-bar" id="quoteProgressBar"></div>
            <div class="quote-divider mx-auto my-4"></div>
            <p class="quote-author">— الدكتور عبد الكريم الشويطر</p>
        </div>
    </section>
</div>

<!-- Articles Section -->
<section id="articles" class="articles-section py-5">
    <div class="container py-5">
        <div class="row align-items-end mb-5 reveal-up">
            <div class="col-lg-8 text-center text-lg-start">
                <h2 class="section-title mb-0 brand-font display-5 text-primary-custom">أحدث المقالات والكتــابات</h2>
                <p class="text-muted mt-2 mb-0 fs-5">جميع الملفات المحفوظة من النسخة القديمة</p>
            </div>
            <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                <span class="badge bg-gold px-4 py-2 rounded-pill shadow-sm fs-6" id="totalItemsBadge"></span>
            </div>
        </div>

        <!-- Cards injected by home.js -->
        <div class="row g-4" id="articles-container"></div>

        <div class="text-center mt-5 pt-3 reveal-up delay-1">
            <div class="loader" id="loader"></div>
            <button id="load-more-btn" class="btn btn-gold mt-3 px-5 py-3 fs-5 shadow-lg rounded-pill hover-lift" style="display:none;">
                تحميل المزيد من المقالات <i class="fas fa-sync-alt ms-2"></i>
            </button>
        </div>
    </div>
</section>

<?php include 'templates/footer.php'; ?>

<script src="js/home-scroll.min.js?v=3"></script>
<script src="js/home.min.js"></script>

</body>
</html>
