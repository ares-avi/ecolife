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
$add = new elAlbums;
if ($add->CreateAlbum(el_loggedin_user()->guid, input('title'), input('privacy'))) {
    redirect(REF);
} else {
    redirect(REF);
}