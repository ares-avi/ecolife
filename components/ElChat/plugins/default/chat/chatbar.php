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
?>
<div class="el-chat-base hidden-xs hidden-sm">
    <div class="el-chat-bar">
        <div class="friends-list">

            <div class="el-chat-tab-titles">
                <div class="text">Chat</div>
            </div>

            <div class="data">
                <?php
                echo el_plugin_view('chat/friendslist');
                ?>
            </div>
        </div>
        <div class="inner friends-tab">
            <div class="el-chat-icon">
                <div class="el-chat-inner-text el-chat-online-friends-count">
                    Chat (<span><?php echo el_chat()->countOnlineFriends('', 10); ?></span>)
                </div>
            </div>
        </div>

    </div>

    <div class="el-chat-containers">
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

        // load active chats
        $active_sessions = elChat::GetActiveSessions();
        if ($active_sessions) {
            foreach ($active_sessions as $user) {
                $user = el_user_by_guid($user);
                if($user) {
                    $friend['user'] = $user;
                    echo el_plugin_view('chat/selectfriend', $friend);
                }
            }
        }
        ?>
    </div>
</div>
<div class="el-chat-windows-long">
    <div class="inner">
        <?php
        echo el_plugin_view('chat/friends/status');
        ?>
    </div>
</div>
