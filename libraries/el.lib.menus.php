<?php


/**
 * Register a menu;
 * @param string $name Name of menu;
 * @param string $text Text for menu;
 * @param string $link Link for menu;
 *
 * @return void
 */
function el_register_menu_link($name, $text, $link, $menutype = 'site') {
				el_register_menu_item($menutype, array(
								'name' => $name,
								'text' => $text,
								'href' => $link
				));
}
/**
 * Register a menu item
 *
 * @param string $name menu name;
 * @param array  $options A link options;
 * @param string $menutype A menu name
 *
 * @return void
 */
function el_register_menu_item($menutype, array $options = array()) {
				$menu = new ElMenu($menutype, $options);
				$menu->register();
}

/**
 * Unregister menu from system;
 * @param string $menu Menu name
 * @param string  $menutype MenuType
 *
 * @return void;
 *
 */
function el_unregister_menu($menu, $menutype = 'site') {
				global $El;
				unset($El->menu[$menutype][$menu]);
}
/**
 * Unregister Type -> Menu -> Menu Item
 *
 * @param string $name Name of Menu Item
 * @param string $menu Name of Menu
 * @param string $menutype The name of menutype
 * 
 * @return void
 */
function el_unregister_menu_item($name, $menu, $menutype = 'site') {
				global $El;
				if(isset($El->menu[$menutype][$menu])) {
								foreach($El->menu[$menutype][$menu] as $key => $item) {
												if($item['name'] == $name) {
																unset($El->menu[$menutype][$menu][$key]);
												}
								}
				}
}
/**
 * View a menu
 *
 * @param string $menu Menu name
 * @param boolean $custom if the file path is custom
 *
 * @note This will fetch layout from defualt template that how menu should appear; check menu file for more info;
 *
 * @return string
 */
function el_view_menu($menu, $custom = false) {
				global $El;
				if(!isset($El->menu[$menu])) {
								return false;
				}
				$elmenu = new ElMenu;
				$elmenu->sortMenu($menu);
				
				$params['menu'] = $El->menu[$menu];
				if($custom == false) {
								$params['menuname'] = $menu;
								return el_plugin_view("menus/{$menu}", $params);
				} elseif($custom !== false) {
								$params['menuname'] = $menu;
								return el_plugin_view($custom, $params);
				}
}

/**
 * Register a section base menu
 *
 * @param string $menu A name of menu
 * $param array $params A option values
 *
 * @return false|null
 */
function el_register_sections_menu($menu = '', array $params = array()) {
				if(!isset($params['name'])){
						//If not set section menu name #1479
						$params['name'] = md5($params['url']);	
				}
				if(isset($params['url'])){
					$params['href'] = $params['url'];
					unset($params['url']);
				}
				if(isset($params['section'])){
					$params['parent'] = $params['section'];
					unset($params['section']);					
				}
				el_register_menu_item($menu,  $params);				
}

/**
 * View section base menu
 *
 * @param string $type (frontend or backend(
 * @param string $menu
 *
 * @note This will fetch layout from defualt template that how menu should appear; check menu file for more info;
 *
 * @return mixed data
 *
 */
function el_view_sections_menu($menu, $type = 'frontend') {
		return el_view_menu($menu, "menus/sections/{$menu}");		
}
