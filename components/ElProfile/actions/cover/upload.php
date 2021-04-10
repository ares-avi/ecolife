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
$file             = new elFile;
$user             = el_loggedin_user();
$user             = el_user_by_guid($user->guid);
$file->owner_guid = $user->guid;

$file->type    = 'user';
$file->subtype = 'profile:cover';
$file->setFile('coverphoto');
$file->setPath('profile/cover/');
$file->setExtension(array(
		'jpg',
		'png',
		'jpeg',
		'gif'
));
if($fileguid = $file->addFile()) {
		//update user cover time, this time has nothing to do with photo entity time
		$user->data->cover_time = time();
		//default cover photo #1647
		$user->data->cover_guid = $fileguid;
		
		$user->save();
		
		$newcover    = $file->getFiles();
		$elprofile = new elProfile;
		$elprofile->ResetCoverPostition($file->owner_guid);
		$elprofile->addPhotoWallPost($file->owner_guid, $newcover->{0}->guid, 'cover:photo');
		echo 1;
		exit;
} else {
		echo 0;
		exit;
}
