<?php

echo el_view_form('add', array(
    'action' => el_site_url() . 'action/elads/add',
    'component' => 'ElAds',
    'class' => 'el-ads-form',
), false);
