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
?>
    <label><?php echo el_print('album:name'); ?></label>
    <input type="text" name="title" value="<?php echo $params['album']->title;?>"/>
    <input type="hidden" name="guid" value="<?php echo $params['album']->guid;?>" />
    <input type="submit" class="el-hidden" id="el-album-edit-submit"/>
<?php
	echo el_plugin_view('input/privacy', array(
		'value' => (int)$params['album']->access,											 
	));
?>