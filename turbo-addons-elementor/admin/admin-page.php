<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue necessary styles and scripts
function turbo_addons_admin_enqueue_styles_scripts() {
    wp_enqueue_style( 'turbo-addons-admin-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'admin/assets/css/style.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'admin/assets/css/style.css' ), 'all' );
    wp_enqueue_script('turbo-addons-admin-script', plugin_dir_url(__FILE__) . 'assets/js/admin-script.js', array('jquery'), filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'admin/assets/js/admin-script.js' ), true);
    wp_localize_script( 'turbo-addons-admin-script', 'tradAdmin', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'trad_fetch_template' ),
    ] );
}
add_action('admin_enqueue_scripts', 'turbo_addons_admin_enqueue_styles_scripts');

// ── AJAX: fetch latest templates fresh (no cache) ──────────────────────────────
function trad_ajax_fetch_latest_template() {
    check_ajax_referer( 'trad_fetch_template', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( 'Unauthorized', 403 );
    }
    $response = wp_remote_get(
        'https://mt.turbo-addons.com/api/ta/v1/latest-template',
        [ 'timeout' => 8, 'sslverify' => true ]
    );
    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        wp_send_json_error( 'API unreachable' );
    }
    $data = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( ! is_array( $data ) || empty( $data ) ) {
        wp_send_json_error( 'Invalid response' );
    }
    $templates   = isset( $data[0] ) ? $data : [ $data ];
    $first       = $templates[0];
    $pointer_key = 'trad_tpl_pointer_v1';
    $data_pfx    = 'trad_tpl_data_';
    $pointer     = md5( $first['title'] ?? $first['name'] ?? 'turbo' );
    set_transient( $data_pfx . $pointer, $templates, 6 * HOUR_IN_SECONDS );
    set_transient( $pointer_key, $pointer, 1 * HOUR_IN_SECONDS );
    wp_send_json_success( $templates );
}
add_action( 'wp_ajax_trad_fetch_latest_template', 'trad_ajax_fetch_latest_template' );

