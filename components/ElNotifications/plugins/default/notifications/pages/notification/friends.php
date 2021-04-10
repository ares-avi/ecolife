<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
?>
<div class="messages-inner">
    <div class="notification-friends">
        <?php
        if ($params['friends']) {
            $confirmbutton = el_print('el:notifications:friendrequest:confirmbutton');
            $denybutton = el_print('el:notifications:friendrequest:denybutton');
            foreach ($params['friends'] as $users) {
                $baseurl = el_site_url();
                $url = $users->profileURL();
                $img = "<img src='{$users->iconURL()->small}' />";
                $messages[] = "<li id='notification-friend-item-{$users->guid}'>
		              <div class='el-notifications-friends-inner'>
		                <div class='image'>{$img}</div> 
		                <div class='notfi-meta'>
		                
						<a href='{$url}' class='user'>{$users->fullname}</a>
						  <div class='controls' id='el-nfriends-{$users->guid}'>
						  <script>
						  el.AddFriend($users->guid); 
						  el.removeFriendRequset($users->guid);
						  </script>
						  <form id='add-friend-{$users->guid}'>
                           <input class='btn btn-primary' type='submit' value='{$confirmbutton}' />
						   </form>
						   	<form id='remove-friend-{$users->guid}'>
						   <input class='btn btn-default' type='submit' value='{$denybutton}' />
						   </form>

                           </div>
  
						</div>
						</div>
						</li>";
            }
        }
        echo implode('', $messages);
        ?>
    </div>
</div>
<div class="bottom-all">
    <!-- <a href="#">See All</a> -->
</div>
