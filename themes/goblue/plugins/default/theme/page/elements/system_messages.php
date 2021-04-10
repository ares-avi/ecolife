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
$col = "col-md-11";
if($params['admin'] === true){
	$col = "col-md-12";
}
 ?>
<div class="el-system-messages">
	   <div class="row">
	  	 <div class="<?php echo $col;?>">
       			<div class="el-system-messages-inner">
    				<?php echo el_display_system_messages(); ?>
            		</div>
	   	</div>
	</div>
</div>    
