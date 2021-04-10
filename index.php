<?php

define('EL_ALLOW_SYSTEM_START', TRUE);
require_once('system/start.php');
//page handler
$handler = input('h');
//page name
$page = input('p');

//check if there is no handler then load index page handler
if (empty($handler)) {
    $handler = 'index';
}
echo el_load_page($handler, $page);
