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

$new_owner = input('user');
$group     = el_get_group_by_guid(input('group'));
if ($group->owner_guid !== el_loggedin_user()->guid && !el_isAdminLoggedin()) {
    el_trigger_message(el_print('group:update:fail'), 'error');
    redirect(REF);
}

if ($group->changeOwner($new_owner, $group->guid)) {
    el_trigger_message(el_print('group:updated'));
    redirect("group/{$group->guid}/members");
} else {
    el_trigger_message(el_print('group:update:fail'), 'error');
    redirect(REF);
}
