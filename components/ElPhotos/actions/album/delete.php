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
$guid = input('guid');
$album = new elAlbums;
if($album->deleteAlbum($guid)){
        el_trigger_message(el_print('photo:album:deleted'));
        redirect();	
} else {
        el_trigger_message(el_print('photo:album:delete:error'), 'error');
        redirect(REF);	
}
