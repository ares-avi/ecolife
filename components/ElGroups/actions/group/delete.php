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


$guid = input('guid');
$group = el_get_group_by_guid($guid);

if(($group->owner_guid === el_loggedin_user()->guid) || el_isAdminLoggedin()){
	if ($group->deleteGroup($group->guid)) {
    	el_trigger_message(el_print('group:deleted'));
    	redirect();
	} 
}
el_trigger_message(el_print('group:delete:fail'), 'error');
redirect(REF);	
