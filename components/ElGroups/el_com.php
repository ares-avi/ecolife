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

define('__el_GROUPS__', el_route()->com . 'elGroups/');

/* Include group class and library */
require_once(__el_GROUPS__ . 'classes/elGroup.php');
require_once(__el_GROUPS__ . 'libraries/groups.php');
/**
 * Initialize Groups Component
 *
 * @return void;
 * @access private
 */
function el_groups() {
		//group css
		el_extend_view('css/el.default', 'css/groups');
		
		//group js
		el_extend_view('js/opensource.socialnetwork', 'js/groups');
		
		//group pages
		el_register_page('group', 'el_group_page');
		el_register_page('groups', 'el_groups_page');
		el_group_subpage('about');
		el_group_subpage('members');
		el_group_subpage('edit');
		el_group_subpage('requests');
		
		//group hooks
		el_add_hook('group', 'subpage', 'group_about_page');
		el_add_hook('group', 'subpage', 'group_members_page');
		el_add_hook('group', 'subpage', 'group_edit_page');
		el_add_hook('group', 'subpage', 'group_requests_page');
		el_add_hook('newsfeed', "left", 'el_add_groups_to_newfeed');
		el_add_hook('search', 'type:groups', 'groups_search_handler');
		el_add_hook('notification:add', 'comments:post:group:wall', 'el_notificaiton_groups_comments_hook');
		el_add_hook('notification:add', 'like:post:group:wall', 'el_notificaiton_groups_comments_hook');
		el_add_hook('notification:view', 'group:joinrequest', 'el_group_joinrequest_notification');
		
		//group actions
		if(el_isLoggedin()) {
				el_register_action('group/add', __el_GROUPS__ . 'actions/group/add.php');
				el_register_action('group/edit', __el_GROUPS__ . 'actions/group/edit.php');
				el_register_action('group/join', __el_GROUPS__ . 'actions/group/join.php');
				el_register_action('group/delete', __el_GROUPS__ . 'actions/group/delete.php');
				el_register_action('group/change_owner', __el_GROUPS__ . 'actions/group/change_owner.php');
				el_register_action('group/member/approve', __el_GROUPS__ . 'actions/group/member/request/approve.php');
				el_register_action('group/member/cancel', __el_GROUPS__ . 'actions/group/member/request/cancel.php');
				el_register_action('group/member/decline', __el_GROUPS__ . 'actions/group/member/request/decline.php');
				
				el_register_action('group/cover/upload', __el_GROUPS__ . 'actions/group/cover/upload.php');
				el_register_action('group/cover/reposition', __el_GROUPS__ . 'actions/group/cover/reposition.php');
				el_register_action('group/cover/delete', __el_GROUPS__ . 'actions/group/cover/delete.php');
		}
		
		
		//callbacks
		el_register_callback('page', 'load:group', 'el_group_load_event');
		el_register_callback('page', 'load:search', 'el_group_search_link');
		el_register_callback('user', 'delete', 'el_user_groups_delete');
		
		//group list in newsfeed sidebar mebu
		$groups_user = el_get_user_groups(el_loggedin_user());
		if($groups_user) {
				foreach($groups_user as $group) {
						$icon = el_site_url('components/elGroups/images/group.png');
						el_register_sections_menu('newsfeed', array(
								'text' => $group->title,
								'name' => "groups",
								'url' => el_group_url($group->guid),
								'parent' => 'groups',
								'icon' => $icon
						));
						unset($icon);
				}
		}
		//add gorup link in sidebar
		el_register_sections_menu('newsfeed', array(
				'name' => 'addgroup',
				'text' => el_print('add:group'),
				'url' => 'javascript:void(0);',
				'id' => 'el-group-add',
				'parent' => 'groups',
				'icon' => el_site_url('components/elGroups/images/add.png')
		));
		//Create link in nav to list all groups #990
		el_register_sections_menu('newsfeed', array(
				'name' => 'allgroups',
				'text' => el_print('groups'),
				'url' => el_site_url('search?type=groups&q='),
				'parent' => 'groups',
				'icon' => true
		));
		//my groups link
		/* el_register_sections_menu('newsfeed', array(
		'text' => 'My Groups',
		'url' => 'javascript:void(0);',
		'section' => 'groups',
		'icon' => el_site_url('components/elGroups/images/manages.png')
		));*/
		
}

/**
 * Group search page handler
 *
 * @return mixdata;
 * @access private
 */
