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

define('__el_LIKES__', el_route()->com . 'elLikes/');
require_once(__el_LIKES__ . 'classes/elLikes.php');
/**
 * Initialize Likes Component
 *
 * @return void;
 * @access private
 */
function el_likes() {
		if(el_isLoggedin()) {
				el_register_action('post/like', __el_LIKES__ . 'actions/post/like.php');
				el_register_action('post/unlike', __el_LIKES__ . 'actions/post/unlike.php');
				
				el_register_action('annotation/like', __el_LIKES__ . 'actions/annotation/like.php');
				el_register_action('annotation/unlike', __el_LIKES__ . 'actions/annotation/unlike.php');
				
		}
		el_extend_view('js/opensource.socialnetwork', 'js/elLikes');
		el_extend_view('css/el.default', 'css/likes');
		
		el_register_callback('post', 'delete', 'el_post_like_delete');
		el_register_callback('comment', 'delete', 'el_comment_like_delete');
		el_register_callback('annotation', 'delete', 'el_comment_like_delete');
		el_register_callback('user', 'delete', 'el_user_likes_delete');
		el_register_callback('wall', 'load:item', 'el_wall_like_menu');
		el_register_callback('entity', 'load:comment:share:like', 'el_entity_like_link');
		
		el_register_page('likes', 'el_likesview_page_handler');
		
		el_add_hook('notification:view', 'like:annotation', 'el_like_annotation');
		el_add_hook('post', 'likes', 'el_post_likes');
		el_add_hook('post', 'likes:entity', 'el_post_likes_entity');
		el_add_hook('notification:participants', 'like:post', 'el_likes_suppress_participants_notifications');
		el_add_hook('notification:participants', 'like:annotation', 'el_likes_suppress_participants_notifications');
}
/**
 * Add a like menu item in post
 *
 * @return void
 */
function el_wall_like_menu($callback, $type, $params) {
		$guid = $params['post']->guid;
		
		el_unregister_menu('like', 'postextra');
		
		if(!empty($guid)) {
				$likes = new elLikes;
				if(!$likes->isLiked($guid, el_loggedin_user()->guid)) {
						el_register_menu_item('postextra', array(
								'name' => 'like',
								'href' => "javascript:void(0);",
								'id' => 'el-like-' . $guid,
								'data-reaction' => "el.PostLike({$guid}, '<<reaction_type>>');",
								'text' => el_print('el:like')
						));
				} else {
						el_register_menu_item('postextra', array(
								'name' => 'like',
								'href' => "javascript:void(0);",
								'id' => 'el-like-' . $guid,
								'onclick' => "el.PostUnlike({$guid});",
								'text' => el_print('el:unlike')
						));
				}
		}
}
/**
 * Add a entity like menu item
 *
 * @return void
 */
function el_entity_like_link($callback, $type, $params) {
		$guid = $params['entity']->guid;
		
		el_unregister_menu('like', 'entityextra');
		
		if(!empty($guid)) {
				$likes = new elLikes;
				if(!$likes->isLiked($guid, el_loggedin_user()->guid, 'entity')) {
						el_register_menu_item('entityextra', array(
								'name' => 'like',
								'href' => "javascript:void(0);",
								'id' => 'el-elike-' . $guid,
								'data-reaction' => "el.EntityLike({$guid}, '<<reaction_type>>');",
								'text' => el_print('el:like')
						));
				} else {
						el_register_menu_item('entityextra', array(
								'name' => 'like',
								'href' => "javascript:void(0);",
								'id' => 'el-elike-' . $guid,
								'onclick' => "el.EntityUnlike({$guid});",
								'text' => el_print('el:unlike')
						));
				}
		}
}
/**
 * Delete post likes
 *
 * @return voud;
 * @access private
 */
function el_post_like_delete($name, $type, $params) {
		$delete = new elLikes;
		$delete->deleteLikes($params);
}
/**
 * Delete user likes
 *
 * @return voud;
 * @access private
 */
function el_user_likes_delete($name, $type, $entity) {
		$delete = new elLikes;
		$delete->deleteLikesByOwnerGuid($entity['entity']->guid);
}
/**
 * Comment likes delete
 *
 * @return voud;
 * @access private
 */
function el_comment_like_delete($name, $type, $params) {
		$delete = new elLikes;
		if(isset($params['comment'])) {
				$delete->deleteLikes($params['comment'], 'annotation');
				if(isset($params['annotation'])) {
						$delete->deleteLikes($params['annotation'], 'annotation');
				}
		}
}

/**
 * Notification View for liking annotation
 *
 * @return voud;
 * @access private
 */
function el_like_annotation($hook, $type, $return, $params) {
		$notif          = $params;
		$baseurl        = el_site_url();
		$user           = el_user_by_guid($notif->poster_guid);
		$user->fullname = "<strong>{$user->fullname}</strong>";
		
		$img = "<div class='notification-image'><img src='{$user->iconURL()->small}' /></div>";
		if(preg_match('/like/i', $notif->type)) {
				$type     = 'like';
				$database = new elDatabase;
				$database->statement("SELECT * FROM el_entities WHERE(guid='{$notif->subject_guid}')");
				$database->execute();
				$result = $database->fetch();
				$url    = el_site_url("post/view/{$notif->subject_guid}#comments-item-{$notif->item_guid}");
				if($result->subtype == 'file:el:aphoto') {
						$url = el_site_url("photos/view/{$notif->subject_guid}#comments-item-{$notif->item_guid}");
				}
				if($result->subtype == 'file:profile:photo') {
						$url = el_site_url("photos/user/view/{$notif->subject_guid}#comments-item-{$notif->item_guid}");
				}
				if($result->subtype == 'file:profile:cover') {
						$url = el_site_url("photos/cover/view/{$notif->subject_guid}#comments-item-{$notif->item_guid}");
				}
				if($result->subtype == 'file:video') {
						$url = el_site_url("video/view/{$result->owner_guid}#comments-item-{$notif->item_guid}");
				}
		}
		$type = "<div class='el-notification-icon-{$type}'></div>";
		if($notif->viewed !== NULL) {
				$viewed = '';
		} elseif($notif->viewed == NULL) {
				$viewed = 'class="el-notification-unviewed"';
		}
		$notification_read = "{$baseurl}notification/read/{$notif->guid}?notification=" . urlencode($url);
		return "<a href='{$notification_read}'>
	       <li {$viewed}> {$img} 
		   <div class='notfi-meta'> {$type}
		   <div class='data'>" . el_print("el:notifications:{$notif->type}", array(
				$user->fullname
		)) . '</div>
		   </div></li></a>';
}

/**
 * View like bar for posts
 *
 * @return mix data;
 * @access private
 */
function el_post_likes($hook, $type, $return, $params) {
		return el_plugin_view('likes/post/likes', $params);
}

/**
 * View like bar for entities
 *
 * @return mix data;
 * @access private
 */
function el_post_likes_entity($h, $t, $r, $p) {
		return el_plugin_view('likes/post/likes_entity', $p);
}

/**
 * Don't create participants notification records on likes
 *
 * @return false;
 * @access private
 */
function el_likes_suppress_participants_notifications($h, $t, $r, $p) {
	$notifyParticipants = false;
	return $notifyParticipants;
}

/**
 * View post likes modal box
 *
 * @return mix data;
 * @access public;
 */
function el_likesview_page_handler() {
		echo el_plugin_view('output/elbox', array(
				'title' => el_print('people:like:this'),
				'contents' => el_plugin_view('likes/pages/view'),
				'control' => false
		));
}
el_register_callback('el', 'init', 'el_likes');
