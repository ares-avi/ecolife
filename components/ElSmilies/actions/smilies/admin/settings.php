<?php

$component = new ElComponents;
$modes = array(
		'off',
		'on'
);
$compat_mode     = input('compatibility_mode');
$close_anywhere  = input('close_anywhere');
if(in_array($compat_mode, $modes) && in_array($close_anywhere, $modes)) {
	if($component->setSettings('ElSmilies', array('compatibility_mode' => $compat_mode, 'close_anywhere' => $close_anywhere))) {
		el_trigger_message(el_print('el:admin:settings:saved'));
		redirect(REF);
	}
}
el_trigger_message(el_print('el:admin:settings:save:error'), 'error');
redirect(REF);