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
$image = $params['entity'];
$img = str_replace('profile/photo/', '', $image->value);
?>
<div class="el-photo-view">
    <a class="button-grey" href="<?php echo el_site_url("album/profile/{$image->owner_guid}"); ?>"> <?php echo el_print('back:to:album'); ?>  </a>
    <br/>
    <table border="0" class="el-photo-viewer">
        <tr>
            <td class="image-block">
                <img
                    src="<?php echo el_site_url("album/getphoto/") . $image->owner_guid; ?>/<?php echo $img; ?>?type=1"/>
            </td>
        </tr>
    </table>

</div>
<br/>
<br/>
<?php
	$vars['entity'] = $image;
	$vars['full_view'] = $params['full_view'];
	echo el_plugin_view('entity/comment/like/share/view', $vars);
?>
<div class="el-photo-view-controls">
    <?php
    if (el_is_hook('photo:view', 'profile:controls')) {
        echo el_call_hook('photo:view', 'profile:controls', $image);
    }
    ?>
</div>
