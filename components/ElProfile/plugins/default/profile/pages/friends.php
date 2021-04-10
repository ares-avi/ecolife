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
echo '<div>';
$users['users'] = $params['user']->getFriends(false, array(
		'page_limit' => 10
));
$count          = $params['user']->getFriends(false, array(
		'count' => true
));
echo el_plugin_view("output/users", $users);
echo el_view_pagination($count);
echo '</div>';
