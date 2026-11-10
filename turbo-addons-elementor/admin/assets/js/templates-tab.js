/**
 * Turbo Addons — dashboard "Templates" tab: search, category filter and pagination.
 * Shared by the free and Pro dashboards (moved out of admin-script.js in 1.9.6).
 */
/* ============================================================
   Templates tab search, category filter and pagination
   ============================================================ */
document.addEventListener('DOMContentLoaded', function () {
    var grid = document.getElementById('trad-tmpl-grid');
    var searchInput = document.getElementById('trad-template-search');
    var categoryFilter = document.getElementById('trad-template-category-filter');
    var paginationWrap = document.getElementById('trad-tmpl-pagination');
    var resultsCount = document.getElementById('trad-tmpl-results-count');
    var emptyState = document.getElementById('trad-tmpl-empty');

    if ( ! grid || ! searchInput || ! categoryFilter || ! paginationWrap ) return;

    var cards = Array.prototype.slice.call(grid.querySelectorAll('.trad-tmpl-card'));
    var pageSize = 10;
    var currentPage = 1;
    var filteredCards = cards.slice();

    function normalize(value) {
        return (value || '').toString().toLowerCase().trim();
    }

    function renderPagination(totalPages, page) {
        paginationWrap.innerHTML = '';

        if ( totalPages <= 1 ) {
            return;
        }

        var prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = 'trad-tmpl-page-btn';
        prevBtn.textContent = '← Prev';
        prevBtn.disabled = page === 1;
        prevBtn.addEventListener('click', function () {
            if ( page > 1 ) {
                renderPage(page - 1);
            }
        });
        paginationWrap.appendChild(prevBtn);

        for ( var i = 1; i <= totalPages; i++ ) {
            var pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            pageBtn.className = 'trad-tmpl-page-btn';
            if ( i === page ) {
                pageBtn.classList.add('is-active');
            }
            pageBtn.textContent = i;
            pageBtn.setAttribute('data-page', i);
            pageBtn.addEventListener('click', function () {
                renderPage(parseInt(this.getAttribute('data-page'), 10));
            });
            paginationWrap.appendChild(pageBtn);
        }

        var nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = 'trad-tmpl-page-btn';
        nextBtn.textContent = 'Next →';
        nextBtn.disabled = page === totalPages;
        nextBtn.addEventListener('click', function () {
            if ( page < totalPages ) {
                renderPage(page + 1);
            }
        });
        paginationWrap.appendChild(nextBtn);
    }

    function renderPage(page) {
        var totalPages = Math.max(1, Math.ceil(filteredCards.length / pageSize));
        page = Math.min(Math.max(1, page), totalPages);
        currentPage = page;

        cards.forEach(function (card) {
            card.style.display = 'none';
        });

        var startIndex = (page - 1) * pageSize;
        var endIndex = startIndex + pageSize;

        filteredCards.slice(startIndex, endIndex).forEach(function (card) {
            card.style.display = 'flex';
        });

        if ( resultsCount ) {
            if ( filteredCards.length > 0 ) {
                resultsCount.textContent = 'Showing ' + Math.min(endIndex, filteredCards.length) + ' of ' + filteredCards.length + ' templates';
            } else {
                resultsCount.textContent = 'No templates found';
            }
        }

        if ( emptyState ) {
            emptyState.style.display = filteredCards.length > 0 ? 'none' : 'block';
        }

        renderPagination(totalPages, page);
    }

    function applyFilters() {
        var query = normalize(searchInput.value);
        var category = normalize(categoryFilter.value);

        filteredCards = cards.filter(function (card) {
            var cardCategory = normalize(card.getAttribute('data-category'));
            var searchText = normalize(card.getAttribute('data-search'));

            if ( category && category !== 'all' && cardCategory !== category ) {
                return false;
            }

            if ( ! query ) {
                return true;
            }

            return searchText.indexOf(query) !== -1;
        });

        renderPage(1);
    }

    searchInput.addEventListener('input', applyFilters);
    categoryFilter.addEventListener('change', applyFilters);
    applyFilters();
});
