/**
 * view-switcher.js — Redirects to ?view=mobile or ?view=desktop.
 * PHP adds html.view-mobile or html.view-desktop class.
 * CSS does all the layout overrides.
 */

(function () {
    var STORAGE_KEY = 'site-view-mode';

    var fab = document.getElementById('viewFab');
    var panel = document.getElementById('viewPanel');
    var closeBtn = document.getElementById('viewPanelClose');
    var options = document.querySelectorAll('.view-option');

    if (!fab || !panel) return;

    function isMobileDevice() {
        return window.innerWidth <= 768;
    }

    function getCurrentView() {
        var p = new URLSearchParams(window.location.search).get('view');
        if (p === 'mobile' || p === 'desktop') return p;
        return null; // no param = natural/default
    }

    function buildUrl(view) {
        var url = new URL(window.location.href);
        url.searchParams.set('view', view);
        return url.toString();
    }

    function setActiveOption(view) {
        options.forEach(function (opt) {
            opt.classList.toggle('active', opt.getAttribute('data-view') === view);
        });
    }

    // --- Determine what "natural" means for this device ---
    function naturalView() {
        return isMobileDevice() ? 'mobile' : 'desktop';
    }

    // --- Init ---
    var currentView = getCurrentView() || naturalView();
    setActiveOption(currentView);

    if (!localStorage.getItem(STORAGE_KEY)) {
        localStorage.setItem(STORAGE_KEY, naturalView());
    }

    // --- Panel toggle ---
    fab.addEventListener('click', function () {
        panel.classList.contains('show') ? closePanel() : openPanel();
    });

    closeBtn.addEventListener('click', closePanel);

    document.addEventListener('click', function (e) {
        if (!panel.contains(e.target) && !fab.contains(e.target)) {
            closePanel();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePanel();
    });

    // --- Option clicks ---
    options.forEach(function (option) {
        option.addEventListener('click', function () {
            var view = option.getAttribute('data-view');
            localStorage.setItem(STORAGE_KEY, view);
            closePanel();

            // Only redirect if switching away from natural view
            if (view !== naturalView()) {
                window.location.href = buildUrl(view);
            } else {
                // Switching back to natural — remove the param
                var url = new URL(window.location.href);
                url.searchParams.delete('view');
                window.location.href = url.toString();
            }
        });
    });

    function openPanel() {
        panel.classList.add('show');
        fab.classList.add('active');
    }

    function closePanel() {
        panel.classList.remove('show');
        fab.classList.remove('active');
    }
})();
