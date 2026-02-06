<?php

namespace Elementor\TemplateLibrary;

if (!defined('ABSPATH')) {
	exit;
}

if (did_action('elementor/loaded')) {
	class TRAD_Turbo_Template_Import_Library extends Source_Base
	{
		public function __construct()
		{
			parent::__construct();
			add_action('wp_ajax_trad_turbo_addon_import_template', array($this, 'xl_tab_import_data'));
		}

		public function get_id() {}

		public function get_title() {}

		public function register_data() {}

		public function get_items($args = []) {}

		public function get_item($template_id) {}

		public function get_data(array $args) {}

		public function delete_template($template_id) {}

		public function save_item($template_data) {}

		public function update_item($new_data) {}

		public function export_template($template_id) {}

		public function xl_tab_import_data()
		{
			// error handle
			// if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'trad_turbo_lib_nonce')) {
			// 	wp_send_json_error(array('error' => __('Invalid nonce. You are not allowed to perform this action.', 'turbo-addons-elementor')), 403);
			// 	wp_die();
			// }
			// ✅ Sanitize nonce after unslash
			$nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';

			if (!wp_verify_nonce($nonce, 'trad_turbo_lib_nonce')) {
				wp_send_json_error(array('error' => __('Invalid nonce. You are not allowed to perform this action.', 'turbo-addons-elementor')), 403);
				wp_die();
			}
			//end error handle
			//.................................need tochange with live url.............................................
			//error handle
			// $id = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : '';
			$id = isset($_POST['id']) ? sanitize_text_field(wp_unslash($_POST['id'])) : '';
			//end error handle
			$remote = isset($_POST['parent_site']) ? 'https://mt.turbo-addons.com/' : '';
			$end_point = \TRAD_Turbo_Template_Library::$plugin_data["trad_turbo_import_data"];

			$url = esc_url_raw($remote . 'api/ta/v1/' . $end_point . '/?id=' . urlencode($id));
			$response = wp_safe_remote_get($url, ['timeout' => 120]);

			if (is_wp_error($response)) {
				wp_send_json_error(array('message' => __('Failed to fetch data', 'turbo-addons-elementor')));
				wp_die();
			}

			$data = json_decode(wp_remote_retrieve_body($response), true);

			if (!isset($data['content'])) {
				wp_send_json_error(array('message' => __('Invalid data received', 'turbo-addons-elementor')));
				wp_die();
			}

			$content = $data['content'];
			$content = $this->process_export_import_content($content, 'on_import');
			$content = $this->replace_elements_ids($content);

			echo wp_json_encode($content);
			wp_die();
		}
	}

	new TRAD_Turbo_Template_Import_Library();
}
