<?php



$englsih = array(
	'site:settings' => 'Site Settings',
	'el:installed' => 'Installed',
	'el:installation' => 'Installation',
	'el:check' => 'Validate',
	'el:installed' => 'Installed',
	'el:installed:message' => 'Open Source Social Network has been installed.',
    'el:prerequisites' => 'Installation prerequisites',
    'el:settings' => 'Server Settings',
    'el:dbsettings' => 'Database',
	'el:dbuser' => 'Database User',
	'el:dbpassword' => 'Database Password',
	'el:dbname' => 'Database Name',
	'el:dbhost' => 'Database Host',
    'el:sitesettings' => 'Website',
    'el:websitename' => 'Website name',
    'el:mainsettings' => 'Paths',
	'el:weburl' => 'elSite Url',
	'installation:notes' => 'The data directory contains users files. The data directory must be located outside the el installation path.',
	'el:datadir' => 'Data Directory',
	'owner_email' => 'Site Owner Email',
	'notification_email' => 'Notification Email (noreply@domain.com)',
	'create:admin:account' => 'Create Admin Account',
	'el:setting:account' => 'Account settings',
	
	'data:directory:invalid' => 'Invalid data directory or directory is not writeable.',	
	'data:directory:outside' => 'Data directory must be outside the installation path.',
	'all:files:required' => 'All files are required! Please check your files.',
	
	'el:install:php' => 'PHP ',
	'el:install:old:php' => "You have an old version of PHP " . PHP_VERSION . " You need PHP 7.0 or 7.x",
	
	'el:install:mysqli' => 'MYSQLI ENABLED',
	'el:install:mysqli:required' => 'MYSQLI PHP EXTENSION REQUIRED',
	
	'el:install:apache' => 'APACHE ENABLED',
	'el:install:apache:required' => 'APACHE IS REQUIRED',
	
	'el:install:modrewrite' => 'MOD_REWRITE',
	'el:install:modrewrite:required' => 'MOD_REWRITE REQUIRED',
	
	'el:install:curl' => 'PHP CURL',
	'el:install:curl:required' => 'PHP CURL REQUIRED',
	
	'el:install:gd' => 'PHP GD LIBRARY',
	'el:install:gd:required' => 'PHP GD LIBRARY REQUIRED',
	
	'el:install:config' => 'CONFIGURATION DIRECTORY WRITEABLE',
	'el:install:config:error' => 'CONFIGURATION DIRECTORY IS NOT WRITEABLE',
	
	'el:install:next' => 'Next',
    'el:install:install' => 'Install',
    'el:install:create' => 'Create',
    'el:install:finish' => 'Finish',
	
	'fields:require' => 'All fields are required!',
	
	'el:install:allowfopenurl' => 'PHP allow_url_fopen ENABLED',
	'el:install:allowfopenurl:error' => 'PHP allow_url_fopen is required',
	
	'el:install:ziparchive' => 'PHP ZipArchive ENABLED',
	'el:install:ziparchive:error' => 'PHP ZipArchive EXTENSION REQUIRED',
	'el:install:cachedir:note:failed' => 'Make sure your files and directories are owned by correct apache user.',
);

el_installation_register_languages($englsih);
