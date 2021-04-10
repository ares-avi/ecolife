<?php

 
$site  = new ElFile;
$site->setFile('logo_site');
$site->setExtension(array(
		'png',
));
if(isset($site->file['tmp_name']) && $site->typeAllowed()){
	$file = $site->file['tmp_name'];
	$size = filesize($file);
	if($size > 0){
			if($size > 500000){ //500KB
					el_trigger_message(el_print('theme:goblue:logo:large'), 'error');
					redirect(REF);
			}
			$contents = file_get_contents($file);
			if(strlen($contents) > 0 && file_put_contents(el_route()->themes.'goblue/images/logo.png', $contents)){
					$cache  = el_site_settings('cache');
					if($cache == false) {
							$done = true;
					} else {
							$done = 2;
					}								
			} else {
				$done = false;
		
			}
	}
}
$admin  = new ElFile;
$admin->setFile('logo_admin');
$admin->setExtension(array(
		'jpg',
		'jpeg',
));
if(isset($admin->file['tmp_name']) && $admin->typeAllowed()){
	$file = $admin->file['tmp_name'];
	$size = filesize($file);
	if($size > 0){
			if($size > 500000){ //500KB
					el_trigger_message(el_print('theme:goblue:logo:large'), 'error');
					redirect(REF);
			}
			$contents = file_get_contents($file);
			if(strlen($contents) > 0 && file_put_contents(el_route()->themes.'goblue/images/logo_admin.jpg', $contents)){
					$cache  = el_site_settings('cache');
					if($cache == false) {
							$done = true;
					} else {
							$done = 2;
					}								
			} else {
				$done = false;
		
			}
	}
}
if($done === true){
	el_trigger_message(el_print('theme:goblue:logo:changed'));
	redirect(REF);	
} elseif($done == 2){
	//redirect and flush cache
	el_trigger_message(el_print('theme:goblue:logo:changed'));	
	$action = el_add_tokens_to_url("action/admin/cache/flush");
	redirect($action);	
} else {
	el_trigger_message(el_print('theme:goblue:logo:failed'), 'error');
	redirect(REF);		
}
