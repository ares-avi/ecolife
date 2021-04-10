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
$friends = $params['user']->getFriends(false, array(
		'limit' => 9
));
echo '<div class="el-profile-module-friends">';
if($friends) {
		foreach($friends as $friend) {
				$url       = $friend->iconURL()->large;
				$profile   = $friend->profileURL();
				$user_name = $friend->fullname;
				echo "<a href='{$profile}'>
          <div class='user-image'>
            <img src='{$url}' title='{$friend->fullname}'/>
			<div class='user-name'>{$user_name}</div>
		   </div>
       </a>";
		}
} else {
		echo '<h3>' . el_print('no:friends') . '</h3>';
}
echo '</div>';
