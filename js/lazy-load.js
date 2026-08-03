/**
 * lazy-load.js — Lazy-loads CSS background images using Intersection Observer.
 * Elements with class="bg-lazy" and data-bg="path/to/image" will have their
 * background-image set only when they scroll into the viewport.
 */

(function () {
    function initBgLazyLoad() {
        const lazyEls = document.querySelectorAll('.bg-lazy');
        if (!lazyEls.length) return;

        if (!('IntersectionObserver' in window)) {
            // Fallback: load everything immediately
            lazyEls.forEach(function (el) {
                el.style.backgroundImage = "url('" + el.dataset.bg + "')";
                el.classList.remove('bg-lazy');
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    el.style.backgroundImage = "url('" + el.dataset.bg + "')";
                    el.classList.remove('bg-lazy');
                    observer.unobserve(el);
                }
            });
        }, {
            rootMargin: '200px 0px'   // start loading 200px before visible
        });

        lazyEls.forEach(function (el) {
            observer.observe(el);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBgLazyLoad);
    } else {
        initBgLazyLoad();
    }
})();
