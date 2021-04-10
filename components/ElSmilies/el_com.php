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
 
define('__el_SMILIES__', el_route()->com . 'elSmilies/');
require_once(__el_SMILIES__ . 'libraries/smilify.lib.php');

/**
 * Initialize el Smilies component
 *
 * @note Please don't call this function directly in your code.
 * 
 * @return void
 * @access private
 */
function el_smiley_embed_init() {	
	el_extend_view('css/el.default', 'css/smilies/emojii');
	el_extend_view('css/el.admin.default', 'css/smilies/emojii');
 	el_extend_view('js/opensource.socialnetwork', 'js/smilies/emojii');
    el_extend_view('el/site/head', 'js/smilies/emojii-settings');
    el_extend_view('el/admin/head', 'js/smilies/emojii-settings');
	el_extend_view('comments/attachment/buttons', 'smilies/comment/button');
	
	if (el_isLoggedin()) {
		$component = new elComponents;
		$settings = $component->getComSettings('elSmilies');
		if($settings && $settings->compatibility_mode == 'on'){
			el_add_hook('wall', 'templates:item', 'el_embed_smiley', 100);
			el_add_hook('comment:view', 'template:params', 'el_smiley_in_comments', 100);	
			el_add_hook('chat', 'message:smilify', 'el_embed_smiley_in_chat', 100);	
			el_add_hook('messages', 'message:smilify', 'el_embed_smiley_in_messages', 100);	
		}

		$emojii_button = array(
				'name' => 'emojii_selector',
				'text' => '<i class="fa fa-smile-o"></i>',
				'href' => 'javascript:void(0);',
		);
	
		el_register_menu_item('wall/container/controls/home', $emojii_button);		
		el_register_menu_item('wall/container/controls/user', $emojii_button);	
		el_register_menu_item('wall/container/controls/group', $emojii_button);
		
		if(el_isAdminLoggedin()) {
			el_register_action('smilies/admin/settings', __el_SMILIES__ . 'actions/smilies/admin/settings.php');
			el_register_com_panel('elSmilies', 'settings');
		}
	}
}
/**
 * Replace certain ascii patterns with el emoticons.
 *
 * @note Please don't call this function directly in your code.
 * 
 * @param string $hook Name of hook
 * @param string $type Hook type
 * @param array|object $return Array or Object
 * @params array $params Array contatins params
 *
 * @return array
 * @access private
 */
function el_embed_smiley($hook, $type, $return, $params){
	$params['text'] = smilify($return['text']);
	return $params;
}
/**
 * Replace certain ascii patterns with el emoticons in comments.
 *
 * @note Please don't call this function directly in your code.
 * 
 * @param string $hook Name of hook
 * @param string $type Hook type
 * @param array|object $return Array or Object
 * @params array $params Array contatins params
 *
 * @return array
 * @access private
 */
function el_smiley_in_comments($hook, $type, $return, $params){
	if(isset($return['comment']['comments:post'])){
		$return['comment']['comments:post'] = smilify($return['comment']['comments:post']);
	} elseif(isset($return['comment']['comments:entity'])){
		$return['comment']['comments:entity'] = smilify($return['comment']['comments:entity']);		
	}
	return $return;	
}
function el_embed_smiley_in_chat($hook, $type, $return, $params){
	return smilify($return);
}
function el_embed_smiley_in_messages($hook, $type, $return, $params){
	return smilify($return);
}
//initilize el smilies
el_register_callback('el', 'init', 'el_smiley_embed_init');
