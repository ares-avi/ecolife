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
define('__el_COMMENTS__', el_route()->com . 'elComments/');
require_once(__el_COMMENTS__ . 'classes/elComments.php');
require_once(__el_COMMENTS__ . 'libs/comments.php');
if(!com_is_active('elNotifications')) {
	require_once(el_route()->com . 'elNotifications/classes/elNotifications.php');
}

/**
 * Initialize Comments Component
 *
 * @return void;
 * @access private
 */
function el_comments() {
		if(el_isLoggedin()) {
				el_register_action('post/comment', __el_COMMENTS__ . 'actions/post/comment.php');
				el_register_action('post/entity/comment', __el_COMMENTS__ . 'actions/post/entity/comment.php');
				el_register_action('delete/comment', __el_COMMENTS__ . 'actions/comment/delete.php');
				el_register_action('comment/edit', __el_COMMENTS__ . 'actions/comment/edit.php');
				el_register_action('comment/embed', __el_COMMENTS__ . 'actions/comment/embed.php');
		}
		el_add_hook('post', 'comments', 'el_post_comments');
		el_add_hook('post', 'comments:entity', 'el_post_comments_entity');
		
		el_extend_view('js/opensource.socialnetwork', 'js/elComments');
		el_extend_view('css/el.default', 'css/comments');
		
		el_register_page('comment', 'el_comment_page');
		
		if(el_isLoggedin()) {
				el_register_callback('comment', 'load', 'el_comment_menu');
				el_register_callback('comment', 'load', 'el_comment_edit_menu');
				el_register_callback('post', 'delete', 'el_post_comments_delete');
				el_register_callback('wall', 'load:item', 'el_wall_comment_menu');
				el_register_callback('entity', 'load:comment:share:like', 'el_entity_comment_link');
				el_register_callback('comment', 'delete', 'el_comment_notifications_delete');
		}
}
/**
 * Delete like notifiactions
 *
 * Orphan notification after posting/comment has been deleted #609
 * 
 * @param string  $callback A callback name
 * @param string  $type A callback type
 * @param array   $vars Option values
 *
 * @return void
 */
function el_comment_notifications_delete($callback, $type, $vars) {
		$delete = new elNotifications;
		if(isset($vars['comment']) && !empty($vars['comment'])) {
				$delete->deleteNotification(array(
						'item_guid' => $vars['comment'],
						'type' => array(
								'comments:post',
								'like:annotation',
								'comments:entity:file:profile:photo',
								'comments:entity:file:profile:cover',
								'comments:entity:file:el:aphoto'
						)
				));
		}
}
/**
 * Entity comment link
 *
 * @param string  $callback A callback name
 * @param string  $type A callback type
 * @param array   $params Option values
 *
 * @return void
 */
function el_entity_comment_link($callback, $type, $params) {
		$guid = $params['entity']->guid;
		el_unregister_menu('comment', 'entityextra');
		
		if(!empty($guid) && el_isLoggedIn()) {
				el_register_menu_item('entityextra', array(
						'name' => 'comment',
						'class' => "comment-entity",
						'href' => "javascript:void(0)",
						'data-guid' => $guid,
						'text' => el_print('comment:comment')
				));
		}
		el_trigger_callback('comment', 'entityextra:menu', $params);
}
/**
 * Add a comment menu item in post
 *
 * @return void
 */
function el_wall_comment_menu($callback, $type, $params) {
		$guid = $params['post']->guid;
		
		el_unregister_menu('comment', 'postextra');
		el_unregister_menu('commentall', 'postextra');
		
		if(!empty($guid)) {
				$comment = new elComments;
				el_register_menu_item('postextra', array(
						'name' => 'comment',
						'class' => "comment-post",
						'href' => "javascript:void(0)",
						'data-guid' => $guid,
						'text' => el_print('comment:comment')
				));
				if($comment->countComments($guid) > 5) {
						el_register_menu_item('postextra', array(
								'name' => 'commentall',
								'href' => el_site_url("post/view/{$guid}"),
								'text' => el_print('comment:view:all')
						));
				}
		}
}
/**
 * View comments bar on wall posts
 *
 * @return mix data;
 * @access private
 */
