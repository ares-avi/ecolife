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
$album = new elAlbums;
$image = $params['entity'];

$name = $album->GetAlbum($image->owner_guid)->album->title;
$img = str_replace('album/photos/', '', $image->value);
?>
<div class="el-photo-view">
    <h2> <?php echo $name; ?></h2>
    <a class="button-grey" href="<?php echo el_site_url("album/view/{$image->owner_guid}");?>"> <?php echo el_print('back:to:album'); ?>  </a>
    <br/>
    <table border="0" class="el-photo-viewer">
        <tr>
            <td class="image-block">
                <img
                    src="<?php echo el_site_url("album/getphoto/") . $image->owner_guid; ?>/<?php echo $img; ?>?size=view"/>
            </td>
        </tr>
    </table>

</div>
<?php
	$vars['entity'] = $image;
	$vars['full_view'] = $params['full_view'];
	echo el_plugin_view('entity/comment/like/share/view', $vars);
?>
<div class="el-photo-view-controls">
    <?php
    if (el_is_hook('photo:view', 'album:controls')) {
        echo el_call_hook('photo:view', 'album:controls', $image);
    }
    ?>
</div>
