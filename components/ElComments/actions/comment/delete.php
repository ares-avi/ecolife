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
$comment = input('comment');
$delete = new elComments;
$comment = $delete->GetComment($comment);

//group admins must be able to delete ANY comment in their own group #170
//first get wall post then get group and check if loggedin user is group owner
if ($comment->type == 'comments:post') {
    $post = el_get_object($comment->subject_guid);
    if ($post && $post->type == 'group') {
        $group = el_get_group_by_guid($post->owner_guid);
    }
}
$user = el_loggedin_user();
if ($comment->type == 'comments:entity') {
    $entity = el_get_entity($comment->subject_guid);
}
//Post owner can not delete others comments #607
if (($comment->owner_guid == $user->guid) || ($post->type == 'user' && $user->guid == $post->owner_guid) || ($group->owner_guid == $user->guid) || ($entity->owner_guid == $user->guid) || el_isAdminLoggedin()) {
    if ($delete->deleteComment($comment->getID())) {
        if (el_is_xhr()) {
            echo 1;
            exit;
        } else {
            el_trigger_message(el_print('comment:deleted'), 'success');
            redirect(REF);
        }
    } else {
        if (el_is_xhr()) {
            echo 0;
            exit;
        } else {
            el_trigger_message(el_print('comment:delete:error'), 'error');
            redirect(REF);
        }
    }
} else {
    if (el_is_xhr()) {
        echo 0;
    } else {
        el_trigger_message(el_print('comment:delete:error'), 'error');
        redirect(REF);
    }
}
