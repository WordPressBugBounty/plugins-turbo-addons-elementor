jQuery(document).ready(function($) {
    // Tab switching logic
    $('.trad-tab-link').on('click', function(e) {
        e.preventDefault();

        // Remove active class from all tabs and content
        $('.trad-tab-link').removeClass('active');
        $('.trad-tab-content').removeClass('active');

        // Add active class to the clicked tab and corresponding content
        $(this).addClass('active');
        $('#' + $(this).data('tab')).addClass('active');

        // Set the current tab in the hidden input field
        $('#current_tab').val($(this).data('tab'));
        
    });

    // On page load, set the active tab from the hidden input value (if exists)
    var savedTab = $('#current_tab').val();
    if (savedTab) {
        // Remove active class from all tabs and content
        $('.trad-tab-link').removeClass('active');
        $('.trad-tab-content').removeClass('active');

        // Add active class to the saved tab and corresponding content
        $('.trad-tab-link[data-tab="' + savedTab + '"]').addClass('active');
        $('#' + savedTab).addClass('active');
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("turbo-dashboard-navbar");
    const contentDetails = document.getElementById("turbo-addons-content-details");
    const sidebarMenu = document.getElementById("turbo-addons-sidebar-menu");
    const toggleInput = document.getElementById("turbo-dashboard-navbar-theme-input");
    const storedTheme = localStorage.getItem("dashboardNavbarTheme");

    // Function to set text color based on background color
    function updateTextColor(element, backgroundColor) {
        if (backgroundColor === "dark") {
            element.style.color = "#eeeeee"; // White text for dark background
        } else {
            element.style.color = "#444444"; // Black text for light background
        }
    }

    // Function to update background and text color for all elements
    function updateColors(backgroundColor) {
        const bgColor = backgroundColor === "dark" ? "#333" : "#ffffff"; // Set background color
        navbar.style.backgroundColor = bgColor;
        contentDetails.style.backgroundColor = bgColor;
        const sidebgColor = backgroundColor === "dark" ? "#101112" : "#d7d7d761";
        sidebarMenu.style.backgroundColor = sidebgColor;

        // Update the text color for the navbar and content details
        updateTextColor(navbar, backgroundColor);
        updateTextColor(contentDetails, backgroundColor);

        // Update the text color for all anchor tags in the sidebar menu
        const anchors = sidebarMenu.querySelectorAll("a");
        anchors.forEach(anchor => updateTextColor(anchor, backgroundColor));

        // Update text color for <h1> and <p> tags in content details
        const headings = contentDetails.querySelectorAll("h1, p, a");
        headings.forEach(heading => updateTextColor(heading, backgroundColor));
    }

    // Apply the stored background color and text color on page load
    if (storedTheme) {
        updateColors(storedTheme); // Apply colors based on stored theme
        toggleInput.checked = storedTheme === "dark";
    }

    // Event listener for toggle change
    toggleInput.addEventListener("change", function () {
        if (toggleInput.checked) {
            // Set dark theme
            localStorage.setItem("dashboardNavbarTheme", "dark");
            updateColors("dark"); // Update colors for dark theme
        } else {
            // Set light theme
            localStorage.setItem("dashboardNavbarTheme", "light");
            updateColors("light"); // Update colors for light theme
        }
    });
});

jQuery(document).ready(function($) {
    $('.trad-alert-dismiss-button').on('click', function() {
        $(this).closest('.trad-alert-updated-div').fadeOut();
    });
});

jQuery(document).ready(function ($) {
    $('#adminmenu .toplevel_page_turbo_addons .wp-menu-image img').addClass('trad-turbo-addon-admin-dashboard-icon');
});


// plugin filter tab sections dom//

document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.trad-widget-tabs-list .trad-widget-filter-tab-item');
    const tabContents = document.querySelectorAll('.trad-widget-tabs-content .trad-widget-tab-content');

    // Ensure all tabs are visible by default
    tabContents.forEach(content => {
        content.classList.add('active');
    });

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetTab = tab.getAttribute('data-tab');

            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));

            // Add active class to clicked tab
            tab.classList.add('active');

            // Scroll to the corresponding tab content
            const targetContent = document.getElementById(targetTab);
            
            // Calculate offset to stop at the title
            const scrollOffset = targetContent.getBoundingClientRect().top + window.scrollY - 140; // Adjust the `-100` for a comfortable margin
            window.scrollTo({
                top: scrollOffset,
                behavior: 'smooth'
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('select-all-widgets');
    const widgetCheckboxes = document.querySelectorAll('.widget-checkbox');

    // Function to update the "Select All" checkbox state
    function updateSelectAllCheckbox() {
        selectAllCheckbox.checked = Array.from(widgetCheckboxes).every(checkbox => checkbox.checked);
    }

    // Function to update individual checkboxes based on "Select All"
    function toggleAllCheckboxes(state) {
        widgetCheckboxes.forEach(checkbox => {
            checkbox.checked = state;
        });
    }

    // Set initial state on page load
    updateSelectAllCheckbox();

    // Add event listener to "Select All" checkbox
    selectAllCheckbox.addEventListener('change', function () {
        toggleAllCheckboxes(selectAllCheckbox.checked);
    });

    // Add event listener to each individual checkbox
    widgetCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectAllCheckbox);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const selectAllExtensions = document.getElementById('select-all-extensions');
    const extensionCheckboxes = document.querySelectorAll('.extension-checkbox');

    // ✅ If extension tab exists
    if (selectAllExtensions && extensionCheckboxes.length > 0) {

        // Update "Select All" when individual checkbox changes
        function updateSelectAllExtension() {
            selectAllExtensions.checked = Array.from(extensionCheckboxes).every(chk => chk.checked);
        }

        // Toggle all extensions
        function toggleAllExtensions(state) {
            extensionCheckboxes.forEach(chk => { chk.checked = state; });
        }

        // ✅ Initial state (page load)
        updateSelectAllExtension();

        // ✅ "Select All" checkbox behavior
        selectAllExtensions.addEventListener('change', function () {
            toggleAllExtensions(selectAllExtensions.checked);
        });

        // ✅ Individual checkbox behavior
        extensionCheckboxes.forEach(chk => {
            chk.addEventListener('change', updateSelectAllExtension);
        });
    }
});

