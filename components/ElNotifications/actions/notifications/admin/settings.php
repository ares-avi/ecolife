<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$component = new elComponents;
$modes = array(
		'off',
		'on'
);
$close_anywhere  = input('close_anywhere');
if(in_array($close_anywhere, $modes)) {
	if($component->setSettings('elNotifications', array('close_anywhere' => $close_anywhere))) {
		el_trigger_message(el_print('el:admin:settings:saved'));
		redirect(REF);
	}
}
el_trigger_message(el_print('el:admin:settings:save:error'), 'error');
redirect(REF);
