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
$entity = el_user_by_username(input('username'));
if(!$entity){
	redirect(REF);
}
$user['firstname'] = input('firstname');
$user['lastname'] = input('lastname');
$user['email'] = input('email');
$user['username'] = input('username');

$fields = el_user_fields_names();
foreach($fields['required'] as $field){
	$user[$field] = input($field);
}
if (!empty($user)) {
    foreach ($user as $field => $value) {
        if (empty($value)) {
            el_trigger_message(el_print('fields:require'), 'error');
            redirect(REF);
        }
    }
}
if($fields['non_required']) {
	foreach($fields['non_required'] as $field){
		$user[$field] = input($field);
	}
}
$password = input('password');

$elUser = new elUser;
$elUser->password = $password;
$elUser->email = $user['email'];
//if not algo specified when user edit md5 is used #1503
if(isset($entity->password_algorithm) && !empty($entity->password_algorithm)){
		$elUser->setPassAlgo($entity->password_algorithm);
}

$elDatabase = new elDatabase;
$user_get = el_user_by_username(input('username'));
if ($user_get->guid !== el_loggedin_user()->guid) {
    redirect("home");
}

$params['table'] = 'el_users';
$params['wheres'] = array("guid='{$user_get->guid}'");

$params['names'] = array(
    'first_name',
    'last_name',
    'email'
);
$params['values'] = array(
    $user['firstname'],
    $user['lastname'],
    $user['email']
);
//check if email is not in user
if($entity->email !== input('email')){
  if($elUser->iselEmail()){
    el_trigger_message(el_print('email:inuse'), 'error');
    redirect(REF);
  }
}
//check if email is valid email 
if(!$elUser->isEmail()){
    el_trigger_message(el_print('email:invalid'), 'error');
    redirect(REF);	
}
//check if password then change password
if (!empty($password)) {
    if (!$elUser->isPassword()) {
        el_trigger_message(el_print('password:error'), 'error');
        redirect(REF);
    }
    $salt = $elUser->generateSalt();
    $password = $elUser->generate_password($password, $salt);
    $params['names'] = array(
        'first_name',
        'last_name',
        'email',
        'password',
        'salt'
    );
    $params['values'] = array(
        $user['firstname'],
        $user['lastname'],
        $user['email'],
        $password,
        $salt
    );
}
$language = input('language');
$success  = el_print('user:updated');
if(!empty($language) && in_array($language, el_get_available_languages())){
	$lang = $language;
} else {
	$lang = 'en';
}
//save
if ($elDatabase->update($params)) {
    //update entities
	$user_get->data = new stdClass;
    $guid = $user_get->guid;
    if (!empty($guid)) {
		foreach($fields as $items){
				foreach($items as $field){
						$user_get->data->{$field} = $user[$field];
				}
		}
		$user_get->data->language = $lang;
        $user_get->save();
    }
    el_trigger_message($success, 'success');
    redirect(REF);
} 
