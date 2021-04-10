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
 
/**
 * Get group by guid
 *
 * @param int $guid Group guid
 * @return object
 */
function el_get_group_by_guid($guid) {
    $group = new elGroup;
    return $group->getGroup($guid);
}
/**
 * Get group layout
 *
 * @param html $contents Content of page (html, php)
 * @return mixed data
 */
function el_group_layout($contents) {
    $content['content'] = $contents;
    return el_plugin_view('groups/page/group', $content);
}
/**
 * Get user groups (owned/member of)
 *
 * @param object $user User entity
 * @return object
 */
function el_get_user_groups($user) {
    if ($user) {
        $groups = new elGroup;
		//get user owned/member of groups #155
        return $groups->getMyGroups($user);
    }
}
/**
 * Group subpage set
 *
 * @param string $page Page name
 * @return void
 */
function el_group_subpage($page) {
    global $VIEW;
    $VIEW->pagePush[] = $page;
}
/**
 * Check if page is instace of group subpage
 *
 * @param string $page Page name
 * @return bool
 */
function el_is_group_subapge($page) {
    global $VIEW;
    if (in_array($page, $VIEW->pagePush)) {
        return true;
    }
    return false;
}
/**
 * Get group url
 *
 * @param object $group Group entity
 * @return string
 */
function el_group_url($group) {
    return el_site_url("group/{$group}/");
}
