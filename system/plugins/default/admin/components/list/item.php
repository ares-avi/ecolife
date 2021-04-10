<?php

 $ElComs = new ElComponents;
 $translit = ElTranslit::urlize($params['component']->id);
 if(empty($params['component']->name)){
	 $translit = rand();
 } 
 $requirements = $ElComs->checkRequirments($params['component']);

 //used code from el v1.0
 if (!$params['ElCom']->isActive($params['name'])) {
  	$enable = el_site_url("action/component/enable?com={$params['name']}", true);
  	$enable = "<a href='{$enable}' class='btn btn-success'><i class='fa fa-check'></i>" . el_print('admin:button:enable') ."</a>";
 } elseif (!in_array($params['name'], $params['ElCom']->requiredComponents())) {
  	$disable = el_site_url("action/component/disable?com={$params['name']}", true);
  	$disable = "<a href='{$disable}' class='btn btn-warning'><i class='fa fa-minus'></i>" . el_print('admin:button:disable') ."</a>";
 }
 if (in_array($params['name'], el_registered_com_panel())) {
  	$configure = el_site_url("administrator/component/{$params['name']}");
  	$configure = "<a href='{$configure}' class='btn btn-primary'><i class='fa fa-cogs'></i>" . el_print('admin:button:configure') ."</a>";
 }
 if (!in_array($params['name'], $params['ElCom']->requiredComponents())) {
  	$delete = el_site_url("action/component/delete?component={$params['name']}", true);
  	$delete = "<a href='{$delete}' class='btn btn-danger el-com-delete-button'><i class='fa fa-close'></i>" . el_print('admin:button:delete') ."</a>";
 }
 // find active usage of a required component
 if (in_array($params['name'], $params['ElCom']->requiredComponents())) {
		$in_use = false;
		if($active_usage = $ElComs->inUseBy($params['name'])) {
			$active_usage_list = implode(", ", $active_usage);
			$in_use = true;
		}
 }
?>    
    
    <div class="panel panel-default margin-top-10">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-parent="#accordion" href="#collapse-<?php echo $translit;?>" data-toggle="collapse">
		  	<?php echo $params['component']->name;?> <?php echo $params['component']->version;?> <i class="fa fa-sort-desc"></i>
          </a>
          <div class="right">
          <?php if (!$params['ElCom']->isActive($params['name'])){ ?>
           	<i title="<?php echo el_print('admin:button:disabled');?>" class="component-title-icon component-title-delete fa fa-times-circle-o"></i>         
          <?php } else {?>
           	<i title="<?php echo el_print('admin:button:enabled');?>" class="component-title-icon component-title-check fa fa-check-circle"></i>           
		  <?php } ?>
          </div>
        </h4>
      </div>
      <div id="collapse-<?php echo $translit;?>" class="panel-collapse collapse">
        <div class="panel-body">
			<p><?php echo $params['component']->description;?></p>
            <?php 
			if(!$ElComs->isOld($params['component'])){
			?>
			<table class="table margin-top-10">
 			 	<tr>
    				<th scope="row"><?php echo el_print('admin:com:version');?></th>
    				<td><?php echo $params['component']->version;?></td>
 			 	</tr>
 			 	<tr>
    				<th scope="row"><?php echo el_print('admin:com:author');?></th>
    				<td><?php echo $params['component']->author;?></td>
 			 	</tr>
 			 	<tr>
    				<th scope="row"><?php echo el_print('admin:com:author:url');?></th>
    				<td><a target="_blank" href="<?php echo $params['component']->author_url;?>"><?php echo $params['component']->author_url;?></a></td>
 			 	</tr>  
 			 	<tr>
    				<th scope="row"><?php echo el_print('admin:com:license');?></th>
    				<td><a target="_blank" href="<?php echo $params['component']->license_url;?>"><?php echo $params['component']->license;?></a></td>
 			 	</tr>
      			 	<tr>
    				<th scope="row"><?php echo el_print('admin:com:requirements');?></th>
    				<td>
                    	<table class="table">
                        	<tr class="table-titles">
                            	<th><?php echo el_print('name');?></th>
                            	<th><?php echo el_print('admin:com:requirement');?></th>
                                <th><?php echo el_print('admin:com:fulfilled');?></th>
                            </tr>
                            <?php
							if($requirements){ 
								$check = true;
								foreach($requirements  as $item){ 
									if($item['availability'] == 0){
										$check = false;
									}
									$icon = 'component-title-delete fa fa-times-circle-o';
									if($item['availability'] == 1){
											$icon = 'component-title-check fa fa-check-circle';
									}
							?>                            
                            	<tr>
                            		<td><?php echo $item['type'];?></td>
                                	<td><?php echo $item['value'];?></td>
                               	 	<td><i class="component-title-icon <?php echo $icon;?>"></i></td>
                            	</tr>
                        	<?php
								} 
							}
							?>
                        </table>
                    
                    </td>
 			 	</tr>                                                      
				<?php
				if($in_use) {
				?>
					<tr>
						<th scope="row"><?php echo el_print('admin:com:used:by');?></th>
						<td><?php echo $active_usage_list?></td>
					</tr>
				<?php
				}
				?>
		</table>
            <div class="margin-top-10 components-list-buttons">
            	<?php
					if($check){
						echo $enable;
					}
			 		echo $disable, $delete;
			 ?>
            </div>
			
			<?php
            } else {
			?>
            <div class="alert alert-danger">
            	<?php echo el_print('admin:old:com', array($params['name'])); ?>
            </div>
            <div class="margin-top-10 components-list-buttons">
                      <?php echo $delete;?>
             </div>
            <?php } ?>
            
        </div>
      </div>
    </div>
