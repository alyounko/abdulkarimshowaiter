(function() {
    'use strict';

    var toggle = document.getElementById('searchToggle');
    var expand = document.getElementById('searchExpand');
    var input = document.getElementById('globalSearchInput');
    var results = document.getElementById('searchResults');
    var wrapper = document.getElementById('searchWrapper');
    var isOpen = false;
    var debounceTimer = null;
    var currentRequest = null;

    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        isOpen = !isOpen;
        wrapper.classList.toggle('active', isOpen);
        if (isOpen) {
            setTimeout(function() { input.focus(); }, 100);
        } else {
            input.value = '';
            results.innerHTML = '';
            results.style.display = 'none';
        }
    });

    document.addEventListener('click', function(e) {
        if (!wrapper.contains(e.target)) {
            isOpen = false;
            wrapper.classList.remove('active');
            input.value = '';
            results.innerHTML = '';
            results.style.display = 'none';
        }
    });

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        var query = input.value.trim();
        if (query.length < 2) {
            results.innerHTML = '';
            results.style.display = 'none';
            return;
        }
        debounceTimer = setTimeout(function() { doSearch(query); }, 250);
    });

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            input.value = '';
            results.innerHTML = '';
            results.style.display = 'none';
        }
    });

    function doSearch(query) {
        if (currentRequest) currentRequest.abort();
        var xhr = new XMLHttpRequest();
        currentRequest = xhr;
        xhr.open('GET', 'search.php?q=' + encodeURIComponent(query), true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState !== 4) return;
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    showResults(data, query);
                } catch (e) {
                    results.innerHTML = '<div class="search-no-results">خطأ في البحث</div>';
                    results.style.display = 'block';
                }
            }
        };
        xhr.send();
    }

    function showResults(items, query) {
        if (items.length === 0) {
            results.innerHTML = '<div class="search-no-results">لا توجد نتائج</div>';
            results.style.display = 'block';
            return;
        }

        var html = '';
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var title = highlightText(item.title, query);
            var excerpt = highlightText(item.excerpt, query);
            html += '<a href="' + escapeHtml(item.url) + '" class="search-result-item">' +
                        '<div class="search-result-title">' + title + '</div>' +
                        '<div class="search-result-excerpt">' + excerpt + '</div>' +
                    '</a>';
        }
        results.innerHTML = html;
        results.style.display = 'block';
    }

    function highlightText(text, query) {
        if (!text) return '';
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        var safe = div.innerHTML;
        var escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        var regex = new RegExp('(' + escaped + ')', 'gi');
        return safe.replace(regex, '<mark>$1</mark>');
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }
})();
