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

/* Define Paths */
define('__el_BLOCK__', el_route()->com . 'elBlock/');

/* Load elBlock Class */
require_once(__el_BLOCK__ . 'classes/elBlock.php');

/**
 * Initialize the block component.
 *
 * @return void;
 * @access private;
 */
function el_block() {
		//callbacks
		el_register_callback('page', 'load:profile', 'el_user_block_menu', 100);
		el_register_callback('action', 'load', 'el_user_block_action');
		
		el_extend_view('css/el.default', 'block/css');
		//hooks
		el_add_hook('page', 'load', 'el_user_block');
		
		//actions
		if(el_isLoggedin()) {
				el_register_action('block/user', __el_BLOCK__ . 'actions/user/block.php');
				el_register_action('unblock/user', __el_BLOCK__ . 'actions/user/unblock.php');
				el_register_page('blocked', 'el_block_page_handler');
				
				el_add_hook('profile', 'edit:section', 'el_blocking_list_page');	
				el_register_menu_item('profile/edit/tabs', array(
							'name' => 'blocking',
							'href' => '?section=blocking',
							'text' => el_print('el:profile:edit:tab'),
				));	
				if(!el_isAdminLoggedin()){
					el_add_hook('wall', 'getPublicPosts', 'el_block_strip_posts');
					el_add_hook('wall', 'GetPostByOwner', 'el_block_strip_group_posts');
				}
		}
		el_register_callback('user', 'delete', 'el_user_block_relations_delete');		
}
function el_block_strip_group_posts($hook, $type, $return, $params){
			$user = el_loggedin_user();
			if(isset($user->guid)){
				$return['entities_pairs'][] = array(
							'name' => 'poster_guid',
							'value' => true,
							'wheres' => "([this].value NOT IN (SELECT DISTINCT relation_to FROM `el_relationships` WHERE relation_from={$user->guid} AND type='userblock') AND [this].value NOT IN (SELECT 	DISTINCT relation_from FROM `el_relationships` WHERE relation_to={$user->guid} AND type='userblock'))"
 				 );
			}
			return $return;	
}
function el_block_strip_posts($hook, $type, $return, $params){
			//here posts belongs to owner_guid so we can use owner_guid instea of poster_guid using joins.
			if(isset($params['user']->guid) && $params['user']->guid == el_loggedin_user()->guid){
				$return['wheres'][] = "(o.owner_guid NOT IN (SELECT DISTINCT relation_to FROM `el_relationships` WHERE relation_from={$params['user']->guid} AND type='userblock') AND o.owner_guid NOT IN (SELECT 	DISTINCT relation_from FROM `el_relationships` WHERE relation_to={$params['user']->guid} AND type='userblock'))";			
			}
			return $return;
}
/**
 * Register a page that shows a list of users that blocked
 *
 * @return string|void
 */
function el_blocking_list_page($hook, $type, $return, $params){
		if($params['section'] == 'blocking'){
			return el_plugin_view('block/list');
		}
}
/**
 * User block menu item in profile.
 *
 * @return void;
 * @access private;
 */
function el_user_block_menu($name, $type, $params) {
		$user = el_user_by_guid(el_get_page_owner_guid());
		if(elBlock::isBlocked(el_loggedin_user(), $user)) {
				$unblock = el_site_url("action/unblock/user?user={$user->guid}", true);
				el_register_menu_link('block', el_print('user:unblock'), $unblock, 'profile_extramenu');
		} else {
				$block = el_site_url("action/block/user?user={$user->guid}", true);
				el_register_menu_link('block', el_print('user:block'), $block, 'profile_extramenu');
		}
}
/**
 * Check user blocks.
 *
 * @return void;
 * @access private;
 */
function el_user_block_action($callback, $type, $params) {
		switch($params['action']) {
				case 'poke/user':
						$user = el_user_by_guid(input('user'));
						if($user) {
								if(elBlock::UserBlockCheck($user)) {
										el_trigger_message(el_print('user:poke:error'), 'error');
										redirect(REF);
								}
						}
						break;
				case 'elchat/send':
						$user = el_user_by_guid(input('to'));
						if($user) {
								//we need to check for other user too to avoid sending message to user that he blocked
								//[E] Stop UserA to send messages to UserB if he blocked UserB #1676					
								if(elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user)) {
										header('Content-Type: application/json');
										echo json_encode(array(
												'type' => 0
										));
										exit;
								}
						}
						break;
				case 'post/comment':
						$guid = input('post');
						
						$post = new elWall;
						$post = $post->GetPost($guid);
						
						$user = el_user_by_guid($post->owner_guid);
						if($user && (elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user))) {
								el_block_page();
						}
						break;
				case 'message/send':
						$user = el_user_by_guid(input('to'));
						if($user) {
								//we need to check for other user too to avoid sending message to user that he blocked
								//[E] Stop UserA to send messages to UserB if he blocked UserB #1676
								if(elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user)) {
										echo 0;
										exit;
								}
						}
						break;
		}
}
/**
 * Check user blocks.
 *
 * @return void;
 * @access private;
 */
