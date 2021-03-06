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
 
define('__el_EMBED__', el_route()->com . 'elEmbed/');
require_once(__el_EMBED__ . 'libraries/elembed.lib.php');
require_once(__el_EMBED__ . 'vendors/linkify/linkify.php');

/**
 * Initialize el Embed component
 *
 * @note Please don't call this function directly in your code.
 * 
 * @return void
 * @access private
 */
function el_embed_init() {	
 	el_add_hook('wall', 'templates:item', 'el_embed_wall_template_item');
	el_add_hook('comment:view', 'template:params', 'el_embed_comments_template_params');
}
/**https://player.vimeo.com/video/15371813
 * Replace videos links and simple url to html url.
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
function el_embed_wall_template_item($hook, $type, $return){
	$patterns = array(	'#(((https?://)?)|(^./))(((www.)?)|(^./))youtube\.com/watch[?]v=([^\[\]()<.,\s\n\t\r]+)#i',
						'#(((https?://)?)|(^./))(((www.)?)|(^./))youtu\.be/([^\[\]()<.,\s\n\t\r]+)#i',
						'/(https?:\/\/)(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)/',
						'/(https?:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/',
						'/(https?:\/\/)(player\.)?(vimeo.com\/video\/)([0-9]*)/',
						'/(https?:\/\/)(www\.)?(metacafe\.com\/watch\/)([0-9a-zA-Z_-]*)(\/[0-9a-zA-Z_-]*)(\/)/',
						'/(https?:\/\/www\.dailymotion\.com\/.*\/)([0-9a-z]*)/',
						);
	$regex = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/";
	
	$return['text'] = linkify($return['text']);
	if(preg_match_all($regex, $return['text'], $matches, PREG_SET_ORDER)){
	foreach($matches as $match){
			foreach ($patterns as $pattern){
				if (preg_match($pattern, $match[2]) > 0){
					$return['text'] = str_replace($match[0], el_embed_create_embed_object($match[2], uniqid('videos_embed_'), 500), $return['text']);
				}				
			}
		}
	}
	return $return;
}
/**
 * Convert text links from comments into html links
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
function el_embed_comments_template_params($hook, $type, $return, $params){
	$return['comment']['comments:post'] = linkify($return['comment']['comments:post']);
	return $return;
}
//initilize el wall
el_register_callback('el', 'init', 'el_embed_init');
