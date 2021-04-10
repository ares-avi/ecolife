<?php

$block = new ElBlock;
$user = input('user');
if ($block->removeBlock(el_loggedin_user()->guid, $user)) {
    el_trigger_message(el_print('user:unblocked'), 'success');
    redirect(REF);
} else {
    el_trigger_message(el_print('user:unblock:error'), 'error');
    redirect(REF);
}