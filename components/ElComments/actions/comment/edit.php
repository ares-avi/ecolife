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
$guid    = input('guid');
$text    = input('comment');
$comment = el_get_annotation($guid);

if($comment && (strlen($text) || $comment->{'file:comment:photo'})) {
		//editing, then saving a comment gives warning #685
		$comment->data	= new stdClass;
		if($comment->type == 'comments:entity') {
				$comment->data->{'comments:entity'} = $text;
		} elseif($comment->type == 'comments:post') {
				$comment->data->{'comments:post'} = $text;
		}
		$user = el_loggedin_user();
		if(($comment->owner_guid == $user->guid || $user->canModerate()) && $comment->save()) {
				$params               = array();
				$params['text']       = $text;
				$params['annotation'] = $comment;
				el_trigger_callback('comment', 'edited', $params);
		
				el_trigger_message(el_print('comment:edit:success'));
				return;
		}
}
el_trigger_message(el_print('comment:edit:failed'), 'error');
