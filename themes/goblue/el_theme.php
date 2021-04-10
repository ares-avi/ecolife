<?php

define('__THEMEDIR__', el_route()->themes . 'goblue/');

el_register_callback('el', 'init', 'el_goblue_theme_init');

function el_goblue_theme_init(){	
	//add bootstrap
	el_new_css('bootstrap.min', 'css/bootstrap/bootstrap.min.css');
	//el_new_js('bootstrap.min', 'js/bootstrap/bootstrap.min.js');
	
	el_new_css('el.default', 'css/core/default');
	el_new_css('el.admin.default', 'css/core/administrator');

	//load bootstrap
	el_load_css('bootstrap.min', 'admin');
	el_load_css('bootstrap.min');

	el_load_css('el.default');
	el_load_css('el.admin.default', 'admin');
	
	el_extend_view('el/admin/head', 'el_goblue_admin_head');
	el_extend_view('el/site/head', 'el_goblue_head');
    el_extend_view('js/opensource.socialnetwork', 'js/goblue');	
	
	el_register_admin_sidemenu('admin:theme:goblue', 'admin:theme:goblue', el_site_url('administrator/settings/goblue'), el_print('admin:sidemenu:themes'));
	el_register_site_settings_page('goblue', 'settings/admin/goblue');
	
	if(el_isAdminLoggedin()) {
		el_register_action('goblue/settings', __THEMEDIR__ . 'actions/settings.php');
	}	
}
function el_goblue_head(){
	$head	 = array();
	
	$head[]  = el_html_css(array(
					'href' => '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
			  ));	
	$head[]  = el_html_css(array(
					'href' =>  'https://fonts.googleapis.com/css?family=PT+Sans:400italic,700,400'
			  ));		
	$head[]  = el_html_js(array(
					'src' => el_theme_url() . 'vendors/bootstrap/js/bootstrap.min.js'
			  ));
	$head[]  = el_html_css(array(
					'href' => '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.css'
			  ));	
	return implode('', $head);
}
function el_goblue_admin_head(){
	$head	 = array();	
	$head[]  = el_html_css(array(
					'href' => '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
			  ));	
	$head[]  = el_html_css(array(
					'href' =>  '//fonts.googleapis.com/css?family=Roboto+Slab:300,700,400'
			  ));		
	$head[]  = el_html_js(array(
					'src' => el_theme_url() . 'vendors/bootstrap/js/bootstrap.min.js'
			  ));
	$head[]  = el_html_css(array(
					'href' => '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.css'
			  ));
	return implode('', $head);
}
