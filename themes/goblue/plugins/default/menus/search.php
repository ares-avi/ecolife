<?php

$menus = $params['menu'];
echo "<div class='el-menu-search'>";
echo '<div class="title">' . el_print('result:type') . '</div>';
foreach ($menus as $menu => $val) {
    foreach ($val as $link) {
        $text = el_print($link['text']);
		$link = $link['href'];
		$class = elTranslit::urlize($menu);
        echo "<li class='el-menu-search-{$class}'>
				<a href='{$link}'>
					<div class='text'>{$text}</div>
				</a>
			</li>";
    }
}
echo '</div>';