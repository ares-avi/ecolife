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
$save = new elSitePages;
$save->pagename = 'terms';
$save->pagebody = input('pagebody');
if ($save->SaveSitePage()) {
    el_trigger_message(el_print('page:saved'), 'success');
    redirect(REF);
} else {
    el_trigger_message(el_print('page:save:error'), 'error');
    redirect(REF);
}