function el_post_comments($hook, $type, $return, $params) {
		return el_plugin_view('comments/post/comments', $params);
}

/**
 * View comments bar on entity
 *
 * @return mix data;
 * @access private
 */
function el_post_comments_entity($hook, $type, $return, $params) {
		return el_plugin_view('comments/post/comments_entity', $params);
}

/**
 * Delete post comments
 *
 * @return void;
 * @access private
 */
function el_post_comments_delete($event, $type, $params) {
		$delete = new elComments;
		$delete->commentsDeleteAll($params);
}

/**
 * Delete comment menu
 *
 * @param string $name Name of Callback
 * @param strign $type Callback type
 * @param array  $params A option values
 *
 * @return void
 * @access private
 */
function el_comment_menu($name, $type, $params) {
		//unset previous comment menu item
		//Post owner can not delete others comments #607
		//Pull request #601 , refactoring
		el_unregister_menu('delete', 'comments');
		$user = el_loggedin_user();
		
		$elComment = new elComments;
		if(is_object($params)) {
				$params = get_object_vars($params);
		}
		$comment = $elComment->getComment($params['id']);
		if($comment->type == 'comments:post') {
				if(com_is_active('elWall')) {
						$elwall = new elWall;
						$post     = $elwall->GetPost($comment->subject_guid);
						
						//check if type is group
						if($post->type == 'group') {
								$group = el_get_group_by_guid($post->owner_guid);
						}
						//group admins must be able to delete ANY comment in their own group #170
						//just show menu if group owner is loggedin 
						if(el_isAdminLoggedin() || (el_loggedin_user()->guid == $post->owner_guid) || $user->guid == $comment->owner_guid || (el_loggedin_user()->guid == $group->owner_guid)) {
								el_unregister_menu('delete', 'comments');
								el_register_menu_item('comments', array(
										'name' => 'delete',
										'href' => el_site_url("action/delete/comment?comment={$params['id']}", true),
										'class' => 'el-delete-comment',
										'text' => el_print('comment:delete'),
										'priority' => 200
								));
						}
				}
		}
		//this section is for entity comment only
		if(el_isLoggedin() && $comment->type == 'comments:entity') {
				$entity = el_get_entity($comment->subject_guid);
				if(($user->guid == $params['owner_guid']) || el_isAdminLoggedin() || ($comment->type == 'comments:entity' && $entity->type = 'user' && $user->guid == $entity->owner_guid)) {
						el_unregister_menu('delete', 'comments');
						el_register_menu_item('comments', array(
								'name' => 'delete',
								'href' => el_site_url("action/delete/comment?comment={$params['id']}", true),
								'class' => 'el-delete-comment',
								'text' => el_print('comment:delete'),
								'priority' => 200
						));
				}
		}
}
/**
 * Comment Edit Menu
 *
 * @param string $name Name of Callback
 * @param strign $type Callback type
 * @param array  $params A option values
 *
 * @return void;
 */
function el_comment_edit_menu($name, $type, $comment) {
		el_unregister_menu('edit', 'comments');
		$user = el_loggedin_user();
		if(!empty($comment['id'])) {
				$comment = (object) $comment;
				if(el_isLoggedin()) {
						if(($user->guid == $comment->owner_guid) || $user->canModerate()) {
								el_unregister_menu('edit', 'comments');
								el_register_menu_item('comments', array(
										'name' => 'edit',
										'href' => 'javascript:void(0);',
										'data-guid' => $comment->id,
										'class' => 'el-edit-comment',
										'text' => el_print('edit')
								));
						}
				}
		}
}

/**
 * Comment page for viewing comment photos
 *
 * @access private;
 */
