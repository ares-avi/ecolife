<?php

$Settings = new ElInstallation;
$Settings->dbusername($_POST['dbuser']);
$Settings->dbpassword($_POST['dbpwd']);
$Settings->dbhost($_POST['dbhost']);
$Settings->dbname($_POST['dbname']);
$Settings->weburl($_POST['url']);
$Settings->datadir($_POST['datadir']);
$Settings->setStartupSettings(array(
    'owner_email' => $_POST['owner_email'],
    'notification_email' => $_POST['notification_email'],
    'sitename' => $_POST['sitename']
));
if(empty($_POST['owner_email']) || empty($_POST['notification_email']) || empty($_POST['sitename'])){
	    el_installation_message(el_installation_print('fields:require'), 'fail');
    	$failed = el_installation_paths()->url . '?page=settings';
		header("Location: {$failed}");	
		exit;
}
if ($Settings->INSTALL()) {
    $installed = el_installation_paths()->url . '?page=account';
    header("Location: {$installed}");
} else {
    el_installation_message($Settings->error_mesg, 'fail');
    $failed = el_installation_paths()->url . '?page=settings';
    header("Location: {$failed}");
}
