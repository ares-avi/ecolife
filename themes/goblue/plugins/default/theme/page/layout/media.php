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
<div class="container">
	<div class="row">
       <?php echo el_plugin_view('theme/page/elements/system_messages'); ?>    
		<div class="el-layout-media">
			<div class="row">
				<div class="col-md-8">
					<div class="content">
						<?php echo $params['content']; ?>
					</div>
				</div>
				<div class="col-md-3">
					<?php if (el_is_hook( 'theme', 'sidebar:right')) { ?>
						<div class="page-sidebar">
						<?php
						$modules = el_call_hook('theme', 'sidebar:right', null); 
						echo implode( '', $modules);
						?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
 	 <?php echo el_plugin_view('theme/page/elements/footer');?> 
</div>
