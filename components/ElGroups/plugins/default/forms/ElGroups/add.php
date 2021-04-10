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
?>
<div>
<label><?php echo el_print('group:name'); ?></label>
<input type="text" name="groupname"/>
<input type="submit" class="el-hidden" id="el-group-submit"/>
</div>
<div class="group-add-privacy">
<?php
echo el_plugin_view('input/privacy', array(
			'options' => array(
			    el_PUBLIC => 	 el_print('public') . ' ('. el_print('privacy:group:public').')',		   
			    el_PRIVATE =>  el_print('close') . ' ('. el_print('privacy:group:close').')',		   
			 ),											 
));
?>
</div>