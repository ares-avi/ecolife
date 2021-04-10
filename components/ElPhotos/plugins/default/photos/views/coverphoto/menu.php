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
if (el_isLoggedIn()) {
    ?>
    <div class="el-photo-menu">
        <li><a class="btn btn-danger" href="<?php echo el_site_url("action/profile/cover/photo/delete?id={$params->guid}", true); ?>"> <?php echo el_print('delete:photo'); ?> </a>
        </li>
    </div>
<?php } ?>
