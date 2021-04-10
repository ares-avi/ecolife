<?php

define('AutoPagination', el_route()->com . 'AutoPagination/');

function auto_pagination() {
		el_new_external_js('el.autopagination', el_add_cache_to_url('components/ElAutoPagination/vendors/jquery.scrolling.js'));
		el_load_external_js('el.autopagination');
		el_load_external_js('el.autopagination', 'admin');
		
		el_extend_view('js/opensource.socialnetwork', 'AutoPagination/js');
}
el_register_callback('el', 'init', 'auto_pagination');
