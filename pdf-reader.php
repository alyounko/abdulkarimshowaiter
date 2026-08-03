<?php
$file = isset($_GET['file']) ? trim($_GET['file']) : '';
$from = isset($_GET['from']) ? trim($_GET['from']) : 'books';
if (!$file) {
    header('Location: page.php?slug=books');
    exit;
}

if (!preg_match('#^20\d{2}/\d{2}/[^.]+\.pdf$#i', $file) || strpos($file, '..') !== false) {
    header('Location: page.php?slug=books');
    exit;
}

$back_url = 'page.php?slug=' . urlencode($from);

$book_title = '';
if (file_exists(__DIR__ . '/' . $file)) {
    $basename = pathinfo($file, PATHINFO_FILENAME);
    $decoded = urldecode($basename);
    if (preg_match('/[\x{0600}-\x{06FF}]/u', $decoded)) {
        $book_title = $decoded;
    }
}

$parts = explode('/', $file);
$encoded_parts = array_map('rawurlencode', $parts);
$pdf_url = implode('/', $encoded_parts);

$absolute_url = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $pdf_url;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قراءة - <?php echo htmlspecialchars($book_title ?: 'الكتاب'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Tajawal:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Tajawal', sans-serif; background: #3a3a3a; overflow: hidden; height: 100vh; }

        .reader-toolbar {
            position: fixed; top: 0; left: 0; right: 0; height: 56px;
            background: linear-gradient(135deg, #5c4033, #7a5a3a);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 1rem; z-index: 1000;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3); gap: 0.5rem;
        }
        .toolbar-right, .toolbar-center, .toolbar-left {
            display: flex; align-items: center; gap: 0.5rem;
        }
        .toolbar-title {
            color: #e8dfd2; font-family: 'Amiri', serif;
            font-size: 1rem; font-weight: 600; max-width: 300px;
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .toolbar-divider { width: 1px; height: 24px; background: rgba(255,255,255,0.2); margin: 0 0.25rem; }
        .toolbar-label { color: #e8dfd2; font-size: 0.85rem; }
        .btn-toolbar-action {
            color: #e8dfd2; text-decoration: none; padding: 0.4rem 0.8rem;
            border-radius: 8px; display: flex; align-items: center; gap: 0.3rem;
            font-size: 0.85rem; transition: background 0.2s ease;
        }
        .btn-toolbar-action:hover { background: rgba(255,255,255,0.15); color: #fff; }

        .reader-container {
            position: fixed; top: 56px; left: 0; right: 0; bottom: 0;
        }
        .reader-container iframe {
            width: 100%; height: 100%; border: none;
        }

        .reader-loading {
            position: fixed; inset: 0; top: 56px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: #3a3a3a; z-index: 500;
        }
        .reader-fallback {
            position: fixed; inset: 0; top: 56px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: #3a3a3a; z-index: 400;
        }

        @media (max-width: 768px) {
            .reader-toolbar { flex-wrap: wrap; height: auto; padding: 0.5rem; gap: 0.4rem; }
            .toolbar-right, .toolbar-center, .toolbar-left { width: 100%; justify-content: center; }
            .toolbar-title { display: none; }
            .toolbar-divider { display: none; }
            .reader-container { top: 80px; }
        }
    </style>
</head>
<body>
    <div class="reader-toolbar">
        <div class="toolbar-right">
            <a href="<?php echo $back_url; ?>" class="btn-toolbar-action" aria-label="العودة للكتب">
                <i class="fas fa-arrow-right"></i>
                <span class="toolbar-label">العودة</span>
            </a>
            <span class="toolbar-divider"></span>
            <span class="toolbar-title"><?php echo htmlspecialchars($book_title ?: 'الكتاب'); ?></span>
        </div>
    </div>

    <div class="reader-loading" id="loading">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">جاري التحميل...</span>
        </div>
        <p class="mt-2 text-muted">جاري تحميل الكتاب...</p>
    </div>

    <div class="reader-container" id="readerContainer">
        <iframe src="<?php echo htmlspecialchars($absolute_url); ?>" id="pdfFrame" title="عرض الكتاب"></iframe>
        <div class="reader-fallback" id="readerFallback" style="display:none;">
            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
            <p class="text-white mb-3">لا يمكن عرض الكتاب في المتصفح</p>
            <a href="<?php echo htmlspecialchars($absolute_url); ?>" class="btn btn-warning px-4 py-2 rounded-pill" download>
                <i class="fas fa-download ms-2"></i> تحميل الكتاب
            </a>
            <a href="<?php echo htmlspecialchars($absolute_url); ?>" class="btn btn-outline-light px-4 py-2 rounded-pill ms-2" target="_blank">
                <i class="fas fa-external-link-alt ms-2"></i> فتح في نافذة جديدة
            </a>
        </div>
    </div>

    <script>
    (function() {
        var frame = document.getElementById('pdfFrame');
        var loading = document.getElementById('loading');
        var fallback = document.getElementById('readerFallback');
        var loadTimer = setTimeout(function() {
            loading.style.display = 'none';
        }, 5000);
        frame.addEventListener('load', function() {
            clearTimeout(loadTimer);
            loading.style.display = 'none';
            try {
                var body = frame.contentDocument || frame.contentWindow.document;
                if (!body || !body.body || body.body.innerHTML.length < 10) {
                    frame.style.display = 'none';
                    fallback.style.display = 'flex';
                }
            } catch(e) {
                frame.style.display = 'none';
                fallback.style.display = 'flex';
            }
        });
        frame.addEventListener('error', function() {
            frame.style.display = 'none';
            fallback.style.display = 'flex';
        });
    })();
    </script>
</body>
</html>
