<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
 $user = el_loggedin_user();
 $notification = new elNotifications;
 if($notification->clearAll($user->guid)){
	el_trigger_message(el_print('el:notification:mark:read:success'));
	redirect(REF);	 
 } else {
	el_trigger_message(el_print('el:notification:mark:read:error'), 'error');
	redirect(REF);	 
 }