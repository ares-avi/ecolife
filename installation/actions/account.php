<?php


define('EL_ALLOW_SYSTEM_START', TRUE);
require_once(dirname(dirname(dirname(__FILE__))) . '/system/start.php');

$user['username'] = input('username');
$user['firstname'] = input('firstname');
$user['lastname'] = input('lastname');
$user['email'] = input('email');
$user['reemail'] = input('email_re');
$user['password'] = input('password');
$user['gender'] = input('gender');

$user['bdd'] = input('birthday');
$user['bdm'] = input('birthm');
$user['bdy'] = input('birthy');

foreach ($user as $field => $value) {
    if (empty($value)) {
        el_installation_message(el_print('fields:require'), 'fail');
        redirect(REF);
    }
}

if ($user['reemail'] !== $user['email']) {
    el_installation_message(el_print('emai:match:error'), 'fail');
    redirect(REF);
}


$user['birthdate'] = "{$user['bdd']}/{$user['bdm']}/{$user['bdy']}";

$add = new ElUser;
$add->username = $user['username'];
$add->first_name = $user['firstname'];
$add->last_name = $user['lastname'];
$add->email = $user['email'];
$add->password = $user['password'];
$add->gender = $user['gender'];
$add->birthdate = $user['birthdate'];
$add->sendactiviation = false;
$add->usertype = 'admin';
$add->validated = true;

if (!$add->isUsername($user['username'])) {
    el_installation_message(el_print('username:error'), 'fail');
    redirect(REF);
}
if (!$add->isPassword()) {
    el_installation_message(el_print('password:error'), 'fail');
    redirect(REF);
}

if ($add->addUser()) {
    el_installation_message(el_print('account:created'), 'success');
    redirect('installation?page=installed');
} else {
    el_installation_message(el_print('account:create:error:admin'), 'fail');
    redirect(REF);
}
