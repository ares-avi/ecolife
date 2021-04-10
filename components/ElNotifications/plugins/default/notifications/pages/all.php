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

$get = new  elNotifications;
$notifications = $get->searchNotifications(array(
					'owner_guid' => el_loggedin_user()->guid,	
					'offset' => input('offset', '', 1),
					'order_by' => 'n.guid DESC',
));
$count = $get->searchNotifications(array(
					'owner_guid' => el_loggedin_user()->guid,
					'count' => true,
));
if($notifications){
	$list = '<div class="el-notifications-all el-notification-page">';
	foreach($notifications as $item){
			$list .= $item->toTemplate();	
	}
	$list .= "</div>";
}
$pagination = el_view_pagination($count);
echo el_plugin_view('widget/view', array(
				'title' => el_print('notifications'),
				'contents' => $list . $pagination,
));
