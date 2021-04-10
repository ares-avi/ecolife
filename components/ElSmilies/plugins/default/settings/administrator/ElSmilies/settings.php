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
 
echo el_view_form('administrator/settings', array(
    'action' => el_site_url() . 'action/smilies/admin/settings',
    'component' => 'elSmilies',
    'class' => 'el-admin-form'	
), false);