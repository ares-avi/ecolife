<?php
$list = elBlock::getBlocking();
?>
<p><?php echo el_print('el:profile:list:text');?></p>
<div class="el-block-lists">
	<?php 
	if($list){
			foreach($list as $relation){
					$item = el_user_by_guid($relation->relation_to);
					if(!$item){
						continue;	
					}
				?>
			    <li><span><?php echo $item->fullname;?> (<?php echo $item->username;?>)</span> <a href="<?php echo el_site_url("action/unblock/user?user={$item->guid}", true);?>"><?php echo el_print('user:unblock');?></a></li>
     <?php
			}
	}
	?>
</div>