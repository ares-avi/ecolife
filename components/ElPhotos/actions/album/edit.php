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
$guid   = input('guid');
$name   = input('title');
$access = input('privacy');
$album  = el_get_object($guid);
if(isset($album->guid) && $album->subtype == 'el:album' && ($album->owner_guid == el_loggedin_user()->guid || el_loggedin_user()->canModerate())){
		if(!empty($name) && !empty($access)){
				$album->title        = $name;
				$album->data->access = $access;
				if($album->save()){
						el_trigger_message(el_print('settings:saved'));
						redirect(REF);
				}
		}
		
}
redirect(REF);