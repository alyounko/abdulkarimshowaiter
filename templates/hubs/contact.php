<?php
// templates/hubs/contact.php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        $errors[] = 'خطأ في التحقق. يرجى المحاولة مرة أخرى.';
    }

    $name = trim($name);
    $email = trim($email);
    $message = trim($message);

    if ($name === '') {
        $errors[] = 'الاسم مطلوب.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'الرجاء إدخال بريد إلكتروني صالح.';
    }
    if ($message === '') {
        $errors[] = 'الرجاء كتابة الرسالة.';
    }

    if (empty($errors)) {
        $root = realpath(__DIR__ . '/../../');
        $data_dir = $root . '/data';

        if (!is_dir($data_dir)) {
            if (!mkdir($data_dir, 0755, true)) {
                $errors[] = 'خطأ في إنشاء المجلد.';
            }
        }

        if (empty($errors)) {
            $log_entry = sprintf(
                "[%s] %s <%s>\n%s\n---\n",
                date('Y-m-d H:i:s'),
                $name,
                $email,
                $message
            );

            if (file_put_contents($data_dir . '/contact-messages.txt', $log_entry, FILE_APPEND | LOCK_EX) === false) {
                $errors[] = 'خطأ في حفظ الرسالة. يرجى المحاولة لاحقاً.';
            } else {
                unset($_SESSION['csrf_token']);
                header('Location: page.php?slug=contact-us&sent=1');
                exit;
            }
        }
    }
}
?>
<section class="contact-hero py-5">
    <div class="container text-center">
        <h1 class="contact-title">للتواصل مع إدارة الموقع</h1>
        <p class="contact-description">لإبلاغنا عن أي أخطاء أو استفسارات، يرجى استخدام النموذج أدناه.</p>
        <p class="contact-phone"><strong>رقم الهاتف :</strong> 800-403-777 967+</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <?php if (!empty($_GET['sent'])): ?>
                <div class="contact-alert contact-alert-success">
                    <div class="contact-alert-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="contact-alert-text">
                        <strong>تم الإرسال بنجاح</strong>
                        <span>شكراً لتواصلكم معنا. سنعود إليكم في أقرب وقت ممكن.</span>
                    </div>
                </div>
                <script>
                (function(){ history.replaceState(null, '', window.location.pathname + '?slug=contact-us'); })();
                </script>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <?php
                $has_name_error = in_array('الاسم مطلوب.', $errors);
                $has_email_error = in_array('الرجاء إدخال بريد إلكتروني صالح.', $errors);
                $has_message_error = in_array('الرجاء كتابة الرسالة.', $errors);
                ?>
                <div class="contact-alert contact-alert-error">
                    <div class="contact-alert-icon"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div class="contact-alert-text">
                        <strong>يرجى تعبئة جميع الحقول بشكل صحيح</strong>
                    </div>
                </div>
            <?php endif; ?>

            <div class="contact-card p-4 shadow-sm rounded-4">
                <form id="contact-form" method="post" novalidate>
                    <input type="hidden" name="csrf_token"
                           value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="mb-4">
                        <label for="contact-name" class="form-label">الاسم</label>
                        <input id="contact-name" name="name" type="text"
                            class="form-control form-control-lg <?php echo ($errors && $has_name_error) ? 'is-invalid' : ''; ?>"
                            value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" placeholder="أدخل اسمك">
                        <?php if ($errors && $has_name_error): ?>
                            <div class="invalid-feedback">هذا الحقل مطلوب</div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <label for="contact-email" class="form-label">البريد الإلكتروني</label>
                        <input id="contact-email" name="email" type="email"
                            class="form-control form-control-lg <?php echo ($errors && $has_email_error) ? 'is-invalid' : ''; ?>"
                            value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"
                            placeholder="email@example.com">
                        <?php if ($errors && $has_email_error): ?>
                            <div class="invalid-feedback">أدخل بريداً إلكترونياً صالحاً</div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <label for="contact-message" class="form-label">الرسالة</label>
                        <textarea id="contact-message" name="message" rows="7"
                            class="form-control form-control-lg <?php echo ($errors && $has_message_error) ? 'is-invalid' : ''; ?>"
                            placeholder="اكتب رسالتك هنا"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        <?php if ($errors && $has_message_error): ?>
                            <div class="invalid-feedback">هذا الحقل مطلوب</div>
                        <?php endif; ?>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark btn-lg rounded-pill px-5">إرسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>