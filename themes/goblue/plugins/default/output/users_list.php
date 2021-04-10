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
$users = $params['users'];
if (!isset($params['icon_size'])) {
    $avatar_size = 'large';
} else {
    $avatar_size = $params['icon_size'];
}
foreach ($users as $user) {
    ?>

    <div class="el-list-users">
        <img src="<?php echo el_site_url("avatar/{$user->username}/{$avatar_size}"); ?>"/>

        <div class="uinfo">
            <a class="userlink"
               href="<?php echo el_site_url(); ?>u/<?php echo $user->username; ?>"><?php echo $user->fullname; ?></a>
        </div>
        <?php if (el_isLoggedIn()) { ?>
            <?php if (el_loggedin_user()->guid !== $user->guid) {
                if (!el_user_is_friend(el_loggedin_user()->guid, $user->guid)) {
                    if (el_user()->requestExists(el_loggedin_user()->guid, $user->guid)) {
                        ?>
          <a href="<?php echo el_site_url("action/friend/remove?cancel=true&user={$user->guid}", true); ?>"
                               class='button-grey friendlink'>
                                <?php echo el_print('cancel:request'); ?>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo el_site_url("action/friend/add?user={$user->guid}", true); ?>"
                               class='right btn btn-primary'>
                                <?php echo el_print('add:friend'); ?>
                            </a>
                        <?php
                        }
                    } else {
                        ?>
                        <a href="<?php echo el_site_url("action/friend/remove?user={$user->guid}", true); ?>"
                           class='right btn btn-danger'>
                            <?php echo el_print('remove:friend'); ?>
                        </a>
                <?php
                }

            }
        }?>
    </div>


<?php } ?>
