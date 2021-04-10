<?php

$edit = new ElAds;

$params['title'] = input('title');
$params['description'] = input('description');
$params['siteurl'] = input('siteurl');
$params['guid'] = input('entity');

foreach ($params as $field) {
    if (empty($field)) {
        el_trigger_message(el_print('fields:required'), 'error');
        redirect(REF);
    }
}

if ($edit->EditAd($params)) {
    el_trigger_message(el_print('ad:edited'), 'success');
    redirect(REF);
} else {
    el_trigger_message(el_print('ad:edit:fail'), 'error');
    redirect(REF);
}
