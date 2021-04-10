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
define('__el_CHAT__', el_route()->com . 'elChat/');
if(com_is_active('elMessages')) {
	require_once(__el_CHAT__ . 'classes/elChat.php');
	require_once(__el_CHAT__ . 'libs/el.lib.chat.php');
}

function el_chat_init() {
	if(com_is_active('elMessages')) {
	    el_extend_view('css/el.default', 'css/elChat');

	    el_new_js('el.chat', 'js/elChat');

	    //chat bar
	    if (el_isLoggedIn()) {
	        //load js and chatbar if user is loggedin
 	       el_load_js('el.chat');
  	      el_extend_view('el/page/footer', 'chat/chatbar');
 	   }
 	   el_register_page('elchat', 'el_js_page_handler');

 	   el_register_action('elchat/send', __el_CHAT__ . 'actions/message/send.php');
 	   el_register_action('elchat/markread', __el_CHAT__ . 'actions/markread.php');
	   el_register_action('elchat/close', __el_CHAT__ . 'actions/close.php');
	}
}

function el_js_page_handler($pages) {
    switch ($pages[0]) {
        case 'boot':
            if (!el_isLoggedIn()) {
                el_error_page();
            }
            if (isset($pages[1]) && $pages[1] == 'el.boot.chat.js') {
                header('Content-Type: application/javascript');
                echo el_plugin_view('js/elChat.Boot');
            }
            break;
        case 'selectfriend':
            $user = input('user');
            if (!empty($user)) {
                $user = el_user_by_guid($user);
                elChat::setUserChatSession($user);
                $friend['user'] = $user;
                echo el_plugin_view('chat/selectfriend', $friend);
            }
            break;
		case 'load':
			$guid = input('guid');
			$user = el_user_by_guid($guid);
			if(empty($user->guid)) {
					return;
			}
			
			$messages_meta  = el_chat()->getWith(el_loggedin_user()->guid, $user->guid);
			$messages_count = el_chat()->getWith(el_loggedin_user()->guid, $user->guid, true);
			echo "<div class='el-chat-messages-data-{$user->guid}'>";
			echo el_view_pagination($messages_count, 10, array(
							'offset_name' => "offset_message_xhr_with_{$user->guid}",															 
			));			
            if ($messages_meta) {
                foreach ($messages_meta as $message) {
					$deleted = false;
					$class = '';
					if(isset($message->is_deleted) && $message->is_deleted == true){
								$deleted = true;
								$class = ' el-message-deleted';
					}							
                    $vars['message'] = el_message_print($message->message);
                    $vars['time'] = $message->time;
                    $vars['id'] = $message->id;
					$vars['deleted'] = $deleted;
					$vars['class'] = $class;
                    if (el_loggedin_user()->guid == $message->message_from) {
                        echo el_plugin_view('chat/message-item-send', $vars);
                    } else {
                        if(!isset($vars['reciever'])){
							$vars['reciever'] = el_user_by_guid($message->message_from);
						}
                        echo el_plugin_view('chat/message-item-received', $vars);
                    }
                }
            }			
			echo "</div>";
			break;
        default:
            el_error_page();
            break;
    }
}

el_register_callback('el', 'init', 'el_chat_init');
