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
$from     = $params['message_to'];
$to       = el_loggedin_user();
$messages = el_chat()->getNew($from, $to);
if ($messages) {
		foreach ($messages as $message) {
				$deleted = false;
				$class   = '';
				if (isset($message->is_deleted) && $message->is_deleted == true) {
						$deleted = true;
						$class   = ' el-message-deleted';
				}
				$vars['message'] = el_message_print($message->message);
				$vars['time']    = $message->time;
				$vars['id']      = $message->id;
				$vars['deleted'] = $deleted;
				$vars['class']   = $class;
				if (el_loggedin_user()->guid == $message->message_from) {
						echo el_plugin_view('chat/message-item-send', $vars);
				} else {
						$vars['reciever'] = el_user_by_guid($message->message_from);
						echo el_plugin_view('chat/message-item-received', $vars);
				}
		}
}
