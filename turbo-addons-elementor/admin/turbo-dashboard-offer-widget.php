<?php
/**
 * Dashboard Widget for Turbo Addons Elementor
 *
 * @package Turbo_Addons_Elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Turbo Addons dashboard widget.
 */
function trad_register_dashboard_widget() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	wp_add_dashboard_widget(
		'trad_turbo_addons_dashboard_widget',
		esc_html__( 'Turbo Addons News', 'turbo-addons-elementor' ),
		'trad_render_dashboard_widget'
	);
}
add_action( 'wp_dashboard_setup', 'trad_register_dashboard_widget' );

/**
 * Render the content of the Turbo Addons dashboard widget.
 */
function trad_render_dashboard_widget() {
	?>

	<div class="trad-dashboard-widget" style="padding:5px;">
		<div class="trad-dashboard-banner" style="margin-bottom:10px;">
            <!-- <h4 style="margin-bottom: 10px; font-weight: 400;">Turbo Addons Pro</h4> -->
            <a href="https://turbo-addons.com/deals/" target="_blank" rel="noopener noreferrer" style="focus:outline:none; text-decoration:none;">
                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/images/sale-offer.webp'); ?>" alt="<?php echo esc_attr__('Turbo Addons Sale Banner', 'turbo-addons-elementor'); ?>" style="max-width:100%; border-radius:6px;"> 
            </a>
		</div>
		<ul style="list-style:none; margin:0; padding:0;">
			<li><a style="font-weight: bold;" href="https://turbo-addons.com/deals/" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Turbo Addons Pro - Visit Now', 'turbo-addons-elementor' ); ?></a></li>
		</ul>
        <hr>
		<div style="margin-top:10px; font-size:13px;">
			<strong><a href="https://turbo-addons.com/contact/" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Need Help?', 'turbo-addons-elementor' ); ?></a></strong>
			<a href="https://www.youtube.com/@turboaddons" target="_blank" rel="noopener noreferrer" style="margin-left:8px; color: #e1002d;">YouTube Channel <span class="dashicons dashicons-youtube"></span></a> | 
			<a href="https://web.facebook.com/groups/792283830069158" target="_blank" rel="noopener noreferrer" style="color: #1877F2">Facebook Community <span class="dashicons dashicons-facebook"></span></a>
		</div>
	</div>

	<?php
}
