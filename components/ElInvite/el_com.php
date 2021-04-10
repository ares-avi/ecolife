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
 
define('__el_INVITE__', el_route()->com . 'elInvite/');
require_once(__el_INVITE__ . 'classes/elInvite.php');

/**
 * Initialize el Invite component
 *
 * @note Please don't call this function directly in your code.
 * 
 * @return void
 * @access private
 */
function el_invite_init() {
	el_extend_view('css/el.default', 'css/invite');
	el_register_page('invite', 'el_invite_pagehandler');
    if (el_isLoggedin()) {
        el_register_action('invite/friends', __el_INVITE__. 'actions/invite.php');
		
    	$icon = el_site_url('components/elProfile/images/friends.png');
    	el_register_sections_menu('newsfeed', array(
			'name' => 'invite_friends',
        	'text' => el_print('com:el:invite:friends'),
        	'url' => el_site_url('invite'),
        	'parent' => 'links',
        	'icon' => $icon
    	));		
    }
	//[E] Add friends automatically when user joined using invitation email #1744
	el_extend_view('forms/signup', 'invites/addfriends');
	el_register_callback('user', 'created', 'el_invite_addfriends');
}
/**
 * Invite page handler
 * 
 * @note Please don't call this function directly in your code.
 *
 * @return mixed
 * @access private
 */
function el_invite_pagehandler(){
   if (!el_isLoggedin()) {
            el_error_page();
   }
   $title = el_print('com:el:invite:friends');
   $contents['content'] = el_plugin_view('invites/pages/invite');
   $content = el_set_page_layout('newsfeed', $contents);
   echo el_view_page($title, $content);	
}
/**
 * Add friends during invite 
 * 
 * @param string $callback
 * @param string $type
 * @param array  $params
 *
 * @return arrau
 */
function el_invite_addfriends($callback, $type, $params){
	   $friend = input('com_invite_friend');
	   if(isset($params['guid']) && !empty($params['guid']) && isset($friend) && !empty($friend)){
				el_add_friend($friend, $params['guid']);
				el_add_friend($params['guid'], $friend);
	   }
}
//initilize el wall
el_register_callback('el', 'init', 'el_invite_init');
