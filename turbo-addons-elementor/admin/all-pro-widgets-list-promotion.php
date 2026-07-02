<?php
namespace Turbo_Addons;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class ProPromotion {
      public static function get_pro_promtion_lists() {
        // Get saved extensions from DB
        $pro_wid_list = get_option('turbo_addons_extensions', []);

        $all_pro_list = [
    // 3D Elements
    'trad_3d_carousel' => __('3D Carousel', 'turbo-addons-elementor'),
    'trad-flip-box' => __('3D Flip Box', 'turbo-addons-elementor'),
    'trad-flip-book' => __('PDF Flip Book', 'turbo-addons-elementor'),
    
    // Sliders
    'trad_testimonial_slider' => __('Testimonial Slider', 'turbo-addons-elementor'),
    'hero-slider' => __('Hero Slider', 'turbo-addons-elementor'),
    'image-auto-scrolling' => __('Image Auto Scroll', 'turbo-addons-elementor'),
    
    // Date & Time
    'turbo-date-time' => __('Local Date', 'turbo-addons-elementor'),
    'turbo-post-date' => __('Post Date', 'turbo-addons-elementor'),
    
    // Post Elements
    'category-post-count' => __('Post Count', 'turbo-addons-elementor'),
    'post-list' => __('Post List', 'turbo-addons-elementor'),
    'advance-featured-card' => __('Advance Featured Card', 'turbo-addons-elementor'),
    'category-filter-tab' => __('Advance Post Filter', 'turbo-addons-elementor'),
    'list-icon' => __('List Icon', 'turbo-addons-elementor'),
    
    // WooCommerce Elements
    'woo-product-card' => __('Woo Products Card', 'turbo-addons-elementor'),
    'woo-product-pagination' => __('WOO Product Pagination', 'turbo-addons-elementor'),
    'woo-category' => __('WOO Category', 'turbo-addons-elementor'),
    'woo-mini-cart' => __('WOO Mini Cart', 'turbo-addons-elementor'),
    'woo-product-breadcrumb' => __('WOO Product Breadcrumb', 'turbo-addons-elementor'),
    'woo-product-button' => __('WOO BuyNow Button', 'turbo-addons-elementor'),
    'woo-product-cart' => __('WOO Product Add to Cart', 'turbo-addons-elementor'),
    'woo-product-description' => __('WOO Product Description', 'turbo-addons-elementor'),
    'woo-product-image' => __('WOO Product Image', 'turbo-addons-elementor'),
    'woo-product-meta' => __('WOO Product Meta', 'turbo-addons-elementor'),
    'woo-product-navigation' => __('WOO Product Navigation', 'turbo-addons-elementor'),
    'woo-product-price' => __('WOO Product Price', 'turbo-addons-elementor'),
    'woo-product-rating' => __('WOO Product Rating', 'turbo-addons-elementor'),
    'woo-product-related' => __('WOO Product Related', 'turbo-addons-elementor'),
    'woo-product-short-description' => __('WOO Product Short Description', 'turbo-addons-elementor'),
    'woo-product-stock' => __('WOO Product Stock', 'turbo-addons-elementor'),
    'woo-product-tab' => __('WOO Product Tabs', 'turbo-addons-elementor'),
    'woo-product-title' => __('WOO Product Title', 'turbo-addons-elementor'),
    
    // Utility Elements
    'tour-guide' => __('Tour Guide', 'turbo-addons-elementor'),
    'text-gradient' => __('Text Gradient', 'turbo-addons-elementor'),
    'csv-data-table' => __('CSV Data Table', 'turbo-addons-elementor'),
    'trad-advanced-search' => __('Advanced Search', 'turbo-addons-elementor'),
    'trad-off-canvas' => __('Off-Canvas', 'turbo-addons-elementor'),
    'trad-whatsapp' => __('WhatsApp', 'turbo-addons-elementor'),
    'trad-hotspot' => __('Image Hotspot', 'turbo-addons-elementor'),
];

        // 🟢 Logic: user controls activation manually — nothing auto-enabled
        return [
            'pro_wid_list'     => $pro_wid_list,
            'all_pro_list' => $all_pro_list,
        ];
    }

}