// Function to render the admin page
function turbo_addons_admin_page() {
    ?>

    <!-- ----------------------dashboard top section-----------------------------------
     --------------------------------------------------------------------------------// -->
    <div id="turbo-dashboard-navbar">
        <div class="trad-dashboard-top-banner-container">
            <div class="trad-dashboard-top-banner-container-60">
                <span class="trad-top-banner-eyebrow">&#9889; New &mdash; Turbo Addons Pro</span>
                <p>Now available with full <strong>WooCommerce support with custom product pages.</strong> Get 90+ widgets and 200+ ready templates to speed up your design process.</p>
                <p>Upgrade to <strong>Turbo Addons Pro</strong> and unlock the full potential!
                    <a class="trad-dashboard-top-message-button" href="https://turbo-addons.com/pricing/" target="_blank">
                        &#9889; Upgrade Now
                    </a>
                </p>
            </div>
            
            <div class="trad-dashboard-top-banner-container-40">
                <a href="https://wordpress.org/plugins/header-footer-builder-for-elementor/" target="_blank" rel="noopener noreferrer" style="text-decoration:none; display:block; position:relative; z-index:1; width:100%;">
                    <img class="turbo-dashboard-banner-add" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/h_and_f_promotion.webp' ); ?>" alt="<?php echo esc_attr( 'turbo-logo' ); ?>">    
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
                        <h3 class="trad-dashboard-sub-heading">What's New in Version 1.8.14</h3>
                        <hr>
                        <div class="trad-updated-list">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/updatelist-icon.svg'); ?>" alt="<?php echo esc_attr('update icon'); ?>"> 
                            <div class="trad-updated-list-typography">
                                <h4>Added Free Widgets</h4>
                                <p>Accordion Slider, Modal PopUp and Metro Grid</p>
                            </div>
                        </div>
                        <hr>
                        <div class="trad-updated-list">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/updatelist-icon.svg'); ?>" alt="<?php echo esc_attr('update icon'); ?>"> 
                            <div class="trad-updated-list-typography">
                                <h4>Features</h4>
                                <p>Template gallery and Add 20+ New Modern Templates.</p>
                            </div>
                        </div>
                        <hr>
                        <div class="trad-updated-list">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/updatelist-icon.svg'); ?>" alt="<?php echo esc_attr('update icon'); ?>"> 
                            <div class="trad-updated-list-typography">
                                <h4>Updated</h4>
                                <p>Tested and verified for full compatibility with Elementor version 4.0.2</p>
                            </div>
                        </div>

                        <div class="trad-updated-list">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/updatelist-icon.svg'); ?>" alt="<?php echo esc_attr('update icon'); ?>"> 
                            <div class="trad-updated-list-typography">
                                <h4>Templates, Block & Sections</h4>
                                <p>Added different types of 20+ free templates, block and sections</p>
                            </div>
                        </div>
                    </div>


                    <!-- dynamic latest templates slider -->
                    <div class="trad-dashboard-sec-one-right">
                        <?php
                        $trad_api_url    = 'https://mt.turbo-addons.com/api/ta/v1/latest-template';
                        $trad_ptr_key    = 'trad_tpl_pointer_v1';
                        $trad_data_pfx   = 'trad_tpl_data_';
                        $trad_templates  = null;
                        $trad_ptr        = get_transient( $trad_ptr_key );
                        if ( $trad_ptr ) {
                            $trad_templates = get_transient( $trad_data_pfx . $trad_ptr );
                        }
                        if ( empty( $trad_templates ) ) {
                            $trad_resp = wp_remote_get( $trad_api_url, [ 'timeout' => 8, 'sslverify' => true ] );
                            if ( ! is_wp_error( $trad_resp ) && 200 === wp_remote_retrieve_response_code( $trad_resp ) ) {
                                $trad_decoded = json_decode( wp_remote_retrieve_body( $trad_resp ), true );
                                if ( is_array( $trad_decoded ) && ! empty( $trad_decoded ) ) {
                                    $trad_templates = isset( $trad_decoded[0] ) ? $trad_decoded : [ $trad_decoded ];
                                    $trad_first     = $trad_templates[0];
                                    $trad_new_ptr   = md5( $trad_first['title'] ?? $trad_first['name'] ?? 'turbo' );
                                    set_transient( $trad_data_pfx . $trad_new_ptr, $trad_templates, 6 * HOUR_IN_SECONDS );
                                    set_transient( $trad_ptr_key, $trad_new_ptr, 1 * HOUR_IN_SECONDS );
                                }
                            }
                        }
                        ?>

                        <!-- Panel header -->
                        <!-- <div class="trad-template-panel-header">
                            <div class="trad-template-panel-header-left">
                                <span class="trad-live-dot"></span>
                                <span class="trad-live-label"><?php esc_html_e( 'New', 'turbo-addons-elementor' ); ?></span>
                                <h3 class="trad-dashboard-sub-heading"><?php esc_html_e( 'Latest Templates', 'turbo-addons-elementor' ); ?></h3>
                            </div>
                            <a href="https://turbo-addons.com/pricing/" target="_blank" rel="noopener" class="trad-upgrade-pill">
                                ⚡ <?php esc_html_e( 'Get Pro', 'turbo-addons-elementor' ); ?>
                            </a>
                        </div> -->
                        <div class="trad-template-panel-header">
                            <div class="trad-template-panel-header-left">
                                <span class="trad-live-dot"></span>
                                <span class="trad-live-label"><?php esc_html_e( 'New', 'turbo-addons-elementor' ); ?></span>
                                <h3 class="trad-dashboard-sub-heading"><?php esc_html_e( 'Templates Added', 'turbo-addons-elementor' ); ?></h3>
                            </div>
                            <a href="#trad-watch-guide-video" class="trad-how-to-btn trad-scroll-to-video">
                                <span class="trad-how-to-ring">
                                    <span class="trad-how-to-play"></span>
                                </span>
                                <span class="trad-how-to-text">
                                    <span class="trad-how-to-label"><?php esc_html_e( 'How to Use', 'turbo-addons-elementor' ); ?></span>
                                    <span class="trad-how-to-sub"><?php esc_html_e( 'Watch tutorial', 'turbo-addons-elementor' ); ?></span>
                                </span>
                            </a>
                        </div>
                        <hr>

                        <?php if ( ! empty( $trad_templates ) ) :
                            $trad_items = [];
                            foreach ( $trad_templates as $t ) {
                                $trad_items[] = [
                                    'title'    => sanitize_text_field( $t['title']       ?? $t['name']    ?? '' ),
                                    'desc'     => sanitize_text_field( $t['description'] ?? '' ),
                                    'category' => sanitize_text_field( $t['category']    ?? '' ),
                                    'type'     => sanitize_text_field( $t['type']        ?? '' ),
                                    'batch'    => sanitize_text_field( $t['batch']       ?? $t['pro']     ?? '' ),
                                    'link'     => esc_url( $t['link']    ?? $t['preview'] ?? '#' ),
                                    'thumb'    => esc_url( $t['thumb']   ?? '' ),
                                ];
                            }
                            $trad_first_tpl = $trad_items[0];
                        ?>

                        <div class="trad-tpl-slider-card" id="trad-template-card">

                            <!-- LEFT: image slider -->
                            <div class="trad-tpl-slider-left">
                                <div class="trad-tpl-slides" id="trad-tpl-slides">
                                    <?php foreach ( $trad_items as $idx => $tpl ) : ?>
                                    <div class="trad-tpl-slide <?php echo $idx === 0 ? 'active' : ''; ?>"
                                         data-index="<?php echo esc_attr( $idx ); ?>">
                                        <img src="<?php echo esc_url( $tpl['thumb'] ); ?>"
                                             alt="<?php echo esc_attr( $tpl['title'] ); ?>"
                                             class="trad-tpl-slide-img">
                                        <?php if ( strtoupper( $tpl['batch'] ) === 'PRO' || $tpl['batch'] === 'on' ) : ?>
                                        <span class="trad-template-pro-badge">PRO</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if ( count( $trad_items ) > 1 ) : ?>
                                <div class="trad-tpl-dots" id="trad-tpl-dots">
                                    <?php foreach ( $trad_items as $idx => $tpl ) : ?>
                                    <button class="trad-tpl-dot <?php echo $idx === 0 ? 'active' : ''; ?>"
                                            data-index="<?php echo esc_attr( $idx ); ?>"
                                            aria-label="<?php echo esc_attr( $tpl['title'] ); ?>"></button>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- RIGHT: info -->
                            <div class="trad-tpl-info" id="trad-tpl-info">
                                <div class="trad-tpl-meta">
                                    <?php if ( $trad_first_tpl['category'] ) : ?>
                                    <span class="trad-tpl-badge trad-tpl-badge-cat" id="trad-tpl-category">
                                        <?php echo esc_html( ucfirst( $trad_first_tpl['category'] ) ); ?>
                                    </span>
                                    <?php endif; ?>
                                    <?php if ( $trad_first_tpl['type'] ) : ?>
                                    <span class="trad-tpl-badge trad-tpl-badge-type" id="trad-tpl-type">
                                        <?php echo esc_html( ucfirst( $trad_first_tpl['type'] ) ); ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <h4 class="trad-tpl-name" id="trad-tpl-name">
                                    <?php echo esc_html( $trad_first_tpl['title'] ); ?>
                                </h4>
                                <p class="trad-tpl-desc" id="trad-tpl-desc">
                                    <?php echo esc_html( $trad_first_tpl['desc'] ?: sprintf(
                                        /* translators: %s: template name */
                                        __( 'A brand-new "%s" template is now available. Import it in one click.', 'turbo-addons-elementor' ),
                                        $trad_first_tpl['title']
                                    ) ); ?>
                                </p>
                                <?php if ( count( $trad_items ) > 1 ) : ?>
                                <div class="trad-tpl-counter">
                                    <span id="trad-tpl-current">1</span>/<span><?php echo count( $trad_items ); ?></span>
                                    <span class="trad-tpl-counter-lbl"><?php esc_html_e( 'templates', 'turbo-addons-elementor' ); ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="trad-tpl-actions">
                                    <a href="<?php echo esc_url( $trad_first_tpl['link'] ); ?>" target="_blank" rel="noopener"
                                       class="trad-tpl-btn trad-tpl-btn-preview" id="trad-tpl-preview-btn">
                                        <?php esc_html_e( 'Live Preview ⤴', 'turbo-addons-elementor' ); ?>
                                    </a>
                                    <a href="https://turbo-addons.com/templates/" target="_blank" rel="noopener"
                                       class="trad-tpl-btn trad-tpl-btn-all">
                                        <?php esc_html_e( 'All Templates', 'turbo-addons-elementor' ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <script>window.tradTemplates = <?php echo wp_json_encode( $trad_items ); ?>;</script>

                        <?php else : ?>
                        <div class="trad-tpl-fallback">
                            <div class="trad-dashboard-sec1-template-add">
                                <img src="<?php echo esc_url( plugin_dir_url(__FILE__) . 'assets/images/template1.webp' ); ?>" alt="template">
                                <img src="<?php echo esc_url( plugin_dir_url(__FILE__) . 'assets/images/template2.webp' ); ?>" alt="template">
                                <img src="<?php echo esc_url( plugin_dir_url(__FILE__) . 'assets/images/template3.webp' ); ?>" alt="template">
                            </div>
                            <div class="trad-dashboard-center-btn">
                                <a href="https://turbo-addons.com/templates/" target="_blank" rel="noopener">
                                    <?php esc_html_e( 'Explore All Templates ⤴', 'turbo-addons-elementor' ); ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>


                </div>

                <!-- Section 2: Review CTA -->
                <div class="trad-review-cta-wrap">
                    <div class="trad-review-cta-blob trad-review-cta-blob-left"></div>
                    <div class="trad-review-cta-blob trad-review-cta-blob-right"></div>
                    <div class="trad-review-cta-inner">
                        <div class="trad-review-stars" aria-label="5 stars">
                            <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                        </div>
                        <h3 class="trad-review-cta-title"><?php esc_html_e( 'Loving Turbo Addons?', 'turbo-addons-elementor' ); ?></h3>
                        <p class="trad-review-cta-desc"><?php esc_html_e( "Your review helps thousands of WordPress users discover Turbo Addons. It takes 30 seconds and means the world to us.", 'turbo-addons-elementor' ); ?></p>
                        <div class="trad-review-cta-actions">
                            <a href="https://wordpress.org/plugins/turbo-addons-elementor/#reviews" target="_blank" rel="noopener" class="trad-review-btn trad-review-btn-primary">
                                &#9733;&nbsp;<?php esc_html_e( 'Leave a Review', 'turbo-addons-elementor' ); ?>
                            </a>
                            <a href="https://turbo-addons.com/get-support/" target="_blank" rel="noopener" class="trad-review-btn trad-review-btn-ghost">
                                <?php esc_html_e( 'Need Help?', 'turbo-addons-elementor' ); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Three info cards -->
                <div class="trad-info-cards-grid">

                    <!-- Card 1: Support & Docs -->
                    <div class="trad-info-card trad-info-card--support">
                        <div class="trad-info-card-icon-wrap">
                            <span class="trad-info-card-icon">📚</span>
                        </div>
                        <div class="trad-info-card-body">
                            <h3 class="trad-info-card-title"><?php esc_html_e( 'Docs & Support', 'turbo-addons-elementor' ); ?></h3>
                            <p class="trad-info-card-desc"><?php esc_html_e( 'Everything you need — step-by-step guides, widget references, and a dedicated support team ready to help.', 'turbo-addons-elementor' ); ?></p>
                            <ul class="trad-info-card-list">
                                <li>✅ <?php esc_html_e( 'Full widget documentation', 'turbo-addons-elementor' ); ?></li>
                                <li>✅ <?php esc_html_e( 'Video tutorials', 'turbo-addons-elementor' ); ?></li>
                                <li>✅ <?php esc_html_e( 'Community support', 'turbo-addons-elementor' ); ?></li>
                            </ul>
                        </div>
                        <div class="trad-info-card-footer">
                            <a href="https://turbo-addons.com/docs/" target="_blank" rel="noopener" class="trad-info-card-btn trad-info-card-btn--primary">
                                <?php esc_html_e( 'Read Docs', 'turbo-addons-elementor' ); ?> →
                            </a>
                            <a href="https://turbo-addons.com/get-support/" target="_blank" rel="noopener" class="trad-info-card-btn trad-info-card-btn--ghost">
                                <?php esc_html_e( 'Get Support', 'turbo-addons-elementor' ); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: Pro Upgrade -->
                    <div class="trad-info-card trad-info-card--upgrade">
                        <div class="trad-info-card-gradient-header">
                            <span class="trad-info-card-badge"><?php esc_html_e( 'UPGRADE TO PRO', 'turbo-addons-elementor' ); ?></span>
                            <h3 class="trad-info-card-title trad-info-card-title--light"><?php esc_html_e( 'Unlock Premium Features', 'turbo-addons-elementor' ); ?></h3>
                        </div>
                        <div class="trad-info-card-body">
                            <div class="trad-feature-chips">
                                <span class="trad-feature-chip">🛒 <?php esc_html_e( 'WooCommerce Builder', 'turbo-addons-elementor' ); ?></span>
                                <span class="trad-feature-chip">🎠 <?php esc_html_e( '3D Carousel', 'turbo-addons-elementor' ); ?></span>
                                <span class="trad-feature-chip">📄 <?php esc_html_e( 'PDF Flip Book', 'turbo-addons-elementor' ); ?></span>
                                <span class="trad-feature-chip">🦸 <?php esc_html_e( 'Hero Slider', 'turbo-addons-elementor' ); ?></span>
                                <span class="trad-feature-chip">🔍 <?php esc_html_e( 'Advanced Search', 'turbo-addons-elementor' ); ?></span>
                                <span class="trad-feature-chip">💬 <?php esc_html_e( 'WhatsApp Chat', 'turbo-addons-elementor' ); ?></span>
                                <span class="trad-feature-chip">🎯 <?php esc_html_e( 'Image Hotspot', 'turbo-addons-elementor' ); ?></span>
                                <span class="trad-feature-chip">📊 <?php esc_html_e( 'Dynamic Table', 'turbo-addons-elementor' ); ?></span>
                            </div>
                        </div>
                        <div class="trad-info-card-footer">
                            <a href="https://turbo-addons.com/pricing/" target="_blank" rel="noopener" class="trad-info-card-btn trad-info-card-btn--purple">
                                <?php esc_html_e( 'Get Pro Now', 'turbo-addons-elementor' ); ?> →
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Our Other Plugins -->
                    <div class="trad-info-card trad-info-card--plugins">
                        <div class="trad-info-card-body">
                            <h3 class="trad-info-card-title"><?php esc_html_e( 'More From Our Team', 'turbo-addons-elementor' ); ?></h3>
                            <p class="trad-info-card-desc"><?php esc_html_e( 'Free plugins built by the same team — trusted by thousands of WordPress users.', 'turbo-addons-elementor' ); ?></p>
                            <div class="trad-plugin-list">
                                <a href="https://wordpress.org/plugins/header-footer-builder-for-elementor/" target="_blank" rel="noopener" class="trad-plugin-item">
                                    <div class="trad-plugin-icon trad-plugin-icon--green">🧩</div>
                                    <div class="trad-plugin-info">
                                        <strong><?php esc_html_e( 'Header Footer Builder', 'turbo-addons-elementor' ); ?></strong>
                                        <span><?php esc_html_e( 'Custom headers & footers for Elementor', 'turbo-addons-elementor' ); ?></span>
                                    </div>
                                    <span class="trad-plugin-arrow">→</span>
                                </a>
                                <a href="https://wordpress.org/plugins/turbo-templates-library-for-elementor/" target="_blank" rel="noopener" class="trad-plugin-item">
                                    <div class="trad-plugin-icon trad-plugin-icon--blue">🎨</div>
                                    <div class="trad-plugin-info">
                                        <strong><?php esc_html_e( 'Turbo Templates Library', 'turbo-addons-elementor' ); ?></strong>
                                        <span><?php esc_html_e( '200+ ready-made Elementor templates', 'turbo-addons-elementor' ); ?></span>
                                    </div>
                                    <span class="trad-plugin-arrow">→</span>
                                </a>
                                <a href="https://wordpress.org/plugins/whitespace-fixer-for-xml-sitemap/" target="_blank" rel="noopener" class="trad-plugin-item">
                                    <div class="trad-plugin-icon trad-plugin-icon--orange">🗺️</div>
                                    <div class="trad-plugin-info">
                                        <strong><?php esc_html_e( 'Whitespace Fixer for XML Sitemap', 'turbo-addons-elementor' ); ?></strong>
                                        <span><?php esc_html_e( 'Fix XML sitemap whitespace errors instantly', 'turbo-addons-elementor' ); ?></span>
                                    </div>
                                    <span class="trad-plugin-arrow">→</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Section 4: Watch Video -->
                <div class="trad-guide-video-wrap" id="trad-watch-guide-video">
                    <div class="trad-video-blob trad-video-blob-l"></div>
                    <div class="trad-video-blob trad-video-blob-r"></div>
                    <div class="trad-video-inner">
                        <div class="trad-video-text">
                            <span class="trad-video-eyebrow">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="vertical-align:middle;margin-right:5px;">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                <?php esc_html_e( 'Video Tutorial', 'turbo-addons-elementor' ); ?>
                            </span>
                            <h2 class="trad-video-title"><?php esc_html_e( 'Get Started in Minutes', 'turbo-addons-elementor' ); ?></h2>
                            <p class="trad-video-desc"><?php esc_html_e( 'Watch this quick walkthrough to learn how to set up Turbo Addons, activate widgets, import templates, and build stunning pages — no coding needed.', 'turbo-addons-elementor' ); ?></p>
                            <ul class="trad-video-checklist">
                                <li>✅ <?php esc_html_e( 'Activate & configure widgets', 'turbo-addons-elementor' ); ?></li>
                                <li>✅ <?php esc_html_e( 'Import ready-made templates', 'turbo-addons-elementor' ); ?></li>
                                <li>✅ <?php esc_html_e( 'Customize with Elementor', 'turbo-addons-elementor' ); ?></li>
                            </ul>
                            <a href="https://www.youtube.com/@TurboAddons" target="_blank" rel="noopener" class="trad-video-channel-btn">
                                <?php esc_html_e( 'Visit Our YouTube Channel ⤴', 'turbo-addons-elementor' ); ?>
                            </a>
                        </div>
                        <div class="trad-video-frame-wrap">
                            <div class="trad-video-frame-glow"></div>
                            <div class="trad-video-frame">
                                <iframe
                                    src="https://www.youtube.com/embed/Z5v6LXkcWLo?rel=0&modestbranding=1"
                                    title="<?php esc_attr_e( 'Turbo Addons — How to Use', 'turbo-addons-elementor' ); ?>"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    loading="lazy">
                                </iframe>
                            </div>
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

            <div id="premium-tab" class="trad-tab-content tab-content trad-dashboard-premium-tab <?php echo $current_tab === 'premium-tab' ? 'active' : ''; ?>">

                <!-- ── HERO ─────────────────────────────────────────────────────── -->
                <div class="trad-pro-hero">
                    <div class="trad-pro-hero-blob trad-pro-hero-blob-a"></div>
                    <div class="trad-pro-hero-blob trad-pro-hero-blob-b"></div>
                    <div class="trad-pro-hero-blob trad-pro-hero-blob-c"></div>
                    <div class="trad-pro-hero-inner">
                        <span class="trad-pro-hero-eyebrow">&#9889; Limited Time Offer</span>
                        <h1 class="trad-pro-hero-title"><?php esc_html_e( 'Faster. Better. Higher Converting', 'turbo-addons-elementor' ); ?><br><span class="trad-pro-hero-title-accent"><?php esc_html_e( 'with Turbo Addons Pro', 'turbo-addons-elementor' ); ?></span></h1>
                        <p class="trad-pro-hero-desc"><?php esc_html_e( '90+ premium widgets, 200+ ready-made templates, WooCommerce builder, and priority support — everything you need to build stunning websites faster.', 'turbo-addons-elementor' ); ?></p>
                        <div class="trad-pro-hero-actions">
                            <a href="https://turbo-addons.com/pricing/" target="_blank" rel="noopener" class="trad-pro-btn trad-pro-btn-primary">
                                &#9889; <?php esc_html_e( 'Get Pro Now', 'turbo-addons-elementor' ); ?>
                            </a>
                            <a href="https://turbo-addons.com/templates/" target="_blank" rel="noopener" class="trad-pro-btn trad-pro-btn-ghost">
                                <?php esc_html_e( 'View Live Demo', 'turbo-addons-elementor' ); ?> &rarr;
                            </a>
                        </div>
                        <div class="trad-pro-hero-trust">
                            <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                            <span><?php esc_html_e( 'Trusted by 10,000+ WordPress users', 'turbo-addons-elementor' ); ?></span>
                        </div>
                    </div>
                </div>

                <!-- ── STATS ROW ─────────────────────────────────────────────────── -->
                <div class="trad-pro-stats">
                    <div class="trad-pro-stat">
                        <span class="trad-pro-stat-num">90<span class="trad-pro-stat-plus">+</span></span>
                        <span class="trad-pro-stat-lbl"><?php esc_html_e( 'Pro Widgets', 'turbo-addons-elementor' ); ?></span>
                    </div>
                    <div class="trad-pro-stat-divider"></div>
                    <div class="trad-pro-stat">
                        <span class="trad-pro-stat-num">200<span class="trad-pro-stat-plus">+</span></span>
                        <span class="trad-pro-stat-lbl"><?php esc_html_e( 'Ready Templates', 'turbo-addons-elementor' ); ?></span>
                    </div>
                    <div class="trad-pro-stat-divider"></div>
                    <div class="trad-pro-stat">
                        <span class="trad-pro-stat-num">10K<span class="trad-pro-stat-plus">+</span></span>
                        <span class="trad-pro-stat-lbl"><?php esc_html_e( 'Happy Users', 'turbo-addons-elementor' ); ?></span>
                    </div>
                    <div class="trad-pro-stat-divider"></div>
                    <div class="trad-pro-stat">
                        <span class="trad-pro-stat-num">4.8<span class="trad-pro-stat-star">&#9733;</span></span>
                        <span class="trad-pro-stat-lbl"><?php esc_html_e( 'Average Rating', 'turbo-addons-elementor' ); ?></span>
                    </div>
                </div>

                <!-- ── FEATURES GRID ─────────────────────────────────────────────── -->
                <div class="trad-pro-section-label"><?php esc_html_e( "What's Included in Pro", 'turbo-addons-elementor' ); ?></div>
                 <div class="trad-pro-features-grid">
                    <div class="trad-pro-feat-card">
                        <div class="trad-pro-feat-icon trad-pro-feat-icon--violet">&#128722;</div>
                        <h3 class="trad-pro-feat-title"><?php esc_html_e( 'WooCommerce Builder', 'turbo-addons-elementor' ); ?></h3>
                        <p class="trad-pro-feat-desc"><?php esc_html_e( 'Design custom product pages, shop layouts, cart & checkout — all with drag-and-drop.', 'turbo-addons-elementor' ); ?></p>
                    </div>

                    <div class="trad-pro-feat-card">
                        <div class="trad-pro-feat-icon trad-pro-feat-icon--blue">&#127912;</div>
                        <h3 class="trad-pro-feat-title"><?php esc_html_e( '200+ Premium Templates', 'turbo-addons-elementor' ); ?></h3>
                        <p class="trad-pro-feat-desc"><?php esc_html_e( 'Import pixel-perfect, professionally designed templates in one click.', 'turbo-addons-elementor' ); ?></p>
                    </div>

                    <div class="trad-pro-feat-card">
                        <div class="trad-pro-feat-icon trad-pro-feat-icon--pink">&#127905;</div>
                        <h3 class="trad-pro-feat-title"><?php esc_html_e( '3D Carousel & Flip Book', 'turbo-addons-elementor' ); ?></h3>
                        <p class="trad-pro-feat-desc"><?php esc_html_e( 'Stunning 3D carousel sliders and interactive PDF flip books for your content.', 'turbo-addons-elementor' ); ?></p>
                    </div>

                    <div class="trad-pro-feat-card">
                        <div class="trad-pro-feat-icon trad-pro-feat-icon--green">&#128269;</div>
                        <h3 class="trad-pro-feat-title"><?php esc_html_e( 'Advanced Search', 'turbo-addons-elementor' ); ?></h3>
                        <p class="trad-pro-feat-desc"><?php esc_html_e( 'Ajax-powered live search with filters, categories, and custom post type support.', 'turbo-addons-elementor' ); ?></p>
                    </div>

                    <div class="trad-pro-feat-card">
                        <div class="trad-pro-feat-icon trad-pro-feat-icon--orange">&#128640;</div>
                        <h3 class="trad-pro-feat-title"><?php esc_html_e( 'Hero Slider', 'turbo-addons-elementor' ); ?></h3>
                        <p class="trad-pro-feat-desc"><?php esc_html_e( 'Full-screen hero sliders with animations, video backgrounds, and CTA overlays.', 'turbo-addons-elementor' ); ?></p>
                    </div>

                    <div class="trad-pro-feat-card">
                        <div class="trad-pro-feat-icon trad-pro-feat-icon--teal">&#128172;</div>
                        <h3 class="trad-pro-feat-title"><?php esc_html_e( 'WhatsApp Chat & Hotspot', 'turbo-addons-elementor' ); ?></h3>
                        <p class="trad-pro-feat-desc"><?php esc_html_e( 'Floating WhatsApp chat button and interactive image hotspots to boost engagement.', 'turbo-addons-elementor' ); ?></p>
                    </div>

                </div>
                <div class="trad_go_primium_explore_btn">
                    <a href="https://turbo-addons.com/widgets/" target="_blank" rel="noopener"><button><?php esc_html_e('Explore More', 'turbo-addons-elementor') ?> </button></a>
                </div>

                <div class="trad-pro-testimonials">

                    <div class="trad-pro-testi-card">
                        <div class="trad-pro-testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <p class="trad-pro-testi-text"><?php esc_html_e( '"Turbo Addons Pro completely transformed how I build sites. The WooCommerce builder alone is worth every penny."', 'turbo-addons-elementor' ); ?></p>
                        <div class="trad-pro-testi-author">
                            <div class="trad-pro-testi-avatar trad-pro-testi-avatar--a">JD</div>
                            <div>
                                <strong><?php esc_html_e( 'James D.', 'turbo-addons-elementor' ); ?></strong>
                                <span><?php esc_html_e( 'Freelance Web Designer', 'turbo-addons-elementor' ); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="trad-pro-testi-card">
                        <div class="trad-pro-testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <p class="trad-pro-testi-text"><?php esc_html_e( '"200+ templates saved our agency countless hours. The 3D carousel and hero slider widgets are absolutely stunning."', 'turbo-addons-elementor' ); ?></p>
                        <div class="trad-pro-testi-author">
                            <div class="trad-pro-testi-avatar trad-pro-testi-avatar--b">SR</div>
                            <div>
                                <strong><?php esc_html_e( 'Sarah R.', 'turbo-addons-elementor' ); ?></strong>
                                <span><?php esc_html_e( 'Agency Owner', 'turbo-addons-elementor' ); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="trad-pro-testi-card">
                        <div class="trad-pro-testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <p class="trad-pro-testi-text"><?php esc_html_e( '"Priority support is lightning fast. Had an issue resolved in under 2 hours. Best Elementor addon I\'ve used."', 'turbo-addons-elementor' ); ?></p>
                        <div class="trad-pro-testi-author">
                            <div class="trad-pro-testi-avatar trad-pro-testi-avatar--c">MK</div>
                            <div>
                                <strong><?php esc_html_e( 'Mike K.', 'turbo-addons-elementor' ); ?></strong>
                                <span><?php esc_html_e( 'WordPress Developer', 'turbo-addons-elementor' ); ?></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ── BOTTOM CTA ─────────────────────────────────────────────────── -->
                <div class="trad-pro-bottom-cta">
                    <div class="trad-pro-bottom-cta-blob trad-pro-bottom-cta-blob-l"></div>
                    <div class="trad-pro-bottom-cta-blob trad-pro-bottom-cta-blob-r"></div>
                    <div class="trad-pro-bottom-cta-inner">
                        <h2 class="trad-pro-bottom-cta-title"><?php esc_html_e( 'Ready to Build Something Amazing?', 'turbo-addons-elementor' ); ?></h2>
                        <p class="trad-pro-bottom-cta-desc"><?php esc_html_e( 'Join 10,000+ WordPress professionals who trust Turbo Addons Pro to power their websites.', 'turbo-addons-elementor' ); ?></p>
                        <div class="trad-pro-bottom-cta-actions">
                            <a href="https://turbo-addons.com/pricing/" target="_blank" rel="noopener" class="trad-pro-btn trad-pro-btn-primary trad-pro-btn-lg">
                                &#9889; <?php esc_html_e( 'Upgrade to Pro Today', 'turbo-addons-elementor' ); ?>
                            </a>
                            <a href="https://turbo-addons.com/" target="_blank" rel="noopener" class="trad-pro-btn trad-pro-btn-ghost-white">
                                <?php esc_html_e( 'Explore All Features', 'turbo-addons-elementor' ); ?> &rarr;
                            </a>
                        </div>
                        <p class="trad-pro-bottom-cta-note"><?php esc_html_e( '14-days money-back guarantee &nbsp;', 'turbo-addons-elementor' ); ?></p>
                    </div>
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
