<?php

$guid = input('guid');
$type = input('type');
$cids = input('comments_ids');
$timestamp = input('timestamp');
$commentids = array();
if($cids) {
		$cids = explode(',', $cids);
		foreach($cids as $id) {
				$commentids[] = (int) $id;
		}
}
$commentids       = implode(',', $commentids);
$RealTimeComments = new RealTimeComments;
$comments         = new elComments;

$vars                 = array();
$vars['subject_guid'] = $guid;
$vars['type']         = "comments:{$type}";
$vars['order_by']     = 'a.id ASC';
$vars['page_limit']   = false;

if(!empty($commentids)) {
		$vars['wheres'] = "a.id NOT IN($commentids) AND a.time_created > {$timestamp}";
}
$comments = $comments->searchAnnotation($vars);
$lists    = array();
if($comments) {
		foreach($comments as $comment) {
				$data['comment'] = get_object_vars($comment);
				$lists[]         = el_comment_view($data);
		}
}
header('Content-Type: application/json');
if($RealTimeComments->isTyping($guid, $type)) {
		echo json_encode(array(
				'status' => 'typing',
				'lists' => $lists
		));
} else {
		echo json_encode(array(
				'lists' => $lists,
				'status' => 'nottyping'
		));
}
exit;
