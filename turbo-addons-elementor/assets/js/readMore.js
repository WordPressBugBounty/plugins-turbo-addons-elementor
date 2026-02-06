(function ($) {

    const initializeReadMoreFunctionality = function (scope) {
        const readMoreButtons = $(scope).find('.trad-read-more-button');

        readMoreButtons.each(function () {
            const button = $(this);
            const parent = button.closest('.trad-read-more-description-wrapper');
            const description = parent.find('.trad-read-more-description');

            button.off('click').on('click', function () {
                const isExpanded = description.toggleClass('expanded').hasClass('expanded');

                if (isExpanded) {
                    const icon = $('<i>').addClass(button.data('less-icon'));
                    const text = document.createTextNode(' ' + button.data('less-text'));
                    button.empty().append(icon).append(text);
                    description.text(description.data('full-text'));
                } else {
                    const icon = $('<i>').addClass(button.data('more-icon'));
                    const text = document.createTextNode(' ' + button.data('more-text'));
                    button.empty().append(icon).append(text);
                    description.text(description.data('short-text'));
                }
            });
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', initializeReadMoreFunctionality);
        elementorFrontend.hooks.addAction('frontend/element_ready/trad-read-more.default', initializeReadMoreFunctionality);
    });

})(jQuery);
