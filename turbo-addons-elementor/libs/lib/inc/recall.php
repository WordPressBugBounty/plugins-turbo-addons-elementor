<?php
if (!defined('ABSPATH')) {
	exit;
}

class TRAD_Turbo_Addons_Recall_Class
{

	function __construct()
	{

		add_action('init', [$this, 'init']);
	}

	public static function init()
	{
		$remote = \TRAD_Turbo_Template_Library::$plugin_data["remote_site"];
		$endpoint = \TRAD_Turbo_Template_Library::$plugin_data["widget"];
		$remote_page = \TRAD_Turbo_Template_Library::$plugin_data["remote_page_site"];
		// version update
		if (!get_option('trad_turbo_addons_template_items')) {
			// No existing data, fetch from API
			// error_log("No existing data found in trad_turbo_addons_template_items. Fetching from API...");
			$response = wp_safe_remote_get($remote . 'api/ta/v1/' . $endpoint);
			$library_data = json_decode(wp_remote_retrieve_body($response), true);
		
			if (!empty($library_data)) {
				update_option('trad_turbo_addons_template_items', $library_data);
				// error_log("Library data fetched and stored.");
			}
		}
		
		// Now check if the version needs to be updated
		$current_version = get_option('trad_turbo_addons_version');
		
		// Check if first installation (no version stored)
		if (!$current_version) {
			// Set the version for the first time
			update_option('trad_turbo_addons_version', TRAD_TURBO_ADDONS_PLUGIN_VERSION);

			// Fetch and store initial data
			$response = wp_safe_remote_get($remote . 'api/ta/v1/' . $endpoint);
			$library_data = json_decode(wp_remote_retrieve_body($response), true);

			if (!empty($library_data)) {
				update_option('trad_turbo_addons_template_items', $library_data);
				// error_log("Library data fetched and stored on first install.");
			}
		} 
		// Check if version update is required
		elseif ($current_version !== TRAD_TURBO_ADDONS_PLUGIN_VERSION) {
			// error_log("Version mismatch detected. Updating version and re-fetching data...");

			update_option('trad_turbo_addons_version', TRAD_TURBO_ADDONS_PLUGIN_VERSION);

			// Fetch and update data again if version changed
			$response = wp_safe_remote_get($remote . 'api/ta/v1/' . $endpoint);
			$library_data = json_decode(wp_remote_retrieve_body($response), true);

			if (!empty($library_data)) {
				update_option('trad_turbo_addons_template_items', $library_data);
				// error_log("Library data re-fetched and updated due to version change.");
			}
		}else {
			// Fetch and update data again if version changed
			$response = wp_safe_remote_get($remote . 'api/ta/v1/' . $endpoint);
			$library_data = json_decode(wp_remote_retrieve_body($response), true);

			if (!empty($library_data)) {
				update_option('trad_turbo_addons_template_items', $library_data);
				// error_log("Library data re-fetched and updated due to version change.");
			}
		}

		
		// else {
		// 	error_log("Library data and version are up-to-date. No action needed.");
			
		// 	$stored_data = get_option('trad_turbo_addons_template_items');
		// 	$stored_version = get_option('trad_turbo_addons_version');
			
		// 	error_log("Stored Version: " . $stored_version);
		// 	if (!empty($stored_data)) {
		// 		error_log("Stored Library Data: " . json_encode($stored_data, JSON_PRETTY_PRINT));
		// 	} else {
		// 		error_log("Stored Library Data is empty!");
		// 	}
		// }
		
	}
}

new TRAD_Turbo_Addons_Recall_Class();

