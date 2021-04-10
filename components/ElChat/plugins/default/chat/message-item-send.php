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
 $args = array(
		'instance' => $params['instance'],
		'view' => 'chat/message-item-send',
  );
?>
<div class="message-sender" id="el-message-item-<?php echo $params['id'];?>">
    <div class="el-chat-text-data-right">
        <div class="el-chat-triangle el-chat-triangle-blue"></div>
        <div class="text <?php echo $params['class'];?>">
            <div class="inner" title="<?php echo elChat::messageTime($params['time']); ?>">
            	<?php if($params['deleted']){ ?>
                	<span><i class="fa fa-times-circle"></i><?php echo el_print('elmessages:deleted');?></span>
                <?php } else { ?>
	                <span><?php echo el_call_hook('chat', 'message:smilify', $args, el_message_print($params['message'])); ?></span>
                <?php } ?>    
            </div>
        </div>
    </div>
</div>
