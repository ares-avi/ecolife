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
 
//unused pagebar skeleton when ads are disabled #628 
if(el_is_hook('newsfeed', "sidebar:right")) {
	$newsfeed_right = el_call_hook('newsfeed', "sidebar:right", NULL, array());
	$sidebar = implode('', $newsfeed_right);
	$isempty = trim($sidebar);
}
//show center:top div only when there is something otherwise on phone it results empty div with padding/whitebg.
if(el_is_hook('newsfeed', "center:top")) {
	$newsfeed_center_top = el_call_hook('newsfeed', "center:top", NULL, array());
	$newsfeed_center_top = implode('', $newsfeed_center_top);
	$isempty_top 	     = trim($newsfeed_center_top);
}
?>
<div class="container-fluid">
	<div class="row">
       	<?php echo el_plugin_view('theme/page/elements/system_messages'); ?>    
		<div class="el-layout-newsfeed">
			<div class="col-md-7">
				<?php if(!empty($isempty_top)){ ?>
				<div class="newsfeed-middle-top">
					<?php echo $newsfeed_center_top; ?>
				</div>
				 <?php } ?>
				<div class="newsfeed-middle">
					<?php echo $params['content']; ?>
				</div>
			</div>
			<div class="col-md-4">
            			<?php if(!empty($isempty)){ ?>
				<div class="newsfeed-right">
					<?php
						echo $sidebar;
						?>                            
				</div>
                		<?php } ?>
			</div>
		</div>
	</div>
	<?php echo el_plugin_view('theme/page/elements/footer');?>
</div>
