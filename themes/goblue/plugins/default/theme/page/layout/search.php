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
?>
<div class="container-fluid">
	<div class="row">
		<?php echo el_plugin_view('theme/page/elements/system_messages'); ?>    
		<div class="el-layout-newsfeed">
			<div class="col-md-2">
				<div class="coloum-left el-page-contents">
					<?php
						if (el_is_hook('search', "left")) {
						   	$searchleft = el_call_hook('search', "left", NULL, array());
						  		echo implode('', $searchleft);
						}
						?>   
				</div>
			</div>
			<div class="col-md-6">
				<div class="newsfeed-middle el-page-contents">
					<?php echo $params['content']; ?>
				</div>
			</div>
			<div class="col-md-3">
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