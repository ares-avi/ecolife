<?php

echo el_view_form('edit', array(
    'action' => el_site_url() . 'action/elads/edit',
    'component' => 'ElAds',
    'class' => 'el-ads-form',
	'params' => $params,
), false);
