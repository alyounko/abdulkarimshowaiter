<?php // templates/footer.php ?>
<footer>
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> د. عبد الكريم الشويطر. جميع الحقوق محفوظة.</p>
        <?php echo picture('cropped-untitled-320-x-480-px-640-x-960-px1-1.png', 'شعار الموقع', '', 'height="45" width="45" style="border-radius:8px;" loading="lazy"'); ?>
    </div>
</footer>

<!-- Floating View Switcher -->
<button class="view-fab" id="viewFab" aria-label="تغيير وضع العرض">
    <i class="fas fa-display"></i>
</button>
<div class="view-panel" id="viewPanel">
    <div class="view-panel-header">
        <span class="view-panel-title">وضع العرض</span>
        <button class="view-panel-close" id="viewPanelClose" aria-label="إغلاق">&times;</button>
    </div>
    <div class="view-panel-body">
        <button class="view-option" data-view="mobile">
            <div class="view-option-icon mobile-icon">
                <i class="fas fa-mobile-screen-button"></i>
            </div>
            <div class="view-option-text">
                <span class="view-option-title">عرض الهاتف</span>
                <span class="view-option-desc">مُحسَّن للشاشات الصغيرة</span>
            </div>
        </button>
        <button class="view-option" data-view="desktop">
            <div class="view-option-icon desktop-icon">
                <i class="fas fa-desktop"></i>
            </div>
            <div class="view-option-text">
                <span class="view-option-title">عرض سطح المكتب</span>
                <span class="view-option-desc">التجربة الكاملة</span>
            </div>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="js/main.min.js?v=50"></script>
<script src="js/lazy-load.min.js"></script>
<script src="js/view-switcher.min.js"></script>
<script src="js/search.js?v=2"></script>
<?php if (isset($extra_js)) echo $extra_js; ?>
