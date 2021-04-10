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
$params['owner_guid'] = el_loggedin_user()->guid;
$params['name'] = input('groupname');
$params['description'] = input('description');
$params['privacy'] = input('privacy');
if ($add->createGroup($params)) {
    el_trigger_message(el_print('group:added'), 'success');
    redirect("group/{$add->getGuid()}");
} else {
    el_trigger_message(el_print('group:add:fail'), 'error');
    redirect(REF);
}