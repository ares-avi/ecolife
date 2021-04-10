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

$en = array(
	'elnotifications' => 'Notifications',
    'el:notifications:comments:post' => "%s commented on the post.",
    'el:notifications:like:post' => "%s liked your post.",
    'el:notifications:like:annotation' => "%s liked your comment.",
    'el:notifications:like:entity:file:el:aphoto' => "%s liked your photo.",
    'el:notifications:comments:entity:file:el:aphoto' => '%s commented on your photo.',
    'el:notifications:wall:friends:tag' => '%s tagged you in a post.',
    'el:notification:are:friends' => 'You are now friends!',
    'el:notifications:comments:post:group:wall' => "%s commented on the group post.",
    'el:notifications:like:entity:file:profile:photo' => "%s liked your profile photo.",
    'el:notifications:comments:entity:file:profile:photo' => "%s commented your the profile photo.",
    'el:notifications:like:entity:file:profile:cover' => "%s liked your profile cover.",
    'el:notifications:comments:entity:file:profile:cover' => "%s commented on your profile cover.",

    'el:notifications:like:post:group:wall' => '%s liked your post.',
	
    'el:notification:delete:friend' => 'Friend request deleted!',
    'notifications' => 'Notifications',
    'see:all' => 'See All',
    'friend:requests' => 'Friend Requests',
    'el:notifications:friendrequest:confirmbutton' => 'Confirm',
    'el:notifications:friendrequest:denybutton' => 'Deny',
	
    'el:notification:mark:read:success' => 'Successfully marked all as read',
    'el:notification:mark:read:error' => 'Can not mark all as read',
    
    'el:notifications:mark:as:read' => 'Mark all as read',
	'el:notifications:admin:settings:close_anywhere:title' => 'Close notification windows by clicking anywhere',
	'el:notifications:admin:settings:close_anywhere:note' => '<i class="fa fa-info-circle"></i> closes any notification window by clicking anywhere on the page<br><br>',
);
el_register_languages('en', $en); 
