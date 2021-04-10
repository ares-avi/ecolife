<?php

define('EL_ALLOW_SYSTEM_START', TRUE);
require_once(dirname(dirname(dirname(__FILE__))) . '/system/start.php');
file_put_contents(el_installation_paths()->root . 'INSTALLED', 1);

$factory = new ElFactory(array(
		'callback' => 'installation',
		'website' => el_site_url(),
		'email' => el_site_settings('owner_email'),
		'version' => el_site_settings('site_version')
));
$factory->connect;

//Enable cache after installation complete! #1338
el_create_cache();

$installed = el_installation_paths()->el_url . 'administrator';
header("Location: {$installed}");
  
