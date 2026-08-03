/**
 * main.js — Shared utilities used across every page.
 * No page-specific logic lives here.
 */

// Scroll-reveal animation for any card elements
function initScrollReveal() {
    const cards = document.querySelectorAll('.article-card, .letter-card, .hub-card, .interview-card, .artwork-card, .book-card, .diwan-card, .about-wrapper, .privacy-panel, .contact-card, .poems-hub-wrapper');
    if (!cards.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08 });

    cards.forEach(card => {
        card.style.opacity    = '0';
        card.style.transform  = 'translateY(20px)';
        card.style.transition = 'opacity 0.45s ease, transform 0.45s ease';
        observer.observe(card);
    });
}

// Close mobile navbar when a link is clicked
function initNavbarAutoClose() {
    const collapseEl = document.querySelector('.navbar-collapse');
    if (!collapseEl) return;

    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.addEventListener('click', (e) => {
            if (link.classList.contains('dropdown-toggle')) return;
            if (collapseEl.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    });

    document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
        item.addEventListener('click', () => {
            if (collapseEl.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    });
}

// Highlight the active dropdown item based on current slug
function highlightActiveDropdownItem() {
    const slug = new URLSearchParams(window.location.search).get('slug');
    if (!slug) return;
    document.querySelectorAll('.dropdown-item').forEach(el => {
        if (el.href.includes(`slug=${slug}`)) el.classList.add('active', 'fw-bold');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initNavbarAutoClose();
    highlightActiveDropdownItem();
});
