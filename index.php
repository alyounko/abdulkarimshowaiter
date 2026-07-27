<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$menu_pages = get_menu_pages($pdo);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>موقع د.عبد الكريم الشويطر</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css?v=41">
</head>
<body class="home-page">

<?php include 'templates/navbar.php'; ?>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="hero-bg parallax-window"></div>
    <div class="container h-100 d-flex flex-column justify-content-end align-items-start pb-5 reveal-scale">
        <div class="hero-glass-panel shadow-lg text-center" id="hero-panel" style="max-width: 520px; margin-bottom: 5px;">
            <button class="hero-close-btn" id="hero-close" aria-label="إغلاق">&times;</button>
            <h1 class="display-3 brand-font fw-bold hero-title mb-3">د. عبد الكريم الشويطر</h1>
            <p class="lead fw-medium fs-3 text-primary-custom">الطبيب، الشاعر، والفنان التشكيلي</p>
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
                    <img src="2025/01/untitled-320-x-480-px-640-x-960-px.png" alt="د. عبد الكريم الشويطر" class="img-fluid rounded-4 about-img parallax-img">
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

<!-- Hubs Section -->
<section class="hubs-section py-5 bg-light-pattern">
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
                        <img src="2025/02/photo_2025-02-02_22-15-22.jpg" class="img-fluid w-100 hub-zoom" alt="الأدب">
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
                        <img src="2025/01/untitled-design31.png" class="img-fluid w-100 hub-zoom" alt="الفن التشكيلي">
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

<!-- Custom JS specific to index page scroll effects -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Hero panel close button
    const heroClose = document.getElementById('hero-close');
    const heroPanel = document.getElementById('hero-panel');
    if (heroClose && heroPanel) {
        heroClose.addEventListener('click', function() {
            heroPanel.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            heroPanel.style.opacity = '0';
            heroPanel.style.transform = 'translateY(-20px)';
            setTimeout(function() { heroPanel.style.display = 'none'; }, 400);
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('.smooth-scroll').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Intersection Observer for scroll animations (mobile & desktop)
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-up, .reveal-scale, .reveal-left, .reveal-right').forEach((el) => {
        scrollObserver.observe(el);
    });

    // Parallax effect removed
});
</script>

<script src="js/home.js"></script>

</body>
</html>
