<?php


// get menu_width of profile menu
$menu_width = $params['menu_width'];

global $el;
$elmenu = new elMenu;
$elmenu->sortMenu('user_timeline');
$params['menu'] = $el->menu['user_timeline'];
 
echo '<ul>';
$i = 0;
$dropdown = false;
foreach($params['menu'] as $menu) {
		if($menu_width != 1) {
			// ignore string length in bootstrap xs mode
			// and unconditionally display dropdown menu
			$i = $i + mb_strlen(el_print($menu[0]['text']));
		}
		if($menu_width != 1 && $i <= $menu_width) {
				foreach($menu as $name => $link) {
						$class = "menu-user-timeline-" . $link['name'];
						if(isset($link['class'])) {
								$link['class'] = $class . ' ' . $link['class'];
						} else {
								$link['class'] = $class;
						}
						unset($link['name']);
						$link['text'] = el_print($link['text']);
						$link         = el_plugin_view('output/url', $link);
						echo "<li>{$link}</li>";
				}
		} else {
				if(!$dropdown) {
						if($menu_width == 1) {
								// special case for mobile devices
								echo "<li class='dropdown'><a href='javascript:void(0);' data-toggle='dropdown' class='dropdown-toggle'>" . "<i class='fa fa-bars fa-2x'></i></a>
								<ul class='dropdown-menu'>";
						}
						else {
								echo "<li class='dropdown'><a href='javascript:void(0);' data-toggle='dropdown' class='dropdown-toggle'>" . el_print('more') . "<i class='fa fa-caret-down'></i></a>
								<ul class='dropdown-menu'>";
						}
						$dropdown = true;
				}
				foreach($menu as $name => $link) {
						$class = "menu-user-timeline-" . $link['name'];
						if(isset($link['class'])) {
								$link['class'] = $class . ' ' . $link['class'];
						} else {
								$link['class'] = $class;
						}
						unset($link['name']);
						$link['text'] = el_print($link['text']);
						$link         = el_plugin_view('output/url', $link);
						echo "<li>{$link}</li>";
				}
		}
}
if($dropdown) {
	echo "</ul></li>";
}
echo '</ul>';
