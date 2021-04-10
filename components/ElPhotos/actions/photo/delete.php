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

$photoid = input('id');

$delete = el_photos();
$delete->photoid = $photoid;

$photo = $delete->GetPhoto($delete->photoid);

$owner = el_albums();
$owner = $owner->GetAlbum($photo->owner_guid);

if (($owner->album->owner_guid == el_loggedin_user()->guid) || el_isAdminLoggedin()) {
    if ($delete->deleteAlbumPhoto()) {
        el_trigger_message(el_print('photo:deleted:success'), 'success');
        redirect("album/view/{$owner->album->guid}");
    } else {
        el_trigger_message(el_print('photo:delete:error'), 'error');
        redirect(REF);
    }
} else {
    el_trigger_message(el_print('photo:delete:error'), 'error');
    redirect(REF);
}
