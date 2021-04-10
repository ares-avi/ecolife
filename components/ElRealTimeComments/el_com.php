<?php

define('RealTimeComments', el_route()->com . 'elRealTimeComments/');
el_register_class(array(
		'RealTimeComments' => RealTimeComments . 'classes/RealTimeComments.php'
));
function rtcomments_init() {		
		el_extend_view('js/opensource.socialnetwork', 'js/rtcomments');
		el_extend_view('css/el.default', 'css/rtcomments');
		
		if(el_isLoggedin()){
				el_extend_view('comments/post/comments', 'rtcomments/item/js');
				el_extend_view('comments/post/comments_entity', 'rtcomments/item/js_entity');
		
				el_register_action('rtcomments/status', RealTimeComments . 'actions/status.php');
				el_register_action('rtcomments/setstatus', RealTimeComments . 'actions/setstatus.php');
				
				el_register_callback('post', 'delete', 'rtcomments_post_delete');
				el_register_callback('delete', 'entity', 'rtcomments_entity_delete');
				el_register_callback('user', 'delete', 'rtcomments_user_delete');
		}
}
function rtcomments_user_delete($event, $type, $params) {
				if(!empty($params['entity']->guid)){
					$delete           = new elDatabase;
					$params['from']   = 'el_relationships';
					$params['wheres'] = array(
							"relation_from='{$params['entity']->guid}' AND type IN('rtctypingentity', 'rtctypingpost')",
					);
					if($delete->delete($params)) {
							return true;
					}
				}
}

function rtcomments_entity_delete($event, $type, $params) {
				if(!empty($params['entity'])){
					$delete           = new elDatabase;
					$params['from']   = 'el_relationships';
					$params['wheres'] = array(
							"relation_to='{$params['entity']}' AND type='rtctypingentity'",
					);
					if($delete->delete($params)) {
							return true;
					}
				}
}
function rtcomments_post_delete($event, $type, $guid) {
				if(!empty($guid)){
					$delete           = new elDatabase;
					$params['from']   = 'el_relationships';
					$params['wheres'] = array(
							"relation_to='{$guid}' AND type='rtctypingpost'",
					);
					if($delete->delete($params)) {
							return true;
					}
				}
}
el_register_callback('el', 'init', 'rtcomments_init');
