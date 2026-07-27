/**
 * home.js — Homepage article loader.
 * Handles dynamic "Load More" pagination via the api.php JSON endpoint.
 */

let currentPage = 1;
let isLoading   = false;

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

async function fetchArticles() {
    if (isLoading) return;
    const container = document.getElementById('articles-container');
    const loader    = document.getElementById('loader');
    const btn       = document.getElementById('load-more-btn');
    if (!container) return;

    isLoading = true;
    if (btn) btn.style.display = 'none';
    if (loader) loader.style.display = 'block';

    try {
        const res  = await fetch(`api.php?page_num=${currentPage}`);
        const data = await res.json();

        if (data.length === 0) {
            if (btn) btn.textContent = 'لا توجد مزيد من المقالات';
            return;
        }

        data.forEach(item => {
            const col = document.createElement('div');
            col.className = 'col-lg-4 col-md-6 mb-4';
            const dateHtml = item.published_date
                ? `<div class="small text-muted mb-2"><i class="far fa-calendar-alt ms-1"></i> ${item.published_date}</div>`
                : '';
            col.innerHTML = `
                <div class="article-card card h-100">
                    <div class="card-body d-flex flex-column">
                        ${dateHtml}
                        <h3 class="card-title h5">
                            <a href="page.php?slug=${encodeURIComponent(item.slug)}">${escapeHtml(item.title || 'بدون عنوان')}</a>
                        </h3>
                        <p class="card-text text-muted flex-grow-1">${escapeHtml(item.excerpt)}</p>
                        <div class="mt-3">
                            <a href="page.php?slug=${encodeURIComponent(item.slug)}" class="btn btn-gold w-100">اقرأ المزيد</a>
                        </div>
                    </div>
                </div>`;
            container.appendChild(col);
        });

        currentPage++;
        const badge = document.getElementById('totalItemsBadge');
        if (badge) badge.textContent = container.children.length + '+';

    } catch (err) {
        console.error('Load error:', err);
        if (btn) btn.textContent = 'حدث خطأ، حاول مجدداً';
    } finally {
        isLoading = false;
        if (loader) loader.style.display = 'none';
        const b = document.getElementById('load-more-btn');
        if (b && !['لا توجد مزيد من المقالات', 'حدث خطأ، حاول مجدداً'].includes(b.textContent)) {
            b.style.display = 'inline-block';
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    fetchArticles();
    document.getElementById('load-more-btn')?.addEventListener('click', fetchArticles);
});
