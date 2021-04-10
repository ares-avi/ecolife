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

define('__el_NOTIF__', el_route()->com . 'elNotifications/');
require_once(__el_NOTIF__ . 'classes/elNotifications.php');
/**
 * Initialize Notification Component
 *
 * @return void;
 * @access private
 */
function el_notifications() {
		//css
		el_extend_view('css/el.default', 'css/notifications');
		//js
		el_extend_view('js/opensource.socialnetwork', 'js/elNotifications');
		el_extend_view('el/site/head', 'js/notifications-settings');
		
		//pages
		el_register_page('notification', 'el_notification_page');
		el_register_page('notifications', 'el_notifications_page');
		
		//callbacks
		el_register_callback('like', 'created', 'el_notification_like');
		el_register_callback('wall', 'post:created', 'el_notification_walltag');
		el_register_callback('annotations', 'created', 'el_notification_annotation');
		el_register_callback('user', 'delete', 'el_user_notifications_delete');
		
		//Orphan notification after posting/comment has been deleted #609
		el_register_callback('post', 'delete', 'el_post_notifications_delete');
		el_register_callback('like', 'deleted', 'el_like_notifications_delete');
		
		//hooks 
		el_add_hook('notification:add', 'comments:post', 'el_notificaiton_comments_post_hook');
		el_add_hook('notification:add', 'like:post', 'el_notificaiton_comments_post_hook');
		el_add_hook('notification:add', 'like:annotation', 'el_notificaiton_like_annotation_hook');
		el_add_hook('notification:add', 'comments:entity', 'el_notificaiton_comment_entity_hook');
		el_add_hook('notification:add', 'like:entity', 'el_notificaiton_comment_entity_hook');
		//tag post with a friend, doesn't show in friend's notification #589
		el_add_hook('notification:add', 'wall:friends:tag', 'el_notificaiton_walltag_hook');
		
		if(el_isLoggedin()) {
				el_extend_view('el/js/head', 'notifications/js/autocheck');
				el_register_action('notification/mark/allread', __el_NOTIF__ . 'actions/markread.php');
				if(el_isAdminLoggedin()) {
						el_register_action('notifications/admin/settings', __el_NOTIF__ . 'actions/notifications/admin/settings.php');
						el_register_com_panel('elNotifications', 'settings');
				}
		}
		el_register_sections_menu('newsfeed', array(
				'name' => 'notifications',
				'text' => el_print('notifications'),
				'url' => el_site_url('notifications/all'),
				'parent' => 'links',
		));		
}
/**
 * Create a notification for annotation like
 *
 * @return void;
 * @access private
 */
function el_notification_annotation($callback, $type, $params) {
		$notification = new elNotifications;
		$notification->add($params['type'], $params['owner_guid'], $params['subject_guid'], $params['annotation_guid']);
}
/**
 * Notification Page
 *
 * @return mixed data;
 * @access public
 */
