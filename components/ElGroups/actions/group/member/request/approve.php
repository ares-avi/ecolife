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
$add = new elGroup;
$group = input('group');
$user = input('user');
if (el_get_group_by_guid($group)->owner_guid !== el_loggedin_user()->guid && !el_isAdminLoggedin()) {
    el_trigger_message(el_print('member:add:error'), 'error');
    redirect(REF);
}
if ($add->approveRequest($user, $group)) {
    el_trigger_message(el_print('member:added'), 'success');
    redirect(REF);
} else {
    el_trigger_message(el_print('member:add:error'), 'error');
    redirect(REF);
}
