<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue necessary styles and scripts
function turbo_addons_admin_enqueue_styles_scripts() {
    wp_enqueue_style( 'turbo-addons-admin-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'admin/assets/css/style.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'admin/assets/css/style.css' ), 'all' );
    wp_enqueue_script('turbo-addons-admin-script', plugin_dir_url(__FILE__) . 'assets/js/admin-script.js', array('jquery'), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'turbo_addons_admin_enqueue_styles_scripts');

// Function to render the admin page
function turbo_addons_admin_page() {
    ?>

    <!-- ----------------------dashboard top section-----------------------------------
     --------------------------------------------------------------------------------// -->
    <div id="turbo-dashboard-navbar">
        <div class="trad-dashboard-top-banner-container">
            <div class="trad-dashboard-top-banner-container-60">
                <!-- <h3> -->
                   <?php 
                  //  $current_user = wp_get_current_user();
                  //  esc_html_e('Hello, ', 'turbo-addons-elementor');
                  //  echo esc_html($current_user->display_name);
                   ?>
                <!-- 👋🏻</h3> -->
                <p style="font-size:18px">Turbo Addons Pro is now available with full <strong>WooCommerce support with custom product pages.</strong> You’ll also get 80+ widgets and 100+ ready templates to speed up your design process.
                </p>
                <p style="font-size:18px;">
                    Upgrade to <strong>Turbo Addons Pro</strong> and unlock the full potential! 🚀  
                    <a class="trad-dashboard-top-message-button" href="https://turbo-addons.com/pricing/" target="_blank">
                        Upgrade Now
                    </a>
                </p>
            </div>
            
            <div class="trad-dashboard-top-banner-container-40">
                <a href="https://wordpress.org/plugins/header-footer-builder-for-elementor/" target="_blank" rel="noopener noreferrer" style="focus:outline:none; text-decoration:none;">
                    <img style="width: 100%" class="turbo-dashboard-banner-add" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/h_and_f_promotion.webp' ); ?>" alt="<?php echo esc_attr( 'turbo-logo' ); ?>">    
                </a>  

            </div>

        </div>
    </div>

      <!-- ----------------------dashboard tab section-----------------------------------
     --------------------------------------------------------------------------------// -->

    <div class="trad_wrap_dashboard turbo-addons-dashboard">
        <?php 
            $current_tab = isset($_POST['current_tab']) ? sanitize_text_field(wp_unslash($_POST['current_tab'])) : 'general-tab'; 
        ?>

        <div class="turbo-addons-sidebar" id="turbo-addons-sidebar-menu">
            <ul class="trad-turbo-dashboard-menu-list">
                <li class="trad-tab-link tab-link active" data-tab="general-tab"><a href="#"><?php esc_html_e('Dashboard', 'turbo-addons-elementor'); ?></a></li>
                <li class="trad-tab-link tab-link" data-tab="elements-tab"><a href="#"><?php esc_html_e('Elements', 'turbo-addons-elementor'); ?></a></li>
                <li class="trad-tab-link tab-link" data-tab="extension-tab"><a href="#"><?php esc_html_e('Extension', 'turbo-addons-elementor'); ?></a></li>
                <li class="trad-tab-link tab-link" data-tab="premium-tab"><a href="#"><?php esc_html_e('Go Premium', 'turbo-addons-elementor'); ?></a></li>
            </ul>
        </div> 


        <div class="turbo-addons-content" id="turbo-addons-content-details">

            <!-- ==tab1======================Dashboard Tab Content
             ============================================================================== -->
             <div id="general-tab" class="trad-tab-content tab-content trad-dashboard-tab <?php echo $current_tab === 'general-tab' ? 'active' : ''; ?>">

             <!-- ------------------tab1-----section  1// ---------------------------->
                <div class="trad-dashboard-sec-one">
                    <div class="trad-dashboard-sec-one-left">
                        <h3 class="trad-dashboard-sub-heading">What's New in Version 1.8.9</h3>
                        <hr>
                        <div class="trad-updated-list">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/updatelist-icon.svg'); ?>" alt="<?php echo esc_attr('update icon'); ?>"> 
                            <div class="trad-updated-list-typography">
                                <h4>Optimized</h4>
                                <p>Plugin performance, security, and code quality</p>
                            </div>
                        </div>
                        <hr>
                        <div class="trad-updated-list">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/updatelist-icon.svg'); ?>" alt="<?php echo esc_attr('update icon'); ?>"> 
                            <div class="trad-updated-list-typography">
                                <h4>Updated</h4>
                                <p>Tested and verified for full compatibility with Elementor version 3.34.1.</p>
                            </div>
                        </div>
                    </div>

                    <div class="trad-dashboard-sec-one-right">
                        <h3 class="trad-dashboard-sub-heading">New Template</h3>
                        <hr>
                        <div class="trad-dashboard-sec1-template-add">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/template1.webp'); ?>" alt="<?php echo esc_attr('new template'); ?>"> 
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/template2.webp'); ?>" alt="<?php echo esc_attr('new template'); ?>"> 
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/template3.webp'); ?>" alt="<?php echo esc_attr('new template'); ?>">   
                        </div>
                        <div class="trad-dashboard-center-btn">
                            <a href="https://turbo-addons.com/templates/" target="_blank" rel="noopener" >Explore All Template ⤴</a>
                        </div>
                    </div>
                </div>
                <!-- ------------------tab1-----section  2// ---------------------------->
                <div class="trad-dashboard-sec-two">
                    <div class="trad-dashboard-sec-two-content">
                        <h3 class="trad-dashboard-sub-heading">Share Your Thoughts</h3>
                        <p>We’d love to hear your feedback! Share your experience with us and help us improve. Your insights make a difference. <br/> Click below to request a review</p>
                        <div class="trad-dashboard-center-btn">
                                <a href="https://wordpress.org/plugins/turbo-addons-elementor/#reviews" target="_blank" rel="noopener" >Request for Review</a>
                        </div>
                    </div>
                </div>

                <!-- ------------------tab1-----section 3// ---------------------------->
                <!-- <div class="trad-dashboard-sec-three">
                    <div class="trad-dashboard-sec-three-promotion-bnr">
                        <img style="width: 360px" class="turbo-dashboard-banner-add" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/seventyoffer.webp' ); ?>" alt="<?php echo esc_attr( 'turbo-logo' ); ?>">    
                        <div class="turbo-dashboard-banner-branding">
                            <h2>🚀 Supercharge with Turbo Addons! 🎨✨</h2>
                            <p>
                                Turbo Addons for Elementor offers advanced widgets to enhance Elementor, helping you <br/>create professional, interactive websites easily and quickly.
                            </p>   
                        </div>

                    </div>
                </div> -->
                <!-- ------------------tab1-----section  4// ---------------------------->
                <div class="trad-dashboard-sec-four">
                    <div class="trad-dashboard-sec-four-card">
                        <h3 class="trad-dashboard-sub-heading">Documentation</h3>
                        <p>
                        Thank you for choosing Turbo Addons! ✨ We're excited to share that our Pro version is now available, loaded with advanced features to take your web design to the next level.
                        </p>  
                        <img class="turbo-dashboard-banner-add" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/documentation.webp' ); ?>" alt="<?php echo esc_attr( 'turbo-logo' ); ?>"> 
                        <div class="trad-dashboard-center-btn">
                            <a href="https://turbo-addons.com/docs/" target="_blank" rel="noopener" >Documentation ⤴</a>
                        </div>
                    </div>
                    <div class="trad-dashboard-sec-four-card">
                        <h3 class="trad-dashboard-sub-heading">Explore 80+ Widgets</h3>
                        <p>
                            Discover a powerful collection of 80+ versatile widgets designed to enhance your website’s functionality, creativity, and user experience.
                        </p>  
                        <img class="turbo-dashboard-banner-add" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/widgets.webp' ); ?>" alt="<?php echo esc_attr( 'turbo-logo' ); ?>"> 
                        <div class="trad-dashboard-center-btn">
                            <a href="https://turbo-addons.com/widgets/" target="_blank" rel="noopener" >Explore⤴</a>
                        </div>
                    </div>
                    <div class="trad-dashboard-sec-four-card">
                        <h3 class="trad-dashboard-sub-heading">Get Support</h3>
                        <p>
                        Get expert guidance, instant support, and personalized insights to troubleshoot issues, explore features, and achieve your goals effortlessly.
                        </p>  
                        <img class="turbo-dashboard-banner-add" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/support.webp' ); ?>" alt="<?php echo esc_attr( 'turbo-logo' ); ?>"> 
                        <div class="trad-dashboard-center-btn">
                            <a href="https://turbo-addons.com/get-support/" target="_blank" rel="noopener" >Get Support ⤴</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ======================tab-2===Elements Tab Content
             ================================================================================ -->
            <div id="elements-tab" class="trad-tab-content tab-content trad-dashboard-elements-tab <?php echo $current_tab === 'elements-tab' ? 'active' : ''; ?>" >
                
                <div class="trad-widgets-section">
                    

                    <form method="post" action="#">
                        <?php
                        wp_nonce_field('save_turbo_addons_widgets', 'turbo_addons_nonce');
                        // Check if the form was submitted
                        if (isset($_POST['save_changes'])) {

                            // Verify nonce to ensure the form submission is secure
                            if (!isset($_POST['turbo_addons_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['turbo_addons_nonce'])), 'save_turbo_addons_widgets')) {
                                wp_die(esc_html__('Nonce verification failed. Please try again.', 'turbo-addons-elementor'));
                            }
            
                            // Apply your line after nonce verification
                            $widgets = isset($_POST['widgets']) && is_array($_POST['widgets']) ? array_map('sanitize_key', wp_unslash($_POST['widgets'])) : [];
                        
                            update_option('turbo_addons_widgets', $widgets);
                            echo '<div class="trad-alert-updated-div updated">
                                <p>' . esc_html__('Widgets saved successfully.', 'turbo-addons-elementor') . '</p>
                                <button class="trad-alert-dismiss-button" type="button">×</button>
                            </div>';

                        }
                      
                        $widget_data = Turbo_Addons\Helper::get_the_widget_lists();
                        $widgets = $widget_data['widgets'];
                        $all_widgets = $widget_data['all_widgets'];
                        $widget_categories = $widget_data['widget_categories'];
                        
                        // Display the widgets in categories
                        echo '<div class="trad-widget-tabs-container">'; // 
                        
                        echo '<div class="trad-dashboard-elements-tab-wraper">';
                        echo '<ul class="trad-widget-tabs-list" >'; 
                        $tab_count = 0; // For generating unique tab IDs
                        foreach ($widget_categories as $category => $widgets_in_category) {
                            echo '<li class="trad-widget-filter-tab-item" data-tab="trad-widget-tab' . esc_attr($tab_count) . '">' . esc_html($category) . '</li>';
                            $tab_count++;
                        }
                        echo '</ul>'; 
                       
                        echo '<div class="trad-dashboard-select-widget-btn">';
                            echo '<label>';
                            echo '<input type="checkbox" id="select-all-widgets" />';
                            echo '<span>';
                            ?>

                            <?php esc_html_e('Select All', 'turbo-addons-elementor'); ?>
                            <?php
                            echo '</span>';
                            echo '</label>';
                        echo '</div>';
                        echo '</div>';
                        
                        // Generate the tab content
                        echo '<div class="trad-widget-tabs-content">'; // Updated tab content container class
                        $tab_count = 0; // Reset for content
                        foreach ($widget_categories as $category => $widgets_in_category) {
                            echo '<div class="trad-widget-tab-content" id="trad-widget-tab' . esc_attr($tab_count) . '">'; // Updated tab content class
                            echo '<h3>' . esc_html($category) . '</h3>';
                            echo '<div class="trad-widget-list">'; // List of widgets in the category
                        
                            foreach ($widgets_in_category as $widget_key) {
                                $is_active = in_array($widget_key, $widgets);
                                ?>
                                <div class="trad-widget-card">
                                    <label class="trad-elements-tab-icon-text">
                                        <input type="checkbox" class="widget-checkbox trad-dashboard-toggle-switch" name="widgets[]" value="<?php echo esc_attr($widget_key); ?>" <?php checked($is_active); ?> />
                                        <span class="trad-dashboard-toggle-slider"></span>
                                        <span class="trad-dashboard-widget-label"><?php echo esc_html($all_widgets[$widget_key] ?? $widget_key); ?></span>
                                    </label>
                                </div>
                                <?php
                            }
                        
                            echo '</div>'; 
                            echo '</div>'; 
                            $tab_count++;
                        }
                        echo '</div>'; // Close tabs-content
                        
                        echo '</div>'; // Close widget tabs wrapper
                        ?>
                        <input type="hidden" id="current_tab" name="current_tab" value="<?php echo esc_attr(!empty($current_tab) ? $current_tab : 'general-tab'); ?>">

                        <div class="trad-tab-filter-save-btn">
                            <input type="submit" name="save_changes" class="button trad-dashboard-elements-btn-submit " value="<?php esc_attr_e('Save Changes', 'turbo-addons-elementor'); ?>" />
                    </div>
                    </form>
                </div>
            </div>
            
            <!-- ======================tab-3===Extension Tab Content
            ================================================================================ -->

            <div id="extension-tab" class="trad-tab-content tab-content trad-dashboard-extension-tab <?php echo $current_tab === 'extension-tab' ? 'active' : ''; ?>">
                <div class="trad-widgets-section">

                    <form method="post" action="#">
                        <?php
                        // ✅ Nonce for security
                        wp_nonce_field('save_turbo_addons_extensions_action', 'turbo_addons_extensions_nonce');

                        // ✅ Handle form submission
                        if (isset($_POST['save_extensions'])) {

                            // Verify nonce
                            if (
                                !isset($_POST['turbo_addons_extensions_nonce']) ||
                                !wp_verify_nonce(
                                    sanitize_text_field(wp_unslash($_POST['turbo_addons_extensions_nonce'])),
                                    'save_turbo_addons_extensions_action'
                                )
                            ) {
                                wp_die(esc_html__('Nonce verification failed. Please try again.', 'turbo-addons-elementor'));
                            }

                            // Sanitize and save selected extensions
                            $extensions = isset($_POST['extensions']) && is_array($_POST['extensions'])
                                ? array_map('sanitize_key', wp_unslash($_POST['extensions']))
                                : [];

                            // ✅ Save (can be empty array)
                            update_option('turbo_addons_extensions', $extensions);

                            // ✅ Keep current tab active after reload
                            $current_tab = 'extension-tab';

                            echo '<div class="trad-alert-updated-div updated">
                                    <p>' . esc_html__('Extensions saved successfully.', 'turbo-addons-elementor') . '</p>
                                    <button class="trad-alert-dismiss-button" type="button">×</button>
                                </div>';
                        }

                        // ✅ Get extension data
                        $extension_data   = Turbo_Addons\Helper::get_the_extension_lists();
                        $extensions       = $extension_data['extensions'];
                        $all_extensions   = $extension_data['all_extensions'];

                        // ✅ Same wrapper CSS structure as elements tab
                        echo '<div class="trad-widget-tabs-container">'; // same parent container

                        echo '<div class="trad-dashboard-elements-tab-wraper">'; // reuse same flex wrapper
                        echo '<ul class="trad-widget-tabs-list">';
                        echo '<li class="trad-widget-filter-tab-item active">' . esc_html__('Available Extensions', 'turbo-addons-elementor') . '</li>';
                        echo '</ul>';

                        // Select All
                        echo '<div class="trad-dashboard-select-widget-btn">';
                        echo '<label>';
                        echo '<input type="checkbox" id="select-all-extensions" />';
                        echo '<span>' . esc_html__('Select All', 'turbo-addons-elementor') . '</span>';
                        echo '</label>';
                        echo '</div>';
                        echo '</div>'; // close .trad-dashboard-elements-tab-wraper

                        // ✅ Content layout identical to widget tab
                        echo '<div class="trad-widget-tabs-content">';
                        echo '<div class="trad-widget-tab-content active" id="trad-extension-tab">';
                        echo '<div class="trad-widget-list">';

                        foreach ($all_extensions as $extension_key => $extension_label) {
                            $is_active = in_array($extension_key, $extensions, true);
                            ?>
                            <div class="trad-widget-card">
                                <label class="trad-elements-tab-icon-text">
                                    <input type="checkbox" class="extension-checkbox trad-dashboard-toggle-switch"
                                        name="extensions[]"
                                        value="<?php echo esc_attr($extension_key); ?>"
                                        <?php checked($is_active); ?> />
                                    <span class="trad-dashboard-toggle-slider"></span>
                                    <span class="trad-dashboard-widget-label"><?php echo esc_html($extension_label); ?></span>
                                </label>
                            </div>
                            <?php
                        }

                        echo '</div>';  // .trad-widget-list
                        echo '</div>';  // .trad-widget-tab-content
                        echo '</div>';  // .trad-widget-tabs-content
                        echo '</div>';  // .trad-widget-tabs-container
                        ?>

                        <!-- ✅ Hidden input to keep current tab after save -->
                        <input type="hidden" id="current_tab_extension" name="current_tab" value="extension-tab">

                        <div class="trad-tab-filter-save-btn">
                            <input type="submit" name="save_extensions"
                                class="button trad-dashboard-elements-btn-submit"
                                value="<?php esc_attr_e('Save Changes', 'turbo-addons-elementor'); ?>" />
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- ======tab-4/// ========================================Premium tabs=========================
             ====================================================================================================-->

            <div id="premium-tab" class="trad-tab-content tab-content trad-dashboard-premium-tab <?php echo $current_tab === 'premium-tab' ? 'active' : ''; ?>"
                style=
                    "background-position:center-center;
                    background-size:cover;
                    background-repeat:none;
                ">
                <div class="trad-header-section">
                    <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/DashboardBanner.webp'); ?>" alt="<?php echo esc_attr('update icon'); ?>"> 
                    
                    <div class="trad_dashboard_pro_tabs_cta">

                        <h3>Discover Our Lates Creation Enjoy Flat 50% Off for any package ( Limited Time ) <span class="trad_dashboard_copun"><code>TURBO50</code></span></h3>
                        <a href="https://turbo-addons.com/pricing/" target="blank"><button class="trad-dashboard-pro-tabs-top-btn">Upgrade Now</button></a>
                     
                    </div>
                </div>

                <div class="trad-widgets-section">
                    
                </div>
            </div>

            <!-- Add other tab contents like 'extensions-tab', 'tools-tab', 'integrations-tab', and 'premium-tab' similarly -->

        </div>
    </div>
    <?php
}
// Function to safely construct the URL for the icon
function trad_safe_url($url) {
    return esc_url($url);
}

// Register the admin menu
function turbo_addons_add_admin_menu() {
    $icon_url = trad_safe_url(plugin_dir_url(__FILE__) . 'assets/images/turbo-icon.png');
    add_menu_page(
        'Turbo Addons',
        'Turbo Addons',
        'manage_options',
        'turbo_addons',
        'turbo_addons_admin_page',
        $icon_url,
        20
    );
}
add_action('admin_menu', 'turbo_addons_add_admin_menu');

