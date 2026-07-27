<?php
// templates/hubs/about.php
$author_name    = "د. عبد الكريم عبد الله الشويطر";
$birth_date     = "١٩٥٠/٧/٢٤";
$social_status  = "متزوج وأب لأربعة أبناء وثلاث بنات";
$photo_src      = "2025/01/untitled-320-x-480-px-640-x-960-px.png";

$bio_sections = [
    "تلقى علومه الأساسية في مدينة إب والثانوية في القاهرة وتعز. رُشح لدراسة العلوم الطبية إلى براغ جامعة تشارلس في عام ١٩٧٠ ضمن أوائل الطلبة.",
    "حصل على البكالوريوس في الطب والجراحة بتاريخ ١٩٧٨/٦/٢٦. بعد عودته إلى اليمن، بدأ حياته العملية في صنعاء ضمن قطاع الصحة المدرسية، حيث تعين للعمل في الصحة المدرسية بصنعاء في تاريخ ١٩٧٨/١٠/٣١، خلفاً للدكتور الأصبحي الذي تعين وزيراً للصحة، إضافة إلى عمله الرسمي في الصحة المدرسية، أجرى مسحاً طبياً شاملاً مع الفريق الطبي على جميع مدارس العاصمة (بنين وبنات)، وأكمل بحثاً عن البلهارسيا المعوية والأمراض السارية.",
    "بعد عام واحد انتقل للعمل في إب وتعين مديراً عاماً للشُّؤون الصحية بتاريخ ١٩٨١/٨/١٣. أمضى في هذا المنصب نحو ثلاث سنوات حتى تاريخ ١٩٨٤/٣/١١، وخلال هذه المدة ساهم في إنشاء معظم المشاريع الصحية الكبرى كالمستشفيات الكبرى، المستوصفات، ومشاريع الرعاية الصحية الأولية. عاد للعمل في كل من مستشفى ناصر والثورة، حيث أمضى نحو خمسة عشر عاماً رئيساً لقسم الأمراض الباطنية ورئيساً للأطباء في كلا المستشفيين حتى تاريخ ١٩٩٦/٣/٢٠.",
    "حضر العديد من الندوات والمؤتمرات المحلية والدولية. أكمل بحثاً شاملاً عن البلهارسيا المعوية في محافظة إب. نُشر له العديد من المقالات والدراسات في معظم الصحف والمجلات الوطنية، وله علاقة مشاركة مع جامعة إب في معظم الأنشطة الثقافية والاجتماعية. عام 2005، انتقل إلى صنعاء والتحق بمستشفى الثورة العام، ثم تنقل بين العديد من المراكز الصحية والمستشفيات كاستشاري للأمراض الباطنية."
];
?>

<div class="about-wrapper">
    <div class="container py-5">
        <!-- نبذة - Centered -->
        <h1 class="about-title text-center">نبذة</h1>

        <!-- Photo + All Text - Same Level -->
        <div class="row align-items-start mt-4">
            <!-- Photo - Right -->
            <div class="col-lg-6 text-center mb-4 mb-lg-0 order-lg-2">
                <div class="about-photo-wrap">
                    <img src="<?php echo htmlspecialchars($photo_src); ?>"
                         alt="<?php echo htmlspecialchars($author_name); ?>"
                         class="about-photo shadow-lg">
                </div>
            </div>

            <!-- All Text - Left -->
            <div class="col-lg-6 order-lg-1">
                <h2 class="about-subtitle">السيرة الذاتية</h2>

                <div class="about-info-list mb-4">
                    <div>
                        <div class="mb-2">
                            <span class="about-info-label">الاسم:</span> <?php echo htmlspecialchars($author_name); ?>
                        </div>
                        <div class="mb-2">
                            <span class="about-info-label">تاريخ الميلاد:</span> <?php echo htmlspecialchars($birth_date); ?>
                        </div>
                        <div class="mb-2">
                            <span class="about-info-label">الحالة الاجتماعية:</span> <?php echo htmlspecialchars($social_status); ?>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-25">

                <div class="about-bio">
                    <?php foreach ($bio_sections as $para): ?>
                        <p class="mb-3"><?php echo htmlspecialchars($para); ?></p>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-5 py-2">
                <i class="fas fa-arrow-right ms-2"></i> العودة للرئيسية
            </a>
        </div>
    </div>
</div>
