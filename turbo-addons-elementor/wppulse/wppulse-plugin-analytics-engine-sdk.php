<?php
/**
 * SDK: WPPulse – Plugin Analytics Engine
 * Description: Lightweight plugin analytics SDK with optional deactivation feedback modal.
 * Author: Turbo Addons
 * @package WPPulse
 */

if ( ! defined( 'ABSPATH' ) ) exit;
// phpcs:disable WordPress.WP.I18n.NonSingularStringLiteralDomain, WordPress.WP.I18n.TextDomainMismatch
/**
 * WPPulse SDK – works like Appsero SDK but fully open-source.
 *
 * One canonical class is shared by every plugin. Configuration is stored per
 * plugin (keyed by plugin basename), so activating/deactivating one plugin can
 * never overwrite another plugin's events.
 *
 * Privacy (WordPress.org guideline 7): nothing that identifies the site (URL,
 * admin email) is sent until an administrator explicitly opts in from the
 * admin notice. Without consent only an anonymous deactivation answer that the
 * user typed and submitted themselves is sent.
 *
 * The class name is versioned so that an older, consent-less copy bundled in
 * another plugin (class WPPulse_SDK) is never used for this plugin.
 */
class WPPulse_SDK_V2 {

	/**
	 * Default telemetry endpoint, also used by uninstall.php where init() never runs.
	 */
	const DEFAULT_ENDPOINT = 'https://wp-turbo.com/wp-json/wppulse/v1/collect';

	/**
	 * Option holding each plugin's consent decision: [ basename => 'yes'|'no' ].
	 */
	const CONSENT_OPTION = 'wppulse_consent';

	/**
	 * Per-plugin configuration, keyed by plugin basename.
	 *
	 * @var array<string, array>
	 */
	private static $plugins = [];

	/**
	 * Whether the shared hooks (modal + AJAX + updater) are registered.
	 *
	 * @var bool
	 */
	private static $shared_hooks = false;

	/**
	 * Whether the feedback modal was already printed.
	 *
	 * @var bool
	 */
	private static $modal_printed = false;

	/**
	 * Initialize the SDK for one plugin.
	 *
	 * @param string $file Main plugin file.
	 * @param array  $args Configuration (name, slug, version, endpoint).
	 */
	public static function init( $file, $args ) {
		$key = plugin_basename( $file );

		self::$plugins[ $key ] = wp_parse_args( $args, [
			'name'     => '',
			'slug'     => '',
			'version'  => '',
			'endpoint' => '',
		] );

		// Track activation/deactivation per plugin, without a shared static $file.
		register_activation_hook( $file, function () use ( $key ) {
			self::send( $key, 'activated' );
		} );

		register_deactivation_hook( $file, function () use ( $key ) {
			self::deactivated( $key );
		} );

		// Tag this plugin's deactivate link so the modal knows which plugin it is.
		add_filter( 'plugin_action_links_' . $key, function ( $links ) use ( $key ) {
			if ( isset( $links['deactivate'] ) ) {
				$links['deactivate'] = str_replace(
					'<a ',
					'<a class="wppulse-deactivate-link" data-wppulse-plugin="' . esc_attr( $key ) . '" ',
					$links['deactivate']
				);
			}
			return $links;
		} );

		if ( self::$shared_hooks ) {
			return;
		}
		self::$shared_hooks = true;

		add_action( 'upgrader_process_complete', [ __CLASS__, 'updated' ], 10, 2 );
		add_action( 'admin_footer', [ __CLASS__, 'print_modal' ] );
		add_action( 'wp_ajax_wppulse_reason_submit', [ __CLASS__, 'ajax_reason_submit' ] );
		add_action( 'wp_ajax_wppulse_reason_skip', [ __CLASS__, 'ajax_reason_skip' ] );
		add_action( 'admin_notices', [ __CLASS__, 'consent_notice' ] );
		add_action( 'wp_ajax_wppulse_consent', [ __CLASS__, 'ajax_consent' ] );
	}