/*****************************************************************************************/









/* ============================================================
   Free plugin — Latest Templates Slider (trad- prefix)
   ============================================================ */
(function () {
    'use strict';

    var templates = window.tradTemplates || [];
    if ( templates.length < 2 ) return;

    var currentIdx = 0;
    var AUTO_DELAY = 4000;
    var autoTimer  = null;

    var slides     = document.querySelectorAll('#trad-tpl-slides .trad-tpl-slide');
    var dots       = document.querySelectorAll('#trad-tpl-dots .trad-tpl-dot');
    var nameEl     = document.getElementById('trad-tpl-name');
    var descEl     = document.getElementById('trad-tpl-desc');
    var catEl      = document.getElementById('trad-tpl-category');
    var typeEl     = document.getElementById('trad-tpl-type');
    var previewBtn = document.getElementById('trad-tpl-preview-btn');
    var currentEl  = document.getElementById('trad-tpl-current');

    function cap(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; }

    function goTo(idx) {
        if ( idx < 0 ) idx = templates.length - 1;
        if ( idx >= templates.length ) idx = 0;

        slides.forEach(function(s, i) { s.classList.toggle('active', i === idx); });
        dots.forEach(function(d, i)   { d.classList.toggle('active', i === idx); });

        var tpl = templates[idx];
        if ( nameEl )     nameEl.textContent     = tpl.title || '';
        if ( descEl )     descEl.textContent     = tpl.desc  || 'A brand-new "' + (tpl.title||'') + '" template is now available.';
        if ( catEl )      catEl.textContent      = cap(tpl.category);
        if ( typeEl )     typeEl.textContent     = cap(tpl.type);
        if ( previewBtn ) previewBtn.href        = tpl.link || '#';
        if ( currentEl )  currentEl.textContent  = idx + 1;

        currentIdx = idx;
    }

    dots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            resetAuto();
            goTo(parseInt(dot.getAttribute('data-index'), 10));
        });
    });

    function startAuto() { autoTimer = setInterval(function() { goTo(currentIdx + 1); }, AUTO_DELAY); }
    function resetAuto()  { clearInterval(autoTimer); startAuto(); }

    startAuto();
}());


