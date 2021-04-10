<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$menus = $params['menu'];
if($menus){
    echo '<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">';
	foreach($menus as $menu) {
			foreach($menu as $link) {
					$class = "menu-topbar-dropdown-" . $link['name'];
					if(isset($link['class'])) {
						$link['class'] = $class . ' ' . $link['class'];
					} else {
							$link['class'] = $class;
					}
					unset($link['name']);	
					echo "<li>".el_plugin_view('output/url', $link)."</li>";
			}
	}
	echo "</ul>";
}
