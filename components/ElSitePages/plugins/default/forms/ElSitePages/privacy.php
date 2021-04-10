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
$elSitePages = new elSitePages;
$elSitePages->pagename = 'privacy';
$elSitePages = $elSitePages->getPage();
?>
<div>
	<label><?php echo el_print('site:privacy'); ?></label>
	<textarea name="pagebody" class="el-editor"><?php echo html_entity_decode($elSitePages->description); ?></textarea>
</div>
<div class="margin-top-10">
	<input type="submit" class="btn btn-success btn-sm" value="<?php echo el_print('save'); ?>"/>
</div>
