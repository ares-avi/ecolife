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

$component = new elComponents;
$settings = $component->getComSettings('elNotifications');
?>

<label><?php echo el_print('el:notifications:admin:settings:close_anywhere:title');?></label>
<?php echo el_print('el:notifications:admin:settings:close_anywhere:note');?>
<select name="close_anywhere">
 	<?php
	$close_anywhere_off = '';
	$close_anywhere_on = '';
	if($settings && $settings->close_anywhere == 'on'){
		$close_anywhere_on = 'selected';
	} else {
		$close_anywhere_off = 'selected';
	}
	?>
	<option value="off" <?php echo $close_anywhere_off;?>><?php echo el_print('el:admin:settings:off');?></option>
	<option value="on" <?php echo $close_anywhere_on;?>><?php echo el_print('el:admin:settings:on');?></option>
</select>
<input type="submit" value="<?php echo el_print("save");?>" class="btn btn-success btn-sm"/>