function groups_search_handler($hook, $type, $return, $params) {
		$groups = new elGroup;
		$data   = $groups->searchGroups($params['q']);
		$count  = $groups->searchGroups($params['q'], array(
				'count' => true
		));
		
		$group['groups'] = $data;
		$search          = el_plugin_view('groups/search/view', $group);
		$search .= el_view_pagination($count);
		if(empty($data)) {
				return el_print('el:search:no:result');
		}
		return $search;
}

/**
 * Call event on group load
 *
 * @return void;
 * @access private
 */
function el_group_load_event($event, $type, $params) {
		$owner = el_get_page_owner_guid();
		$url   = el_site_url();
		el_register_menu_link('about', 'about:group', el_group_url($owner) . 'about', 'groupheader');
		el_register_menu_link('members', 'members', el_group_url($owner) . 'members', 'groupheader');
		// show 'Requests' menu tab only on pending requests
		$group = el_get_group_by_guid($owner);
		if ($group && $group->countRequests() && ($group->owner_guid == el_loggedin_user()->guid || el_isAdminLoggedin())) {
			el_register_menu_link('requests', 'requests', el_group_url($owner) . 'requests', 'groupheader');
		}
}

/**
 * Add search group link on search page
 *
 * @return void;
 * @access private
 */
function el_group_search_link($event, $type, $params) {
		$url = elPagination::constructUrlArgs(array(
				'type'
		));
		el_register_menu_link('groups', 'groups', "search?type=groups{$url}", 'search');
}

/**
 * Groups page handler
 *
 * Pages:
 *      groups/
 *      groups/add ( ajax )
 * @return mixdata;
 * @access private
 */
function el_groups_page($pages) {
		$page = $pages[0];
		if(empty($page)) {
				return false;
		}
		switch($page) {
				case 'add':
						$params = array(
								'action' => el_site_url() . 'action/group/add',
								'component' => 'elGroups',
								'class' => 'el-form'
						);
						$form   = el_view_form('add', $params, false);
						echo el_plugin_view('output/elbox', array(
								'title' => el_print('add:group'),
								'contents' => $form,
								'callback' => '#el-group-submit'
						));
						break;
				case 'cover':
						if(isset($pages[1]) && !empty($pages[1])) {
								$File          = new elFile;
								$File->file_id = $pages[1];
								$File          = $File->fetchFile();
								
								$etag = $File->guid . $File->time_created;
								
								if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
										header("HTTP/1.1 304 Not Modified");
										exit;
								}
								if(isset($File->guid)) {
										$Cover    = el_get_userdata("object/{$File->owner_guid}/{$File->value}");
										$filesize = filesize($Cover);
										header("Content-type: image/jpeg");
										header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
										header("Pragma: public");
										header("Cache-Control: public");
										header("Content-Length: $filesize");
										header("ETag: \"$etag\"");
										readfile($Cover);
										return;
								} else {
										el_error_page();
								}
						}
						break;
				default:
						echo el_error_page();
						break;
		}
}

/**
 * Group page handler
 * This page also contain subpages like group/<guid>/members
 *
 * Pages:
 *      group/<guid>
 *      group/<guid>/<subpage>
 * Subpage need to be register seperatly.
 *
 * @return mixdata;
 * @access private
 */
function el_group_page($pages) {
		if(empty($pages[0])) {
				el_error_page();
		}
		if(!empty($pages[0])) {
				if(isset($pages[1])) {
						$params['subpage'] = $pages[1];
				} else {
						$params['subpage'] = '';
				}
				
				if(!el_is_group_subapge($params['subpage']) && !empty($params['subpage'])) {
						el_error_page();
				}
				$group = el_get_group_by_guid($pages[0]);
				if(empty($group->guid)) {
						el_error_page();
				}
				el_set_page_owner_guid($group->guid);
				el_trigger_callback('page', 'load:group');
				
				
				$params['group']     = $group;
				$title               = $group->title;
				$view                = el_plugin_view('groups/pages/profile', $params);
				$contents['content'] = el_group_layout($view);
				$content             = el_set_page_layout('contents', $contents);
				echo el_view_page($title, $content);
		}
}

/**
 * Group about page
 *
 * Page:
 *      group/<guid>/about
 *
 * @return mixdata;
 * @access private
 */
