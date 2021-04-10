<?php

/**
 * Initialize the admin library
 *
 * @return void
 */
function el_admin() {
		el_register_admin_sidemenu('admin:components', 'admin:components', el_site_url('administrator/components'), el_print('admin:sidemenu:components'));
		el_register_admin_sidemenu('admin:install', 'admin:install', el_site_url('administrator/com_installer'), el_print('admin:sidemenu:components'));
		
		el_register_admin_sidemenu('admin:themes', 'admin:themes', el_site_url('administrator/themes'), el_print('admin:sidemenu:themes'));
		el_register_admin_sidemenu('admin:install', 'admin:install', el_site_url('administrator/theme_installer'), el_print('admin:sidemenu:themes'));
		
		el_register_admin_sidemenu( 'admin:basic', 'admin:basic', el_site_url('administrator/settings/basic'), el_print('admin:sidemenu:settings'));
		el_register_admin_sidemenu('admin:cache', 'admin:cache', el_site_url('administrator/cache'), el_print('admin:sidemenu:settings'));
		//el_register_admin_sidemenu('admin/sidemenu', 'admin:mode', el_site_url('administrator/theme_installer'), el_print('admin:sidemenu:settings'));
		
		el_register_admin_sidemenu('admin:users', 'admin:users', el_site_url('administrator/users'), el_print('admin:sidemenu:usermanager'));
		el_register_admin_sidemenu('admin:add:user', 'admin:add:user', el_site_url('administrator/adduser'), el_print('admin:sidemenu:usermanager'));
		el_register_admin_sidemenu('admin:users:unvalidated', 'admin:users:unvalidated', el_site_url('administrator/unvalidated_users'), el_print('admin:sidemenu:usermanager'));
		
		
		el_register_menu_link('home', 'admin:dashboard', el_site_url('administrator'), 'topbar_admin');
		
		el_register_menu_link('help', 'admin:help', 'https://www.opensource-socialnetwork.org/', 'topbar_admin');
		el_register_menu_item('topbar_admin', array(
				'name' => 'support',
				'text' => 'el:premium',
				'href' => 'https://www.softlab24.com/',
				'target' => '_blank',
		));	
		
		el_register_menu_link('viewsite', 'admin:view:site', el_site_url(), 'topbar_admin');
		
		el_register_action('admin/login', el_route()->actions . 'administrator/login.php');
		el_register_action('admin/logout', el_route()->actions . 'administrator/logout.php');
		
		if(el_isAdminLoggedin()) {
				el_register_site_settings_page('account', 'pages/account');
				
				el_register_action('component/enable', el_route()->actions . 'administrator/component/enable.php');
				el_register_action('component/disable', el_route()->actions . 'administrator/component/disable.php');
				el_register_action('component/delete', el_route()->actions . 'administrator/component/delete.php');
				
				el_register_action('theme/enable', el_route()->actions . 'administrator/theme/enable.php');
				el_register_action('theme/delete', el_route()->actions . 'administrator/theme/delete.php');
				
				el_register_action('admin/add/user', el_route()->actions . 'administrator/user/add.php');
				el_register_action('admin/edit/user', el_route()->actions . 'administrator/user/edit.php');
				el_register_action('admin/delete/user', el_route()->actions . 'administrator/user/delete.php');
				el_register_action('admin/validate/user', el_route()->actions . 'administrator/user/validate.php');
				
				el_register_action('admin/com_install', el_route()->actions . 'administrator/component/com_install.php');
				el_register_action('admin/theme_install', el_route()->actions . 'administrator/theme/theme_install.php');
				
				el_register_action('admin/settings/save/basic', el_route()->actions . 'administrator/settings/save/basic.php');
				el_register_action('admin/cache/create', el_route()->actions . 'administrator/cache/create.php');
				el_register_action('admin/cache/flush', el_route()->actions . 'administrator/cache/flush.php');
				
		}
		
		/*
		 * Register login and backend pages
		 */
		if(el_isAdminLoggedin()) {
				el_register_page('administrator', 'el_administrator_pagehandler');
				el_register_site_settings_page('basic', 'settings/admin/basic_settings');
				
				el_register_menu_item('topbar_dropdown', array(
						'name' => 'administration',
						'text' => el_print('admin'),
						'href' => el_site_url('administrator')
				));
		} else {
				el_register_page('administrator', 'el_administrator_login_pagehandler');
		}
}

/**
 * Register sidebar menu
 *
 * @param string $name The name of the menu
 * @param string $text Link text
 * @param string $link Full url
 * @param string $section Menu section
 * @param string $for sidebar name
 *
 * @return void
 */
function el_register_admin_sidemenu($name, $text, $link, $section, $for = 'admin/sidemenu') {
		el_register_menu_item($for, array(
				'name' => $name,
				'text' => $text,
				'href' => $link,
				'parent' => $section
		));
}

/**
 * Register component panel page
 *
 * @param string $component Component Id
 * @param string $page A page URL
 *
 * @return void
 */
