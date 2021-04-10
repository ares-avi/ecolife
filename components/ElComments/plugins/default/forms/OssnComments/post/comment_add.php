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
$object = $params['object'];
?>
<div class="el-comment-attach-photo" onclick="el.Clk('#el-comment-image-file-p<?php echo $object; ?>');"><i class="fa fa-camera"></i></div>
<?php echo el_fetch_extend_views('comments/attachment/buttons'); ?>
<span type="text" name="comment" id="comment-box-p<?php echo $object; ?>" class="comment-box"
       placeholder="<?php echo el_print('write:comment'); ?>" contenteditable="true"></span>
<input type="hidden" name="post" value="<?php echo $object; ?>"/>
<input type="hidden" name="comment-attachment"/>
 
      
