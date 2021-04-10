<?php

echo el_view_form('list', array(
        'action' => el_site_url() . 'action/elads/delete',
        'component' => 'ElAds',
    ), false);
