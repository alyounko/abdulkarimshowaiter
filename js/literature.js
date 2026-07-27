/**
 * literature.js — Specific page behavior for the literary works hub.
 * Adds staggered reveal delay to hub-card elements (already observed by main.js).
 */
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.literature-card');
    if (!cards.length) return;

    cards.forEach((card, index) => {
        card.style.transitionDelay = `${0.08 * index}s`;
    });
});
