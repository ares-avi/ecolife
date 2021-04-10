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
echo '<ul>';
$i = 0;
foreach($params['menu'] as $menu) {
		if($i <= 3) {
				foreach($menu as $name => $link) {
						$class = "menu-group-timeline-" . $link['name'];
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
				echo "<li><a href='javascript:void(0);'>" . el_print('more') . "</a>
		  <ul>";
				foreach($menu as $name => $link) {
						$class = "menu-group-timeline-" . $link['name'];
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
				echo "</ul>
		 </li>";
		}
		$i++;
}
echo '</ul>';