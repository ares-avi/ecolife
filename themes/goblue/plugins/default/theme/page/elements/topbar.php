<?php
	if(el_isLoggedin()){		
		$hide_loggedin = "hidden-xs hidden-sm";
	}
?>
<!-- el topbar -->
<div class="topbar">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2 left-side left">
				<?php if(el_isLoggedin()){ ?>
				<div class="topbar-menu-left">
					<li id="sidebar-toggle" data-toggle='0'>
						<a role="button" data-target="#"> <i class="fa fa-th-list"></i></a>
					</li>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-7 site-name text-center <?php echo $hide_loggedin;?>">
				<span><a href="<?php echo el_site_url();?>"><?php echo el_site_settings('site_name');?></a></span>
			</div>
			<div class="col-md-3 text-right right-side">
				<div class="topbar-menu-right">
					<ul>
					<li class="el-topbar-dropdown-menu">
						<div class="dropdown">
						<?php
							if(el_isLoggedin()){						
								echo el_plugin_view('output/url', array(
									'role' => 'button',
									'data-toggle' => 'dropdown',
									'data-target' => '#',
									'text' => '<i class="fa fa-sort-desc"></i>',
								));									
								echo el_view_menu('topbar_dropdown'); 
							}
							?>
						</div>
					</li>                
					<?php
						if(el_isLoggedin()){
							echo el_plugin_view('notifications/page/topbar');
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ./ el topbar -->
