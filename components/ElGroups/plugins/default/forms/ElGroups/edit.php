<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$group = $params['group'];
?>
<label><?php echo el_print('group:name'); ?></label>
<input type="text" name="groupname" value="<?php echo $group->title; ?>"/>
<label><?php echo el_print('group:desc'); ?></label>

<textarea name="groupdesc"><?php echo $group->description; ?></textarea>
<br/>

<label><?php echo el_print('privacy'); ?></label>
<select name="membership">
    <?php
    if ($group->membership == el_PUBLIC) {
        $open = 'selected';
        $close = '';
    } elseif ($group->membership == el_PRIVATE) {
        $close = 'selected';
        $open = '';
    }
    ?>
    <option value='2' <?php echo $open; ?>> <?php echo el_print('public'); ?> </option>
    <option value='1' <?php echo $close; ?>> <?php echo el_print('close'); ?> </option>
</select>
<input type="hidden" name="group" value="<?php echo $group->guid; ?>"/>
<input type="submit" value="<?php echo el_print('save'); ?>" class="btn btn-success"/>
<a class="btn btn-warning" href="<?php echo el_site_url("action/group/cover/delete?guid={$group->guid}", true);?>"><i class="fa fa-trash-o"></i><?php echo el_print('group:delete:cover');?></a>
<?php
	echo el_plugin_view('output/url', array(
			'text' => el_print('delete'),
			'href' => el_site_url("action/group/delete?guid=$group->guid"),
			'class' => 'btn btn-danger delete-group el-make-sure',
			'action' => true,
	));
