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
 
 echo "<div class='user-fullname el-profile-role'>";
 if($params['user']->isAdmin()){
	echo "<i class='fa fa-star'></i>".el_print('admin'); 
 }
 echo "</div>";