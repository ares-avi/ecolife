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
$photos = $albums->GetAlbum($params['album']);
echo '<div class="el-photos">';
echo '<h2>' . $photos->album->title . '</h2>';
if ($photos->photos) {
    foreach ($photos->photos as $photo) {
        $image = str_replace('album/photos/', '', $photo->value);
        $image = el_site_url() . "album/getphoto/{$params['album']}/{$image}?size=album";
        $view_url = el_site_url() . 'photos/view/' . $photo->guid;
        echo "<li><a href='{$view_url}'><img src='{$image}'  class='pthumb'/></a></li>";
    }
}
echo '</div>';
echo el_plugin_view('photos/pages/gallery', array(
		'photos' => $photos->photos,													
));