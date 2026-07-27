<?php
// templates/navbar.php
// Expects: $menu_pages (array), $pdo (PDO connection)
?>
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">د. عبد الكريم الشويطر</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($current_slug) ? '' : 'active'; ?>" href="index.php">الرئيسية</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
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
