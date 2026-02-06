(function ($) {
    var widgetCookieConsent = function ($scope, $) {
        var $cookieConsent = $scope.find('.trad-cookie-consent');
        var settings = $cookieConsent.data('settings');

        if (!$cookieConsent.length || !settings) {
            // console.warn('Cookie Consent: Element not found or settings missing.');
            return;
        }

        // console.log('Cookie Consent Settings:', settings);

        // Function to check if a cookie exists
        function getCookie(name) {
            let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }

        // Function to set a cookie with expiry
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + value + expires + "; path=/";
        }

        // Check if Accept or Reject cookie exists BEFORE showing the popup
        if (getCookie('trad_cookie_widget_accept') === 'yes' || getCookie('trad_cookie_widget_reject') === 'yes') {
            // console.log('Cookie already set. Hiding consent banner.');
            jQuery('.cc-window').hide();
            return; // Stop execution if already accepted or rejected
        }

        // Ensure window.cookieconsent is available before initializing
        if (typeof window.cookieconsent !== 'undefined') {
            window.cookieconsent.initialise({
                content: {
                    message: settings.content.message,
                    dismiss: settings.content.dismiss,
                    link: settings.content.link,
                    href: settings.content.href
                },
                cookie: {
                    name: "trad_cookie_widget_accept",
                    expiryDays: settings.cookie.expiryDays
                }
            });

            // console.log('Cookie consent initialized successfully');
        } else {
            // console.error('Cookie Consent Library Not Found.');
        }

        // Handle Accept button click (Dismiss Immediately)
        jQuery('.cc-dismiss').off('click').on('click', function (event) {
            event.preventDefault();
            setCookie("trad_cookie_widget_accept", "yes", settings.cookie.expiryDays);
            jQuery('.cc-window').fadeOut(); // Hide immediately
            // console.log('Cookies accepted (accept=yes), popup dismissed');
        });

        // Manually add Reject button if it doesn't exist
        if (!jQuery('.cc-reject').length) {
            // console.log("Adding Reject Button...");
            jQuery('.cc-compliance').append('<a class="cc-btn cc-reject" role="button" tabindex="0">' + settings.content.reject + '</a>');
        }

        // Handle Reject button click
        jQuery('.cc-reject').on('click', function () {
            setCookie("trad_cookie_widget_reject", "yes", settings.cookie.expiryDays);
            jQuery('.cc-window').fadeOut();
            // console.log('Cookies rejected, popup dismissed for ' + settings.cookie.expiryDays + ' days');
        });
    };

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/trad-cookie-consent.default',
            widgetCookieConsent
        );
    });

    // Ensure script runs even outside Elementor
    jQuery(document).ready(function () {
        widgetCookieConsent($('body'));
    });
})(jQuery);
