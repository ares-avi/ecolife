<?php


/**
 * Generate css cache
 *
 * @return false|void
 */
function el_trigger_css_cache($cache = '') {
		if(empty($cache)) {
				return false;
		}
		global $El;
		
		require_once(el_route()->libs . 'minify/CSSmin.php');
		$minify = new CSSmin;
		
		$dir = el_route()->cache;
		if(!is_dir("{$dir}css/{$cache}/view/")) {
				mkdir("{$dir}css/{$cache}/view/", 0755, true);
		}
		if(!isset($El->css)) {
				return false;
		}
		foreach($El->css as $name => $file) {
				$cache_file = "{$dir}css/{$cache}/view/{$name}.css";
				$css        = $minify->run(el_plugin_view($file));
				$css .= $minify->run(el_fetch_extend_views("css/{$name}"));
				file_put_contents($cache_file, $css);
		}
}

/**
 * Generate js cache
 *
 * @return false|void
 */
function el_trigger_js_cache($cache = '') {
		if(empty($cache)) {
				return false;
		}
		global $El;
		require_once(el_route()->libs . 'minify/JSMin.php');
		$dir = el_route()->cache;
		if(!is_dir("{$dir}js/{$cache}/view/")) {
				mkdir("{$dir}js/{$cache}/view/", 0755, true);
		}
		if(!isset($El->js)) {
				return false;
		}
		header('Content-Type: text/html; charset=utf-8');
		foreach($El->js as $name => $file) {
				$cache_file = "{$dir}js/{$cache}/view/{$name}.js";
				$js         = JSMin::minify(el_plugin_view($file));
				$js .= JSMin::minify(el_fetch_extend_views("js/{$name}"));
				file_put_contents($cache_file, $js);
		}
}
/**
 * Create a cache for plugin paths
 *
 * @return void;
 */
function el_trigger_plugins_cache() {
		global $El;
		if(isset($El->plugins)) {
				//we have to also secure paths
				$dir = el_get_userdata("system/");
				if(!is_dir($dir)) {
						mkdir($dir, 0755, true);
				}
				$encode = json_encode($El->plugins);
				file_put_contents($dir . 'plugins_paths', $encode);
		}
}
/**
 * Create languages cache
 *
 * @retrun false|void
 */
function el_trigger_language_cache($cache) {
		if(empty($cache)) {
				return false;
		}
		global $El;
		$available_languages = el_get_available_languages();
		$dir = el_route()->cache;
		
		$coms = new ElComponents;
		$comlist = $coms->getActive();
		$comdir  = el_route()->com;	

		$system_locale_cache = el_get_userdata("system/locales/");
		if(!is_dir($system_locale_cache)) {
				mkdir($system_locale_cache, 0755, true);
		}
		header('Content-Type: application/json; charset=utf-8');
		foreach($available_languages as $lang) {
				//load all laguages
				foreach($El->locale[$lang] as $item){
					if(is_file($item)){
						include_once($item);
					}
				}
				//load components all languages
				if($comlist){
					foreach($comlist as $com){
								if(is_file("{$comdir}{$com->com_id}/locale/el.{$lang}.php")) {
										include_once("{$comdir}{$com->com_id}/locale/el.{$lang}.php");
								}						
					}
				}
				if(isset($El->localestr[$lang])) {
						$json = el_load_json_locales($lang);
						//private locale cache , Cache the locale files #1321
						$file     = $system_locale_cache . "el.{$lang}.json";
						file_put_contents($file, $json);
						
						//public js cache		
						$json = "var ElLocale = $json";
						$cache_file = "{$dir}js/{$cache}/view/el.{$lang}.language.js";
						file_put_contents($cache_file, "\xEF\xBB\xBF" . $json);
				}
		}
}
/**
 * Create and Enable site cache
 *
 * @return bool
 */
function el_create_cache() {
		$database         = new ElDatabase;
		$params['table']  = 'el_site_settings';
		$params['names']  = array(
				'value'
		);
		$params['values'] = array(
				1
		);
		$params['wheres'] = array(
				"setting_id='4'"
		);
		$time = time();
		el_trigger_callback('cache', 'before:create', array(
				'time' => $time,
		));					
		if($database->update($params)) {
				global $El;
				$cache = el_update_last_cache();
				if($cache) {
						//update last_cache settings on run time
						$El->siteSettings->cache = 1;						
						$El->siteSettings->last_cache = $cache;
						el_link_cache_files($cache);
						
						el_trigger_callback('cache', 'created', array(
								'time' => $time,
						));						
				}
				return true;
		}
		return false;
}
/**
 * Update last cache time
 *
 * @return integer;
 */
function el_update_last_cache($type = true) {
		if($type === true) {
				$time = time();
		} else {
				$time = 0;
		}
		$database         = new ElDatabase;
		$params['table']  = 'el_site_settings';
		$params['names']  = array(
				'value'
		);
		$params['values'] = array(
				$time
		);
		$params['wheres'] = array(
				"name='last_cache'"
		);
		if($database->update($params)) {
				return $time;
		}
		return false;
}
/**
 * Disable cache
 *
 * @return bool
 */
function el_disable_cache() {
		$database         = new ElDatabase;
		$params['table']  = 'el_site_settings';
		$params['names']  = array(
				'value'
		);
		$params['values'] = array(
				0
		);
		$params['wheres'] = array(
				"setting_id='4'"
		);
		if($database->update($params)) {
				el_update_last_cache(false);
				el_unlink_cache_files();
				return true;
		}
		return false;
}
/**
 * Link cache files
 *
 * @return void;
 */
function el_link_cache_files($cache) {
		if(empty($cache)) {
				return false;
		}
		el_trigger_css_cache($cache);
		el_trigger_js_cache($cache);
		el_trigger_language_cache($cache);
		el_trigger_plugins_cache();
}
/**
 * Unlink cache files
 *
 * @return void;
 */
function el_unlink_cache_files() {
		ElFile::DeleteDir(el_route()->cache);
		ElFile::DeleteDir(el_get_userdata("system/"));
}
/**
 * Add action tokens to url
 * 
 * @param string $url Full complete url
 * 
 * @return string
 */
function el_add_cache_to_url($url){
	if(el_site_settings('cache') == 0){
			return $url;	
	}
	$params = parse_url($url);
	
	$query = array();
	if(isset($params['query'])){
		parse_str($params['query'],  $query);
	}
	$tokens['el_cache'] = hash('crc32b', el_site_settings('last_cache'));
	$tokens = array_merge($query, $tokens);
	
	$query = http_build_query($tokens);
	
	$params['query'] = $query;
	return  el_build_token_url($params);	
}
