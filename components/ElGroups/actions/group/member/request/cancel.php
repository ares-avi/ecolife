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
$user = el_loggedin_user()->guid;
if ($add->deleteMember($user, $group)) {
    el_trigger_message(el_print('membership:cancel:succes'), 'success');
    redirect(REF);
} else {
    el_trigger_message(el_print('membership:cancel:fail'), 'error');
    redirect(REF);
}