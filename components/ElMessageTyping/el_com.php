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
define('MessageTyping', el_route()->com . 'elMessageTyping/');
el_register_class(array(
		'MessageTyping' => MessageTyping . 'classes/MessageTyping.php'
));
function message_typing_init() {
		el_extend_view('css/el.default', 'messagetyping/css');
		el_extend_view('js/opensource.socialnetwork', 'messagetyping/js');
		
		el_extend_view('js/elChat.Boot', 'messagetyping/check_status');
		if(el_isLoggedin()) {
				el_register_action('message/typing/status/save', MessageTyping . 'actions/status.php');
				el_register_callback('user', 'delete', 'message_typing_user_delete');
		}
}
function message_typing_user_delete($event, $type, $params) {
		if(!empty($params['entity']->guid)) {
				$delete = new MessageTyping;
				$list   = $delete->searchAnnotation(array(
						'type' => 'messagetypingstatus',
						'wheres' => "(a.owner_guid={$params['entity']->guid} OR a.subject_guid={$params['entity']->guid})",
						'page_limit' => false
				));
				if($list) {
						foreach($list as $annotation) {
								$annotation->deleteAnnotation();
						}
				}
		}
}
el_register_callback('el', 'init', 'message_typing_init');
