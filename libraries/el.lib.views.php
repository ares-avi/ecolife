<?php


$VIEW = new stdClass;
$VIEW->register = array();

/**
 * Include a specific file
 *
 * @param string $file Valid file name;
 * @param array $params Options;
 * @last edit: $arsalanshah
 * @return mixed data
 */
function el_include($file = '', $params = array()) {
    if (!empty($file) && is_file($file)) {
        ob_start();
        $params = $params;
        include($file);
        $contents = ob_get_clean();
        return $contents;
    }

}

/**
 * View a file
 *
 * @param string $file valid file name of php file without extension;
 * @param array $params Options;
 * @last edit: $arsalanshah
 * @return mixed data
 */
function el_view($path = '', $params = array()) {
    global $VIEW;
    if (isset($path) && !empty($path)) {
        //call hook in case to over ride the view
        if (el_is_hook('halt', "view:{$path}")) {
            return el_call_hook('halt', "view:{$path}", $params);
        }
        $path = el_route()->www . $path;
        $file = el_include($path . '.php', $params);
        return $file;
    }
}
/**
 * el_arg
 *
 * @param array $params Options;
 */
function el_args(array $attrs) {
    $attrs = $attrs;
    $attributes = array();

    foreach ($attrs as $attr => $val) {
        $attr = strtolower($attr);
        if ($val === TRUE) {
            $val = $attr;
        }
        if ($val !== NULL && $val !== false && (is_array($val) || !is_object($val))
        ) {
            if (is_array($val)) {
                $val = implode(' ', $val);
            }
            $val = htmlspecialchars($val, ENT_QUOTES, 'UTF-8', false);
            $attributes[] = "$attr=\"$val\"";
        }
    }
    return implode(' ', $attributes);
}

/**
 * Register a view;
 *
 * @param string $view Path of view;
 * @param  stringn $file File name for view;
 * @last edit: $arsalanshah
 *
 * @reason: Initial;
 * @returnn mix data
 */
function el_extend_view($views, $file) {
    global $VIEW;
    $VIEW->register[$views][] = $file;
	return true;
}

/**
 * Fetch a register view
 *
 * @param string $layout Name of view;
 * @params  string $params Args for file;
 * @last edit: $arsalanshah
 *
 * @reason: Initial;
 * @return mixed data
 */
function el_fetch_extend_views($layout, $params = array()) {
    global $VIEW;
    if (isset($VIEW->register[$layout]) && !empty($VIEW->register[$layout])) {
        foreach ($VIEW->register[$layout] as $file) {
            if (!function_exists($file)) {
                $fetch[] = el_plugin_view($file, $params);
            } else {
                $fetch[] = call_user_func($file, el_get_context(), $params, current_url());
            }
        }
        return implode('', $fetch);
    }
}

/**
 * Unregister a view from system
 *
 * @param string $layout Name of view;
 *
 * @last edit: $arsalanshah
 * @reason: Initial;
 * @return void
 */
function el_remove_extend_view($layout) {
    global $VIEW;
    unset($VIEW->register[$layout]);
}

/**
 * Add a context to page
 *
 * @param string $context Name of context;
 * @last edit: $arsalanshah
 *
 * @Reason: Initial;
 * @return void;
 */
function el_add_context($context) {
    global $VIEW;
    $VIEW->context = $context;
	return true;
}

/**
 * Check the if are in registered context or not
 *
 * @param: string $context Name of context;
 * @last edit: $arsalanshah
 * @reason: Initial;
 * @return bool;
 */
function el_is_context($context) {
    global $VIEW;
    if (isset($VIEW->context) && $VIEW->context == $context) {
        return true;
    }
    return false;
}

/**
 * Get a current context;
 *
 * @last edit: $arsalanshah
 * @reason: Initial;
 *
 * @return false|string;
 */
function el_get_context() {
    global $VIEW;
    if (isset($VIEW->context)) {
        return $VIEW->context;
    }
    return false;
}

/**
 * Fetch a layout;
 *
 * @last edit: $arsalanshah
 * @Reason: Initial;
 *
 * @param string $layout
 */
function el_set_page_layout($layout, $params = array()) {
    if (!empty($layout)) {
        $theme = new ElThemes;
        $active_theme = $theme->getActive();
        return el_plugin_view("theme/page/layout/{$layout}", $params);
    }
}

/**
 * View page;
 *
 * @param  string $title Title for page;
 * @param string $content Content for page;
 *
 * @last edit: $arsalanshah
 * @reason Initial;
 * @return mixed data;
 */
function el_view_page($title, $content, $page = 'page') {
    $params['title'] = $title;
    $params['contents'] = $content;
    return el_plugin_view("theme/page/{$page}", $params);
}

/**
 * El get default theme path
 *
 * @return string
 */
function el_default_theme() {
    return el_route()->themes . el_site_settings('theme') . '/';
}
/**
 * Activated theme URL
 *
 * @param string $extend Extend the theme url with extra url param (path to file etc)
 *
 * @return string
 */
function el_theme_url($extend = ''){
	$default = el_site_settings('theme');
	return el_site_url("themes/{$default}/{$extend}");
}
/**
 * El view form
 *
 * @param string $name
 * @return mix data
 */
function el_view_form($name, $args = array(), $type = 'core') {
    $args['name'] = $name;
    $args['type'] = $type;
    return el_plugin_view("output/form", $args);
}

/**
 * El view widget
 *
 * @param array $params A options
 *
 * @return string
 */
function el_view_widget(array $params = array()) {
    return el_plugin_view("widget/view", $params);
}
/**
 * View a template
 *
 * Use a templates from core (image view, url view etc)
 * 
 * @param string $template A name of template
 * @param array $params
 * 
 * @return mix data
 */
function el_view_template($template = '', array $params){
	if(!empty($template)){
		return el_plugin_view("{$template}", $params);
	}
}
/**
 * Create a pagiantion using count and page limit
 *
 * @param integer $count total entities/objects
 * @param integer $page_limit Number of entities/objects per page
 * @param array   $args Overwrite the default behaviour of pagination view
 *
 * @return false|mixed data
 */
function el_view_pagination($count = false, $page_limit = 10, array $args = array()){
	$page_limit = el_call_hook('pagination', 'page_limit', false, $page_limit);
	if(!empty($count) && !empty($page_limit)){
		$pagination = new ElPagination;
	
		$params = array();
		$params['limit'] = $count;
		$params['page_limit']  = $page_limit;
		
		if(!isset($args['offset_name']) || empty($args['offset_name'])){
				$args['offset_name'] = 'offset';
		}
		$offset = input($args['offset_name']);
		if(empty($offset)){
			el_set_input($args['offset_name'], 1);
		}
		$params['options'] = $args;
		return $pagination->pagination($params);
	}
	return false;
}
