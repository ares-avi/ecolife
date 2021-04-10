<?php

$ElClasses = array(
		'Session',
		'Factory',
		'SiteException',
		'DatabaseException',
		'Base',
		'Translit',
		'Mail',
		'Pagination',
		'Database',
		'Site',
		'Entities',
		'User',
		'Object',
		'Annotation',
		'Themes',
		'File',
		'Components',
		'Menu',
		'System',
		'Kernel',
);
foreach($ElClasses as $class){
		$loadClass['El'.$class] = el_route()->classes . "El{$class}.php";
}
el_register_class($loadClass);
