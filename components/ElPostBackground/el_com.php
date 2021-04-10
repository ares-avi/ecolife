<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
define('PostBackground', el_route()->com . 'elPostBackground/');
define('__PostBackground_List__', array(
		array(
				'name' => 'pbg1',
				'url' => el_site_url('components/elPostBackground/images/1.jpg'),
				'color_hex' => '#fff',
		),
		array(
				'name' => 'pbg2',
				'url' => el_site_url('components/elPostBackground/images/2.jpg'),
				'color_hex' => '#fff',
		),
		array(
				'name' => 'pbg3',
				'url' => el_site_url('components/elPostBackground/images/3.jpg'),
				'color_hex' => '#fff',
		),
		array(
				'name' => 'pbg4',
				'url' => el_site_url('components/elPostBackground/images/4.jpg'),
				'color_hex' => '#fff',
		),
		array(
				'name' => 'pbg5',
				'url' => el_site_url('components/elPostBackground/images/5.jpg'),
				'color_hex' => '#fff',
		),
		array(
				'name' => 'pbg6',
				'url' => el_site_url('components/elPostBackground/images/6.jpg'),
				'color_hex' => '#fff',
		),
		array(
				'name' => 'pbg7',
				'url' => el_site_url('components/elPostBackground/images/7.jpg'),
				'color_hex' => '#333',
		),
		array(
				'name' => 'pbg8',
				'url' => el_site_url('components/elPostBackground/images/8.jpg'),
				'color_hex' => '#333',
		),
		array(
				'name' => 'pbg9',
				'url' => el_site_url('components/elPostBackground/images/9.jpg'),
				'color_hex' => '#333',
		),
		array(
				'name' => 'pbg10',
				'url' => el_site_url('components/elPostBackground/images/10.jpg'),
				'color_hex' => '#333',
		),
		array(
				'name' => 'pbg11',
				'url' => el_site_url('components/elPostBackground/images/11.jpg'),
				'color_hex' => '#333',
		)
));
el_register_class(array(
		'PostBackground' => PostBackground . 'classes/PostBackground.php'
));
function postbg_init() {
		el_extend_view('js/opensource.socialnetwork', 'postbg/js');
		el_extend_view('css/el.default', 'postbg/css');
		
		$post_background = array(
				'name' => 'postbg_selector',
				'text' => '<i class="fa fa-paint-brush"></i>',
				'href' => 'javascript:void(0);'
		);
		
		el_register_menu_item('wall/container/controls/home', $post_background);
		el_register_menu_item('wall/container/controls/user', $post_background);
		el_register_menu_item('wall/container/controls/group', $post_background);
		
		el_extend_view('wall/templates/wall/user/item', 'postbg/item');
		el_extend_view('wall/templates/wall/group/item', 'postbg/item');
		el_extend_view('wall/templates/wall/businesspage/item', 'postbg/item');		
		
		el_register_callback('wall', 'post:created', 'postbg_wall_created');
}
function postbg_wall_created($callback, $type, $params) {
		$PostBackground = new PostBackground;
		$PostBackground->setBackground($params);
}
el_register_callback('el', 'init', 'postbg_init');