/**
* Open Source Social Network
*
* @package   (softlab24.com).el
* @author    el Core Team
<info@opensource-socialnetwork.org>
* @copyright (C) SOFTLAB24 LIMITED
* @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
* @link      https://www.opensource-socialnetwork.org/
*/
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
$new_all    = el_chat()->getNewAll(array(
		'message_from'
));
$allfriends = elChat::AllNew();

$active_sessions = elChat::GetActiveSessions();

$construct_active = NULL;
$new_messages     = NULL;

if($active_sessions) {
		foreach($active_sessions as $friend) {
				$messages = el_chat()->getNew($friend, el_loggedin_user()->guid);
				if($messages) {
						foreach($messages as $message) {
								if(el_loggedin_user()->guid == $message->message_from) {
										$vars['message'] = $message->message;
										$vars['time']    = $message->time;
										$vars['id']      = $message->id;
										$messageitem     = el_plugin_view('chat/message-item-send', $vars);
								} else {
										$vars['reciever'] = el_user_by_guid($message->message_from);
										$vars['message']  = $message->message;
										$vars['time']     = $message->time;
										$vars['id']       = $message->id;
										$messageitem      = el_plugin_view('chat/message-item-received', $vars);
								}
								$total          = get_object_vars($messages);
								$new_messages[] = array(
										'fid' => $friend,
										'id' => $message->id,
										'message' => $messageitem,
										'total' => count($total)
								);
						}
				}
				
				if(elChat::getChatUserStatus($friend, 10) == 'online') {
						$status = 'el-chat-icon-online';
				} else {
						$status = 'el-chat-icon-offline';
				}
				$construct_active[$friend] = array(
						'status' => $status
				);
		}
}
if($new_messages){
	foreach($new_messages as $item) {
		$messages_items[$item['fid']][] = array(
				'id' => $item['id'],
				'fid' => $item['fid'],
				'message' => $item['message'],
				'total' => $item['total']
		);
	}
}
if($messages_items){
	foreach($messages_items as $key => $mitem) {
		$messages_combined[] = array(
				'message' => $mitem,
				'total' => $mitem[0]['total'],
				'fid' => $key
		);
	}
}
$api = json_encode(array(
		'active_friends' => $construct_active,
		'allfriends' => $allfriends,
		'friends' => array(
				'online' => el_chat()->countOnlineFriends('', 10),
				'data' => el_plugin_view('chat/friendslist')
		),
		'newmessages' => $messages_combined,
		'all_new' => $new_all
		
));

echo 'var elChat = ';
echo preg_replace('/[ ]{2,}/', ' ', $api);
echo ';';
?>


/**
 * Count Online friends and put then in friends list
 *
 * @params elChat['friends'] Array
 */	
$friends_online = $('.el-chat-online-friends-count').find('span');
if(elChat['friends']['online'] > $friends_online.text() || elChat['friends']['online'] < $friends_online.text()){
   $('.friends-list').find('.data').html(elChat['friends']['data']);
}
$friends_online.html(elChat['friends']['online']);

/**
 * Reset the user status
 *
 * @params elChat['active_friends'] Array
 */	
if(elChat['active_friends']){
$.each(elChat['active_friends'], function(key, data){
               $('#elchat-ustatus-'+key).attr('class', data['status']);
});
}
/**
 * Add all friends in sidebar
 *
 * @params elChat['active_friends'] Array
 */	
if(elChat['allfriends']){
	$.each(elChat['allfriends'], function(key, data){
        	var $item  = $(".el-chat-windows-long .inner").find('#friend-list-item-'+data['guid']);
       		if($item.length){
			if (data['status'] == 'el-chat-icon-online' && $item.find('.ustatus').hasClass('el-chat-icon-online') == false) {
				/* state change offline -> online: move friend to top of list */
				$item.remove();
				var prependata = '<div data-toggle="tooltip" title="'+data['name']+'" class="friends-list-item" id="friend-list-item-'+data['guid']+'" onClick="el.ChatnewTab('+data['guid']+');"><div class="friends-item-inner"><div class="icon"><img class="ustatus el-chat-icon-online" src="'+data['icon']+'" /></div></div></div>';  
				if ($('.el-chat-pling').length) {
					$(".el-chat-windows-long .inner .el-chat-pling").after(prependata);
				}
				else {
					$(".el-chat-windows-long .inner").prepend(prependata);
				}
			}
			if (data['status'] == '0' && $item.find('.ustatus').hasClass('el-chat-icon-online') == true) {
				/* state change online -> offline: move friend to bottom of list */
				$item.remove();
				var appendata = '<div data-toggle="tooltip" title="'+data['name']+'" class="friends-list-item" id="friend-list-item-'+data['guid']+'" onClick="el.ChatnewTab('+data['guid']+');"><div class="friends-item-inner"><div class="icon"><img class="ustatus" src="'+data['icon']+'" /></div></div></div>';    
				$(".el-chat-windows-long .inner").append(appendata);
			}
        	} 
        	else {
			/* build initial list */
			var appendata = '<div data-toggle="tooltip" title="'+data['name']+'" class="friends-list-item" id="friend-list-item-'+data['guid']+'" onClick="el.ChatnewTab('+data['guid']+');"><div class="friends-item-inner"><div class="icon"><img class="ustatus '+data['status']+'" src="'+data['icon']+'" /></div></div></div>';    
         		$(".el-chat-windows-long .inner").find('.el-chat-none').hide();
			$(".el-chat-windows-long .inner").append(appendata);
        	}
  	});
	$('[data-toggle="tooltip"]').tooltip({
		placement:'left',										  
	});   
}

/**
 * Check if there is new message then put them in tab
 *
 * @params elChat['newmessages'] Array
 */	
if(elChat['newmessages']){
$.each(elChat['newmessages'], function(key, data){
            if($('.el-chat-base').find('#ftab-i'+data['fid']).length){
                      $totalelement = $('#ftab-i'+data['fid']).find('.el-chat-new-message');
                      $texa = $('#ftab-i'+data['fid']).find('.el-chat-new-message').text();
                      if(data['total'] > 0){
                      	    $.each(data['message'], function(ikey, item){
                            	  if($('#el-message-item-'+item['id']).length == 0){
	 		                          $('#ftab-i'+data['fid']).find('.data').append(item['message']); 
                                  }
                            })
                           
                           if($('.el-chat-base').find('#ftab-i'+data['fid']).find('.tab-container').is(":not(:visible)")){
                               $('#ftab-i'+data['fid']).find('#ftab'+data['fid']).addClass('el-chat-tab-active');
                               $totalelement.html(data['total']);
                               $totalelement.show();
                           } else {
                           	   $totalelement.empty();
                               el.ChatMarkViewed(data['fid']);
                           }
                           if($texa != data['total']){
	                           el.ChatplaySound();
                           }
                           el.ChatScrollMove(data['fid']);
                           
                           //chat linefeed problem #278.
                           // move scroll once again when div is loaded fully
                           $("#el-chat-messages-data-"+data['fid']).load(function() {
                           		el.ChatScrollMove(data['fid']);
                           });

                       }
                 
            }
});
}
/**
 * Open new tab on new message
 *
 * @params elChat['all_new'] Array
 */	
if(elChat['all_new']){
$.each(elChat['all_new'], function(key, data){
     if($(".el-chat-containers").children(".friend-tab-item").size() < 4){   						   
         var $friend = data['message_from'];
         el.ChatnewTab($friend);         
           if(!$('#ftab-i'+$user)){   						     
              el.ChatplaySound();
              el.ChatScrollMove(data['message_from']);
           }
     }
});
}
