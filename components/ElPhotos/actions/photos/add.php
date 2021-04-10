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

$files      = el_input_images('elphoto');
$add        = new elPhotos;
$album_guid = input('album');

if($files) {
		foreach($files as $item) {
				$_FILES['elphoto'] = $item;
				if($guid = $add->AddPhoto($album_guid, 'elphoto', input('privacy'))) {
						$files_added[] = $guid;
				}
		}
		$args['photo_guids'] = $files_added;
		$args['album']       = $album_guid;
		el_trigger_callback('el:photo', 'add:multiple', $args);
		redirect(REF);
} else {
		redirect(REF);
}