function el_notification_page($pages) {
		$page = $pages[0];
		if(empty($page)) {
				el_error_page();
		}
		header('Content-Type: application/json');
		switch($page) {
				case 'notification':
						$get                            = new elNotifications;
						$unread                         = el_call_hook('list', 'notification:unread', array(), true);
						$notifications['notifications'] = $get->get(el_loggedin_user()->guid, $unread);
						$notifications['seeall']        = el_site_url("notifications/all");
						$clearall                       = el_plugin_view('output/url', array(
								'action' => true,
								'href' => el_site_url('action/notification/mark/allread'),
								'class' => 'el-notification-mark-read',
								'text' => el_print('el:notifications:mark:as:read')
						));
						if(!empty($notifications['notifications'])) {
								$data = el_plugin_view('notifications/pages/notification/notification', $notifications);
								echo json_encode(array(
										'type' => 1,
										'data' => $data,
										'extra' => $clearall
								));
						} else {
								echo json_encode(array(
										'type' => 0,
										'data' => '<div class="el-no-notification">' . el_print('el:notification:no:notification') . '</div>'
								));
						}
						break;
				case 'friends':
						$friends['friends'] = el_loggedin_user()->getFriendRequests();
						if(!empty($friends['friends'])) {
								$data = el_plugin_view('notifications/pages/notification/friends', $friends);
								echo json_encode(array(
										'type' => 1,
										'data' => $data
								));
						} else {
								echo json_encode(array(
										'type' => 0,
										'data' => '<div class="el-no-notification">' . el_print('el:notification:no:notification') . '</div>'
								));
						}
						break;
				
				case 'messages':
						$elMessages     = new elMessages;
						$params['recent'] = $elMessages->recentChat(el_loggedin_user()->guid);
						if(!empty($params['recent'])) {
								$data = el_plugin_view('messages/templates/message-with-notifi', $params);
								echo json_encode(array(
										'type' => 1,
										'data' => $data
								));
						} else {
								echo json_encode(array(
										'type' => 0,
										'data' => '<div class="el-no-notification">' . el_print('el:notification:no:notification') . '</div>'
								));
						}
						break;
				case 'read';
						if(!empty($pages[1])) {
								$notification = new elNotifications;
								$guid         = $notification->getbyGUID($pages[1]);
								if($guid->owner_guid == el_loggedin_user()->guid) {
										$notification->setViewed($pages[1]);
										$url = urldecode(input('notification'));
										header("Location: {$url}");
								} else {
										redirect();
								}
						} else {
								redirect();
						}
						break;
				case 'count':
						if(!el_isLoggedIn()) {
								el_error_page();
						}
						$notification = new elNotifications;
						$count_notif  = $notification->countNotification(el_loggedin_user()->guid);
						//Notifications crashing if elMessages module is disabled #646
						if(class_exists('elMessages')) {
								$messages       = new elMessages;
								$count_messages = $messages->countUNREAD(el_loggedin_user()->guid);
						}
						if(!$count_notif) {
								$count_notif = 0;
						}
						$friends   = el_loggedin_user()->getFriendRequests();
						$friends_c = 0;
						if($friends) {
								$friends_c = count($friends);
						}
						echo json_encode(array(
								'notifications' => $count_notif,
								'messages' => $count_messages,
								'friends' => $friends_c
								
						));
						break;
				default:
						el_error_page();
						break;
						
		}
}
/**
 * Notifications page
 *
 * @param (array) $pages Array containg pages
 *
 * @return false|null data;
 * @access public
 */
function el_notifications_page($pages) {
		$page = $pages[0];
		if(empty($page)) {
				return false;
		}
		switch($page) {
				case 'all':
						$title    = 'Notifications';
						$contents = array(
								'content' => el_plugin_view('notifications/pages/all')
						);
						$content  = el_set_page_layout('media', $contents);
						echo el_view_page($title, $content);
						
						break;
				default:
						el_error_page();
						break;
						
		}
}
/**
 * Create a notification for like created
 *
 * @return void;
 * @access private
 */
function el_notification_like($type, $event_type, $params) {
		$notification = new elNotifications;
		$notification->add($params['type'], $params['owner_guid'], $params['subject_guid'], $params['subject_guid']);
}
/**
 * Create a notification for wall tag
 *
 * @return void;
 * @access private
 */
function el_notification_walltag($type, $ctype, $params) {
		$notification = new elNotifications;
		if(isset($params['friends']) && is_array($params['friends'])) {
				foreach($params['friends'] as $friend) {
						//Tagging friend in wall isn't working #1511
						//user object guid instead of itemguid
						if(!empty($params['poster_guid']) && !empty($params['object_guid']) && !empty($friend)) {
								$notification->add('wall:friends:tag', $params['poster_guid'], $params['object_guid'], $params['object_guid'], $friend);						}
				}
		}
}
/**
 * Wall post user tag notification hook
 * 
 * Tag post with a friend, doesn't show in friend's notification #589
 * 
 * @return boolean
 */
