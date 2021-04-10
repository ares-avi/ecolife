<?php

$ads = new ElAds;
$ads = $ads->getAds(
	array (
		'offset' => 1
	)
);
if ($ads) {
	echo '<div class="el-ads">';
        foreach ($ads as $ad) {
          	$items[] = el_plugin_view('ads/item', array(
			'item' => $ad, 
		 ));
        }
	echo el_plugin_view('widget/view', array(
			'title' => el_print('sponsored'),
			'contents' => implode('', $items),
	));	
	echo '</div>';
}
?>   
       
