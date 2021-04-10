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
echo '<div class="el-profile-module-albums">';
$albums = new elAlbums;
$photos = $albums->GetAlbums($params['user']->guid, array(
		'page_limit' => 9,			
		'offset' => 1, //avoid it effecting by offset URL param,
));
if ($photos) {
    foreach ($photos as $photo) {
        $images = new elPhotos;
        $image = $images->GetPhotos($photo->guid);

        if (isset($image->{0}->value)) {
            $image = str_replace('album/photos/', '', $image->{0}->value);
            $image = el_site_url() . "album/getphoto/{$photo->guid}/{$image}?size=small";

        } else {
            $image = el_site_url() . 'components/elPhotos/images/nophoto-album.png';
        }

        $view_url = el_site_url() . 'album/view/' . $photo->guid;
        if (el_access_validate($photo->access, $photo->owner_guid)) {
            echo "<a href='{$view_url}'><img src='{$image}' /></a>";
        }
    }
} else {
    echo '<h3>' . el_print('no:albums') . '</h3>';
}
echo '</div>';