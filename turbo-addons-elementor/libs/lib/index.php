<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TRAD_Turbo_Template_Library')) {

	class TRAD_Turbo_Template_Library
	{

		private static $_instance = null;
		static $plugin_data = null;
		static public function init()
		{

			if (is_null(self::$_instance)) {
				self::$_instance = new self();
				self::$_instance->include_files();
			}
			return self::$_instance;
		}

		private function __construct()
		{

			self::$plugin_data = array(
				'root_file' =>  __FILE__,
				'pro-link' => 'https://turbo-addons.com/elementor-addons-pricing/',
				'remote_site' => 'https://mt.turbo-addons.com/',
				'remote_page_site' => 'https://mt.turbo-addons.com/',
				'widget' => 'ta-items',
				'trad_turbo_import_data' => 'ta-widget'
			);
			// Anik Icon Show ...........................................................................................................................................................
			add_action('elementor/editor/before_enqueue_scripts', array($this, 'editor_script'));
			// Anik Load 
			add_action('wp_ajax_trad_turbo_addon_process_ajax', array($this, 'ajax_data'));

			add_action('wp_ajax_trad_turbo_addon_xl_tab_reload_template', array($this, 'reload_library'));
		}

		public function __clone()
		{

			_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'turbo-addons-elementor'), '1.0.0');
		}

		public function __wakeup()
		{

			_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'turbo-addons-elementor'), '1.0.0');
		}

		public function include_files()
		{

			require __DIR__ . '/inc/import.php';
		}

		public function editor_script()
		{

			wp_enqueue_script('trad-template-library-script',  plugins_url('/assets/js/elementor-manage-library.js', __FILE__), ['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true);
			wp_localize_script('trad-template-library-script', 'trad_turbo_lib_params', [
				'site' => site_url(),
				'nonce' => wp_create_nonce('trad_turbo_lib_nonce'),
			]);
			//Error Handle
			wp_localize_script('trad-template-library-script', 'trad_turbo_lib_nonce_verify', [
				'site' => site_url(),
				'nonce' => wp_create_nonce('trad_turbo_lib_nonce_verify'),
			]);
			wp_enqueue_script('masonry');
			wp_enqueue_style('trad-template-library-style',  plugins_url('/assets/css/style.css', __FILE__),[],TRAD_TURBO_ADDONS_PLUGIN_VERSION);
		}

		function reload_library()
		{
			$file = __DIR__ . '/inc/recall.php';
			if (file_exists($file)) {

				require $file; // Force require, not require_once
		
				// Manually instantiate the class if not already loaded
				if (class_exists('TRAD_Turbo_Addons_Recall_Class')) {
					$instance = new TRAD_Turbo_Addons_Recall_Class();
		
					// Call the init() method directly
					$instance->init();

					die();
				} 
				//error handle
				// else {
				// 	error_log("clss exist!");
				// }
			} 
			//error handle
			// else {
			// 	error_log("File not found: " . $file);
			// }
		}

		function choose_option_table($table_name)
		{
			if ($table_name == 'page') {
				$out = 'pages';
			} elseif ($table_name == 'section') {
				$out = 'section';
			} else {
				$out = 'widget';
			}
			return $out;
		}

		function ajax_data()
		{
			// ⭐ NEW FILTERS — ADD HERE
			$pro_filter     = isset($_POST['data']['pro']) ? sanitize_text_field(wp_unslash($_POST['data']['pro'])) : 'all';
			$website_type   = isset($_POST['data']['website_type']) ? sanitize_text_field(wp_unslash($_POST['data']['website_type'])) : 'all';
			// ⭐ END NEW FILTERS
			$remote_site = isset(self::$plugin_data['remote_site']) ? esc_url_raw(self::$plugin_data['remote_site']) : '';
			$widget      = isset(self::$plugin_data['widget']) ? sanitize_key(wp_unslash(self::$plugin_data['widget'])) : '';

			$request_url = trailingslashit($remote_site) . 'api/ta/v1/' . $widget;

			$response = wp_safe_remote_get(add_query_arg([
				'pro' => $pro_filter,
				'website_type' => $website_type
			], $request_url));

			$direct_data = [];

			if (!is_wp_error($response)) {
				$direct_data = json_decode(wp_remote_retrieve_body($response), true);
			}

			// TYPE selection
			$option_data_item = '';
			if (
				isset($_POST['data']['type'], $_POST['nonce']) &&
				wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'trad_turbo_lib_nonce_verify') &&
				is_string($_POST['data']['type'])
			) {
				$option_data_item = sanitize_text_field(wp_unslash($_POST['data']['type']));
			}

			$option_type = $this->choose_option_table($option_data_item);

			$data = get_option('trad_turbo_addons_template_items');
			$products = $data ? $data[$option_type] : $direct_data[$option_type];

			if (is_array($products)) {

				// INPUT VALUES
				$category     = isset($_POST['data']['category']) ? sanitize_text_field(wp_unslash($_POST['data']['category'])) : '';
				$page_number  = isset($_POST['data']['page']) ? sanitize_text_field(wp_unslash($_POST['data']['page'])) : '';
				$search       = isset($_POST['data']['search']) ? sanitize_text_field(wp_unslash($_POST['data']['search'])) : '';


				$limit = 16;
				$offset = 0;

				$current_page = (int) $page_number ?: 1;
				$offset = ($current_page * $limit) - $limit;

				// SEARCH FILTER
				$search_filter = strtolower($search);
				if (!empty($search_filter)) {
					$products = array_filter($products, function ($product) use ($search_filter) {
						return preg_match("/{$search_filter}/", strtolower($product['name']));
					});
				}

				// ⭐ APPLY PRO / FREE FILTER — ADD HERE
				if ($pro_filter !== 'all') {
					$products = array_filter($products, function ($product) use ($pro_filter) {
						if ($pro_filter === 'pro') {
							return ($product['pro'] === 'on');
						} elseif ($pro_filter === 'free') {
							return ($product['pro'] === 'false');
						}
						return true;
					});
				}
				// ⭐ END PRO / FREE FILTER


				// ⭐ APPLY WEBSITE TYPE FILTER — ADD HERE
				if ($website_type !== 'all') {
					$products = array_filter($products, function ($product) use ($website_type) {
						return isset($product['type']) && $product['type'] === $website_type;
					});
				}
				// ⭐ END WEBSITE TYPE FILTER


				// PAGINATION
				$paged_products = array_slice($products, $offset, $limit);
				$total_products = count($products);
				$total_pages    = ceil($total_products / $limit);

				echo '<div class="item-inner"><div class="item-wrap">';

				if (count($paged_products)) {
					foreach ($paged_products as $product) {

						$template_type = $product['pro'] == 'on'
							? '<span class="pro">pro</span>'
							: '<span class="free">free</span>';

						$parent_site = substr($product['thumb'], 0, strpos($product['thumb'], 'wp-content'));

						if ($product['pro'] == 'on' && !class_exists('TRAD_Turbo_Addons_Pro')) {
							$btn = '<a target="_blank" href="' . self::$plugin_data['pro-link'] . '" class="buy-tmpl"><i class="eicon-external-link-square"></i> Buy pro</a>';
						} else {
							$btn = '<a href="#" data-parentsite="' . $parent_site . '" data-id="' . $product['id'] . '" class="insert-tmpl"><i class="eicon-file-download"></i> Insert</a>';
						}
		?>
						<div class="item">
							<div class="product">
								<div data-preview='<?php echo esc_attr($product['preview']); ?>' class='lib-img-wrap'>
									<?php echo wp_kses_post($template_type); ?>
									<img src="<?php echo esc_url($product['thumb']); ?>">
									<i class="eicon-zoom-in-bold"></i>
								</div>
								<div class='lib-footer'>
									<p class="lib-name"><?php echo esc_html($product['name']); ?></p>
									<?php echo wp_kses_post($btn); ?>
								</div>
							</div>
						</div>
		<?php
					}

					echo '</div><div class="pagination-wrap"><ul>';

					for ($i = 1; $i <= $total_pages; $i++) {
						$active = ($current_page == $i) ? 'active' : '';
						// $active_class = esc_attr($active);

						echo '<li class="page-item ' . esc_attr($active) . '">
								<a class="page-link" href="#" data-page-number="' . esc_attr($i) . '">' . esc_html($i) . '</a>
							</li>';
					}

					echo '</ul></div></div>';
				} else {
					echo '<h3 class="no-found">' . esc_html__('No template found', 'turbo-addons-elementor') . '</h3>';
				}

				die();
			}
		}

	}

	TRAD_Turbo_Template_Library::init();
}
