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

$message = input('message');
$to = input('to');
$from = el_loggedin_user()->guid;

header('Content-Type: application/json');
if ($to && $from && strlen($message)) {
	$send = el_chat();
	if ($send->send($from, $to, $message)) {
		$vars['message'] = $message;
		$vars['time'] = time();
		echo json_encode(array(
			'type' => 1,
			'message' => el_plugin_view('chat/message-item-send', $vars),
		));
		exit;
	}
}
echo json_encode(array('type' => 0));
