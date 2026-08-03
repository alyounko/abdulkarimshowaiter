<?php
// templates/navbar.php
// Expects: $menu_pages (array), $pdo (PDO connection)
?>
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">د. عبد الكريم الشويطر</a>
        <div class="navbar-actions-left">
            <div class="search-wrapper" id="searchWrapper">
                <button class="nav-link search-toggle" id="searchToggle" aria-label="بحث">
                    <i class="fas fa-search"></i>
                </button>
                <div class="search-expand" id="searchExpand">
                    <input type="text" id="globalSearchInput" class="search-global-input" placeholder="ابحث في الموقع..." autocomplete="off" aria-label="بحث في الموقع">
                    <div class="search-results" id="searchResults"></div>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="القائمة">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($current_slug) ? '' : 'active'; ?>" href="index.php">الرئيسية</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        منافذ التصفح
                    </a>
                    <ul class="dropdown-menu scrollable-menu shadow" aria-labelledby="navbarDropdown">
                        <?php foreach($menu_pages as $mpage): ?>
                        <li>
                            <a class="dropdown-item <?php echo (isset($current_slug) && $current_slug === $mpage->slug) ? 'active fw-bold' : ''; ?>"
                               href="page.php?slug=<?php echo htmlspecialchars($mpage->slug); ?>">
                                <?php echo htmlspecialchars($mpage->title ?: 'بدون عنوان'); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
