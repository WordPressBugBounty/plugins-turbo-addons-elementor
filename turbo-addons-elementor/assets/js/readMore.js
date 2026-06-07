(function ($) {

    const initializeReadMoreFunctionality = function (scope) {
        $(scope).find('.trad-read-more-button').each(function () {
            const button      = $(this);
            const parent      = button.closest('.trad-read-more-description-wrapper');
            const description = parent.find('.trad-read-more-description');
            const descEl      = description[0];

            const shortText = description.data('short');
            const fullText  = description.data('full');

            // Step 1: measure full height (full text is in DOM right now)
            descEl.style.maxHeight = 'none';
            var fullHeight = descEl.scrollHeight;

            // Step 2: swap to short text, measure collapsed height
            descEl.innerText = shortText;
            var collapsedHeight = descEl.scrollHeight;

            // Step 3: immediately put full text back, restore collapsed max-height
            descEl.innerText = fullText;
            descEl.style.maxHeight = collapsedHeight + 'px';

            button.off('click').on('click', function () {
                var isExpanded = description.hasClass('expanded');

                if (!isExpanded) {
                    // EXPAND: animate to full height
                    description.addClass('expanded');
                    descEl.style.maxHeight = fullHeight + 'px';

                    var lessIcon = $('<i>').addClass(button.data('less-icon'));
                    button.empty().append(lessIcon).append(document.createTextNode(' ' + button.data('less-text')));

                } else {
                    // COLLAPSE: animate back to collapsed height
                    descEl.style.maxHeight = descEl.scrollHeight + 'px'; // lock first
                    descEl.offsetHeight; // reflow

                    descEl.style.maxHeight = collapsedHeight + 'px';
                    description.removeClass('expanded');

                    var moreIcon = $('<i>').addClass(button.data('more-icon'));
                    button.empty().append(moreIcon).append(document.createTextNode(' ' + button.data('more-text')));
                }
            });
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', initializeReadMoreFunctionality);
        elementorFrontend.hooks.addAction('frontend/element_ready/trad-read-more.default', initializeReadMoreFunctionality);
    });

})(jQuery);
