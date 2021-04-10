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
$friends = el_chat()->getOnlineFriends('', 10);
$have = '';
if ($friends) {
    foreach ($friends as $friend) {
        $friend = arrayObject($friend, 'elUser');
        //[B] user get hook didn't works on chat #1679
	if(!isset($friend->fullname)){
		$friend->fullname = $friend->first_name . ' ' . $friend->last_name;
	}
        $vars['entity'] = $friend;
        $vars['icon'] = $friend->iconURL()->smaller;
        $have = 1;
        echo el_plugin_view('chat/friends-item', $vars);
    }
}
if ($have !== 1) {
    echo '<div class="el-chat-none">'.el_print('el:chat:no:friend:online').'</div>';
}
