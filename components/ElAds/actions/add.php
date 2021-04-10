<?php

$add = new ElAds;

$params['title'] = input('title');
$params['description'] = input('description');
$params['siteurl'] = input('siteurl');
foreach ($params as $field) {
    if (empty($field)) {
        el_trigger_message(el_print('fields:required'), 'error');
        redirect(REF);
    }
}

if ($add->addNewAd($params)) {
    el_trigger_message(el_print('ad:created'), 'success');
    redirect(REF);
} else {
    el_trigger_message(el_print('ad:create:fail'), 'error');
    redirect(REF);
}
