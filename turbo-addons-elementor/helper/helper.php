<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
function trad_get_promotion_widgets_data() {
    $category = 'trad-premium-widgets';
    return [
        [
            'name' => 'trad-timeline-story',
            'title' => __('Timeline', 'turbo-addons-elementor'),
            'icon' => 'eicon-post-list trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'trad-progress-milestone',
            'title' => __('Progress Milestones', 'turbo-addons-elementor'),
            'icon' => 'eicon-skill-bar trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'trad-review-archive',
            'title' => __('Review Archive', 'turbo-addons-elementor'),
            'icon' => 'eicon-post-list trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'visitor-count',
            'title' => __('Live Visitor Counter', 'turbo-addons-elementor'),
            'icon' => 'eicon-person trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        // Add additional promotion widgets here
    ];
}

function trad_get_expert_widgets_data() {
    $category = 'trad-premium-widgets';
    return [
        [
            'name' => 'trad_3d_carousel',
            'title' => __('3D Carousel', 'turbo-addons-elementor'),
            'icon' => 'eicon-carousel trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'trad_testimonial_slider',
            'title' => __('Testimonial Slider', 'turbo-addons-elementor'),
            'icon' => 'eicon-post-slider trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'trad-flip-box',
            'title' => __('3D Flip Box', 'turbo-addons-elementor'),
            'icon' => 'eicon-flip-box trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'turbo-date-time',
            'title' => __('Local Date', 'turbo-addons-elementor'),
            'icon' => 'eicon-calendar trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'turbo-post-date',
            'title' => __('Post Date', 'turbo-addons-elementor'),
            'icon' => 'eicon-date trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'category-post-count',
            'title' => __('Post Count', 'turbo-addons-elementor'),
            'icon' => 'eicon-my-account trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'list-icon',
            'title' => __('List Icon', 'turbo-addons-elementor'),
            'icon' => 'eicon-checkbox trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'advance-featured-card',
            'title' => __('Advance Fatured Card', 'turbo-addons-elementor'),
            'icon' => 'eicon-background trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'post-list',
            'title' => __('Post List', 'turbo-addons-elementor'),
            'icon' => 'eicon-posts-masonry trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'category-filter-tab',
            'title' => __('Advance Post Filter', 'turbo-addons-elementor'),
            'icon' => 'eicon-filter trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'image-auto-scrolling',
            'title' => __('Image Auto Scroll', 'turbo-addons-elementor'),
            'icon' => 'eicon-slideshow trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'pricing-table-pro',
            'title' => __('Pricing Table Pro', 'turbo-addons-elementor'),
            'icon' => 'eicon-price-table trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        // 1.6.5
        [
            'name' => 'hero-slider',
            'title' => __('Hero Slider', 'turbo-addons-elementor'),
            'icon' => 'eicon-slider-device trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'tour-guide',
            'title' => __('Tour Guid', 'turbo-addons-elementor'),
            'icon' => 'eicon-notes trad-icon',
            'categories' => '["' . $category . '"]',
        ],
       
        [
            'name' => 'text-gradient',
            'title' => __('Text Gradient', 'turbo-addons-elementor'),
            'icon' => 'eicon-notes trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-card',
            'title' => __('Woo Products Card', 'turbo-addons-elementor'),
            'icon' => 'eicon-single-product trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-pagination',
            'title' => __('WOO Product Pagination', 'turbo-addons-elementor'),
            'icon' => 'eicon-number-field trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-category',
            'title' => __('WOO Category', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-categories trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-mini-cart',
            'title' => __('WOO Mini Cart', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-categories trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-breadcrumb',
            'title' => __('WOO Product Breadcrumb', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-breadcrumbs trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-button',
            'title' => __('WOO BuyNow Button', 'turbo-addons-elementor'),
            'icon' => 'eicon-button trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-cart',
            'title' => __('WOO Product Add to Cart', 'turbo-addons-elementor'),
            'icon' => 'eicon-woo-cart trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-description',
            'title' => __('WOO Product Description', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-description trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-image',
            'title' => __('WOO Product Image', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-images trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-meta',
            'title' => __('WOO Product Meta', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-meta trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-navigation',
            'title' => __('WOO Product Navigation', 'turbo-addons-elementor'),
            'icon' => 'eicon-post-navigation trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-price',
            'title' => __('WOO Product Price', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-price trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-rating',
            'title' => __('WOO Product Rating', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-rating trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-related',
            'title' => __('WOO Product Related', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-related trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-short-description',
            'title' => __('WOO Product Short Description', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-description trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-stock',
            'title' => __('WOO Product Stock', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-stock trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-tab',
            'title' => __('WOO Product Tabs', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-tabs trad-icon',
            'categories' => '["' . $category . '"]',
        ],
        [
            'name' => 'woo-product-title',
            'title' => __('WOO Product Title', 'turbo-addons-elementor'),
            'icon' => 'eicon-product-title trad-icon',
            'categories' => '["' . $category . '"]',
        ],
       
        // Add additional expert widgets here
    ];
}

function trad_get_widget_lists() {
    return [
        'advanced-heading'            => 'advanced-heading.php' ,             // advance heading
        'contact-info'                => 'contact-info.php',                  // contact info widget
        'popular-post'                => 'popular-post.php',                  // Popular Post Widget
        'preview-card'                => 'preview-card.php',                  // Preview card widget
        'pricing-table'               => 'pricing-table.php',                 // Pricing Table Widget
        'text-animation'              => 'text-animation.php',                // Animated Text Widget
        'icon-button'                 => 'icon-button.php',                   // icon button
        'shape-divider'               => 'shape-divider.php',                 // Section Shape Divider Widget
        'countdown-timer'             => 'countdown-timer.php',               // Countdown timer Widget
        'social-bar'                  => 'social-bar.php',                    // Social bar Widget
        'review-star'                 => 'review-star.php',                   // Review star Widget
        'most-top-bar'                => 'most-top-bar.php',                  // Most top bar Widget
        'team-slider'                 => 'team-slider.php',                   // Team slider Widget
        'dual-header'                 => 'dual-header.php',                   // Dual header Widget 
        'info-box'                    => 'info-box.php',                      // Info box Widget
        'business-hour'               => 'business-hour.php',                 // Business hour Widget
        'carousel'                    => 'carousel.php',                      // Carousel Widget 
        'call-to-action'              => 'call-to-action.php',                // Call to action Widget
        'accordion'                   => 'accordion.php',                     // Accordion Widget
        // 'tooltip'                     => 'tooltip.php',                        Tooltip Widget
        // 'accordion'                   => 'accordion.php',                     // Accordion Widget
        'tooltip'                     => 'tooltip.php',                       // Tooltip Widget
        'floating-effect'             => 'floating-effect.php',               // Image floating Widget 
        'image-overlay-effects'       => 'image-overlay-effects.php',         // Image overlay effects widget
        'food-menu'                   => 'food-menu.php',                     // Food Menu widget
        'coupon-code'                 => 'coupon-code.php',                   // Coupon Code widget 
        'single-testimonial'          => 'single-testimonial.php',            // Single testimonial widget
        'data-table'                  => 'data-table.php',                    // Data Table Widget
        'photo-stack'                 => 'photo-stack.php',                   // Photo Stack Widget
        'debit-card'                  => 'debit-card.php',                    // Debit Card Widget
        'image_icon_card'             => 'image_icon_card.php',               // icon card widget
        'copy-right-footer'           => 'copy-right-footer.php',             // Copy Right Footer Widget
        'read-more'                   => 'read-more.php',                     // Read More Widget
        'google-map'                  => 'google-map.php',                    // Google Map
        'event-calender'              => 'event-calender.php',                // Event Calender
        'image-compare'               => 'image-compare.php',                 // Image Compare
        'advance-search'              => 'advance-search.php',                // Advance Search
        'scroll-to-top'               => 'scroll-to-top.php',                 // Scroll To Top
        'scroll-navigation'           => 'scroll-navigation.php',             // Scroll Navigation
        'cookie-consent'              => 'cookie-consent.php',                // cookie consent
        'navigation-menu'             => 'navigation-menu.php',               // Navigation Menu
        'contact-form-7'              => 'contact-form-7.php',                // Conatct Form 7
        'logo-carousel'               => 'logo-carousel.php',                 // Logo Carousel
        'counter'                     => 'counter.php',                       // Counter
        'news-ticker'                 => 'news-ticker.php',                   // News Ticker
        'audio-player'                => 'audio-player.php',                  // Audio Player
        'advanced-accordion'          => 'advanced-accordion.php',            // Advanced Accordion
        'like-unlike'                 => 'like-unlike.php',                   //Post Like Unlike Counter
    ];
}

function trad_enqueue_scripts_styles() {   

    // preview card
    wp_register_style( 'trad-preview-card-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/preview-card.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/preview-card.css' ), 'all' );

    //Contact info
    wp_register_style( 'trad-section-contact-info-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/contact-info.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/contact-info.css' ), 'all' );

    //Section-shape-divider
    wp_register_style( 'trad-section-divider-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/section-shape-divider.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/section-shape-divider.css' ), 'all' );

    //Text Animation
    wp_register_style( 'trad-animated-text-effect-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/text-animation.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/text-animation.css' ), 'all' );
    wp_register_script( 'typed-js', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/typed.min.js', [], '2.0.12', true );
    wp_register_script( 'trad-animated-text-effect-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/text-animation.js', [ 'jquery', 'typed-js' ], TRAD_TURBO_ADDONS_PLUGIN_PATH, true );

    //Countdown-timer 
    wp_register_style( 'trad-countdown-timer-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/countdown-timer.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/countdown-timer.css' ), 'all' );
    wp_register_script( 'trad-countdown-timer-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/countdown-timer.js', [], TRAD_TURBO_ADDONS_PLUGIN_PATH, true );

    //Social bar
    wp_register_style( 'trad-social-bar-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/social-bar.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/social-bar.css' ), 'all' );

    //Review star
    wp_register_style( 'trad-review-star-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/review-star.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/review-star.css' ), 'all' );

    //Team slider
    wp_register_style( 'trad-team-slider-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/team-slider.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/team-slider.css' ), 'all' );
    wp_register_script( 'trad-team-slider-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/team-slider.js', [ 'jquery'], TRAD_TURBO_ADDONS_PLUGIN_PATH, true );

    //Dual Header
    wp_register_style( 'trad-dual-header-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/dual-header.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/dual-header.css' ), 'all' );

    //Info Box
    wp_register_style( 'trad-info-box-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/info-box.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/info-box.css' ), 'all' );

    //Business hour
    wp_register_style( 'trad-business-hour-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/business-hour.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/business-hour.css' ), 'all' );

    //Owl Carousel
    wp_register_style( 'trad-owl-carousel-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/owl/css/owl.carousel.min.css', [], '2.3.4', 'all' );
    wp_register_script( 'trad-owl-carousel-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/owl/js/owl.carousel.min.js', [ 'jquery'], TRAD_TURBO_ADDONS_PLUGIN_PATH, true );
    wp_register_style( 'owl-carousel-theme', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/owl/css/owl.theme.default.min.css', [''], '2.3.4', 'all' );

    //Call to action
    wp_register_style( 'trad-call-to-action-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/call-to-action.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/call-to-action.css' ), 'all' );

    // Accordion
    wp_register_style( 'trad-accordion-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/trad_accordion.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/trad_accordion.css' ), 'all' );
    // wp_register_script( 'trad-accordion-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/accordion.js', [ 'jquery'], TRAD_TURBO_ADDONS_PLUGIN_PATH, true );

    //Tooltip
    // wp_enqueue_style( 'trad-tooltip-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/tooltip.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/tooltip.css' ), 'all' );

    //Floating Effects
    wp_register_style( 'trad-floating-effect-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/trad-floating-effect.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/trad-floating-effect.css' ), 'all' );
    
    //Image overlay effects
    wp_register_style( 'trad-image-overlay-effects-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/image-overlay-effects.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/image-overlay-effects.css' ), 'all' );

    //Food menu
    wp_register_style( 'trad-food-menu-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/food-menu.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/food-menu.css' ), 'all' );

    //Coupon code
    wp_register_style( 'trad-coupon-code-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/coupon-code.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/coupon-code.css' ), 'all' );
    wp_register_script( 'trad-coupon-code-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/coupon-code.js', [ 'jquery'], TRAD_TURBO_ADDONS_PLUGIN_PATH, true );

    //Single testimonial
    wp_register_style( 'trad-single-testimonial-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/single-testimonial.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/single-testimonial.css' ), 'all' );

    //Data Table
    wp_register_style( 'trad-data-table-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/data-table.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/data-table.css' ), 'all' );
    
    //Photo Stack
    wp_register_style( 'trad-photo-stack-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/photo-stack.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/photo-stack.css' ), 'all' );

    //Bank Card
    wp_register_style( 'trad-debit-card-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/debit-card.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/debit-card.css' ), 'all' );
    
    
    //Image icon card
    wp_register_style( 'trad-image-icon-card-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/image_icon_card.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/image_icon_card.css' ), 'all' );

    //Read More
    wp_register_style( 'trad-read-more-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/read-more.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/read-more.css' ), 'all' );
    wp_register_script( 'trad-read-more-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/readMore.js',[ 'jquery'], TRAD_TURBO_ADDONS_PLUGIN_PATH, true );

    //Event Calender
    wp_register_style( 'trad-event-calender-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/event-calender.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/event-calender.css' ), 'all' );
    wp_register_script('trad-moment-script',TRAD_TURBO_ADDONS_PLUGIN_URL. 'assets/css/vendor/calendar/moment.min.js', [], '2.29.1', true);
    wp_register_script('trad-fullcalendar-script', TRAD_TURBO_ADDONS_PLUGIN_URL. 'assets/css/vendor/calendar/fullcalendar.min.js', ['jquery', 'moment'], '3.10.2', true);
    wp_register_style('trad-fullcalendar-style',TRAD_TURBO_ADDONS_PLUGIN_URL. 'assets/css/vendor/calendar/fullcalendar.min.css', [], '3.10.2');

    //Image Compare
    wp_register_style( 'trad-image-compare-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/image-compare.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/image-compare.css' ), 'all' );
    wp_register_script( 'trad-image-compare-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/image-compare.js',[ 'jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );
    wp_register_script( 'event-move', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/image-compare/js/jquery.event.move.js', ['jquery'], '1.2.0', true );
    wp_register_script( 'twentytwenty', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/image-compare/js/jquery.twentytwenty.js', ['jquery', 'event-move'], '1.2.0', true );
    wp_register_style( 'twentytwenty', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/image-compare/css/twentytwenty.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/vendor/image-compare/css/twentytwenty.css' ), 'all' );

    //Advance Search
    wp_enqueue_style( 'trad-advance-search-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/advance-search.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/advance-search.css' ), 'all' );
    wp_register_script( 'trad-advance-search-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/advance-search.js',[ 'jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    //Scroll To Top
    wp_register_style( 'trad-scroll-to-top-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/back-to-top.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/back-to-top.css' ), 'all' );

    //Scroll Navigation
    wp_register_style( 'trad-scroll-navigation-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/scroll-navigation.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/scroll-navigation.css' ), 'all' );

    //cookieconsent
    wp_register_style( 'trad-cookie-consent-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/cookie-consent.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/cookie-consent.css' ), 'all' );
    wp_register_script( 'trad-cookieconsent-js', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/cookieconsent/cookieconsent.min.js',[], '3.1.1', true );
    wp_register_script( 'trad-cookie-consent-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/cookie-consent.js',['jquery', 'trad-cookieconsent-js'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    //navigation menu
    wp_register_style( 'trad-navigation-menu-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/navigation-menu.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/navigation-menu.css' ), 'all' );
    wp_register_script( 'trad-navigation-menu-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/navigation-menu.js',[ 'jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    //Contact Form 7
    wp_register_style( 'trad-contact-form-7-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/trad-contact-form-7.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/trad-contact-form-7.css' ), 'all' );

    //pricing table
    wp_register_style( 'trad-pricing-table-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/pricing-table.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/pricing-table.css' ), 'all' );
    
    //logo carousel
    wp_register_style( 'trad-logo-carousel-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/logo-carousel.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/logo-carousel.css' ), 'all' );
    wp_register_script( 'trad-logo-carousel-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/logo-carousel.js',[], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    //Counter
    wp_register_style( 'trad-counter-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/counter.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/counter.css' ), 'all' );
    wp_register_script( 'trad-counter-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/counter.js',['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    //News Ticker
    // Load ticker styles
    wp_register_style('trad-ent-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/vendor/ticker/css/ent-style.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/vendor/ticker/css/ent-style.css' ), 'all' );
    wp_register_style( 'trad-ent-admin', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/vendor/ticker/css/ent-admin.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/vendor/ticker/css/ent-admin.css' ), 'all' );
    wp_register_style( 'trad-ent-style-main', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/vendor/ticker/css/style.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/vendor/ticker/css/style.css' ), 'all' );

    // Prevent WebFont dependency error
    wp_register_script( 'trad-ticker-webfont', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/vendor/ticker/js/webfont.js', [], TRAD_TURBO_ADDONS_PLUGIN_VERSION, false );

    // Load ticker JS
    wp_register_script( 'trad-ent-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/vendor/ticker/js/ent-script.min.js', ['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );
    wp_register_script( 'trad-ent-admin-js', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/vendor/ticker/js/ent-admin.js', ['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    // Your custom ticker init
    wp_register_script( 'trad-news-ticker-init', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/news-ticker.js', ['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    //Icon button
    wp_register_style('trad-icon-button-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/icon-button.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/icon-button.css' ), 'all' );

    //Most Top Bar
    wp_register_style('trad-most-top-bar-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/most-top-bar.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/most-top-bar.css' ), 'all' );

    //Copyright
    wp_register_style('trad-copy-right-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/copy-right.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/copy-right.css' ), 'all' );

    //Advanced Heading
    wp_register_style('trad-advanced-heading-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/advanced-heading.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/advanced-heading.css' ), 'all' );
    
    //popular post
    wp_register_style('trad-popular-post-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/popular-post.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/popular-post.css' ), 'all' );

    //Audio Player
    wp_register_style('trad-audio-player-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/audio-player.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/audio-player.css' ), 'all' );
    wp_register_script( 'trad-audio-player-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/audio-player.js', ['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );
   

    //Advanced accordion
    wp_register_script( 'trad-advanced-accordion-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/advance-accordion.js',['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );
    wp_register_style('trad-advanced-accordion-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/advance-accordion.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/advance-accordion.css' ), 'all' );

    //logo carousel
    wp_register_style( 'trad-image-carousel-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/image-carousel.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/image-carousel.css' ), 'all' );
    wp_register_script( 'trad-image-carousel-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/image-carousel.js',[], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    //post like unlike counter
    wp_register_style( 'trad-post-like-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/custom-css/trad-post-like.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/custom-css/trad-post-like.css' ), 'all' );
    wp_register_script( 'trad-post-like-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/trad-post-like.js',['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

    wp_localize_script(
        'trad-post-like-script',
        'tradPostLike',
        [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('trad_post_like_nonce'),
        ]
    );
}

//----------------------------------------------------------- placeholder image functions--------------------------///
function trad_get_placeholder_image() {
    $placeHolderImg = TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/images/tard-default-image.png';
    // return '<img decoding="async" src="' . esc_url($placeHolderImg) . '" alt="Placeholder Image">';
    return $placeHolderImg;
}

//----------------------------------------------------------- Extensions Loader --------------------------///
function trad_extension_register() {
    $active_extensions = get_option( 'turbo_addons_extensions', [] );
    $available_extensions = [
        'tooltip' => 'class-tooltip-extension.php',
        // Future extensions just add here:
        // 'modal'   => 'class-modal-extension.php',
        // 'sticky'  => 'class-sticky-extension.php',
        // 'copy'    => 'class-copy-to-clipboard-extension.php',
    ];

    foreach ( $available_extensions as $key => $file ) {

        // Skip if this extension is not enabled
        if ( ! in_array( $key, $active_extensions, true ) ) {
            continue;
        }

        $path = TRAD_TURBO_ADDONS_PLUGIN_PATH . 'helper/extensions/' . $file;

        if ( file_exists( $path ) ) {
            require_once $path;

            // Build PSR-4 style class name (e.g. TooltipExtension)
            $class_name = '\\TurboAddons\\Extensions\\' . str_replace(
                ' ',
                '',
                ucwords( str_replace( '-', ' ', str_replace( '.php', '', str_replace( 'class-', '', $file ) ) ) )
            );

            // ✅ Step 4: Instantiate the extension class
            if ( class_exists( $class_name ) ) {
                new $class_name();
            }
        }
    }
}
add_action( 'elementor/init', 'trad_extension_register' );  
//----------------------------------------------------------- End Extensions Loader --------------------------///


