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
header('Content-Type: application/json');
$group = input('group');
$group = el_get_group_by_guid($group);
if(el_loggedin_user()->guid !== $group->owner_guid && !el_isAdminLoggedin()) {
		echo json_encode(array(
				'type' => 0
		));
		exit;
}
if($group->UploadCover()) {
		echo json_encode(array(
				'type' => 1,
				'url' => $group->coverURL()
		));
		exit;
} else {
		echo json_encode(array(
				'type' => 0
		));
		exit;
}
