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
$album = input('album');
echo el_view_form('photos/add', array(
    'action' => el_site_url() . 'action/el/photos/add?album=' . $album,
    'method' => 'POST',
    'component' => 'elPhotos',
), false);
