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

/* Define Paths */
define('__el_POKE__', el_route()->com . 'elPoke/');

/* Load elPoke Class */
require_once(__el_POKE__ . 'classes/elPoke.php');

/**
 * Initialize the poke component.
 *
 * @return void;
 * @access private;
 */
function el_poke() {
    //css
    el_extend_view('css/el.default', 'css/poke');

    //actions
    if (el_isLoggedin()) {
        el_register_action('poke/user', __el_POKE__ . 'actions/user/poke.php');
    }
    //hooks
    el_add_hook('notification:view', 'elpoke:poke', 'el_poke_notification');
    //profile menu
    el_register_callback('page', 'load:profile', 'el_user_poke_menu', 1);

}

/**
 * User poke menu item in profile.
 *
 * @return void;
 * @access private;
 */
function el_user_poke_menu($name, $type, $params) {
    $user = el_get_page_owner_guid();
    $poke = el_site_url("action/poke/user?user={$user}", true);
    el_register_menu_link('poke', el_print('poke'), $poke, 'profile_extramenu');
}

/**
 * User notification menu item
 *
 * @return void;
 * @access private;
 */
function el_poke_notification($name, $type, $return, $params) {
    $notif = $params;
    $baseurl = el_site_url();
    $user = el_user_by_guid($notif->poster_guid);
    $user->fullname = "<strong>{$user->fullname}</strong>";

    $img = "<div class='notification-image'><img src='{$baseurl}avatar/{$user->username}/small' /></div>";

    $type = 'poke';
    $type = "<div class='el-notification-icon-poke'></div>";
    if ($notif->viewed !== NULL) {
        $viewed = '';
    } elseif ($notif->viewed == NULL) {
        $viewed = 'class="el-notification-unviewed"';
    }
    $url = $user->profileURL();
    $notification_read = "{$baseurl}notification/read/{$notif->guid}?notification=" . urlencode($url);
    return "<a href='{$notification_read}'>
	       <li {$viewed}> {$img} 
		   <div class='notfi-meta'> {$type}
		   <div class='data'>" . el_print("el:notifications:{$notif->type}", array($user->fullname)) . '</div>
		   </div></li></a>';

}

el_register_callback('el', 'init', 'el_poke');