	/**
	 * Consent decision for one plugin.
	 *
	 * @param string $key Plugin basename.
	 * @return string 'yes', 'no' or '' (not decided yet).
	 */
	public static function consent( $key ) {
		$all = get_option( self::CONSENT_OPTION, [] );
		return ( is_array( $all ) && isset( $all[ $key ] ) && in_array( $all[ $key ], [ 'yes', 'no' ], true ) ) ? $all[ $key ] : '';
	}

	/**
	 * Store the consent decision for one plugin.
	 *
	 * @param string $key    Plugin basename.
	 * @param string $answer 'yes' or 'no'.
	 */
	private static function set_consent( $key, $answer ) {
		$all = get_option( self::CONSENT_OPTION, [] );
		$all = is_array( $all ) ? $all : [];
		$all[ $key ] = ( 'yes' === $answer ) ? 'yes' : 'no';
		update_option( self::CONSENT_OPTION, $all, false );
	}

	/**
	 * Opt-in notice for administrators (dashboard, plugins and the plugin's own
	 * pages), shown until they decide.
	 */
	public static function consent_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( $screen && ! in_array( $screen->base, [ 'dashboard', 'plugins' ], true ) && false === strpos( (string) $screen->id, 'turbo' ) ) {
			return;
		}
		$printed = false;
		foreach ( self::$plugins as $key => $cfg ) {
			if ( '' !== self::consent( $key ) ) {
				continue;
			}
			$printed = true;
			$domain  = ! empty( $cfg['slug'] ) ? $cfg['slug'] : self::text_domain();
			?>
			<div class="notice notice-info wppulse-consent" data-plugin="<?php echo esc_attr( $key ); ?>">
				<p>
					<strong><?php echo esc_html( sprintf( /* translators: %s: plugin name */ __( 'Help us improve %s', $domain ), $cfg['name'] ) ); ?></strong><br>
					<?php esc_html_e( 'Allow sharing your site URL, admin email and plugin version with WP-Turbo when the plugin is activated, updated or deactivated? No other data is collected, and nothing is sent unless you allow it.', $domain ); ?>
					<a href="https://wp-turbo.com/privacy-policy/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Privacy policy', $domain ); ?></a>
				</p>
				<p>
					<button type="button" class="button button-primary wppulse-consent-btn" data-answer="yes"><?php esc_html_e( 'Allow', $domain ); ?></button>
					<button type="button" class="button wppulse-consent-btn" data-answer="no"><?php esc_html_e( 'No thanks', $domain ); ?></button>
				</p>
			</div>
			<?php
		}
		if ( ! $printed ) {
			return;
		}
		?>
		<script>
		jQuery(function($){
			$(document).on('click', '.wppulse-consent-btn', function(){
				var box = $(this).closest('.wppulse-consent');
				$.post(ajaxurl, { action: 'wppulse_consent', nonce: '<?php echo esc_js( wp_create_nonce( 'wppulse_consent_nonce' ) ); ?>', plugin: box.data('plugin'), answer: $(this).data('answer') });
				box.slideUp(150);
			});
		});
		</script>
		<?php
	}

	/** AJAX: store the opt-in / opt-out answer. */
	public static function ajax_consent() {
		check_ajax_referer( 'wppulse_consent_nonce', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Permission denied.', self::text_domain() ), 403 );
		}
		$key = self::request_plugin_key();
		if ( '' === $key ) {
			wp_send_json_error( __( 'Unknown plugin.', self::text_domain() ), 400 );
		}
		$answer = ( isset( $_POST['answer'] ) && 'yes' === sanitize_key( wp_unslash( $_POST['answer'] ) ) ) ? 'yes' : 'no';
		self::set_consent( $key, $answer );
		if ( 'yes' === $answer ) {
			self::send( $key, 'opted_in' );
		}
		wp_send_json_success();
	}

	/**
	 * Plugin deactivated: send unless the modal already reported it.
	 *
	 * @param string $key Plugin basename.
	 */
	public static function deactivated( $key ) {
		$flag = self::flag_key( $key );

		if ( get_transient( $flag ) ) {
			delete_transient( $flag );
			return;
		}

		self::send( $key, 'deactivated' );
	}

	/**
	 * Plugin updated (single or bulk).
	 *
	 * @param WP_Upgrader $upgrader Upgrader instance.
	 * @param array       $options  Upgrader options.
	 */
	public static function updated( $upgrader, $options ) {
		if ( ! is_array( $options ) || 'plugin' !== ( $options['type'] ?? '' ) || 'update' !== ( $options['action'] ?? '' ) ) {
			return;
		}

		$updated = [];
		if ( ! empty( $options['plugins'] ) && is_array( $options['plugins'] ) ) {
			$updated = $options['plugins'];
		} elseif ( ! empty( $options['plugin'] ) ) {
			$updated = [ $options['plugin'] ];
		}

		foreach ( array_unique( $updated ) as $plugin ) {
			if ( isset( self::$plugins[ $plugin ] ) ) {
				self::send( $plugin, 'updated' );
			}
		}
	}

	/**
	 * Send the uninstall event from uninstall.php.
	 *
	 * @param string $main_file Main plugin file (used for name/version headers).
	 * @param string $endpoint  Telemetry endpoint.
	 */
	public static function track_uninstall( $main_file, $endpoint = self::DEFAULT_ENDPOINT ) {
		$data = get_file_data( $main_file, [
			'Name'    => 'Plugin Name',
			'Version' => 'Version',
		] );

		$key = plugin_basename( $main_file );

		self::$plugins[ $key ] = [
			'name'     => $data['Name'],
			'slug'     => dirname( $key ),
			'version'  => $data['Version'],
			'endpoint' => $endpoint,
		];

		self::send( $key, 'uninstalled' );
	}

	/**
	 * Feedback modal HTML + JS (printed once).
	 */
	public static function print_modal() {
		global $pagenow;
		if ( 'plugins.php' !== $pagenow || self::$modal_printed ) return;
		self::$modal_printed = true;

		$nonce  = wp_create_nonce( 'wppulse_reason_nonce' );
		$domain = self::text_domain();
		?>
		<style>
		#wppulse-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:999999;font-family:"Inter",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;}
		.wppulse-modal-wrap{background:#fff;width:992px;margin:6% auto;border-radius:8px;box-shadow:0 10px 30px rgba(0,0,0,0.15);overflow:hidden;}
		.wppulse-header{padding:24px 32px 10px;}
		.wppulse-header h2{margin:0;font-size:18px;color:#111827;font-weight:600;}
		.wppulse-body{padding:0 32px 22px;}
		.wppulse-reason-grid{display:flex;flex-wrap:wrap;gap:10px;margin-top:20px;}
		.wppulse-reason-item{flex:1 1 10%;border:1px solid #E5E7EB;border-radius:8px;padding:18px 12px 10px; text-align:center!important; background:#fff;cursor:pointer;transition:all .2s; display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:100px;}
		.wppulse-reason-item i{display:block;font-size:28px;color:#2563EB;margin-bottom:8px;}
		.wppulse-reason-item span{display:block;font-size:13px;color:#111827;font-weight:500;}
		.wppulse-reason-item.active{background:#2563EB;border-color:#2563EB;}
		.wppulse-reason-item.active i,.wppulse-reason-item.active span{color:#fff;}
		#wppulse-desc{width:100%;height:90px;border:1px solid #D1D5DB;border-radius:6px;padding:10px;margin-top:18px;font-size:14px;color:#111827; display: none;}
		.wppulse-footer{border-top:1px solid #E5E7EB;padding:16px 28px;display:flex;justify-content:space-between;align-items:center;}
		.wppulse-footer .button{border-radius:4px;padding:6px 14px;font-size:14px;}
		.wppulse-footer .button-primary{background:#2563EB;border-color:#2563EB;}
		</style>

		<div id="wppulse-modal">
			<div class="wppulse-modal-wrap">
				<div class="wppulse-header">
					<h2><?php esc_html_e( 'Before deactivation, could you tell us why?', $domain ); ?></h2>
				</div>
				<div class="wppulse-body">
					<div class="wppulse-reason-grid" id="wppulse-reason-grid">
						<?php
						$reasons = [
							'couldnt-understand'  => __( "Couldn't understand", $domain ),
							'found-better-plugin' => __( 'Found a better plugin', $domain ),
							'missing-feature'     => __( 'Missing a feature', $domain ),
							'not-working'         => __( 'Not working', $domain ),
							'not-what-looking'    => __( 'Not what I was looking for', $domain ),
							'didnt-work-expected' => __( "Didn't work as expected", $domain ),
							'others'              => __( 'Others', $domain ),
						];
						foreach ( $reasons as $slug => $label ) {
							switch ( $slug ) {
								case 'couldnt-understand':
									$icon = 'editor-help';
									break;
								case 'found-better-plugin':
									$icon = 'awards';
									break;
								case 'missing-feature':
									$icon = 'admin-tools';
									break;
								case 'not-working':
									$icon = 'dismiss';
									break;
								case 'not-what-looking':
									$icon = 'search';
									break;
								case 'didnt-work-expected':
									$icon = 'warning';
									break;
								case 'others':
								default:
									$icon = 'ellipsis';
									break;
							}

							printf(
								'<div class="wppulse-reason-item" data-value="%1$s"><i class="dashicons dashicons-%3$s"></i><span>%2$s</span></div>',
								esc_attr( $slug ),
								esc_html( $label ),
								esc_attr( $icon )
							);
						}
						?>
					</div>
					<textarea id="wppulse-desc" placeholder="<?php esc_attr_e( 'Optional: tell us more...', $domain ); ?>"></textarea>
					<p style="margin-top: 18px!important;"><?php esc_html_e( 'Submitting sends your answer to WP-Turbo to help us improve the plugin. Your site URL and admin email are included only if you allowed usage sharing.', $domain ); ?> <a href="https://wp-turbo.com/privacy-policy/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Learn more about how we handle your data.', $domain ); ?></a></p>
				</div>
				<div class="wppulse-footer">
					<button type="button" id="wppulse-skip" class="button"><?php esc_html_e( 'Skip & Deactivate', $domain ); ?></button>
					<div>
						<button type="button" id="wppulse-cancel" class="button"><?php esc_html_e( 'Cancel', $domain ); ?></button>
						<button type="button" id="wppulse-submit" class="button button-primary"><?php esc_html_e( 'Submit & Deactivate', $domain ); ?></button>
					</div>
				</div>
			</div>
		</div>

		<script>
		jQuery(function($){
			var modal = $('#wppulse-modal');
			var deactivateLink = '';
			var pluginKey = '';
			var selectedReason = '';
			var descBox = $('#wppulse-desc');

			$('#the-list').on('click', 'a.wppulse-deactivate-link', function(e){
				e.preventDefault();
				deactivateLink = $(this).attr('href');
				pluginKey = $(this).attr('data-wppulse-plugin') || '';
				modal.fadeIn(200);
			});

			$('#wppulse-reason-grid').on('click', '.wppulse-reason-item', function(){
				$('.wppulse-reason-item').removeClass('active');
				$(this).addClass('active');
				selectedReason = $(this).data('value');

				if(selectedReason){
					descBox.slideDown(200);
				}
			});

			$('#wppulse-cancel').on('click', function(){
				modal.fadeOut(200);
			});

			$('#wppulse-skip').on('click', function(){
				$.post(ajaxurl, { action:'wppulse_reason_skip', nonce:'<?php echo esc_js( $nonce ); ?>', plugin:pluginKey })
					.always(function(){ window.location.href = deactivateLink; });
			});

			$('#wppulse-submit').on('click', function(){
				$.post(ajaxurl, {
					action:'wppulse_reason_submit',
					nonce:'<?php echo esc_js( $nonce ); ?>',
					plugin:pluginKey,
					reason_id:selectedReason,
					reason_text:$('#wppulse-desc').val()
				}).always(function(){ window.location.href = deactivateLink; });
			});
		});
		</script>

		<?php
	}

	/** AJAX: Skip button. */
	public static function ajax_reason_skip() {
		check_ajax_referer( 'wppulse_reason_nonce', 'nonce' );
		if ( ! current_user_can( 'activate_plugins' ) ) {
			wp_send_json_error( __( 'Permission denied.', self::text_domain() ) );
		}

		$key = self::request_plugin_key();
		if ( '' === $key ) {
			wp_send_json_error( __( 'Unknown plugin.', self::text_domain() ), 400 );
		}

		if ( self::send( $key, 'deactivated' ) ) {
			set_transient( self::flag_key( $key ), 1, MINUTE_IN_SECONDS );
		}

		wp_send_json_success();
	}

	/** AJAX: Submit feedback. */
	public static function ajax_reason_submit() {
		check_ajax_referer( 'wppulse_reason_nonce', 'nonce' );
		if ( ! current_user_can( 'activate_plugins' ) ) {
			wp_send_json_error( __( 'Permission denied.', self::text_domain() ) );
		}

		$key = self::request_plugin_key();
		if ( '' === $key ) {
			wp_send_json_error( __( 'Unknown plugin.', self::text_domain() ), 400 );
		}

		$reason = isset( $_POST['reason_id'] ) ? sanitize_text_field( wp_unslash( $_POST['reason_id'] ) ) : '';
		$text   = isset( $_POST['reason_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['reason_text'] ) ) : '';

		// The admin typed and submitted this answer, so it is sent even without
		// opt-in, but then anonymously (no site URL / admin email).
		if ( self::send( $key, 'deactivated', [ 'reason_id' => $reason, 'reason_text' => $text ], true ) ) {
			set_transient( self::flag_key( $key ), 1, MINUTE_IN_SECONDS );
		}

		wp_send_json_success();
	}

	/**
	 * Resolve and validate the plugin key posted by the modal.
	 *
	 * @return string Plugin basename, or empty string when unknown.
	 */
	private static function request_plugin_key() {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce verified by the caller.
		$raw = isset( $_POST['plugin'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin'] ) ) : '';
		$key = plugin_basename( $raw );

		return isset( self::$plugins[ $key ] ) ? $key : '';
	}

	/**
	 * Send telemetry data to the WPPulse server.
	 *
	 * @param string $key    Plugin basename.
	 * @param string $status Event status.
	 * @param array  $extra  Extra payload fields.
	 * @param bool   $anonymous_ok Send an anonymous event when the admin has not opted in.
	 * @return bool True when the receiver accepted the event (2xx).
	 */
	private static function send( $key, $status, $extra = [], $anonymous_ok = false ) {
		if ( empty( self::$plugins[ $key ] ) ) {
			return false;
		}

		$consented = ( 'yes' === self::consent( $key ) );
		if ( ! $consented && ! $anonymous_ok ) {
			return false;
		}

		$cfg      = self::$plugins[ $key ];
		$endpoint = ! empty( $cfg['endpoint'] ) ? $cfg['endpoint'] : self::DEFAULT_ENDPOINT;

		$body = [
			'plugin'  => sanitize_text_field( $cfg['name'] ),
			'version' => sanitize_text_field( $cfg['version'] ),
			'status'  => sanitize_text_field( $status ),
		];
		if ( $consented ) {
			$body['domain'] = esc_url_raw( home_url() );
			$body['email']  = sanitize_email( get_bloginfo( 'admin_email' ) );
		}
		$body = array_merge( $body, $extra );

		$response = wp_remote_post( $endpoint, [
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body'    => wp_json_encode( $body ),
			'timeout' => 10,
		] );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );

		return $code >= 200 && $code < 300;
	}

	/**
	 * Transient key used to avoid a duplicate deactivation event.
	 *
	 * @param string $key Plugin basename.
	 * @return string
	 */
	private static function flag_key( $key ) {
		return 'wppulse_deact_' . md5( $key );
	}

	/**
	 * Text domain for the shared modal (first registered plugin's slug).
	 *
	 * @return string
	 */
	private static function text_domain() {
		foreach ( self::$plugins as $cfg ) {
			if ( ! empty( $cfg['slug'] ) ) {
				return $cfg['slug'];
			}
		}
		return 'wppulse-analytics-engine';
	}
}
// phpcs:enable WordPress.WP.I18n.NonSingularStringLiteralDomain, WordPress.WP.I18n.TextDomainMismatch
