<?php // templates/footer.php ?>
<footer>
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> د. عبد الكريم الشويطر. جميع الحقوق محفوظة.</p>
        <img src="cropped-untitled-320-x-480-px-640-x-960-px1-1.png" 
             alt="شعار الموقع" height="45" style="border-radius:8px;">
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
<?php if (isset($extra_js)) echo $extra_js; ?>
