(function ($) {
    function initTypedText($scope) {
        $scope.find('.trad-text-animation-widget').each(function () {
            const $widget = $(this);
            const $target = $widget.find('.trad-text');

            const rawStrings = $target.attr('data-strings');
            let strings = ['Default Text'];
            try {
                if (rawStrings) {
                    const parsed = JSON.parse(rawStrings);
                    if (Array.isArray(parsed)) {
                        strings = parsed;
                    }
                }
            } catch (error) {
                console.error('Invalid JSON in data-strings:', error);
            }

            const typeSpeed = parseInt($target.attr('data-type-speed'), 10) || 100;
            const backSpeed = parseInt($target.attr('data-back-speed'), 10) || 40;
            const loopEnabled = $target.attr('data-loop') === 'true';

            let typedInstance;
            $target.text(''); // Clear any leftover content
            typedInstance = new Typed($target.get(0), {
                strings: strings,
                typeSpeed: typeSpeed,
                backSpeed: backSpeed,
                startDelay: 100,
                backDelay: 1000,
                showCursor: true,
                cursorChar: '|',
                smartBackspace: true,
                loop: false, // we override it manually
                onComplete: function (self) {
                    if (loopEnabled) {
                        setTimeout(() => {
                            self.arrayPos = 0;
                            self.strPos = 0;
                            self.stop(); // stop current instance
                            $target.text(''); // clear text
                            self.begin(); // restart from beginning
                        }, 800);
                    }
                }
            });
            const pauseOnHover = $target.attr('data-pause-hover') === 'true';

            if (pauseOnHover) {
                $widget.on('mouseenter', () => {
                    if (typedInstance) typedInstance.stop();
                });

                $widget.on('mouseleave', () => {
                    if (typedInstance) typedInstance.start();
                });
            }
            
        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/trad_text_animation_widget.default', initTypedText);
    });
})(jQuery);
