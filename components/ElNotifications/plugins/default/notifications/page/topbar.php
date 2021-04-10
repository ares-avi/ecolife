<?php
/**
 *    OpenSource-SocialNetwork
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@opensource-socialnetwork.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   General Public Licence http://opensource-socialnetwork.com/licence
 * @link      http://www.opensource-socialnetwork.com/licence
 */

//declear empty variables;
$friends_c = '';
//init classes
$notification = new elNotifications;
$count_notif = $notification->countNotification(el_loggedin_user()->guid);

if(class_exists('elMessages')){
	$messages = new elMessages;
	$count_messages = $messages->countUNREAD(el_loggedin_user()->guid);
}

$friends = el_loggedin_user()->getFriendRequests();
if ($friends) {
    $friends_c = count($friends);
}
?>
<li id="el-notif-friends">
    <a onClick="el.NotificationFriendsShow(this);" class="el-notifications-friends" href="javascript:void(0);" role="button" data-toggle="dropdown">
                       <span>
                      <?php if ($friends_c > 0) { ?>
                          <span class="el-notification-container"><?php echo $friends_c; ?></span>
                          <div class="el-icon el-icons-topbar-friends-new"><i class="fa fa-users"></i></div>
                      <?php } else { ?>
                          <span class="el-notification-container hidden"></span>
                          <div class="el-icon el-icons-topbar-friends"><i class="fa fa-users"></i></div>
                      <?php } ?>
                       </span>
    </a>
</li>
<?php if($messages){ ?>
<li id="el-notif-messages">
    <a onClick="el.NotificationMessagesShow(this)" href="javascript:void(0);" class="el-notifications-messages" role="button" data-toggle="dropdown">
    
                       <span>
                        <?php if ($count_messages > 0) { ?>
                            <span class="el-notification-container"><?php echo $count_messages; ?></span>
                            <div class="el-icon el-icons-topbar-messages-new"><i class="fa fa-envelope"></i></div>
                        <?php } else { ?>
                            <span class="el-notification-container hidden"></span>
                            <div class="el-icon el-icons-topbar-messages"><i class="fa fa-envelope"></i></div>
                        <?php } ?>
                       </span>
    </a></li>
   <?php } ?> 
<li id="el-notif-notification">
    <a href="javascript:void(0);" onClick="el.NotificationShow(this)" class="el-notifications-notification" onClick="el.NotificationShow(this)"role="button" data-toggle="dropdown"> 
                       <span>
                       <?php if ($count_notif > 0) { ?>
                           <span class="el-notification-container"><?php echo $count_notif; ?></span>
                           <div class="el-icon el-icons-topbar-notifications-new"><i class="fa fa-globe"></i></div>
                       <?php } else { ?>
                           <span class="el-notification-container hidden"></span>
                           <div class="el-icon el-icons-topbar-notification"><i class="fa fa-globe"></i></div>
                       <?php } ?>
                       </span>
    </a>
 
</li>
  <div class="dropdown">
  		<div class="dropdown-menu multi-level dropmenu-topbar-icons el-notifications-box">
        	     <div class="selected"></div>
            	 <div class="type-name"> <?php echo el_print('notifications'); ?> </div>
            	<div class="metadata">
                	<div style="height: 66px;">
                   		 	<div class="el-loading el-notification-box-loading"></div>
               	 	</div>
                	<div class="bottom-all">
                    	<a href="#"><?php echo el_print('see:all'); ?></a>
                	</div>
             </div>
   		</div> 
   </div>
