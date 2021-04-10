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
if (!isset($params['title'])) {
    $params['title'] = '';
}
if (!isset($params['contents'])) {
    $params['contents'] = '';
}
?>
<div class="row el-site-pages">
    <div class="col-md-12 el-site-pages-inner  el-page-contents">
        <div class="el-site-pages-title">
            <?php echo $params['title']; ?>
        </div>
        <div class="el-site-pages-body">
            <?php echo $params['contents']; ?>
        </div>
    </div>
</div>