/* ============================================================
   "How to Use" button — smooth scroll to video section
   ============================================================ */
document.addEventListener('DOMContentLoaded', function () {
    var btn    = document.querySelector('.trad-scroll-to-video');
    var target = document.getElementById('trad-watch-guide-video');
    if ( ! btn || ! target ) return;

    btn.addEventListener('click', function (e) {
        e.preventDefault();
        var offset    = 80; // WP admin bar height
        var targetTop = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top: targetTop, behavior: 'smooth' });
    });
});

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

// ------------------------------ pro widgets promotion js-----------------------------

// Preview URLs for each pro widget
const TURBO_PRO_PREVIEW_URLS = {
    '3D Carousel': 'https://turbo-addons.com/3d-carousel/',
    '3D Flip Box': 'https://turbo-addons.com/3d-flip-box/',
    'PDF Flip Book': 'https://turbo-addons.com/pdf-flip-book/',
    'Testimonial Slider': 'https://turbo-addons.com/testimonial-slider/',
    'Hero Slider': 'https://turbo-addons.com/hero-slider/',
    'Image Auto Scroll': 'https://turbo-addons.com/image-vertical-scrolling/',
    'Local Date': 'https://turbo-addons.com/local-date/',
    'Post Date': 'https://turbo-addons.com/post-date/',
    'Post Category': 'https://turbo-addons.com/elementor-post-category/',
    'Post List': 'https://turbo-addons.com/post-category-list/',
    'Advance Featured Card': 'https://turbo-addons.com/advance-featured-card/',
    'Post Filter Tab': 'https://turbo-addons.com/post-filter-tab/',
    'Icon List': 'https://turbo-addons.com/icon-list/',
    'Woo Products Card': 'https://turbo-addons.com/woo-products-card/',
    'WOO Product Pagination': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Category Card': 'https://turbo-addons.com/woo-category-card/',
    'WOO Mini Cart': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Breadcrumb': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO BuyNow Button': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Add to Cart': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Description': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Image': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Meta': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Navigation': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Price': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Rating': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Related': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Short Description': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Stock': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Tabs': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'WOO Product Title': 'https://turbo-addons.com/product/apple-reveals-apple-watch-series-7-featuring-a-larger-more/',
    'User Walkthrough': 'https://turbo-addons.com/user-walkthrough/',
    'Text Gradient': 'https://turbo-addons.com/text-gradient/',
    'CSV Data Table': 'https://turbo-addons.com/advanced-table/',
    'Advanced Search': 'https://turbo-addons.com/smart-search-field-advanced-search-field-elementor/',
    'Off-Canvas': 'https://turbo-addons.com/off-canvas/',
    'WhatsApp': 'https://turbo-addons.com/whatsapp-chat/',
    'Image Hotspot': 'https://turbo-addons.com/image-hotspot/'
};

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('turbo-pro-modal');
    if (!modal) return;

    const closeBtn = modal.querySelector('.turbo-modal-close');
    const modalTitle = document.getElementById('turbo-modal-widget-name');
    const previewBtn = document.getElementById('turbo-modal-preview-btn');

    // Find and intercept clicks on all Pro Promotional Cards
    document.querySelectorAll('.pro-promo-card').forEach(function (card) {
        card.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation(); // Stops any tab-switching framework events from triggering
            
            // Get the widget name from the card
            const widgetName = card.getAttribute('data-widget-name');
            
            // Update modal title with widget name
            if (modalTitle) {
                modalTitle.textContent = widgetName;
            }
            
            // Update preview button link
            if (previewBtn) {
                const previewUrl = TURBO_PRO_PREVIEW_URLS[widgetName] || 'https://turbo-addons.com/widgets/';
                previewBtn.href = previewUrl;
            }
            
            modal.classList.add('open');
        });
    });

    // Close on X Button click
    closeBtn.addEventListener('click', function () {
        modal.classList.remove('open');
    });

    // Close when clicking outside content card on the backdrop
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.remove('open');
        }
    });

    // Escape Key compatibility
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('open')) {
            modal.classList.remove('open');
        }
    });
});
