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
 if(!el_loggedin_user()){
	 return;
 }
?>
<div class="newseed-uinfo">
    <img src="<?php echo el_loggedin_user()->iconURL()->small; ?>"/>

    <div class="name">
        <a href="<?php echo el_loggedin_user()->profileURL(); ?>"><?php echo el_loggedin_user()->fullname; ?></a>
        <a class="edit-profile" href="<?php echo el_loggedin_user()->profileURL('/edit'); ?>">
            <?php echo el_print('edit:profile'); ?></a>
    </div>
</div>
