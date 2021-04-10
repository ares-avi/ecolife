<?php

define('__EL_ADS__', el_route()->com . 'ElAds/');
require_once(__EL_ADS__ . 'classes/ElAds.php');
/**
 * Initialize Ads Component
 *
 * @return void;
 * @access private
 */
function el_ads() {
		el_register_com_panel('ElAds', 'settings');
		if(el_isAdminLoggedin()) {
				el_register_action('elads/add', __EL_ADS__ . 'actions/add.php');
				el_register_action('elads/edit', __EL_ADS__ . 'actions/edit.php');
				el_register_action('elads/delete', __EL_ADS__ . 'actions/delete.php');
		}
		el_register_page('elads', 'el_ads_handler');
		
		el_extend_view('css/el.default', 'css/ads');
		el_extend_view('css/el.admin.default', 'css/ads.admin');
		
		el_add_hook('newsfeed', "sidebar:right", 'el_ads_sidebar', 300);
		el_add_hook('profile', 'modules', 'profile_modules_ads', 300);
		el_add_hook('group', 'widgets', 'group_widgets_ads', 300);
		el_add_hook('theme', 'sidebar:right', 'theme_sidebar_right_ads', 300);
}

/**
 * Get ad image
 *
 * @return image;
 * @access public
 */
function el_ad_image($guid) {
		$photo             = new ElFile;
		$photo->owner_guid = $guid;
		$photo->type       = 'object';
		$photo->subtype    = 'elads';
		$photos            = $photo->getFiles();
		if(isset($photos->{0}->value) && !empty($photos->{0}->value)) {
				$datadir = el_get_userdata("object/{$guid}/{$photos->{0}->value}");
				return file_get_contents($datadir);
		}
}

/**
 * Ad image page handler
 *
 * Pages: photo
 *
 * @return image;
 * @access public
 */
function el_ads_handler($pages) {
		$page = $pages[0];
		if(empty($page)) {
				return false;
		}
		switch($page) {
				case 'photo':
						header('Content-Type: image/jpeg');
						if(!empty($pages[1]) && !empty($pages[1]) && $pages[2] == md5($pages[1]) . '.jpg') {
								$etag = md5($pages[1]);
								header("Etag: $etag");
								
								if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
										header("HTTP/1.1 304 Not Modified");
										exit;
								}
								$image    = el_ad_image($pages[1]);
								$filesize = strlen($image);
								header("Content-type: image/jpeg");
								header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
								header("Pragma: public");
								header("Cache-Control: public");
								header("Content-Length: $filesize");
								header("ETag: \"$etag\"");
								echo $image;
						}
						break;
				default:
						echo el_error_page();
						break;
		}
}

/**
 * Get ad image url
 *
 * @params $guid ad guid
 *
 * @return url;
 * @access public
 */
function el_ads_image_url($guid) {
		$image = md5($guid);
		return el_site_url("elads/photo/{$guid}/{$image}.jpg");
}
/**
 * Get ad entity
 *
 * @params $guid ad guid
 *
 * @return object;
 * @access public
 */
function get_ad_entity($guid) {
		if($guid < 1 || empty($guid)) {
				return false;
		}
		$resume              = new ElObject;
		$resume->object_guid = $guid;
		$resume              = $resume->getObjectById();
		if(isset($resume->guid)) {
				return arrayObject($resume, 'ElAds');
		}
		return false;
}
/**
 * Display ads on sidebar
 *
 * @param string $hook Name of the hook
 * @param string $type A hook type
 * @param array  $return A array with mixed data.
 *
 * @return array
 */
function el_ads_sidebar($hook, $type, $return){
	$return[] =  el_plugin_view('ads/page/view');
	return $return;
}
/**
 * Add Ads module to user profile
 *
 * @return array
 */
function profile_modules_ads($hook, $type, $module, $params) {
		$module[] = el_plugin_view("ads/page/view_small");
		return $module;
}
/**
 * Add Ads widget to group page
 *
 * @return array
 */
function group_widgets_ads($hook, $type, $module, $params) {
		$module[] = el_plugin_view("ads/page/view");
		return $module;
}
/**
 * Add Ads widget to some pages of a theme (e.g. messages)
 *
 * @return array
 */
function theme_sidebar_right_ads($hook, $type, $module, $params) {
		$module[] = el_plugin_view("ads/page/view");
		return $module;
}
el_register_callback('el', 'init', 'el_ads');
