<?php

 
function el_themes_init(){
	el_register_plugins_by_path(el_default_theme() . 'plugins/');
}
el_register_callback('el', 'init', 'el_themes_init');
