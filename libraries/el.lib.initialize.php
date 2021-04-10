<?php


//register all available language
$available_languages = el_get_available_languages();
foreach($available_languages as $language) {
		el_register_language($language, el_route()->locale . "el.{$language}.php");
}
//el_default_load_locales();
/**
 * Initialize the css library
 *
 * @return void
 */
function el_initialize() {
		$url = el_site_url();
		
		$icon = el_site_url('components/ElWall/images/news-feed.png');
		el_register_sections_menu('newsfeed', array(
				'name' => 'newsfeed',
				'text' => el_print('news:feed'),
				'url' => "{$url}home",
				'parent' => 'links',
				'icon' => $icon
		));
		el_extend_view('el/js/head', 'javascripts/head');
		el_extend_view('el/admin/js/head', 'javascripts/head');
		//actions
		el_register_action('user/login', el_route()->actions . 'user/login.php');
		el_register_action('user/register', el_route()->actions . 'user/register.php');
		el_register_action('user/logout', el_route()->actions . 'user/logout.php');
		
		el_register_action('friend/add', el_route()->actions . 'friend/add.php');
		el_register_action('friend/remove', el_route()->actions . 'friend/remove.php');
		el_register_action('resetpassword', el_route()->actions . 'user/resetpassword.php');
		el_register_action('resetlogin', el_route()->actions . 'user/resetlogin.php');
		
		
		el_register_page('index', 'el_index_pagehandler');
		el_register_page('home', 'el_user_pagehandler');
		el_register_page('login', 'el_user_pagehandler');
		el_register_page('registered', 'el_user_pagehandler');
		el_register_page('syserror', 'el_system_error_pagehandler');
		
		el_register_page('resetlogin', 'el_user_pagehandler');
		
		el_add_hook('newsfeed', "sidebar:left", 'newfeed_menu_handler');
		
		el_register_menu_item('footer', array(
				'name' => 'a_copyrights',
				'text' => el_print('copyright') . ' ' . el_site_settings('site_name'),
				'href' => el_site_url()
		));
		
		el_register_menu_item('footer', el_pow_lnk_args());
		
		el_extend_view('el/endpoint', 'author/view');
}

/**
 * Add left menu to newsfeed page
 *
 * @return menu
 */
function newfeed_menu_handler($hook, $type, $return) {
		$return[] = el_view_sections_menu('newsfeed');
		return $return;
}

/**
 * System Errors
 * @pages:
 *       unknown,
 *
 * @return boolean|null
 */
function el_system_error_pagehandler($pages) {
		$page = $pages[0];
		if(empty($page)) {
				$page = 'unknown';
		}
		switch($page) {
				case 'unknown':
						$error  = "<div class='el-ajax-error'>" . el_print('system:error:text') . "</div>";
						$params = array(
								'title' => el_print('system:error:title'),
								'contents' => $error,
								'callback' => false
						);
						echo el_plugin_view('output/elbox', $params);
						break;
		}
}

/**
 * Register basic pages
 * @pages:
 *       home,
 *    login,
 *       registered
 *
 * @return mixed contents
 */
function el_user_pagehandler($home, $handler) {
		switch($handler) {
				case 'home':
						if(!el_isLoggedin()) {
								//Redirect User to login page if session expired from home page #929
								redirect('login');
						}
						$title = el_print('news:feed');
						if(com_is_active('ElWall')) {
								$contents['content'] = el_plugin_view('wall/pages/wall');
						}
						$content = el_set_page_layout('newsfeed', $contents);
						echo el_view_page($title, $content);
						break;
				case 'resetlogin':
						if(el_isLoggedin()) {
								redirect('home');
						}
						$user                = input('user');
						$code                = input('c');
						$contents['content'] = el_plugin_view('pages/contents/user/resetlogin');
						
						if(!empty($user) && !empty($code)) {
								$contents['content'] = el_plugin_view('pages/contents/user/resetcode');
						}
						$title   = el_print('reset:login');
						$content = el_set_page_layout('startup', $contents);
						echo el_view_page($title, $content);
						break;
				case 'login':
						if(el_isLoggedin()) {
								redirect('home');
						}
						$title               = el_print('site:login');
						$contents['content'] = el_plugin_view('pages/contents/user/login');
						$content             = el_set_page_layout('startup', $contents);
						echo el_view_page($title, $content);
						break;
				
				case 'registered':
						if(el_isLoggedin()) {
								redirect('home');
						}
						$title               = el_print('account:registered');
						$contents['content'] = el_plugin_view('pages/contents/user/registered');
						$content             = el_set_page_layout('startup', $contents);
						echo el_view_page($title, $content);
						break;
				
				default:
						el_error_page();
						break;
						
		}
}

/**
 * Register site index page
 * @pages:
 *       index or home,
 *
 * @return boolean|null
 */
function el_index_pagehandler($index) {
		if(el_isLoggedin()) {
				redirect('home');
		}
		$page = $index[0];
		if(empty($page)) {
				$page = 'home';
		}
		switch($page) {
				case 'home':
						echo el_plugin_view('pages/index');
						break;
				
				default:
						el_error_page();
						break;
						
		}
}
/**
 * El pow lnk args
 * 
 * @return array
 */
function el_pow_lnk_args() {
		$pw  = base64_decode(EL_POW);
		$pow = el_string_decrypt($pw, 'el');
		$pow = trim($pow);
		
		$lnk = base64_decode(EL_LNK);
		$lnk = el_string_decrypt($lnk, 'el');
		$lnk = trim($lnk);
		
		return array(
				'name' => $pow,
				'text' => el_print($pow),
				'href' => $lnk,
				'priority' => 1000,
		);
}
/**
 * Loads system plugins before we load components.
 *
 * @return void
 */
function el_system_plugins_load() {
		//load system plugins before components load #451
		el_register_plugins_by_path(el_route()->system . 'plugins/');
}
el_register_callback('el', 'init', 'el_initialize');
el_register_callback('components', 'before:load', 'el_system_plugins_load');
