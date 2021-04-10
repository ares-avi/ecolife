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
if (empty($group)) {
    el_trigger_message(el_print('member:add:error'), 'error');
    redirect(REF);
}
if ($add->sendRequest(el_loggedin_user()->guid, $group)) {
    el_trigger_message(el_print('memebership:sent'), 'success');
    redirect("group/{$group}");
} else {
    el_trigger_message(el_print('memebership:sent:fail'), 'error');
    redirect(REF);
}