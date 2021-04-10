//<script>
/**
 * 	Open Source Social Network
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
el.NotificationBox = function($title, $meta, $type, height, $extra) {
	//trigger notification box again:
  	el.NotificationsCheck();
    
    $extra = $extra || '';
    if (height == '') {
        //height = '540px';
    }
    if ($type) {
        $('.selected').addClass($type);
    }
    if ($title) {
        $('.el-notifications-box').show()
        $('.el-notifications-box').find('.type-name').html($title+$extra);
    }
    if ($meta) {
        $('.el-notifications-box').find('.metadata').html($meta);
        $('.el-notifications-box').css('height', height);
    }
};
el.NotificationBoxClose = function() {
    $('.el-notifications-box').hide()
    $('.el-notifications-box').find('.type-name').html('');
    $('.el-notifications-box').find('.metadata').html('<div><div class="el-loading el-notification-box-loading"></div></div><div class="bottom-all">---</div>');
    //$('.el-notifications-box').css('height', '140px');
    $('.selected').attr('class', 'selected');

};
el.NotificationShow = function($div) {
    $($div).attr('onClick', 'el.NotificationClose(this)');
    el.PostRequest({
        url: el.site_url + "notification/notification",
        action:false,
        beforeSend: function(request) {
            el.NotificationBoxClose();
            $('.el-notifications-friends').attr('onClick', 'el.NotificationFriendsShow(this)');
            $('.el-notifications-messages').attr('onClick', 'el.NotificationMessagesShow(this)');
            el.NotificationBox(el.Print('notifications'), false, 'notifications');
        },
        callback: function(callback) {
            var data = '';
            var height = '';
            if (callback['type'] == 1) {
                data = callback['data'];
               // height = '540px';
            }
            if (callback['type'] == 0) {
                data = callback['data'];
                //height = '100px';
            }
            el.NotificationBox(el.Print('notifications'), data, 'notifications', height,  callback['extra']);
        }
    });
};


el.NotificationClose = function($div) {
    el.NotificationBoxClose();
    $($div).attr('onClick', 'el.NotificationShow(this)');
};

el.NotificationFriendsShow = function($div) {
    $($div).attr('onClick', 'el.NotificationFriendsClose(this)');
    el.PostRequest({
        url: el.site_url + "notification/friends",
        action:false,
        beforeSend: function(request) {
            el.NotificationBoxClose();
            $('.el-notifications-notification').attr('onClick', 'el.NotificationShow(this)');
            $('.el-notifications-messages').attr('onClick', 'el.NotificationMessagesShow(this)');
            el.NotificationBox(el.Print('friend:requests'), false, 'firends');

        },
        callback: function(callback) {
            var data = '';
            var height = '';
            if (callback['type'] == 1) {
                data = callback['data'];
            }
            if (callback['type'] == 0) {
                data = callback['data'];
                //height = '100px';
            }
            el.NotificationBox(el.Print('friend:requests'), data, 'firends', height);
        }
    });
};


el.NotificationFriendsClose = function($div) {
    el.NotificationBoxClose();
    $($div).attr('onClick', 'el.NotificationFriendsShow(this)');
};

el.AddFriend = function($guid) {
    action = el.site_url + "action/friend/add?user=" + $guid;
    el.ajaxRequest({
        url: action,
        form: '#add-friend-' + $guid,
        action:true,

        beforeSend: function(request) {
            $('#notification-friend-item-' + $guid).find('form').hide();
            $('#el-nfriends-' + $guid).append('<div class="el-loading"></div>');
        },
        callback: function(callback) {
            if (callback['type'] == 1) {
                $('#notification-friend-item-' + $guid).addClass("el-notification-friend-submit");
                $('#el-nfriends-' + $guid).addClass('friends-added-text').html(callback['text']);
            }
            if (callback['type'] == 0) {
                $('#notification-friend-item-' + $guid).find('form').show();
                $('#el-nfriends-' + $guid).find('.el-loading').remove();
            }
            el.NotificationsCheck();
        }
    });
};

el.removeFriendRequset = function($guid) {
    action = el.site_url + "action/friend/remove?user=" + $guid;
    el.ajaxRequest({
        url: action,
        form: '#remove-friend-' + $guid,
        action:true,

        beforeSend: function(request) {
            $('#notification-friend-item-' + $guid).find('form').hide();
            $('#el-nfriends-' + $guid).append('<div class="el-loading"></div>');
        },
        callback: function(callback) {
            if (callback['type'] == 1) {
                $('#notification-friend-item-' + $guid).addClass("el-notification-friend-submit");
                $('#el-nfriends-' + $guid).addClass('friends-added-text').html(callback['text']);
            }
            if (callback['type'] == 0) {
                $('#notification-friend-item-' + $guid).find('form').show();
                $('#el-nfriends-' + $guid).find('.el-loading').remove();
            }
            el.NotificationsCheck();
        }
    });
};

el.NotificationMessagesShow = function($div) {
    $($div).attr('onClick', 'el.NotificationMessagesClose(this)');
    el.PostRequest({
        url: el.site_url + "notification/messages",
        action:false,
        beforeSend: function(request) {
            el.NotificationBoxClose();
            $('.el-notifications-notification').attr('onClick', 'el.NotificationShow(this)');
            $('.el-notifications-friends').attr('onClick', 'el.NotificationFriendsShow(this)');
	    el.NotificationBox(el.Print('messages'), false, 'messages');
        },
        callback: function(callback) {
            var data = '';
            var height = '';
            if (callback['type'] == 1) {
                data = callback['data'];
                height = '';
            }
            if (callback['type'] == 0) {
                data = callback['data'];
               // height = '100px';
            }
            el.NotificationBox(el.Print('messages'), data, 'messages', height);
        }
    });
};


el.NotificationMessagesClose = function($div) {
    el.NotificationBoxClose();
    $($div).attr('onClick', 'el.NotificationMessagesShow(this)');
};
el.NotificationsCheck = function() {
    el.PostRequest({
        url: el.site_url + "notification/count",
        action:false,
        callback: function(callback) {
            $notification = $('#el-notif-notification');
            $notification_count = $notification.find('.el-notification-container');

            $friends = $('#el-notif-friends');
            $friends_count = $friends.find('.el-notification-container');

            $messages = $('#el-notif-messages');
            $messages_count = $messages.find('.el-notification-container');

            if (callback['notifications'] > 0) {
                $notification_count.html(callback['notifications']);
                $notification.find('.el-icon').addClass('el-icons-topbar-notifications-new');
                $notification_count.attr('style', 'display:inline-block !important;');
            }
            if (callback['notifications'] <= 0) {
                $notification_count.html('');
                $notification.find('.el-icon').removeClass('el-icons-topbar-notifications-new');
                $notification.find('.el-icon').addClass('el-icons-topbar-notification');
                $notification_count.hide();
            }

            if (callback['messages'] > 0) {
                $messages_count.html(callback['messages']);
                $messages.find('.el-icon').addClass('el-icons-topbar-messages-new');
                $messages_count.attr('style', 'display:inline-block !important;');
            }
            if (callback['messages'] <= 0) {
                $messages_count.html('');
                $messages.find('.el-icon').removeClass('el-icons-topbar-messages-new');
                $messages.find('.el-icon').addClass('el-icons-topbar-messages');
                $messages_count.hide();
            }

            if (callback['friends'] > 0) {
                $friends_count.html(callback['friends']);
                $friends.find('.el-icon').addClass('el-icons-topbar-friends-new');
                $friends_count.attr('style', 'display:inline-block !important;');
            }
            if (callback['friends'] <= 0) {
                $friends_count.html('');
                $friends.find('.el-icon').removeClass('el-icons-topbar-friends-new');
                $friends.find('.el-icon').addClass('el-icons-topbar-friends');
                $friends_count.hide();
            }
        }
    });
};
el.RegisterStartupFunction(function() {
    $(document).ready(function() {
    		$('.el-topbar-dropdown-menu').click(function(){
                    el.NotificationBoxClose();
        	});
		$(document).on('click','.el-notification-mark-read', function(e){
				e.preventDefault();
   				el.PostRequest({
        				url: el.site_url + "action/notification/mark/allread",
        				action:false,
        				beforeSend: function(request) {
							$('.el-notification-mark-read').attr('style', 'opacity:0.5;');
 	       				},
        				callback: function(callback) {
           					if(callback['success']){
								el.trigger_message(callback['success']);
							}
							if(callback['error']){
								el.trigger_message(callback['error']);								
							}
							$('.el-notification-mark-read').attr('style', '1;');								
        				}
    			 });
		});
    });
});
