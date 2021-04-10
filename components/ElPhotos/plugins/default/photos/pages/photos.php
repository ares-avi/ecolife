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
echo '<div class="el-photos">';
$albums = new elAlbums;
$profile = new elProfile;

$photos = $albums->GetAlbums($params['user']->guid);
$count = $albums->GetAlbums($params['user']->guid, array(
			'count' => true,														 
));
$offset 	   = input('offset');
$profiel_photo = $params['user']->iconURL()->larger;
$pphotos_album = el_site_url("album/profile/{$params['user']->guid}");

$profile_covers_url = el_site_url("album/covers/profile/{$params['user']->guid}");
$profile_cover = $profile->getCoverURL($params['user']);
if(!$offset || $offset == 1){
//show profile pictures album
echo "<li>
	<a href='{$pphotos_album}'><img src='{$profiel_photo}' class='pthumb' />
	 <div class='el-album-name'>" . el_print('profile:photos') . "</div></a>
	</li>";
//show profile cover photos	
echo "<li>
	<a href='{$profile_covers_url}'><img src='{$profile_cover}' class='pthumb' />
	 <div class='el-album-name'>" . el_print('profile:covers') . "</div></a>
	</li>";	
}
if ($photos) {
    foreach ($photos as $photo) {
        if (el_access_validate($photo->access, $photo->owner_guid)) {
            $images = new elPhotos;
            $image = $images->GetPhotos($photo->guid);
            if (isset($image->{0}->value)) {
                $image = str_replace('album/photos/', '', $image->{0}->value);
                $image = el_site_url() . "album/getphoto/{$photo->guid}/{$image}?size=album";

            } else {
                $image = el_site_url() . 'components/elPhotos/images/nophoto-album.png';
            }

            $view_url = el_site_url() . 'album/view/' . $photo->guid;
            if (el_access_validate($photo->access, $photo->owner_guid)) {
                echo "<li>
	<a href='{$view_url}'><img src='{$image}' class='pthumb' />
	 <div class='el-album-name'>{$photo->title}</div></a>
	</li>";
            }
        }
    }
}
?>
</div>
<?php
echo el_view_pagination($count);