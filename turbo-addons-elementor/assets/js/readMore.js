(function ($) {
    'use strict';

    const initReadMore = function (scope) {
        $(scope).find('.trad-read-more-button').each(function () {
            const button      = $(this);
            const parent      = button.closest('.trad-read-more-description-wrapper');
            const description = parent.find('.trad-read-more-description');
            const fullEl      = parent.find('.trad-read-more-description-full');
            const descEl      = description[0];
            if (!descEl) return;

            // Short excerpt is rendered in the DOM; full rich content lives in the hidden template.
            const shortText = description.text().trim();
            const fullHtml  = fullEl.length ? fullEl.html() : descEl.innerHTML;

            // Measure the collapsed height from the current (short) content.
            descEl.style.maxHeight = 'none';
            const collapsedHeight = descEl.scrollHeight;
            descEl.style.maxHeight = collapsedHeight + 'px';

            let collapseTimer = null;
            let onCollapseEnd = null;

            const cancelCollapseSwap = function () {
                if (onCollapseEnd) {
                    descEl.removeEventListener('transitionend', onCollapseEnd);
                    onCollapseEnd = null;
                }
                if (collapseTimer) {
                    clearTimeout(collapseTimer);
                    collapseTimer = null;
                }
            };

            const buildButton = function (expanded) {
                const iconClass = expanded
                    ? (button.data('less-icon') || '')
                    : (button.data('more-icon') || '');
                const label = expanded
                    ? (button.data('less-text') || '')
                    : (button.data('more-text') || '');
                const iconPos = button.data('icon-position') || 'before';
                const icon = iconClass.trim()
                    ? $('<i>').addClass(iconClass.trim()).attr('aria-hidden', 'true')
                    : null;

                button.empty().attr('aria-expanded', expanded ? 'true' : 'false');

                if (icon) {
                    if (iconPos === 'after') {
                        button.append(document.createTextNode(label)).append(icon);
                    } else {
                        button.append(icon).append(document.createTextNode(label));
                    }
                } else {
                    button.text(label);
                }
            };

            button.off('click').on('click', function () {
                cancelCollapseSwap();
                const isExpanded = description.hasClass('trad-read-more-expanded');

                if (!isExpanded) {
                    // Expand: swap in full rich content and animate height up.
                    descEl.innerHTML = fullHtml;
                    descEl.style.maxHeight = 'none';
                    const fullHeight = descEl.scrollHeight;
                    descEl.style.maxHeight = collapsedHeight + 'px';
                    void descEl.offsetHeight; // force reflow
                    descEl.style.maxHeight = fullHeight + 'px';

                    description.addClass('trad-read-more-expanded').removeClass('trad-read-more-collapsed');
                    buildButton(true);
                } else {
                    // Collapse: keep full content (clipped) while max-height animates down,
                    // then swap to the short excerpt only after the transition ends.
                    descEl.style.maxHeight = descEl.scrollHeight + 'px';
                    void descEl.offsetHeight; // force reflow
                    descEl.style.maxHeight = collapsedHeight + 'px';

                    description.removeClass('trad-read-more-expanded').addClass('trad-read-more-collapsed');
                    buildButton(false);

                    const finish = function () {
                        if (onCollapseEnd) {
                            descEl.removeEventListener('transitionend', onCollapseEnd);
                            onCollapseEnd = null;
                        }
                        if (collapseTimer) {
                            clearTimeout(collapseTimer);
                            collapseTimer = null;
                        }
                        // Abort if the user re-expanded during the animation.
                        if (description.hasClass('trad-read-more-expanded')) return;
                        descEl.textContent = shortText;
                        descEl.style.maxHeight = collapsedHeight + 'px';
                    };

                    const duration = (parseFloat(window.getComputedStyle(descEl).transitionDuration) * 1000) || 400;

                    onCollapseEnd = function (e) {
                        if (e && e.propertyName && e.propertyName !== 'max-height') return;
                        finish();
                    };
                    descEl.addEventListener('transitionend', onCollapseEnd);
                    collapseTimer = setTimeout(finish, duration + 80);
                }
            });
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/trad-read-more.default', initReadMore);
    });
})(jQuery);
