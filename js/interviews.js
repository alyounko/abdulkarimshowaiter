/**
 * interviews.js — Video lightbox for the Interviews page.
 * Handles click-to-play YouTube embed in an overlay.
 */

document.addEventListener('DOMContentLoaded', () => {
    const thumbs   = document.querySelectorAll('.interview-thumb');
    const overlay  = document.getElementById('video-overlay');
    const iframe   = document.getElementById('video-iframe');
    const closeBtn = document.getElementById('video-close-btn');

    if (!thumbs.length || !overlay) return;

    function openVideo(videoId) {
        iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
        overlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeVideo() {
        iframe.src = '';
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            const id = thumb.dataset.videoId;
            if (id) openVideo(id);
        });
    });

    closeBtn?.addEventListener('click', closeVideo);
    overlay.addEventListener('click', e => { if (e.target === overlay) closeVideo(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeVideo(); });
});
