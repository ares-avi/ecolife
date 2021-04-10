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
$object = $params['entity_guid'];

$comments = new elComments;

if($params->full_view !== true){
	$comments->limit = 5;
}
if($params->full_view == true || $params['params']['full_view'] == true){
	$comments->limit = false;
	$comments->page_limit = false;
}
$comments = $comments->GetComments($object, 'entity');
echo "<div class='el-comments-list-e{$object}'>";
if ($comments) {
    foreach ($comments as $comment) {
            $data['comment'] = get_object_vars($comment);
            echo el_comment_view($data);
    }
}
echo '</div>';
if (el_isLoggedIn()) {
	
	$user = el_loggedin_user();
	$iconurl = $user->iconURL()->smaller;
    $inputs = el_view_form('entity/comment_add', array(
        'action' => el_site_url() . 'action/post/comment',
        'component' => 'elComments',
        'id' => "comment-container-e{$object}",
        'class' => 'comment-container comment-container-e',
        'autocomplete' => 'off',
        'params' => array('object' => $object)
    ), false);

$form = <<<html
<div class="comments-item">
    <div class="row">
        <div class="col-md-1">
            <img class="comment-user-img" src="{$iconurl}" />
        </div>
        <div class="col-md-11">
            $inputs
        </div>
    </div>
</div>
html;

$form .= '<script>  el.EntityComment(' . $object . '); </script>';
$form .= '<div class="el-comment-attachment" id="comment-attachment-container-e' . $object . '">';
$form .= '<script>el.CommentImage(' . $object . ', "entity");</script>';
$form .= el_view_form('comment_image', array(
        'id' => "el-comment-attachment-e{$object}",
        'component' => 'elComments',
        'params' => array(
			'object' => $object,
			'type' => 'e',
		)
    ), false);
$form .= '</div>';
echo $form;
}
