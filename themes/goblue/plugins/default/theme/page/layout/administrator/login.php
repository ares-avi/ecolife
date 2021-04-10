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
<div class="el-layout-admin">
	<?php echo el_plugin_view('theme/page/elements/system_messages', array(
						'admin' => true
	  	  )); 
	?>    
	<div class="row">
    	<div class="col-md-12 contents">
    	 	<?php echo $params['contents']; ?>
    	</div>
	</div>
</div>    