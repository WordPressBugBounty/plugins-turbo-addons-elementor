<?php
namespace Turbo_Addons;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Helper {
    public static function get_the_widget_lists() {
        
        // Retrieve the current widget settings
        $widgets = get_option('turbo_addons_widgets', []);

        // Default widget list if not set in options
        if (empty($widgets)) {
            $widgets = [
                'advanced-heading',
                'contact-info',
                'popular-post',
                'preview-card',
                'pricing-table',
                'text-animation',
                'icon-button',
                'shape-divider',
                'countdown-timer',
                'social-bar',
                'review-star',
                'most-top-bar',
                'team-slider',
                'dual-header',
                'info-box',
                'business-hour',
                'carousel',
                'call-to-action',
                'accordion',
                'tooltip',
                'floating-effect',
                'image-overlay-effects',
                'food-menu',
                'coupon-code',
                'single-testimonial',
                'data-table',
                'photo-stack',
                'debit-card',
                'image_icon_card',
                'copy-right-footer',
                'read-more',
                'google-map',
                'event-calender',
                'image-compare',
                'advance-search',
                'scroll-to-top',
                'scroll-navigation',
                'cookie-consent',
                'navigation-menu',
                'contact-form-7',
                'logo-carousel',
                'counter',
                'news-ticker',
                'audio-player',
                'advanced-accordion',
                'like-unlike',
            ];
        }

        // Define all available widgets
        $all_widgets = [
            'advanced-heading'         => 'Advanced Heading',
            'contact-info'             => 'Contact Info',
            'popular-post'             => 'Popular Posts',
            'preview-card'             => 'Preview Card',
            'pricing-table'            => 'Pricing Table',
            'text-animation'           => 'Text Animation',
            'icon-button'              => 'Icon Button',
            'shape-divider'            => 'Shape Divider',
            'countdown-timer'          => 'Count Down',
            'social-bar'               => 'Social Bar',
            'review-star'              => 'Review Star',
            'most-top-bar'             => 'Top Bar',
            'team-slider'              => 'Team Slider',
            'dual-header'              => 'Dual Header',
            'info-box'                 => 'Info Box',
            'business-hour'            => 'Business Hour',
            'carousel'                 => 'Image Carousel',
            'call-to-action'           => 'Call To Action',
            'accordion'                => 'Accordion',
            // 'tooltip'                  => 'Turbo Tooltip',
            // 'accordion'                => 'Accordion',
            'tooltip'                  => 'Turbo Tooltip',
            'floating-effect'          => 'Floating Effect',
            'image-overlay-effects'    => 'Image Overlay Effect',
            'food-menu'                => 'Food Menu List',
            'coupon-code'              => 'Coupon Code',
            'single-testimonial'       => 'Single Testimonial',
            'data-table'               => 'Data Table',
            'photo-stack'              => 'Photo Stack',
            'debit-card'               => 'Banking Card',
            'image_icon_card'          => 'Image Icon Card',
            'copy-right-footer'        => 'Copy Right',
            'read-more'                => 'Read More',
            'google-map'               => 'Google Map',
            'event-calender'           => 'Event Calender',
            'image-compare'            => 'Image Compare',
            'advance-search'           => 'Advance Search',
            'scroll-to-top'            => 'Scroll To Top',
            'scroll-navigation'        => 'Scroll Navigation',
            'cookie-consent'           => 'Cookie Consent',
            'navigation-menu'          => 'Navigation Menu',
            'contact-form-7'           => 'Contact Form 7',
            'logo-carousel'            => 'Logo Carousel',
            'counter'                  => 'Counter',
            'news-ticker'              => 'News Ticker',
            'audio-player'             => 'Audio Player',
            'advanced-accordion'      => 'Advanced Accordion',
            'like-unlike'              => 'Post Like Counter',
        ];

        $widget_categories = [
            'CONTENT' => [
                'advanced-heading',
                'google-map',
                'image_icon_card',
                'data-table',
                'single-testimonial',
                'carousel',
                // 'tooltip',
                'accordion',
                'info-box',
                'dual-header',
                'team-slider',
                'review-star',
                'shape-divider',
                'icon-button',
                'preview-card',
                'contact-info',
                'navigation-menu',
                'logo-carousel',
                'advanced-accordion',
            ],
            
            'DYNAMIC CONTENT' => [
                'event-calender',
                'read-more',
                'copy-right-footer',
                'popular-post',
                'contact-form-7',
                'advance-search',
                'like-unlike',
            ],
            'MARKETING' => [
                'debit-card',
                'coupon-code',
                'call-to-action',
                'business-hour',
                'pricing-table',
                'food-menu',
            ],
            'CREATIVE' => [
                'scroll-navigation',
                'scroll-to-top',
                'image-compare',
                'photo-stack',
                'image-overlay-effects',
                'floating-effect',
                'countdown-timer',
                'text-animation',
                'counter',
                'news-ticker',
                'audio-player',
            ],
            'SOCIAL' => [
                'most-top-bar',
                'social-bar',
                'cookie-consent',
            ],
            // 'WOOCOMMERCE' => [
            //     
            //     'food-menu',
            // ],
        ];

        // Return widgets data
        $data = [
            'widgets' => $widgets,
            'all_widgets' => $all_widgets,
            'widget_categories' => $widget_categories
        ];
        
        // Save to database
        // update_option('custom_widget_data', $data);

        return $data;
    }

    public static function get_the_extension_lists() {
        // Get saved extensions from DB
        $extensions = get_option('turbo_addons_extensions', []);

        // Define all available extensions
        $all_extensions = [
            'tooltip' => __( 'Tooltip Extension', 'turbo-addons-elementor' ),
            // future extensions:
            // 'modal'   => __( 'Modal Extension', 'turbo-addons-elementor' ),
            // 'sticky'  => __( 'Sticky Element', 'turbo-addons-elementor' ),
            // 'copy'    => __( 'Copy To Clipboard', 'turbo-addons-elementor' ),
        ];

        // 🟢 Logic: user controls activation manually — nothing auto-enabled
        return [
            'extensions'     => $extensions,
            'all_extensions' => $all_extensions,
        ];
    }

}
