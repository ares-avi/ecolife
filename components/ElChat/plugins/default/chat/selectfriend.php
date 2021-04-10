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
$user = $params['user'];
if (elChat::getChatUserStatus($user->guid) == 'online') {
    $status = 'el-chat-icon-online';
} else {
    $status = 'el-chat-icon-offline';
}
$messages = el_chat()->getNew($user->guid, el_loggedin_user()->guid);
$total = '';
if ($messages) {
    $total = get_object_vars($messages);
    $total = count($total);
}
$tab_class = '';
$style = '';

if ($total > 0) {
    $tab_class = 'el-chat-tab-active';
    $style = 'style="display:block;"';
}

?>
<!-- Item -->
<div class="friend-tab-item" id="ftab-i<?php echo $user->guid; ?>">

    <!-- $arsalan.shah tab container start -->
    <div class="tab-container">

        <div class="el-chat-tab-titles" id="ftab-t<?php echo $user->guid; ?>"
             onclick="el.ChatCloseTab(<?php echo $user->guid; ?>);">
            <div class="text el-chat-inline-table"><?php echo $user->fullname; ?></div>
            <div class="options el-chat-inline-table">
                <div class="el-chat-inline-table el-chat-icon-expend" title="Popout Chat"
                     onclick="el.ChatExpand('<?php echo $user->username; ?>')"></div>
                <div class="el-chat-inline-table el-chat-tab-close" id="ftab-c<?php echo $user->guid; ?>"
                     onclick="el.ChatTerminateTab(<?php echo $user->guid; ?>);"> X
                </div>
            </div>
        </div>
 		<script>
			el.ChatLoading(<?php echo $user->guid; ?>);
	 	</script>
        <!-- $arsalan.shah datatstart -->
        <div class="data" id="el-chat-messages-data-<?php echo $user->guid; ?>">
            <?php
		$messages_meta  = el_chat()->getWith(el_loggedin_user()->guid, $user->guid);
		$messages_count = el_chat()->getWith(el_loggedin_user()->guid, $user->guid, true);
		echo el_view_pagination($messages_count, 10, array(
			'offset_name' => "offset_message_xhr_with_{$user->guid}",															 
		));			
            if ($messages_meta) {
                foreach ($messages_meta as $message) {
			$deleted = false;
			$class = '';
			if(isset($message->is_deleted) && $message->is_deleted == true){
				$deleted = true;
				$class = ' el-message-deleted';
			}							
			$vars['message'] = el_message_print($message->message);
			$vars['time'] = $message->time;
			$vars['id'] = $message->id;
			$vars['deleted'] = $deleted;
			$vars['class'] = $class;	
			$vars['instance'] = (clone $message);
                    	if (el_loggedin_user()->guid == $message->message_from) {
                      	  	echo el_plugin_view('chat/message-item-send', $vars);
                   	 } else {
                        	$vars['reciever'] = el_user_by_guid($message->message_from);
                        	echo el_plugin_view('chat/message-item-received', $vars);
                    	}
                }
            }
            ?>

        </div>
        <!-- $arsalan.shah datatend -->

    </div>
    <!-- $arsalan.shah tab container end -->
    <div class="inner friend-tab <?php echo $tab_class; ?>" id="ftab<?php echo $user->guid; ?>"
         onclick="el.ChatOpenTab(<?php echo $user->guid; ?>);">
        <script>el.ChatSendForm(<?php echo $user->guid;?>);</script>
        <form autocomplete="off" id="el-chat-send-<?php echo $user->guid; ?>">
            <input type="text" name="message" autocomplete="off" id="el-chat-input-<?php echo $user->guid; ?>"/>
            <div class="el-chat-message-sending">
               <div class="el-chat-sending-icon"></div>
            </div>
            <div class="el-chat-inline-table el-chat-icon-smile-set">
                <?php if(com_is_active('elSmilies')){ ?>
                    <div class="el-chat-icon-smile" onClick="el.OpenEmojiBox('#el-chat-input-' + <?php echo $user->guid; ?>);"></div>
                <?php } ?>
            </div>
             <?php echo el_plugin_view('input/security_token'); ?>
            <input type="hidden" name="to" value="<?php echo $user->guid; ?>"/>
        </form>
        <div class="el-chat-new-message" <?php echo $style; ?>><?php echo $total; ?></div>
        <div id="elchat-ustatus-<?php echo $user->guid; ?>" class="<?php echo $status; ?>">
            <div class="el-chat-inner-text">
                <?php echo $user->fullname; ?>
            </div>
        </div>
    </div>

</div>
<!-- Item End -->
    
