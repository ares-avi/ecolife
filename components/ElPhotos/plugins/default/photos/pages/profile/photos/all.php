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

$albums = new elAlbums;
$photos = $albums->GetUserProfilePhotos($params['user']->guid);
echo '<div class="el-photos">';
echo '<h2>' . el_print('profile:photos') . '</h2>';
if ($photos) {
    foreach ($photos as $photo) {
        $imagefile = str_replace('profile/photo/', '', $photo->value);
        $image = el_site_url() . "album/getphoto/{$params['user']->guid}/{$imagefile}?size=larger&type=1";
        $view_url = el_site_url() . 'photos/user/view/' . $photo->guid;
        echo "<li><a href='{$view_url}'><img src='{$image}'  class='pthumb'/></a></li>";
    }
}
echo '</div>';
