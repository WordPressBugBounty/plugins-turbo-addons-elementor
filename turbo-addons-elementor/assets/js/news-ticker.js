jQuery(window).on('elementor/frontend/init', function () {
    function initNewsTicker($scope) {
        const $ticker = $scope.find('.trad-news-ticker-init');

        $ticker.each(function () {
            const id = jQuery(this).attr('id');
            const tickerData = window.taNewsTickers?.find(t => t.id === id);

            if (!tickerData) {
                console.warn('No ticker data found for', id);
                return;
            }

            // Prevent double initialization
            if (jQuery(this).data('initialized')) return;

            if (typeof jQuery(this).easyNewsTicker !== 'function') {
                console.error("❌ easyNewsTicker plugin not loaded.");
                return;
            }

            jQuery(this).data('initialized', true);

            jQuery(this).easyNewsTicker({
                animation: {
                    effect: tickerData.effect || 'scroll',
                    easing: "easeInOutExpo",
                    duration: 1000
                },
                data: tickerData.data || []
            });
        });
    }

    // Init when widget renders
    elementorFrontend.hooks.addAction('frontend/element_ready/trad-news-ticker.default', function ($scope) {
        initNewsTicker($scope);
    });

    // Re-init when control panel changes in editor
    if (window.elementorFrontend?.isEditMode()) {
        elementorFrontend.on('elementor/panel/open_editor', () => {
            setTimeout(() => {
                jQuery('.trad-news-ticker-init').removeData('initialized');
                jQuery('.elementor-widget-trad-news-ticker').each(function () {
                    initNewsTicker(jQuery(this));
                });
            }, 300);
        });
    }
});