function el_register_com_panel($component, $page) {
		global $El;
		$El->com_panel[$component] = $page;
}

/**
 * Get registered component panel pages
 *
 * @return array
 */
function el_registered_com_panel() {
		global $El;
		if(!isset($El->com_panel)) {
				return false;
		}
		foreach($El->com_panel as $key => $name) {
				$registered[] = $key;
		}
		return $registered;
}

/**
 * Register settings/<page>
 *
 * @param string $name <page> path
 * @param string $page A page contents
 *
 * @return void
 */
function el_register_site_settings_page($name, $page) {
		global $El;
		$El->adminSettingsPage[$name] = $page;
}

/**
 * View registered settings pages
 *
 * @return array
 */
function el_registered_settings_pages() {
		global $El;
		if(!isset($El->adminSettingsPage)) {
				return false;
		}
		foreach($El->adminSettingsPage as $key => $name) {
				$registered[] = $key;
		}
		return $registered;
}

/**
 * View admin sidebar menu
 *
 * @return html
 */
function el_view_admin_sidemenu() {
		global $El;
		$params['menu'] = $El->menu['admin/sidemenu'];
		$active_theme   = el_site_settings('theme');
		return el_plugin_view("menus/admin_sidemenu", $params);
}


/**
 * Register a page handler for administrator;
 * @pages:
 *       administrator,
 *   	 administrator/dasbhoard,
 *       administrator/component,
 *       administrator/components,
 *       administrator/com_installer,
 *       administrator/theme_installer,
 *       administrator/settings/<page>,
 *       administrator/cache,
 *       administrator/users,
 *       administrator/edituser
 *
 * @return boolean|null
 */
function el_administrator_pagehandler($pages) {
		$page = $pages[0];
		if(empty($page)) {
				$page = 'dashboard';
		}
		
		switch($page) {
				case 'dashboard':
						$title                = el_print('admin:dashboard');
						$contents['contents'] = el_plugin_view('pages/administrator/contents/dashboard');
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'component':
						global $El;
						if(isset($pages[1]) && in_array($pages[1], el_registered_com_panel())) {
								$com['com']           = ElComponents::getCom($pages[1]);
								$com['settings']      = el_components()->getComSettings($pages[1]);
								$title                = $com['com']->name;
								$contents['contents'] = el_plugin_view("settings/administrator/{$pages[1]}/{$El->com_panel[$pages[1]]}", $com);
								$contents['title']    = $title;
								$content              = el_set_page_layout('administrator/administrator', $contents);
								echo el_view_page($title, $content, 'administrator');
						}
						break;
				case 'components':
						$title                = el_print('admin:components');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/components");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'themes':
						$title                = el_print('admin:themes');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/themes");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'com_installer':
						$title                = el_print('admin:com:installer');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/com_installer");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'theme_installer':
						$title                = el_print('admin:theme:installer');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/theme_installer");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'settings':
						global $El;
						if(isset($pages[1]) && in_array($pages[1], el_registered_settings_pages())) {
								$title                = el_print("{$pages[1]}:settings");
								//file should be in plugins/views/default/settings/<file> $arsalanshah
								$contents['contents'] = el_plugin_view($El->adminSettingsPage[$pages[1]]);
								$contents['title']    = $title;
								$content              = el_set_page_layout('administrator/administrator', $contents);
								echo el_view_page($title, $content, 'administrator');
						}
						break;
				case 'cache':
						$title                = el_print('admin:cache:settings');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/cache");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'adduser':
						$title                = el_print('admin:add:user');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/adduser");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'users':
						$title                = el_print('admin:user:list');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/users/list");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'unvalidated_users':
						$title                = el_print('admin:users:unvalidated');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/users/unvalidated");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'edituser':
						if(isset($pages[1])) {
								$user['user'] = el_user_by_username($pages[1]);
						}
						$title                = el_print('admin:edit:user');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/user/edit", $user);
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/administrator', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				case 'version':
						header('Content-Type: application/json');
						$version = array(
								'version' => el_check_update()
						);
						echo json_encode($version);
						break;
				default:
						el_error_page();
						break;
						
		}
}
/**
 * Register a page handler for administrator login;
 * @pages:
 *       administrator/login,
 * @return mixeddata
 */
function el_administrator_login_pagehandler($pages) {
		$page = $pages[0];
		if(empty($page)) {
				$page = 'login';
		}
		$logout = input('logout');
		if($logout == 'true') {
				el_trigger_message(el_print('logged:out'));
				redirect('administrator');
		}
		switch($page) {
				case 'login':
						$title                = el_print('admin:login');
						$contents['contents'] = el_plugin_view("pages/administrator/contents/login");
						$contents['title']    = $title;
						$content              = el_set_page_layout('administrator/login', $contents);
						echo el_view_page($title, $content, 'administrator');
						break;
				default:
						el_error_page();
						break;
						
		}
}
el_register_callback('el', 'init', 'el_admin');
