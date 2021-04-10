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
$active_sessions = elChat::GetActiveSessions();
$MessageTyping	 = new MessageTyping;
$user_guid		 = el_loggedin_user()->guid;
$status_list			 = array();
if($active_sessions) {
		foreach($active_sessions as $friend_guid) {
				$status_list[] = array(
					'status' => $MessageTyping->getStatus($user_guid, $friend_guid),
					'user_guid'  => $user_guid,
					'friend_guid' => $friend_guid,
					'icon' => el_user_by_guid($friend_guid)->iconURL()->small,
				);
		}
}
?>
$(document).ready(function(){
	var $MessageTypingList = <?php echo json_encode($status_list);?>;
    $.each($MessageTypingList, function($k, $array){
    	if($array['friend_guid'] !== ''){
        	 	$tab = $('#ftab-i'+$array['friend_guid']);
                if($tab.length){
                	var $typinghtml = '<div class="message-reciever message-tying-container"> <div class="user-icon"> <img src="'+$array['icon']+'"> </div> <div class="el-chat-text-data"> <div class="el-chat-triangle el-chat-triangle-white"></div> <div class="text"> <div class="inner"> <div class="messagetyping"> <span class="mtyping-circle mtyping-bouncing"></span> <span class="mtyping-circle mtyping-bouncing"></span> <span class="mtyping-circle mtyping-bouncing"></span> </div> </div> </div> </div> </div>';
                    $titlebar = $tab.find('#el-chat-messages-data-'+$array['friend_guid']);
                    if($titlebar.find('.message-tying-container').length){
                    	$titlebar.find('.message-tying-container').remove();
                    }
                    if(!$titlebar.find('.message-tying-container').length && $array['status'] == 'yes'){
                    	$titlebar.append($typinghtml);
                        el.ChatScrollMove($array['friend_guid']);
                    }
                }
        }
    });
});