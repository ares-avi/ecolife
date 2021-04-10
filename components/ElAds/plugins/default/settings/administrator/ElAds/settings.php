<?php

$settings = input('settings');
if (empty($settings)) {
    $settings = 'list';
}
switch ($settings) {
    case 'list':
        echo el_plugin_view('ads/pages/list');
        break;
    case 'add':
        echo el_plugin_view('ads/pages/add');
        break;
    case 'edit':
	    $id = input('id');
		if(!empty($id)){
			$ads = new ElAds;
			$params['entity'] = $ads->getAd($id);
            echo el_plugin_view('ads/pages/edit', $params);
		}
        break;	
	//missing 'view' case - 'Browse' didn't work #233
    case 'view':
	    $id = input('id');
		if(!empty($id)){
			$ads = new ElAds;
			$params['entity'] = $ads->getAd($id);
            echo el_plugin_view('ads/pages/view', $params);
		}
        break;			
    default:
        break;

}
?>
