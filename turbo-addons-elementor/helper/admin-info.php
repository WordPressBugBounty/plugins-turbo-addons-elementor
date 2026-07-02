<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
class TRAD_ADMIN_INFO
{
    public static function init()
    {

        add_action('admin_notices', [__CLASS__, 'trad_display_admin_info']);
        add_action('init', [__CLASS__, 'trad_display_admin_info_init']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'trad_admin_info_scripts']);
    }

    private function trad_is_turbo_pro_version_active() {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        
        $active_plugins = get_option( 'active_plugins' );
        $all_plugins = get_plugins();
        
        foreach ( $all_plugins as $plugin_file => $plugin_data ) {
            if ( in_array( $plugin_file, $active_plugins ) ) {
                // Check by plugin name instead of folder path
                if ( isset( $plugin_data['Name'] ) && $plugin_data['Name'] === 'Turbo Addons Elementor Pro' ) {
                    return true;
                }
            }
        }
        
        return false;
    }

    static function trad_display_admin_info_output()
    {

    // ✅ Pro version check
    $instance = new self();
    if ( method_exists( $instance, 'trad_is_turbo_pro_version_active' ) && $instance->trad_is_turbo_pro_version_active() ) {
        // Pro version active → return, don't display notice
        return;
    }

?>
        <div class="trad-hero">
            <div class="trad-info-content">
                <div class="trad-info-hello">
                    <?php
                    $addons_name = esc_html__('Turbo Addons Elementor, ', 'turbo-addons-elementor');
                    $current_user = wp_get_current_user();

                    $pro_link = esc_url('https://turbo-addons.com/pricing/');
                    $pricing_link = esc_url('https://turbo-addons.com');

                    esc_html_e('Hello, ', 'turbo-addons-elementor');
                    echo esc_html($current_user->display_name);
                    ?>

                    <?php esc_html_e('👋🏻', 'turbo-addons-elementor'); ?>
                </div>
                <div class="trad-info-desc">
                    <div><?php printf(esc_html__('Thank you for choosing Turbo Addons! ✨ We\'re excited to share that our Turbo Toolkit Bundle is LIVE! Get 3 Premium Elementor Products in ONE bundle with a HUGE DISCOUNT 🔥', 'turbo-addons-elementor'), esc_html($addons_name)); ?></div>
                        <div class="trad-features">
                            ⚡ Turbo Addons Elemento Pro &nbsp;&nbsp; ⚡ Turbo Template Library &nbsp;&nbsp; ⚡ Header & Footer Builder For Elementor
                        </div>
                    <div class="trad-offer"><?php printf(esc_html__('Upgrade your productivity — grab our exclusive deal now!', 'turbo-addons-elementor'), esc_html($addons_name)); ?></div>
                </div>
                <div class="trad-info-actions">
                    <a href="<?php echo esc_url($pro_link); ?>" target="_blank" rel="noopener" class="button button-primary upgrade-btn trad-upgarde-btn-message">
                        <?php esc_html_e('Upgrade Now', 'turbo-addons-elementor'); ?>
                    </a>
                    <button class="button button-info trad-dismiss"><?php esc_html_e('Close Notice', 'turbo-addons-elementor') ?></button>
                </div>
            </div>
            <canvas id="trad-notice-confetti"></canvas>
        </div>
    <?php
    }




    public static function trad_display_admin_info()
    {
        // ✅ Pro version check
        $instance = new self();
        if ( method_exists( $instance, 'trad_is_turbo_pro_version_active' ) && $instance->trad_is_turbo_pro_version_active() ) {
            // Pro version active → return, don't display notice
            return;
        }
        $hide_date = get_option('trad_info_text_date');
        if (!empty($hide_date)) {
            $clickhide = round((time() - strtotime($hide_date)) / 24 / 60 / 60);
            if ($clickhide < 25) {
                return;
            }
        }

        $install_date = get_option('trad_install_date');
        if (!empty($install_date)) {
            $install_day = round((time() - strtotime($install_date)) / 24 / 60 / 60);
            if ($install_day < 5) {
                return;
            }
        }
    ?>
        <div class="trad-notice notice trad-notice-success read-theme-dashboard trad-theme-dashboard-notice is-dismissible tradis-dismissible">
            <?php TRAD_ADMIN_INFO::trad_display_admin_info_output(); ?>
        </div>

<?php


    }

    public static function trad_display_admin_info_init()
    {
        if (
            isset($_GET['traddismissed'], $_GET['trad_nonce']) &&
            $_GET['traddismissed'] === '1'
        ) {
            $nonce = sanitize_text_field(wp_unslash($_GET['trad_nonce']));
    
            if (wp_verify_nonce($nonce, 'trad_dismiss_info')) {
                update_option('trad_info_text_date', current_time('mysql'));
                wp_safe_redirect(remove_query_arg(['traddismissed', 'trad_nonce']));
                exit;
            }
        }
    
        if (
            isset($_GET['tinfohide'], $_GET['trad_nonce']) &&
            $_GET['tinfohide'] === '1'
        ) {
            $nonce = sanitize_text_field(wp_unslash($_GET['trad_nonce']));
    
            if (wp_verify_nonce($nonce, 'trad_dismiss_info')) {
                update_option('trad_hide_tinfo1', current_time('mysql'));
                wp_safe_redirect(remove_query_arg(['tinfohide', 'trad_nonce']));
                exit;
            }
        }
    }
    

    public static function trad_admin_info_scripts()
    {
        wp_enqueue_style('trad-admin-info',  TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/trad-admin-info.css', array(), TRAD_TURBO_ADDONS_PLUGIN_VERSION, 'all');

        wp_enqueue_script('trad-admin-info',  TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/trad-admin-info.js', array('jquery'), TRAD_TURBO_ADDONS_PLUGIN_VERSION, true);

        // ✅ Pass nonce to JS for secure URL generation
        wp_localize_script('trad-admin-info', 'tradData', [
            'nonce' => wp_create_nonce('trad_dismiss_info')
        ]);

        wp_enqueue_script('trad-confetti-script',  TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/confetti/confetti.min.js', array(), TRAD_TURBO_ADDONS_PLUGIN_VERSION, true);

        wp_enqueue_script('trad-confetti-custom-script',  TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/vendor/confetti/confetti-init.js', array('trad-confetti-script', 'jquery'), TRAD_TURBO_ADDONS_PLUGIN_VERSION, true);
    }
}
TRAD_ADMIN_INFO::init();