function el_comment_page($pages) {
		$page = $pages[0];
		switch($page) {
				case 'image':
						if(!empty($pages[1]) && !empty($pages[2])) {
								$file = el_get_userdata("annotation/{$pages[1]}/comment/photo/{$pages[2]}");
								if(is_file($file)) {
										$etag = md5($pages[2]);
										header("Etag: $etag");
										
										if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
												header("HTTP/1.1 304 Not Modified");
												exit;
										}
										$image    = el_resize_image($file, 300, 300);
										$filesize = strlen($image);
										header("Content-type: image/jpeg");
										header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
										header("Pragma: public");
										header("Cache-Control: public");
										header("Content-Length: $filesize");
										header("ETag: \"$etag\"");
										echo $image;
								} else {
										el_error_page();
								}
						} else {
								el_error_page();
						}
						break;
				case 'attachment':
						header('Content-Type: application/json');
						if(isset($_FILES['file']['tmp_name']) && ($_FILES['file']['error'] == UPLOAD_ERR_OK && $_FILES['file']['size'] !== 0) && el_isLoggedin()) {
								//code of comment picture preview ignores EXIF header #1056
								$elFile = new elFile;
								$elFile->resetRotation($_FILES['file']['tmp_name']);
								
								if(preg_match("/image/i", $_FILES['file']['type'])) {
										$file    = $_FILES['file']['tmp_name'];
										$unique  = time() . '-' . substr(md5(time()), 0, 6) . '.jpg';
										$newfile = el_get_userdata("tmp/photos/{$unique}");
										$dir     = el_get_userdata("tmp/photos/");
										if(!is_dir($dir)) {
												mkdir($dir, 0755, true);
										}
										if(move_uploaded_file($file, $newfile)) {
												$file = base64_encode(el_string_encrypt($newfile));
												echo json_encode(array(
														'file' => base64_encode($file),
														'type' => 1
												));
												exit;
										}
								}
						}
						echo json_encode(array(
								'type' => 0
						));
						break;
				case 'staticimage':
						$image = base64_decode(input('image'));
						if(!empty($image)) {
								$file = el_string_decrypt(base64_decode($image));
								header('content-type: image/jpeg');
								$file = rtrim(el_validate_filepath($file), '/');
								
								$tmpphotos = el_get_userdata("tmp/photos/");
								$filename  = str_replace($tmpphotos, '', $file);
								$file      = $tmpphotos.$filename;
								//avoid slashes in the file. 
								if(strpos($filename, '\\') !== FALSE || strpos($filename, '/') !== FALSE) {
										redirect();
								} else {
										if(is_file($file)) {
												echo file_get_contents($file);
										} else {
												redirect();
										}
								}
						} else {
								el_error_page();
						}
						break;
				case 'edit':
						$comment = el_get_annotation($pages[1]);
						if(!el_is_xhr()) {
								el_error_page();
						}
						if(!$comment) {
								header("HTTP/1.0 404 Not Found");
						}
						$user = el_loggedin_user();
						if($comment->owner_guid == $user->guid || $user->canModerate()) {
								$params = array(
										'title' => el_print('edit'),
										'contents' => el_view_form('comment/edit', array(
												'action' => el_site_url('action/comment/edit'),
												'component' => 'elComments',
												'id' => 'el-comment-edit-form',
												'params' => array(
														'comment' => $comment
												)
										), false),
										'callback' => '#el-comment-edit-save'
								);
								echo el_plugin_view('output/elbox', $params);
						}
						break;
		}
}
/**
 * Comment view
 * 
 * @param array $vars Options
 * @param string $template Template name
 * @return mixed data
 */
function el_comment_view($params, $template = 'comment') {
		$vars = el_call_hook('comment:view', 'template:params', $params, $params);
		return el_plugin_view("comments/templates/{$template}", $vars);
}
el_register_callback('el', 'init', 'el_comments');