function el_notificaiton_walltag_hook($hook, $type, $return, $params) {
		if(isset($params['notification_owner'])) {
				$params['owner_guid'] = $params['notification_owner'];
		}
		return $params;
}
/**
 * Delete user notifiactions when user deleted
 *
 * @return void;
 * @access private
 */
function el_user_notifications_delete($callback, $type, $params) {
		$delete = new elNotifications;
		$delete->deleteUserNotifications($params['entity']);
}
/**
 * Delete wall post notifiactions
 *
 * @param string  $hook Hook name
 * @param string  $type Hook type
 * @param integer $guid Post guid
 *
 * @return void
 */
function el_post_notifications_delete($callback, $type, $guid) {
		$delete = new elNotifications;
		if(!empty($guid)) {
				$delete->deleteNotification(array(
						'subject_guid' => $guid,
						'type' => array(
								'wall:friends:tag',
								'like:post'
						)
				));
		}
}
/**
 * Delete like notifiactions
 *
 * @param string  $callback A callback name
 * @param string  $type A callback type
 * @param Array   $guid Option values
 *
 * @return void
 */
function el_like_notifications_delete($callback, $type, $vars) {
		$delete = new elNotifications;
		if(isset($vars['subject_id']) && !empty($vars['subject_id'])) {
				$delete->deleteNotification(array(
						'item_guid' => $vars['subject_id'],
						'type' => array(
								'like:entity:file:profile:photo',
								'like:entity:file:profile:cover',
								'like:entity:file:el:aphoto',
								'like:post',
								'like:annotation'
						)
				));
		}
}
/**
 * Wall post comments/likes notification hook
 *
 * @param string $hook Hook name
 * @param string $type Hook type
 * @param array  $params Callback data
 *
 * @return array or false;
 * @access public
 */
function el_notificaiton_comments_post_hook($hook, $type, $return, $params) {
		$object              = new elObject;
		$object->object_guid = $params['subject_guid'];
		
		$object = $object->getObjectById();
		if($object) {
				$params['owner_guid'] = $object->owner_guid;
				
				if($object->type !== 'user') {
						$params['type'] = "{$params['type']}:{$object->type}:{$object->subtype}";
						return el_call_hook('notification:add', $params['type'], $params, false);
				}
				return $params;
		}
		return false;
}
/**
 * Annotations likes notification hook
 *
 * @param string $hook Hook name
 * @param string $type Hook type
 * @param array Callback data
 *
 * @return array or false;
 * @access public
 */
function el_notificaiton_like_annotation_hook($hook, $type, $return, $params) {
		$annotation                = new elAnnotation;
		$annotation->annotation_id = $params['subject_guid'];
		
		$annotation = $annotation->getAnnotationById();
		if($annotation) {
				$params['owner_guid']   = $annotation->owner_guid;
				$params['subject_guid'] = $annotation->subject_guid;
				return $params;
		}
		return false;
}
/**
 * Entity comments/likes notification hook
 *
 * @param string $hook Hook name
 * @param string $type Hook type
 * @param array Callback data
 *
 * @return array or false;
 * @access public
 */
function el_notificaiton_comment_entity_hook($hook, $type, $return, $params) {
		$entity              = new elEntities;
		$entity->entity_guid = $params['subject_guid'];
		
		$entity         = $entity->get_entity();
		$params['type'] = "{$params['type']}:{$entity->subtype}";
		
		if($entity) {
				if($entity->type == 'user') {
						$params['owner_guid'] = $entity->owner_guid;
				}
				
				if($entity->type == 'object') {
						$object              = new elObject;
						$object->object_guid = $entity->owner_guid;
						$object              = $object->getObjectById();
						if($object) {
								$params['owner_guid'] = $object->owner_guid;
						}
				}
				return $params;
		}
		return false;
}
//initialize notification component
el_register_callback('el', 'init', 'el_notifications');
