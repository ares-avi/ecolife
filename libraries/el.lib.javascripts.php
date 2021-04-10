<?php


/**
 * Initialize the css library
 *
 * @return void
 */
function el_javascript() {
    el_register_page('js', 'el_javascript_pagehandler');
    el_add_hook('js', 'register', 'el_js_trigger');

    el_extend_view('el/site/head', 'el_site_js');
    el_extend_view('el/admin/head', 'el_admin_js');
	
    el_extend_view('el/site/head', 'el_jquery_add');
    el_extend_view('el/admin/head', 'el_jquery_add');

    el_new_js('opensource.socialnetwork', 'javascripts/libraries/core');
	
    el_load_js('opensource.socialnetwork');
    el_load_js('opensource.socialnetwork', 'admin');
	
	//some internal and external js
	el_new_external_js('chart.js', 'vendors/Chartjs/Chart.min.js');
	el_new_external_js('chart.legend.js', 'vendors/Chartjs/chart.legend.js');
	el_new_external_js('jquery-1.11.1.min.js', 'vendors/jquery/jquery-1.11.1.min.js');
	el_new_external_js('tinymce.min', 'vendors/tinymce/tinymce.min.js');
	el_new_external_js('jquery-ui.min.js', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js', false);
	
	el_load_external_js('jquery-1.11.1.min.js');
	el_load_external_js('jquery-1.11.1.min.js', 'admin');

	el_load_external_js('jquery-ui.min.js');
	el_load_external_js('jquery-ui.min.js', 'admin');
	
	el_load_external_js('tinymce.min', 'admin');
	
	if(el_get_context() != 'administrator'){
		el_new_external_js('jquery-arhandler-1.1-min.js', 'vendors/jquery/jquery-arhandler-1.1-min.js');
		el_load_external_js('jquery-arhandler-1.1-min.js');
	}
}

/**
 * Add css page handler
 *
 * @return bool
 */
function el_javascript_pagehandler($js) {
    $page = $js[0];
    if (empty($js[1])) {
        echo '404 SWITCH ERROR';
    }
    if (empty($page)) {
        $page = 'view';
    }
    switch ($page) {
        case 'view':
            if (el_site_settings('cache') == 1) {
                return false;
            }
            header("Content-type: text/javascript");
            if (el_is_hook('js', "register")) {
                echo el_call_hook('js', "register", $js);
            }
            break;

        default:
            echo '404 SWITCH ERROR';
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
function el_new_js($name, $file) {
    global $El;
    $El->js[$name] = $file;
}
/**
 * Register a new external js to system
 *
 * @param string $name The name of the css
 *               $file  complete url path to css file
 *
 * @return void
 */
function el_new_external_js($name, $file, $type = true) {
    global $El;
	if($type){
	    $El->jsExternal[$name] = el_site_url($file);
	} else {
	    $El->jsExternal[$name] = $file;		
	}
}
/**
 * Remove a external js from system
 *
 * @param string $name The name of the css
 *               $file  complete url path to css file
 *
 * @return void
 */
function el_unlink_external_js($name) {
    global $El;
    unset($El->jsExternal[$name]);
}
/**
 * Remove a js from system
 *
 * This will not remove js file it will just unregister it
 * @param string $name The name of the js
 *
 * @return void
 */
function el_unlink_new_js($name) {
    global $El;
    if(isset($El->js[$name])){
	   unset($El->js[$name]);	
	}
}

/**
 * Get a tag for inserting css
 *
 * @params string $args   array()
 *
 * @return string
 */
function el_html_js($args) {
	if(!is_array($args)){
		return false;
	}
	$default = array();	
	$args = array_merge($default, $args);
    $extend = el_args($args);
    return "\r\n<script {$extend}></script>";
}

/**
 * Load registered js to system for site
 *
 * @return html.tag
 */
function el_load_js($name, $type = 'site') {
    global $El;
    $El->jshead[$type][] = $name;
}
/**
 * El system unloads js from head
 *
 * @param string $name The name of the js
 *
 * @return void
 */
function el_unload_js($name, $type = 'site') {
    global $El;
	$js = array_search($name, $El->jshead[$type]);
    if($js !== false){
		unset($El->jshead[$type][$js]);
	}
}
/**
 * Load registered js to system for site
 *
 * @return html.tag
 */
function el_load_external_js($name, $type = 'site') {
    global $El;
    $El->jsheadExternal[$type][] = $name;
}
/**
 * El system unloads js from head
 *
 * @param string $name The name of the js
 *
 * @return void
 */
function el_unload_external_js($name, $type = 'site') {
    global $El;
	$js = array_search($name, $El->jsheadExternal[$type]);
    if($js !== false){
		unset($El->jsheadExternal[$type][$js]);
	}
}

/**
 * Load js for frontend
 *
 * @return html.tags
 */
function el_site_js() {
    global $El;
    $url = el_site_url();
	
	//load external js	
	$external = $El->jsheadExternal['site'];
	if(!empty($external)){
		foreach($external as $item){
			echo el_html_js(array('src' =>  $El->jsExternal[$item]));
		}
	}
	
	//load internal js
    if (isset($El->jshead['site'])) {
        foreach ($El->jshead['site'] as $js) {
            $src = "{$url}js/view/{$js}.js";
            if (el_site_settings('cache') == 1) {
				$cache = el_site_settings('last_cache');
                $src = "{$url}cache/js/{$cache}/view/{$js}.js";
            }
            echo el_html_js(array('src' => $src));
        }
    }
}
/**
 * Load js to backend
 *
 * @return html.tags
 */
function el_admin_js() {
    global $El;
    $url = el_site_url();
	
	//load external js	
	$external = $El->jsheadExternal['admin'];
	if(!empty($external)){
		foreach($external as $item){
			echo el_html_js(array('src' =>  $El->jsExternal[$item]));
		}
	}
	
	//load internal js
    if (isset($El->jshead['admin'])) {
        foreach ($El->jshead['admin'] as $js) {
            $src = "{$url}js/view/{$js}.js";
            if (el_site_settings('cache') == 1) {
				$cache = el_site_settings('last_cache');
                $src = "{$url}cache/js/{$cache}/view/{$js}.js";
            }
            echo el_html_js(array('src' => $src));
        }
    }
}

/**
 * Check if the requested js is registered then load js
 *
 * @return bool
 */
function el_js_trigger($hook, $type, $value, $params) {
    global $El;
    if (isset($params[1]) && substr($params[1], '-3') == '.js') {
        $params[1] = str_replace('.js', '', $params[1]);
        if (isset($El->js[$params[1]])) {
            $file = el_plugin_view($El->js[$params[1]]);
            $extended = el_fetch_extend_views("js/{$params[1]}");
            $data = array(
                $file,
                $extended
            );
            return implode('', $data);
        }
    }
    return false;
}
/**
 * Load jquery framework to system
 *
 * @return js.html.tag
 * @use el_new_external_js()
 */
/**
function el_jquery_add() {
    echo el_html_js(array('src' => el_site_url('vendors/jquery/jquery-1.11.1.min.js')));
} **/
function el_languages_js(){
	$lang = el_site_settings('language');
	$cache = el_site_settings('cache');
	$last_cache = el_site_settings('last_cache');
	
	if($cache == true){
		$js = "el.{$lang}.language";
		$url = "cache/js/{$last_cache}/view/{$js}.js";
		el_new_external_js($js, $url);
		
		el_load_external_js($js, 'site');
		el_load_external_js($js, 'admin');
	} else {
	
		el_new_js('el.language', 'javascripts/languages');
		
		el_load_js('el.language');
		el_load_js('el.language', 'admin');	
	}
}
/**
 * Redirect users to absolute url, if he is on wrong url
 *
 * Many users have issue while registeration, this is due to el.ajax works on absolute path
 * Github ticket: https://github.com/opensource-socialnetwork/opensource-socialnetwork/issues/458
 * 
 * @return void;
 */
 function el_redirect_absolute_url(){
	$baseurl 	= el_site_url();
	$parts		= parse_url($baseurl);
	$iswww		= preg_match('/www./i', $parts['host']);
	$host		= parse_url($_SERVER['HTTP_HOST']);
	$redirect	= false;
	$port 		= "";
	if(!isset($host['host'])){
		$host = array();
		$host['host'] = $_SERVER['HTTP_HOST'];
	}
	
	if(isset($parts['port']) && !empty($parts['port'])){
		$port = ":{$parts['port']}";
		if ($parts['port'] == ':80' || $parts['port'] == ':443'){
			$port = '';
		}
		if($parts['port'] !== (int)$_SERVER['SERVER_PORT']){
			$redirect = true;
		}
	}
	if(isset($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false) {
		 $_SERVER['HTTPS'] = 'on'; 
	}	
	if(empty($parts['port']) && isset($_SERVER['SERVER_PORT']) && !empty($_SERVER['SERVER_PORT']) 
			&& $_SERVER['SERVER_PORT'] !== '80' && $_SERVER['SERVER_PORT'] !=='443'){
			$redirect = true;
	}
    	if($parts['scheme'] == 'https' && empty($_SERVER["HTTPS"]) 
    		|| (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" && $parts['scheme'] == 'http')) {
        	$redirect = true;
    	}

	if(($host['host'] !== $parts['host']) || $redirect){
		header("HTTP/1.1 301 Moved Permanently");
		$url = "{$parts['scheme']}://{$parts['host']}{$port}{$_SERVER['REQUEST_URI']}";
		header("Location: {$url}"); 		
	}
 }
el_register_callback('el', 'init', 'el_languages_js');
el_register_callback('el', 'init', 'el_javascript');
el_register_callback('el', 'init', 'el_redirect_absolute_url');
