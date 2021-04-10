<?php

el_register_callback('el', 'init', 'el_css');
/**
 * Initialize the css library
 *
 * @return void
 */
function el_css() {
		el_register_page('css', 'el_css_pagehandler');
		el_add_hook('css', 'register', 'el_css_trigger');
		el_extend_view('el/site/head', 'el_css_site');
		el_extend_view('el/admin/head', 'el_css_admin');
}

/**
 * Add css page handler
 *
 * @return false|null
 */
function el_css_pagehandler($css) {
		if(el_site_settings('cache') == 1) {
				return false;
		}
		header("Content-type: text/css");
		$page = $css[0];
		if(empty($css[1])) {
				header('Content-Type: text/html; charset=utf-8');
				el_error_page();
		}
		if(empty($page)) {
				$page = 'view';
		}
		switch($page) {
				case 'view':
						if(el_site_settings('cache') == 1) {
								return false;
						}
						if(el_is_hook('css', "register")) {
								echo el_call_hook('css', "register", $css);
						}
						break;
				default:
						header('Content-Type: text/html; charset=utf-8');
						el_error_page();
						break;
						
		}
}

/**
 * Register a new css to system
 *
 * @param string $name The name of the css
 *               $file  path to css file
 *
 * @return void
 */
function el_new_css($name, $file) {
		global $El;
		$El->css[$name] = $file;
}

/**
 * Remove a css from system
 *
 * This will not remove css file it will just unregister it
 * @param string $name The name of the css
 *
 * @return void
 */
function el_unlink_new_css($name, $file) {
		global $El;
		if(isset($El->css[$name])) {
				unset($El->css[$name]);
		}
}

/**
 * Get a tag for inserting css
 *
 * @params array $args array()
 *
 * @return string
 */
function el_html_css($args) {
		if(!is_array($args)) {
				return false;
		}
		$default = array(
				'rel' => 'stylesheet',
				'type' => 'text/css'
		);
		$args    = array_merge($default, $args);
		return "\r\n<link " . el_args($args) . " />";
}

/**
 * Load css to system
 *
 * @params string $name =  name of css
 *                $type   site or admin
 *
 * @return void
 */
function el_load_css($name, $type = 'site') {
		global $El;
		$El->csshead[$type][] = $name;
}
/**
 * El system unloads css from head
 *
 * @param string $name The name of the css
 *
 * @return void
 */
function el_unload_css($name, $type = 'site') {
		global $El;
		$css = array_search($name, $El->csshead[$type]);
		if($css !== false) {
				unset($El->csshead[$type][$css]);
		}
}
/**
 * Load registered css to system for site
 *
 * @return html.tag
 */
function el_css_site() {
		global $El;
		$url      = el_site_url();
		//load external css
		$external = $El->cssheadExternal['site'];
		if(!empty($external)) {
				foreach($external as $item) {
						echo el_html_css(array(
								'href' => $El->cssExternal[$item]
						));
				}
		}
		
		//load internal css
		if(isset($El->csshead['site'])) {
				foreach($El->csshead['site'] as $css) {
						$href = "{$url}css/view/{$css}.css";
						if(el_site_settings('cache') == 1) {
								$cache = el_site_settings('last_cache');
								$href  = "{$url}cache/css/{$cache}/view/{$css}.css";
						}
						echo el_html_css(array(
								'href' => $href
						));
				}
		}
		
}

/**
 * Load registered css to system for admin
 *
 * @return html.tag
 */
function el_css_admin() {
		global $El;
		$url      = el_site_url();
		//load external css
		$external = $El->cssheadExternal['admin'];
		if(!empty($external)) {
				foreach($external as $item) {
						echo el_html_css(array(
								'href' => $El->cssExternal[$item]
						));
				}
		}
		
		//load internal css
		if(isset($El->csshead['admin'])) {
				foreach($El->csshead['admin'] as $css) {
						$href = "{$url}css/view/{$css}.css";
						if(el_site_settings('cache') == 1) {
								$cache = el_site_settings('last_cache');
								$href  = "{$url}cache/css/{$cache}/view/{$css}.css";
						}
						echo el_html_css(array(
								'href' => $href
						));
				}
		}
}

/**
 * Check if the requested css is registered then load css
 *
 * @return string|false
 */
function el_css_trigger($hook, $type, $value, $params) {
		global $El;
		if(isset($params[1]) && substr($params[1], '-4') == '.css') {
				$params[1] = str_replace('.css', '', $params[1]);
				if(isset($El->css[$params[1]])) {
						$file     = el_plugin_view($El->css[$params[1]]);
						$extended = el_fetch_extend_views("css/{$params[1]}");
						$data     = array(
								$file,
								$extended
						);
						return implode(' ', $data);
				}
		}
		return false;
}
/**
 * Register a new external css to system
 *
 * @param string $name The name of the css
 *               $file  complete url path to css file
 *
 * @return void
 */
function el_new_external_css($name, $file, $type = true) {
		global $El;
		if($type) {
				$El->cssExternal[$name] = el_site_url($file);
		} else {
				$El->cssExternal[$name] = $file;
		}
}
/**
 * Remove a external css from system
 *
 * @param string $name The name of the css
 *               $file  complete url path to css file
 *
 * @return void
 */
function el_unlink_external_css($name) {
		global $El;
		unset($El->cssExternal[$name]);
}
/**
 * Load registered css to system for site
 *
 * @return html.tag
 */
function el_load_external_css($name, $type = 'site') {
		global $El;
		$El->cssheadExternal[$type][] = $name;
}
/**
 * El system unloads css from head
 *
 * @param string $name The name of the css
 *
 * @return void
 */
function el_unload_external_css($name, $type = 'site') {
		global $El;
		$css = array_search($name, $El->cssheadExternal[$type]);
		if($css !== false) {
				unset($El->cssheadExternal[$type][$css]);
		}
}
