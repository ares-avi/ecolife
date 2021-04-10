<?php

/**
 * Register a plugins by path
 * This will help us to override components files easily.
 * 
 * @param string $path A valid path;
 * @return boolean
 */
function el_register_plugins_by_path($path) {
		global $El;
		
		if(el_site_settings('cache') == 1) {
				return false;
		}
		if(!is_dir($path)) {
				//disable error log, will cause a huge log file
				//error_log("El tried to register invalid plugins by path: {$path}");
				return false;
		}
		$path      = str_replace("\\", "/", $path);
		$directory = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
		$iterator  = new RecursiveIteratorIterator($directory);
		if($iterator) {
				foreach($iterator as $file) {
						if(pathinfo($file, PATHINFO_EXTENSION) == "php") {
								$file     = str_replace("\\", "/", $file);
								$location = str_replace(dirname(__FILE__) . '/plugins/', '', $file);
								
								$name = str_replace($path, '', $location);
								$name = substr($name, 0, -4);
								$name = explode('/', $name);
								
								$plugin_type = $name[0];
								unset($name[0]);
								
								$name = implode('/', $name);
								
								$fpath = substr($file, 0, -4);
								$fpath = str_replace(array(
										$name,
										el_route()->www
								), '', $fpath);
								
								$El->plugins[$plugin_type][$name] = $fpath;
						}
				}
		}
		return true;
}
/**
 * View a plugin
 * Plugins are registered using el_register_plugins_by_path()
 * 
 * @param string $plugin A valid plugin name;
 * @param array|object  $vars A valid arrays or object
 * @return void|mixed
 */
function el_plugin_view($plugin = '', $vars = array(), $type = 'default') {
		global $El;
		$args        = array(
				'plugin' => $plugin
		);
		$plugin_type = el_call_hook('plugin', 'view:type', $args, $type);
		if(isset($El->plugins[$plugin_type][$plugin])) {
				$extended_views = el_fetch_extend_views($plugin, $vars);
				return el_view($El->plugins[$plugin_type][$plugin] . $plugin, $vars) . $extended_views;
		}
}
/**
 * Unregister a plugin view
 * We need this if we want to disable a plugin view.
 * 
 * @param string $plugin A valid plugin name;
 * @return void
 */
function el_uregister_plugin_view($plugin) {
		global $El;
		if(isset($El->plugins[$plugin])) {
				unset($El->plugins[$plugin]);
		}
}
/**
 * Generate a paths for plugins for cache
 *
 * @return string|false
 */
function el_plugins_cache_paths() {
		$file = el_get_userdata("system/plugins_paths");
		if(is_file($file) && el_site_settings('cache') == 1) {
				$file = file_get_contents($file);
				return json_decode($file, true);
		}
		return false;
}
/**
 * If cache enabled then load paths for cache
 *
 * @return void;
 */
function el_plugin_set() {
		$paths = el_plugins_cache_paths();
		if($paths) {
				global $El;
				$El->plugins = $paths;
		}
}
el_plugin_set();
