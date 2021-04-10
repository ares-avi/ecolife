<?php

$block = new ElBlock;
$user = input('user');
$user = el_user_by_guid($user);

//Admin profiles should be unblockable by 'normal' members #625
if(!$user || $user->isAdmin()){
    el_trigger_message(el_print('user:block:error'), 'error');
    redirect(REF);	
}
if ($block->addBlock(el_loggedin_user()->guid, $user->guid)) {
    //Blocked user should be removed from friend list #1439
    el_remove_friend(el_loggedin_user()->guid, $user->guid);
														 
    el_trigger_message(el_print('user:blocked'), 'success');
    $loggedin_user = el_loggedin_user();
	redirect("u/{$loggedin_user->username}/edit?section=blocking");
} else {
    el_trigger_message(el_print('user:block:error'), 'error');
    redirect(REF);
}
