<?php
// templates/hubs/interviews.php
// Expects: $pdo
//
// Video data extracted from the interviews page WordPress XML content.
// Each entry: [youtube_id, title, alt_text, bg_alternates]
$videos = [
    [
        'id'    => 'VchLP1GqaNY',
        'title' => 'لقاء مع قناة اليمن اليوم',
        'desc'  => 'لقاء مع د. عبد الكريم الشويطر على قناة اليمن اليوم',
    ],
    [
        'id'    => 'IWlOCrm_pjY',
        'title' => 'مقابلة الأديب الشاعر والطبيب عبدالكريم الشويطر (1)',
        'desc'  => 'الجزء الأول من المقابلة مع الشاعر والطبيب الدكتور عبدالكريم الشويطر',
    ],
    [
        'id'    => 'i3TO7dkGChQ',
        'title' => 'مقابلة الأديب الشاعر والطبيب عبدالكريم الشويطر (2)',
        'desc'  => 'الجزء الثاني من المقابلة مع الشاعر والطبيب',
    ],
    [
        'id'    => 'R4omI4bdb0U',
        'title' => 'مقابلة عن الغبار للطبيب عبد الكريم الشويطر',
        'desc'  => 'حديث الدكتور عن قصيدة الغبار وتجربته الشعرية',
    ],
    [
        'id'    => 'PwmfcpRjaa0',
        'title' => 'مقتطفات من قصيدة إب الجميلة',
        'desc'  => 'من أجمل ما كتبه الشاعر عن مدينة إب اليمنية',
    ],
    [
        'id'    => 'BZu6RycJ9pU',
        'title' => 'مختارات من قصيدة إب الجميلة',
        'desc'  => 'مختارات شعرية للدكتور عبدالكريم الشويطر',
    ],
    [
        'id'    => 'jBCwrSBnacc',
        'title' => 'ألبوم مدينة.. اليمن-إب',
        'desc'  => 'لقطات وأشعار عن مدينة إب اليمنية الجميلة',
    ],
    [
        'id'    => 'vEgxSOI1qmI',
        'title' => 'مقتطفات من قصيدة إب الجميلة للشاعر الدكتور عبدالكريم الشويطر',
        'desc'  => 'قصيدة إب الجميلة بصوت وقلم الدكتور عبدالكريم الشويطر',
    ],
];
?>

<div class="interviews-wrapper">

    <!-- Page Header -->
    <div class="interviews-header text-center">
        <div class="container py-5">
            <h1 class="interviews-title">المقابلات المرئية</h1>
            <div class="title-divider"><span></span><i class="fas fa-video"></i><span></span></div>
            <p class="interviews-subtitle">
                أجرى د. عبد الكريم الشويطر عدداً من المقابلات المرئية أبرزها
            </p>
        </div>
    </div>

    <!-- Video Grid -->
    <div class="container py-5">
        <div class="row g-4">
            <?php foreach($videos as $i => $v): ?>
            <?php $isOdd = ($i % 2 === 0); ?>
            <div class="col-12">
                <div class="interview-card <?php echo $isOdd ? '' : 'interview-card--alt'; ?>">
                    <div class="row g-0 align-items-center">

                        <!-- Thumbnail / Embed -->
                        <div class="col-12 col-md-5 <?php echo $isOdd ? 'order-md-2' : 'order-md-1'; ?>">
                            <div class="interview-thumb" data-video-id="<?php echo htmlspecialchars($v['id']); ?>">
                                <img src="https://img.youtube.com/vi/<?php echo $v['id']; ?>/hqdefault.jpg"
                                     alt="<?php echo htmlspecialchars($v['title']); ?>"
                                     class="interview-thumb-img" loading="lazy">
                                <button class="play-btn" aria-label="تشغيل الفيديو">
                                    <i class="fas fa-play"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Text -->
                        <div class="col-12 col-md-7 <?php echo $isOdd ? 'order-md-1' : 'order-md-2'; ?>">
                            <div class="interview-info">
                                <span class="interview-number"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
                                <h2 class="interview-vid-title"><?php echo htmlspecialchars($v['title']); ?></h2>
                                <p class="interview-desc"><?php echo htmlspecialchars($v['desc']); ?></p>
                                <a href="https://www.youtube.com/watch?v=<?php echo $v['id']; ?>"
                                   target="_blank" class="interview-yt-btn">
                                    <i class="fab fa-youtube me-2"></i> مشاهدة على يوتيوب
                                </a>
                            </div>
                        </div>

                    </div>
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

<!-- Lightbox overlay for in-page playback (JS in main.js handles click) -->
<div id="video-overlay" class="video-overlay" style="display:none;">
    <div class="video-overlay-inner">
        <button class="video-close" id="video-close-btn"><i class="fas fa-times"></i></button>
        <div class="ratio ratio-16x9">
            <iframe id="video-iframe" src="" allowfullscreen frameborder="0"></iframe>
        </div>
    </div>
</div>
