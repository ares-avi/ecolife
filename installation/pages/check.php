<?php

echo '<div><div class="layout-installation"><h2>' . el_installation_print('el:prerequisites') . '</h2><div style="margin:0 auto; width:900px;">';
//overwriting of php's default settings by el not working on some servers #965
/*if(!preg_match('/apache/', php_sapi_name()) && !preg_match('/litespeed/', php_sapi_name())){
    echo '<div class="el-installation-message el-installation-fail">APACHE, PHP_SAPI ('.php_sapi_name().')</div>';
    $error[] = 'php_sapi_apache';	
}*/
$error = array();
if (elInstallation::isPhp()) {
    echo '<div class="el-installation-message el-installation-success">'. el_installation_print('el:install:php') . PHP_VERSION . ' </div>';
} else {
    echo '<div class="el-installation-message el-installation-fail"> ' . el_installation_print('el:install:old:php') . '</div>';
    $error[] = 'php';
}
//can not add if message as we have too much to translate already
if(!elInstallation::isCacheWriteable()){
   echo '<div class="el-installation-message el-installation-fail">'. el_installation_print('el:install:cachedir:note:failed') . ' <a target="_blank" </a></div>';	
   $error[] = 'cache';
}
if(elInstallation::allowUrlFopen()){
    echo '<div class="el-installation-message el-installation-success">'.el_installation_print('el:install:allowfopenurl').'</div>';	
} else {
    echo '<div class="el-installation-message el-installation-fail">'.el_installation_print('el:install:allowfopenurl:error').'</div>';
    $error[] = 'allowfopenurl:error';	
}
if(elInstallation::isZipClass()){
	    echo '<div class="el-installation-message el-installation-success">'.el_installation_print('el:install:ziparchive').'</div>';	
} else {
    echo '<div class="el-installation-message el-installation-fail">'.el_installation_print('el:install:ziparchive:error').'</div>';
    $error[] = 'ziparchive:error';		
}
if (elInstallation::isCurl()) {
    echo '<div class="el-installation-message el-installation-success">'.el_installation_print('el:install:curl').'</div>';
} else {
    echo '<div class="el-installation-message el-installation-fail">'.el_installation_print('el:install:curl:required').'</div>';
    $error[] = 'php:curl';
}
if (elInstallation::isPhpGd()) {
    echo '<div class="el-installation-message el-installation-success">'.el_installation_print('el:install:gd').'</div>';
} else {
    echo '<div class="el-installation-message el-installation-fail">'.el_installation_print('el:install:gd:required').'</div>';
    $error[] = 'php:gd';
}
//Missing mcrypt module causes installation crash #941
if(function_exists('openssl_encrypt')) {
	    echo '<div class="el-installation-message el-installation-success">PHP openssl</div>';		
} else {
    echo '<div class="el-installation-message el-installation-fail">PHP openssl</div>';
    $error[] = 'php:openssl:error';			
}
if(extension_loaded('SimpleXML')){
	  echo '<div class="el-installation-message el-installation-success">PHP SimpleXML</div>';			
} else {
    echo '<div class="el-installation-message el-installation-fail">PHP SimpleXML</div>';
    $error[] = 'php:simplexml:error';		
}
if(extension_loaded('json')){
	  echo '<div class="el-installation-message el-installation-success">PHP json</div>';			
} else {
    echo '<div class="el-installation-message el-installation-fail">PHP json</div>';
    $error[] = 'php:json:error';		
}
if(extension_loaded('fileinfo')){
	  echo '<div class="el-installation-message el-installation-success">PHP fileinfo</div>';			
} else {
    echo '<div class="el-installation-message el-installation-fail">PHP fileinfo</div>';
    $error[] = 'php:fileinfo:error';		
}
if(extension_loaded('mbstring')){
	  echo '<div class="el-installation-message el-installation-success">PHP mbstring</div>';			
} else {
    echo '<div class="el-installation-message el-installation-fail">PHP mbstring</div>';
    $error[] = 'php:mbstring:error';		
}
if(extension_loaded('exif')){
	  echo '<div class="el-installation-message el-installation-success">PHP exif</div>';			
} else {
    echo '<div class="el-installation-message el-installation-fail">PHP exif</div>';
    $error[] = 'php:exif:error';		
}
if (elInstallation::is_mysqli_enabled()) {
    echo '<div class="el-installation-message el-installation-success">'.el_installation_print('el:install:mysqli').'</div>';
} else {
    echo '<div class="el-installation-message el-installation-fail">'.el_installation_print('el:install:mysqli:required').'</div>';
    $error[] = 'mysqli';
}
if (elInstallation::isApache()) {
    echo '<div class="el-installation-message el-installation-success">'.el_installation_print('el:install:apache').'</div>';
} else {
    echo '<div class="el-installation-message el-installation-fail">'.el_installation_print('el:install:apache:required').'</div>';
    $error[] = 'apache';
}
if (!in_array('php:curl', $error)) {
	if (elInstallation::is_mod_rewrite()) {
	    echo '<div class="el-installation-message el-installation-success">'.el_installation_print('el:install:modrewrite').'</div>';
	} else {
	    echo '<div class="el-installation-message el-installation-fail">'.el_installation_print('el:install:modrewrite:required').'</div>';
	    $error[] = 'mod_rewrite';
	}
}	
if (elInstallation::isCon_WRITEABLE()) {
    echo '<div class="el-installation-message el-installation-success">'.el_installation_print('el:install:config').'</div>';
} else {
    echo '<div class="el-installation-message el-installation-fail">'.el_installation_print('el:install:config:error').'</div>';
    $error[] = 'permission:configuration';
}
echo '<br />';
if (empty($error)) {
    echo '<a href="' . el_installation_paths()->url . '?page=license" class="button-blue primary">'.el_installation_print('el:install:next').'</a>';
}

echo '</div><br /><br /></div>';
