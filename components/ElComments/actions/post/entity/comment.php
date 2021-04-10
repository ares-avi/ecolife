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
$elComment = new elComments;
$image       = input('comment-attachment');
//comment image check if is attached or not
if(!empty($image)) {
		$elComment->comment_image = $image;
}
//entity on which comment is going to be posted
$entity = input('entity');

//comment text
$comment = input('comment');
if($elComment->PostComment($entity, el_loggedin_user()->guid, $comment, 'entity')) {
		$vars            = array();
		$vars['comment'] = (array) el_get_comment($elComment->getCommentId());
		$data            = el_comment_view($vars);
		if(!el_is_xhr()) {
				redirect(REF);
		} else {
				header('Content-Type: application/json');
				echo json_encode(array(
						'comment' => $data,
						'process' => 1
				));
				exit;
		}
} else {
		if(!el_is_xhr()) {
				redirect(REF);
		} else {
				header('Content-Type: application/json');
				echo json_encode(array(
						'process' => 0
				));
				exit;
		}
}