function group_about_page($hook, $type, $return, $params) {
		$page = $params['subpage'];
		if($page == 'about') {
				$mod_content = el_plugin_view('groups/pages/about', $params);
				$mod         = array(
						'title' => el_print('about:group'),
						'content' => $mod_content
				);
				echo el_set_page_layout('module', $mod);
		}
}

/**
 * Group member page
 *
 * Page:
 *      group/<guid>/member
 *
 * @return mixdata;
 * @access private
 */
function group_members_page($hook, $type, $return, $params) {
		$page = $params['subpage'];
		if($page == 'members') {
				$mod_content = el_plugin_view('groups/pages/members', $params);
				$mod         = array(
						'title' => el_print('members'),
						'content' => $mod_content
				);
				echo el_set_page_layout('module', $mod);
		}
}

/**
 * Group edit page
 *
 * Page:
 *      group/<guid>/edit
 *
 * @return mixdata;
 * @access private
 */
function group_edit_page($hook, $type, $return, $params) {
		$page  = $params['subpage'];
		$group = el_get_group_by_guid(el_get_page_owner_guid());
		if($group->owner_guid !== el_loggedin_user()->guid && !el_isAdminLoggedin()) {
				return false;
		}
		if($page == 'edit') {
				$params = array(
						'action' => el_site_url() . 'action/group/edit',
						'component' => 'elGroups',
						'class' => 'el-edit-form',
						'params' => array(
								'group' => $group
						)
				);
				$form   = el_view_form('edit', $params, false);
				echo el_set_page_layout('module', array(
						'title' => el_print('edit'),
						'content' => $form
				));
		}
}

/**
 * Group member requests page
 *
 * Page:
 *      group/<guid>/requests
 *
 * @return mixdata;
 * @access private
 */
function group_requests_page($hook, $type, $return, $params) {
		$page  = $params['subpage'];
		$group = el_get_group_by_guid(el_get_page_owner_guid());
		if($page == 'requests') {
				if($group->owner_guid !== el_loggedin_user()->guid && !el_isAdminLoggedin()) {
						redirect("group/{$group->guid}");
				}
				$mod_content = el_plugin_view('groups/pages/requests', array(
						'group' => $group
				));
				$mod         = array(
						'title' => el_print('requests'),
						'content' => $mod_content
				);
				echo el_set_page_layout('module', $mod);
		}
}
/**
 * Group delete callback
 *
 * @param string $callback Callback name
 * @param string $type Callback type
 * @param array Callback data
 *
 * @return void;
 * @access private
 */
function el_user_groups_delete($callback, $type, $params) {
		$deleteGroup = new elGroup;
		$groups      = $deleteGroup->getUserGroups($params['entity']->guid);
		if($groups) {
				foreach($groups as $group) {
						$deleteGroup->deleteGroup($group->guid);
				}
		}
}
/**
 * Group comments/likes notification hook
 *
 * @param string $hook Hook name
 * @param string $type Hook type
 * @param array Callback data
 *
 * @return array or false;
 * @access public
 */
function el_notificaiton_groups_comments_hook($hook, $type, $return, $params) {
		$object              = new elObject;
		$object->object_guid = $params['subject_guid'];
		$object              = $object->getObjectById();
		if($object) {
				$params['owner_guid'] = $object->poster_guid;
				return $params;
		}
		return false;
}


// #186 group join request hook
function el_group_joinrequest_notification($name, $type, $return, $params) {
		$baseurl        = el_site_url();
		$user           = el_user_by_guid($params->poster_guid);
		$user->fullname = "<strong>{$user->fullname}</strong>";
		$group          = el_get_group_by_guid($params->subject_guid);
		$img            = "<div class='notification-image'><img src='{$baseurl}avatar/{$user->username}/small' /></div>";
		$type           = "<div class='el-groups-notification-icon'></div>";
		if($params->viewed !== NULL) {
				$viewed = '';
		} elseif($params->viewed == NULL) {
				$viewed = 'class="el-notification-unviewed"';
		}
		// lead directly to groups request page
		$url               = "{$baseurl}group/{$params->subject_guid}/requests";
		$notification_read = "{$baseurl}notification/read/{$params->guid}?notification=" . urlencode($url);
		return "<a href='{$notification_read}' class='el-group-notification-item'>
	       <li {$viewed}> {$img} 
		   <div class='notfi-meta'> {$type}
		   <div class='data'>" . el_print("el:notifications:{$params->type}", array(
				$user->fullname,
				$group->title
		)) . '</div>
		   </div></li></a>';
}
el_register_callback('el', 'init', 'el_groups');