function el_user_block($name, $type, $return, $params) {
		/*
		 * Deny from visiting profile
		 */
		if($params['handler'] == 'u' && !el_isAdminLoggedin()) {
				$user = el_user_by_username($params['page'][0]);
				//in case blocked but make user user viewing user is not admin
				if($user && elBlock::UserBlockCheck($user)  || elBlock::selfBlocked($user)) {
						el_block_page();
				}
		}
		/*
		 * Deny from sending messages
		 */
		if($params['handler'] == 'messages' && isset($params['page'][1])) {
				$user = el_user_by_username($params['page'][1]);
				if($user && (elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user))) {
						el_block_page();
				}
		}
		/*
		 * Deny from viewing user wall posts
		 */
		if($params['handler'] == 'post' && $params['page'][0] == 'view' && com_is_active('elWall') && !el_isAdminLoggedin()) {
				$post = new elWall;
				$post = $post->GetPost($params['page'][1]);
				$user = el_user_by_guid($post->owner_guid);
				if($user && (elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user))) {
						el_block_page();
				}
		}
		//add support for some components
		if($params['handler'] == 'video' && com_is_active('Videos') && function_exists('el_get_video') && $params['page'][0] == 'view' && !el_isAdminLoggedin()) {
				$video = el_get_video($params['page'][1]);
				$user  = el_user_by_guid($video->owner_guid);
				if($user && (elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user))) {
						el_block_page();
				}
		}
		if($params['handler'] == 'event' && com_is_active('Events') && function_exists('el_get_event') && $params['page'][0] == 'view' && !el_isAdminLoggedin()) {
				$video = el_get_event($params['page'][1]);
				$user  = el_user_by_guid($video->owner_guid);
				if($user && (elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user))) {
						el_block_page();
				}
		}
		if($params['handler'] == 'polls' && com_is_active('Polls') && function_exists('el_poll_get') && $params['page'][0] == 'view' && !el_isAdminLoggedin()) {
				$video = el_poll_get($params['page'][1]);
				$user  = el_user_by_guid($video->owner_guid);
				if($user && (elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user))) {
						el_block_page();
				}
		}
		if($params['handler'] == 'files' && com_is_active('Files') && function_exists('el_file_get') && $params['page'][0] == 'view' && !el_isAdminLoggedin()) {
				$video = el_file_get($params['page'][1]);
				$user  = el_user_by_guid($video->owner_guid);
				if($user && (elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user))) {
						el_block_page();
				}
		}
		if($params['handler'] == 'blog' && com_is_active('Blog') && function_exists('el_file_get') && $params['page'][0] == 'view' && !el_isAdminLoggedin()) {
				$video = com_blog_get_blog($params['page'][1]);
				$user  = el_user_by_guid($video->owner_guid);
				if($user && (elBlock::UserBlockCheck($user) || elBlock::selfBlocked($user))) {
						el_block_page();
				}
		}
		/*
		 * Deny from viewing profile photos album and albums
		 */
		if($params['handler'] == 'album' && !el_isAdminLoggedin()) {
				//check if album is profile photos
				if($params['page'][0] == 'profile') {
						$user = el_user_by_guid($params['page'][1]);
						//if album is not profile photos album then it means it simple album
				} elseif($params['page'][0] == 'view') {
						$album = new elAlbums;
						$album = $album->GetAlbum($params['page'][1]);
						$user  = el_user_by_guid($album->album->owner_guid);
				}
				if(isset($user) && elBlock::UserBlockCheck($user)) {
						el_block_page();
				}
		}
		return $return;
}
/**
 * Block Page
 * 
 * @return void
 */
function el_block_page_handler() {
		if(isset($_SESSION['__is_sent_blocked']) && $_SESSION['__is_sent_blocked'] == true){
			$_SESSION['__is_sent_blocked'] = false;
			$title                  = el_print('el:blocked:error');
			$contents['content']    = el_plugin_view('block/error');
			$contents['background'] = false;
			$content                = el_set_page_layout('contents', $contents);
			echo el_view_page($title, $content);
		} else {
			el_error_page();
		}
}
/**
 * el block page
 *
 * @return void
 */
function el_block_page() {
		if(el_is_xhr()) {
				header("HTTP/1.0 404 Not Found");
		} else {
				//show blocked page only if user is sent to it.
				$_SESSION['__is_sent_blocked'] = true;
				redirect('blocked');
		}
}
/**
 * Delete block user relationships entries
 *
 * @param string $callback Name of callback
 * @param string $type Callback type
 * @param array $params Arrays or Objects
 *
 * @return void
 * @access private
 */
function el_user_block_relations_delete($callback, $type, $params) {
		$guid  = $params['entity']->guid;
		$from  = el_get_relationships(array(
						'from' =>  $guid,
						'type' => 'userblock',
						'page_limit' => false,
		));
		if($from){
				foreach($from as $item){
						el_delete_relationship_by_id($item->relation_id);
				}
		}
		
		$to  = el_get_relationships(array(
						'to' =>  $guid,
						'type' => 'userblock',
						'page_limit' => false,
		));
		if($to){
				foreach($to as $item){
						el_delete_relationship_by_id($item->relation_id);
				}
		}		
}
el_register_callback('el', 'init', 'el_block');
