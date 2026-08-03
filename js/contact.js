/**
 * contact.js — Contact page validation and form interaction.
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-form');
    if (!form) return;

    function clearErrors() {
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.field-error-msg').forEach(el => el.remove());
        const topAlert = form.closest('.col-lg-7')?.querySelector('.contact-alert');
        if (topAlert) topAlert.remove();
    }

    function showError(input, msg) {
        input.classList.add('is-invalid');
        const div = document.createElement('div');
        div.className = 'invalid-feedback field-error-msg';
        div.textContent = msg;
        input.parentNode.appendChild(div);
    }

    function showTopAlert() {
        const col = form.closest('.col-lg-7');
        if (!col) return;
        const existing = col.querySelector('.contact-alert');
        if (existing) return;
        const alert = document.createElement('div');
        alert.className = 'contact-alert contact-alert-error';
        alert.innerHTML = '<div class="contact-alert-icon"><i class="fa-solid fa-circle-xmark"></i></div>' +
            '<div class="contact-alert-text"><strong>يرجى تعبئة جميع الحقول بشكل صحيح</strong></div>';
        col.insertBefore(alert, form.closest('.contact-card'));
    }

    form.addEventListener('submit', (event) => {
        clearErrors();
        let hasError = false;

        const name = form.querySelector('[name=name]');
        const email = form.querySelector('[name=email]');
        const message = form.querySelector('[name=message]');
        const emailValue = email?.value.trim();

        if (!name?.value.trim()) {
            showError(name, 'هذا الحقل مطلوب');
            hasError = true;
        }
        if (!emailValue) {
            showError(email, 'هذا الحقل مطلوب');
            hasError = true;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) {
            showError(email, 'أدخل بريداً إلكترونياً صالحاً');
            hasError = true;
        }
        if (!message?.value.trim()) {
            showError(message, 'هذا الحقل مطلوب');
            hasError = true;
        }

        if (hasError) {
            event.preventDefault();
            showTopAlert();
            return false;
        }

        const btn = form.querySelector('[type=submit]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin ms-2"></i> جاري الإرسال...';
        }

        return true;
    });
});
