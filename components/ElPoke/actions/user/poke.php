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
$poke = new elPoke;
$user = input('user');
if ($poke->addPoke(el_loggedin_user()->guid, $user)) {
    $user = el_user_by_guid($user);
    el_trigger_message(el_print('user:poked', array($user->fullname)), 'success');
    redirect(REF);
} else {
    el_trigger_message(el_print('user:poke:error'), 'error');
    redirect(REF);
}