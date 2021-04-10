<script>
<?php
$component = new elComponents;
$settings = $component->getComSettings('elNotifications');
if($settings && $settings->close_anywhere == 'on'){
?>
$(document).ready(function() {
	$('body').click(function(e){
		var clicked_target = e.target.className.substring(0, 6);
		if (clicked_target != 'btn bt' && clicked_target != 'el-n' && clicked_target != 'el-i' && clicked_target != 'fa fa-') {
			el.NotificationBoxClose();
			$('.el-notifications-notification').attr('onClick', 'el.NotificationShow(this)');
			$('.el-notifications-messages').attr('onClick', 'el.NotificationMessagesShow(this)');
			$('.el-notifications-friends').attr('onClick', 'el.NotificationFriendsShow(this)');
		}
	});
});
<?php
}
?>
</script>
