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
<div class="el-photos-add-button">
	<input type="file" name="elphoto[]" multiple class="hidden"/>
	<button type="button" id="el-photos-add-button-inner" class="btn btn-default btn-lg"><i class="fa fa-copy"></i> <?php echo el_print('photo:select'); ?></button>
    <div class="images"><i class="fa fa-image"></i> <span class="count">0</span></div>
</div>

<input type="submit" class="el-hidden" id="el-photos-submit"/>
<?php
// Shouldn't album privacy applied on photos? $dev.arsalan
//echo el_plugin_view('input/privacy');
?>
