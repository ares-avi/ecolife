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
$save = new elSitePages;
$save->pagename = 'privacy';
$save->pagebody = input('pagebody');
if ($save->SaveSitePage()) {
    el_trigger_message(el_print('page:saved'), 'success');
    redirect(REF);
} else {
    el_trigger_message(el_print('page:save:error'), 'error');
    redirect(REF);
}

