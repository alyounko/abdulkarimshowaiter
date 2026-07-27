/**
 * artworks.js — Gallery lightbox for the Art Works page.
 * Supports click-to-open, prev/next navigation, and keyboard arrows.
 */

document.addEventListener('DOMContentLoaded', () => {
    const cards    = document.querySelectorAll('.artwork-card');
    const lightbox = document.getElementById('artwork-lightbox');
    const lbImg    = document.getElementById('lightbox-img');
    const lbLabel  = document.getElementById('lightbox-label');
    const closeBtn = document.getElementById('artwork-close');
    const prevBtn  = document.getElementById('artwork-prev');
    const nextBtn  = document.getElementById('artwork-next');
    const rotateBtn = document.getElementById('rotate-btn');

    if (!cards.length || !lightbox) return;

    let current = 0;
    let rotation = 0;
    const items = Array.from(cards).map(c => ({
        src:   c.dataset.src,
        label: c.dataset.label,
    }));

    function show(index) {
        current = (index + items.length) % items.length;
        lbImg.src            = items[current].src;
        lbLabel.textContent  = items[current].label;
        rotation = 0;
        lbImg.style.transform = 'rotate(0deg)';
    }

    function open(index) {
        show(index);
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lightbox.style.display = 'none';
        document.body.style.overflow = '';
    }

    cards.forEach((card, i) => card.addEventListener('click', () => open(i)));
    closeBtn?.addEventListener('click', close);
    prevBtn?.addEventListener('click', () => show(current - 1));
    nextBtn?.addEventListener('click', () => show(current + 1));
    lightbox.addEventListener('click', e => { if (e.target === lightbox) close(); });

    rotateBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        rotation += 90;
        lbImg.style.transform = `rotate(${rotation}deg)`;
    });

    document.addEventListener('keydown', e => {
        if (lightbox.style.display === 'none') return;
        if (e.key === 'Escape')     close();
        if (e.key === 'ArrowRight') show(current - 1); // RTL: right = previous
        if (e.key === 'ArrowLeft')  show(current + 1);
    });
});
