<?php


/**
 * Disable Errors during upgrade
 *
 * @return void
 * @access private
 */
function el_upgrade_init() {
		el_add_hook('database', 'execution:message', 'el_disable_database_exception');
}
/**
 * Get upgrade files
 *
 * @return array
 * @access private
 */
function el_get_upgrade_files() {
		$path   = el_validate_filepath(el_route()->upgrade . 'upgrades/');
		$handle = opendir($path);
		if(!$handle) {
				return false;
		}
		
		$files = array();
		
		while($file = readdir($handle)) {
				if($file != "." && $file != "..") {
						$files[] = $file;
				}
		}
		
		sort($files);
		return $files;
}

/**
 * Get the list of files that already being upraded
 *
 * @return array
 * @access private
 */
function el_get_upgraded_files() {
		$settings = new ElSite;
		$upgrades = $settings->getSettings('upgrades');
		$upgrades = json_decode($upgrades);
		if(!is_array($upgrades) || empty($upgrades)) {
				$upgrades = array();
		}
		return $upgrades;
}

/**
 * Get the files that need to be run for upgrade
 *
 * @return array
 * @access private
 */
function el_get_process_upgrade_files() {
		$upgrades           = el_get_upgraded_files();
		$available_upgrades = el_get_upgrade_files();
		return array_diff($available_upgrades, $upgrades);
}

/**
 * Trigger upgrade / Run upgrade
 *
 * @return void;
 * @access private
 */
function el_trigger_upgrades() {
		if(!el_isAdminLoggedin()) {
				el_kill_upgrading();
				el_error_page();
		}
		$upgrades = el_get_process_upgrade_files();
		if(!is_array($upgrades) || empty($upgrades)) {
				el_trigger_message(el_print('upgrade:not:available'), 'error');
				el_kill_upgrading();
				redirect('administrator');
		}
		foreach($upgrades as $upgrade) {
				$file = el_route()->upgrade . "upgrades/{$upgrade}";
				if(!include_once($file)) {
						throw new exception(el_print('upgrade:file:load:error'));
				}
		}
		/**
		 * Since the update wiki states that disable cache,  so this code never works 
		 * https://www.opensource-socialnetwork.org/wiki/view/708/how-to-upgrade-el
		 *
		 * EL v4.2
		 */
		 
		//need to reset cache files
		//if(el_site_settings('cache') !== 0) {
		//		el_trigger_css_cache();
		//		el_trigger_js_cache();
		//}
		
		return true;
}

/**
 * Generate site secret key
 *
 * @return str;
 */
function el_generate_site_secret() {
		return substr(md5('el' . rand()), 3, 8);
}
/**
 * Get update status
 *
 * @return boolean
 */
function el_get_upgrade_status() {
		$upgrading = el_route()->www . '_upgrading_process';
		if(is_file($upgrading)) {
				return true;
		}
		return false;
}
/**
 * Disable exception during upgrade
 *
 * @return void|false
 */
function el_disable_database_exception() {
		if(el_get_upgrade_status()) {
				return false;
		}
}
/**
 * Kill upgrading
 *
 * @return boolean
 */
function el_kill_upgrading() {
		if(el_get_upgrade_status()) {
				$upgrading = el_route()->www . '_upgrading_process';
				unlink($upgrading);
		}
}
/**
 * Update site version
 *
 * @param string $version new Version
 * 
 * @return boolean
 */
function el_update_db_version($version = '') {
		if(!empty($version)) {
				$db             = new ElDatabase;
				$vars           = array();
				$vars['table']  = 'el_site_settings';
				$vars['names']  = array(
						'value'
				);
				$vars['values'] = array(
						$version
				);
				$vars['wheres'] = array(
						"name='site_version'"
				);
				return $db->update($vars);
		}
}
/** 
 * Update processed upgrades
 *
 * @param integer $upgrade New release
 *
 * @return boolean
 */
function el_update_upgraded_files($upgrade) {
		if(empty($upgrade)) {
				return false;
		}
		$database     = new ElDatabase;
		$upgrade_json = array_merge(el_get_upgraded_files(), array(
				$upgrade
		));
		$upgrade_json = json_encode($upgrade_json);
		
		$update           = array();
		$update['table']  = 'el_site_settings';
		$update['names']  = array(
				'value'
		);
		$update['values'] = array(
				$upgrade_json
		);
		$update['wheres'] = array(
				"name='upgrades'"
		);
		
		if($database->update($update)) {
				return true;
		} else {
				return false;
		}
}
/** 
 * Update version of El
 *
 * @param integer $upgrade New release
 *
 * @return boolean
 */
function el_version_upgrade($upgrade, $version) {
		if(empty($upgrade) || empty($version)) {
				return false;
		}
		$release = str_replace('.php', '', $upgrade);
		if(el_update_upgraded_files($upgrade) && el_update_db_version($version)) {
				el_trigger_message(el_print('upgrade:success', array(
						$release
				)), 'success');
		} else {
				el_trigger_message(el_print('upgrade:failed', array(
						$release
				)), 'error');
		}
		return true;
}
//initilize upgrades
el_register_callback('el', 'init', 'el_upgrade_init', 1);
