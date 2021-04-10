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

$photoid         = input('id');
$delete          = el_photos();
$delete->photoid = $photoid;
$photo           = $delete->GetPhoto($delete->photoid);
if(($photo->owner_guid == el_loggedin_user()->guid) || el_isAdminLoggedin()) {
		if($delete->deleteProfilePhoto()) {
				$user = el_user_by_guid($photo->owner_guid);
				if(isset($user->icon_guid) && $user->icon_guid == $photoid){				
						$user->data->icon_time = time();
						//[E] Default profile picture #1647
						$user->data->icon_guid = false;
						$user->save();
				}
				el_trigger_message(el_print('photo:deleted:success'), 'success');
				redirect("album/profile/{$photo->owner_guid}");
		} else {
				el_trigger_message(el_print('photo:delete:error'), 'error');
				redirect(REF);
		}
} else {
		el_trigger_message(el_print('photo:delete:error'), 'error');
		redirect(REF);
}
