<?php

global $elInstall;
if (!isset($elInstall)) {
    $elInstall = new stdClass;
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (is_file('DISPLAY_ERRORS')) {
    error_reporting(E_NOTICE ^ ~E_WARNING);
} else {
    ini_set('display_errors', 'off');
}
if (is_file('INSTALLED')) {
    exit('It seems the Open Source Social Network is already installed');
}
require_once(dirname(__FILE__) . '/libraries/elInstall.php');
require_once(dirname(__FILE__) . '/classes/ElInstall.php');

//geneate .htaccess file #432
//el_generate_server_config_setup('apache');

if (!isset($_REQUEST['action'])) {
    el_installation_page();
}
if (!isset($_REQUEST['page'])) {
    el_installation_actions();
}
