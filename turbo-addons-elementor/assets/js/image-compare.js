(function ($) {
    var imageCompare = function ($scope) {
        var s = $scope.find(".trad-image-compare");
        // console.log('s', s);
        if (s.length > 0) {
            var o = s.data('orientation'),
                ot = s.data('original-text'),
                mt = s.data('modified-text');

            // Initialize twentytwenty plugin
            s.twentytwenty({
                orientation: o, // Orientation of the before and after images ('horizontal' or 'vertical')
                before_label: ot, // Set a custom before label
                after_label: mt  // Set a custom after label
            });
        }
    };

    // Bind to Elementor frontend hooks
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/trad-image-compare.default', imageCompare);
    });
})(jQuery);

