/**
 * privacy.js — Page-specific enhancements for the privacy page.
 */
document.addEventListener('DOMContentLoaded', () => {
    const heroTitle = document.querySelector('.privacy-title');
    const heroSubtitle = document.querySelector('.privacy-subtitle');
    const panel = document.querySelector('.privacy-panel');

    [heroTitle, heroSubtitle, panel].forEach((element, index) => {
        if (!element) return;
        element.style.opacity = '0';
        element.style.transform = 'translateY(14px)';
        element.style.transition = 'opacity 0.45s ease, transform 0.45s ease';
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 120 * index);
    });
});
