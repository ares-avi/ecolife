<div class="col-md-11">
	<div class="el-profile-edit-layout">
		<div class="profile-edit-layout-title">
			<?php echo el_print('edit'); ?>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="profile-edit-tabs">
					<?php
						echo el_view_menu('profile/edit/tabs', 'profile/menus/edittabs')
						?>
				</div>
			</div>
			<div class="col-md-9">
				<div class="profile-edit-layout-right">
					<?php echo $params['contents'];?>
				</div>
			</div>
		</div>
	</div>
</div>