jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/trad-counter.default', function ($scope, $) {
        $scope.find('.trad-counter-value').each(function () {
            const $counter = $(this).find('.trad-count-number');
            const start = parseInt($(this).data('start')) || 0;
            const end = parseInt($(this).data('end')) || 100;
            const duration = parseInt($(this).data('duration')) || 2000;
            const separator = $(this).data('separator') || '';

            $({ countNum: start }).animate({ countNum: end }, {
                duration: duration,
                easing: 'swing',
                step: function () {
                    let val = Math.floor(this.countNum);
                    if (separator && typeof val === 'number') {
                        val = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, separator);
                    }
                    $counter.text(val);
                },
                complete: function () {
                    let val = end;
                    if (separator && typeof val === 'number') {
                        val = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, separator);
                    }
                    $counter.text(val);
                }
            });
        });
    });
});
