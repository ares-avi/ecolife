<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

define('__el_PHOTOS__', el_route()->com . 'elPhotos/');
//include classes
require_once(__el_PHOTOS__ . 'classes/elPhotos.php');
require_once(__el_PHOTOS__ . 'classes/elAlbums.php');

//inlcude libraries
require_once(__el_PHOTOS__ . 'libraries/el.lib.photos.php');
require_once(__el_PHOTOS__ . 'libraries/el.lib.albums.php');

/**
 * Initialize Photos Component
 *
 * @return void;
 * @access private;
 */
function el_photos_initialize() {
		//css
		el_extend_view('css/el.default', 'css/photos');
		//js
		el_extend_view('js/opensource.socialnetwork', 'js/elPhotos');
		
		//hooks
		el_add_hook('profile', 'subpage', 'el_profile_photos_page');
		el_add_hook('profile', 'modules', 'profile_modules_albums');
		el_add_hook('notification:view', 'like:entity:file:el:aphoto', 'el_notification_like_photo');
		el_add_hook('notification:view', 'comments:entity:file:el:aphoto', 'el_notification_like_photo');
		el_add_hook('photo:view', 'profile:controls', 'el_profile_photo_menu');
		el_add_hook('photo:view', 'album:controls', 'el_album_photo_menu');
		el_add_hook('cover:view', 'profile:controls', 'el_album_cover_photo_menu');
		el_add_hook('wall:template', 'album:photos:wall', 'el_photos_wall');
	
		//[B] Wrong Notifications because of 'notification:participants' #1822
		el_add_hook('notification:participants', 'like:entity:file:profile:photo', 'el_profile_photo_cover_like_participants_deny');		
		el_add_hook('notification:participants', 'like:entity:file:profile:cover', 'el_profile_photo_cover_like_participants_deny');
	
		el_add_hook('notification:participants', 'comments:entity:file:profile:photo', 'el_profile_photo_cover_like_participants_deny');		
		el_add_hook('notification:participants', 'comments:entity:file:profile:cover', 'el_profile_photo_cover_like_participants_deny');	
	
		el_add_hook('notification:participants', 'like:entity:file:el:aphoto', 'el_profile_photo_cover_like_participants_deny');		
		el_add_hook('notification:participants', 'comments:entity:file:el:aphoto', 'el_profile_photo_cover_like_participants_deny');	
	
		//actions
		if(el_isLoggedin()) {
				el_register_action('el/album/add', __el_PHOTOS__ . 'actions/album/add.php');
				el_register_action('el/album/delete', __el_PHOTOS__ . 'actions/album/delete.php');
				el_register_action('el/album/edit', __el_PHOTOS__ . 'actions/album/edit.php');
				el_register_action('el/photos/add', __el_PHOTOS__ . 'actions/photos/add.php');
				el_register_action('profile/photo/delete', __el_PHOTOS__ . 'actions/photo/profile/delete.php');
				el_register_action('profile/cover/photo/delete', __el_PHOTOS__ . 'actions/photo/profile/cover/delete.php');
				el_register_action('photo/delete', __el_PHOTOS__ . 'actions/photo/delete.php');
		}
		//callbacks
		el_register_callback('page', 'load:profile', 'el_profile_menu_photos');
		el_register_callback('delete', 'profile:photo', 'el_photos_likes_comments_delete');
		el_register_callback('delete', 'album:photo', 'el_photos_likes_comments_delete');
		el_register_callback('user', 'delete', 'el_user_photos_delete');
		el_register_callback('el:photo', 'add:multiple', 'el_photos_add_to_wall');
		
		el_profile_subpage('photos');
		
		el_register_page('album', 'el_album_page_handler');
		el_register_page('photos', 'el_photos_page_handler');
		
		$url = el_site_url();
		if(el_isLoggedin()) {
				$user_loggedin = el_loggedin_user();
				$icon          = el_site_url('components/elPhotos/images/photos-el.png');
				el_register_sections_menu('newsfeed', array(
						'name' => 'photos',
						'text' => el_print('photos:el'),
						'url' => $user_loggedin->profileURL('/photos'),
						'parent' => 'links',
						'icon' => $icon
				));
				
		}
		//gallery plugin dist include
		el_new_external_js('jquery.fancybox.min.js', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js', false);
		el_new_external_css('jquery.fancybox.min.css', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css', false);
}
/**
 * Delete user photos
 * elPhotos still exists when user delete #1142
 *
 * @param string $callback Name of callback
 * @param string $type Callback type
 * @param array $params Arrays or Objects
 *
 * @return void
 * @access private
 */
function el_user_photos_delete($callback, $type, $params) {
		$guid    = $params['entity']->guid;
		$album   = new elAlbums;
		$albums  = $album->GetAlbums($guid, array(
						'page_limit' =>  false,										
		));
		if($albums) {
				foreach($albums as $item) {
						$album->deleteAlbum($item->guid);
				}
		}
}
/**
 * Add user album photos to wall
 *
 * @param string $callback Name of callback
 * @param string $type Callback type
 * @param array  $params array|object
 *
 * @return void
 * @access private
 */
function el_photos_add_to_wall($callback, $type, $params) {
		if(isset($params['album']) && isset($params['photo_guids'])) {
				$wall = new elPhotos();
				$wall->addWall($params['album'], $params['photo_guids']);
		}
}
/**
 * Template for wall file
 *
 * @return string
 */
function el_photos_wall($hook, $type, $return, $params) {
		return el_plugin_view("photos/wall/template", $params);
}
/**
 * Set template for photos like for elNotifications
 *
 * @return html;
 * @access private;
 */
function el_notification_like_photo($hook, $type, $return, $params) {
		$notif          = $params;
		$baseurl        = el_site_url();
		$user           = el_user_by_guid($notif->poster_guid);
		$user->fullname = "<strong>{$user->fullname}</strong>";
		$iconURL        = $user->iconURL()->small;
		
		$img = "<div class='notification-image'><img src='{$iconURL}' /></div>";
		if(preg_match('/like/i', $notif->type)) {
				$type = 'like';
		}
		if(preg_match('/comments/i', $notif->type)) {
				$type = 'comment';
		}
		$type = "<div class='el-notification-icon-{$type}'></div>";
		if($notif->viewed !== NULL) {
				$viewed = '';
		} elseif($notif->viewed == NULL) {
				$viewed = 'class="el-notification-unviewed"';
		}
		$url               = el_site_url("photos/view/{$notif->subject_guid}");
		$notification_read = "{$baseurl}notification/read/{$notif->guid}?notification=" . urlencode($url);
		return "<a href='{$notification_read}'>
	       <li {$viewed}> {$img} 
		   <div class='notfi-meta'> {$type}
		   <div class='data'>" . el_print("el:notifications:{$notif->type}", array(
				$user->fullname
		)) . '</div>
		   </div></li></a>';
}

/**
 * Add photos link to user timeline
 *
 * @return void;
 * @access private;
 */
function el_profile_menu_photos($event, $type, $params) {
		$owner = el_user_by_guid(el_get_page_owner_guid());
		$url   = el_site_url();
		el_register_menu_link('photos', 'photos', $owner->profileURL('/photos'), 'user_timeline');
		
}

/**
 * Set photos sizes
 *
 * @return array;
 * @access private;
 */
function el_photos_sizes() {
		return array(
				'small' => '100x100',
				'album' => '200x200',
				'large' => '600x600',
				'view' => '700x700'
		);
}

/**
 * Add Albums module to user profile
 *
 * @return html;
 * @access private;
 */
function profile_modules_albums($hook, $type, $module, $params) {
		$user['user'] = $params['user'];
		$content      = el_plugin_view("photos/modules/profile/albums", $user);
		$title        = el_print('photo:albums');
		
		$module[] = el_view_widget(array(
				'title' => $title,
				'contents' => $content
		));
		return $module;
}

/**
 * el Photos page handler
 * @pages:
 *       view,
 *    user,
 *       add,
 *       viewer
 *
 * @return mixed contents
 */
function el_photos_page_handler($album) {
		$page = $album[0];
		if(empty($page)) {
				el_error_page();
		}
		switch($page) {
				
				case 'view':
						if(isset($album[1])) {
								
								$title          = el_print('photos');
								$photo['photo'] = $album[1];
								$photo['full_view'] = $album[2];
								
								$view            = new elPhotos;
								$image           = $view->GetPhoto($photo['photo']);
								$photo['entity'] = $image;
								
								//redirect user to home page if image is empty
								if(empty($image)) {
										redirect();
								}
								//throw 404 page if there is no album access
								$albumget = el_albums();
								$owner    = $albumget->GetAlbum($image->owner_guid)->album;
								if($owner->access == 3) {
										if(!el_validate_access_friends($owner->owner_guid)) {
												el_error_page();
										}
								}
								$contents = array(
										'title' => el_print('photos'),
										'content' => el_plugin_view('photos/pages/photo/view', $photo)
								);
								//set page layout
								$content  = el_set_page_layout('media', $contents);
								echo el_view_page($title, $content);
						}
						break;
				case 'user':
						if(isset($album[1]) && isset($album[2]) && $album[1] == 'view') {
								
								$title          = el_print('photos');
								$photo['photo'] = $album[2];
								$photo['full_view'] = $album[3];
								$type           = input('type');
								
								$view            = new elPhotos;
								$image           = $view->GetPhoto($photo['photo']);
								$photo['entity'] = $image;
								
								//redirect user if photo is empty
								if(empty($image->value)) {
										redirect();
								}
								$contents = array(
										'title' => 'Photos',
										'content' => el_plugin_view('photos/pages/profile/photos/view', $photo)
								);
								//set page layout
								$content  = el_set_page_layout('media', $contents);
								echo el_view_page($title, $content);
						}
						break;
				case 'cover':
						if(isset($album[1]) && isset($album[2]) && $album[1] == 'view') {
								
								$title          = el_print('cover:view');
								$photo['photo'] = $album[2];
								$photo['full_view'] = $album[3];
								$type           = input('type');
								
								$image           = el_get_entity($photo['photo']);
								$photo['entity'] = $image;
								
								//redirect user if photo is empty
								if(empty($image->value)) {
										redirect();
								}
								//Fixed hardcoded photos of user widget title #1482
								$contents = array(
										'title' => el_print('photos'),
										'content' => el_plugin_view('photos/pages/profile/covers/view', $photo)
								);
								//set page layout
								$content  = el_set_page_layout('media', $contents);
								echo el_view_page($title, $content);
						}
						break;
				case 'add':
						//add photos (ajax)
						if(!el_is_xhr()) {
								el_error_page();
						}
						echo el_plugin_view('output/elbox', array(
								'title' => el_print('add:photos'),
								'contents' => el_plugin_view('photos/pages/photos/add'),
								'callback' => '#el-photos-submit'
						));
						break;
				case 'viewer':
						//el image viewer currently works for profile images
						$image = input('user');
						
						$url   = el_site_url("avatar/{$image}");
						$media = "<img src='{$url}' />";
						
						$photo_guid = get_profile_photo_guid(el_user_by_username($image)->guid);
						//set viewer sidebar (comments and likes)
						$sidebar    = el_plugin_view('photos/viewer/comments', array(
								'entity_guid' => $photo_guid
						));
						echo el_plugin_view('output/viewer', array(
								'media' => $media,
								'sidebar' => $sidebar
						));
						break;
				default:
						el_error_page();
						break;
		}
}

/**
 * el Albums page handler
 * @pages:
 *       getphoto,
 *    view,
 *       profile,
 *       add
 *
 * @return false|null contents
 */
function el_album_page_handler($album) {
		$page = $album[0];
		if(empty($page)) {
				return false;
		}
		switch($page) {
				case 'getphoto':
						
						$guid    = $album[1];
						$picture = $album[2];
						$size    = input('size');
						
						$name = str_replace(array(
								'.jpg',
								'.jpeg',
								'gif'
						), '', $picture);
						$etag = $size . $name . $guid;
						
						if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
								header("HTTP/1.1 304 Not Modified");
								exit;
						}
						
						// get image size
						if(empty($size)) {
								$datadir = el_get_userdata("object/{$guid}/album/photos/{$picture}");
						} else {
								$datadir = el_get_userdata("object/{$guid}/album/photos/{$size}_{$picture}");
						}
						//get image type
						$type = input('type');
						
						if($type == '1') {
								if(empty($size)) {
										$datadir = el_get_userdata("user/{$guid}/profile/photo/{$picture}");
								} else {
										$datadir = el_get_userdata("user/{$guid}/profile/photo/{$size}_{$picture}");
								}
						}
						if(is_file($datadir)) {
								$filesize = filesize($datadir);
								header("Content-type: image/jpeg");
								header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
								header("Pragma: public");
								header("Cache-Control: public");
								header("Content-Length: $filesize");
								header("ETag: \"$etag\"");
								readfile($datadir);
								return;
						} else {
								el_error_page();
						}
						break;
				case 'getcover':
						
						$guid    = $album[1];
						$picture = $album[2];
						$type    = input('type');
						
						$name = str_replace(array(
								'.jpg',
								'.jpeg',
								'gif'
						), '', $picture);
						$etag = $size . $name . $guid;
						
						if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
								header("HTTP/1.1 304 Not Modified");
								exit;
						}
						
						// get image size
						$datadir = el_get_userdata("user/{$guid}/profile/cover/{$picture}");
						if(empty($type)) {
								$image = file_get_contents($datadir);
						} elseif($type == 1) {
								$image = el_resize_image($datadir, 170, 170, true);
						}
						//get image file else show error page
						if(is_file($datadir)) {
								$filesize = strlen($image);
								header("Content-type: image/jpeg");
								header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
								header("Pragma: public");
								header("Cache-Control: public");
								header("Content-Length: $filesize");
								header("ETag: \"$etag\"");
								//elphotos get cover type 1 not working #943
								echo $image;
								return;
						} else {
								el_error_page();
						}
						break;
				case 'edit':
						if(!el_isLoggedin() || !el_is_xhr()) {
								el_error_page();
						}
						$album = el_get_object($album[1]);
						if(isset($album->guid) && $album->subtype == 'el:album' && $album->owner_guid == el_loggedin_user()->guid) {
								echo el_plugin_view('output/elbox', array(
										'title' => el_print('edit'),
										'contents' => el_plugin_view('photos/pages/album/edit', array(
												'album' => $album
										)),
										'callback' => '#el-album-edit-submit'
								));
						} else {
								el_error_page();
						}
						break;
				case 'view':
						el_load_external_css('jquery.fancybox.min.css');
						el_load_external_js('jquery.fancybox.min.js');
						if(isset($album[1])) {
								$title = el_print('photos');
								
								$user['album'] = $album[1];
								$albumget      = el_albums();
								$owner         = $albumget->GetAlbum($album[1])->album;
								
								if(empty($owner)) {
										el_error_page();
								}
								
								//throw 404 page if there is no album access
								if($owner->access == 3) {
										if(!el_validate_access_friends($owner->owner_guid)) {
												el_error_page();
										}
								}
								$gallery_button  = array(
										'text' => "<i class='fa fa-caret-square-o-right'></i>",
										'href' => 'javascript:void(0);',
										'class' => 'button-grey',
										'id' => 'el-photos-show-gallery'
								);
								$control_gbutton = el_plugin_view('output/url', $gallery_button);
								//shows add photos if owner is loggedin user
								if(el_loggedin_user()->guid == $owner->owner_guid) {
										$addphotos = array(
												'text' => el_print('add:photos'),
												'href' => 'javascript:void(0);',
												'id' => 'el-add-photos',
												'data-url' => '?album=' . $album[1],
												'class' => 'button-grey'
										);
										
										$edit_album = array(
												'text' => el_print('edit'),
												'class' => 'button-grey',
												'data-guid' => $album[1],
												'id' => 'el-photos-edit-album'
										);
										
										$delete_action = el_site_url("action/el/album/delete?guid={$album[1]}", true);
										$delete_album  = array(
												'text' => el_print('delete:album'),
												'href' => $delete_action,
												'class' => 'button-grey el-make-sure'
										);
										$control       = el_plugin_view('output/url', $edit_album);
										$control .= el_plugin_view('output/url', $addphotos);
										$control .= el_plugin_view('output/url', $delete_album);
								} else {
										$control = false;
								}
								//Missing back button to photos #570
								$owner = el_user_by_guid($owner->owner_guid);
								$back  = array(
										'text' => el_print('back'),
										'href' => el_site_url("u/{$owner->username}/photos"),
										'class' => 'button-grey'
								);
								$control .= el_plugin_view('output/url', $back);
								//set photos in module
								$contents          = array(
										'title' => el_print('photos'),
										'content' => el_plugin_view('photos/pages/albums', $user),
										'controls' => $control_gbutton . $control,
										'module_width' => '850px'
								);
								//set page layout
								$module['content'] = el_set_page_layout('module', $contents);
								$content           = el_set_page_layout('contents', $module);
								echo el_view_page($title, $content);
						}
						break;
				case 'profile':
						if(isset($album[1])) {
								$title = el_print('profile:photos');
								
								$user['user'] = el_user_by_guid($album[1]);
								if(empty($user['user']->guid)) {
										el_error_page();
								}
								//Missing back button to photos #570
								$back              = array(
										'text' => el_print('back'),
										'href' => el_site_url("u/{$user['user']->username}/photos"),
										'class' => 'button-grey'
								);
								$control           = el_plugin_view('output/url', $back);
								//view profile photos in module layout
								$contents          = array(
										'title' => el_print('photos'),
										'content' => el_plugin_view('photos/pages/profile/photos/all', $user),
										'controls' => $control,
										'module_width' => '850px'
								);
								$module['content'] = el_set_page_layout('module', $contents);
								//set page layout
								$content           = el_set_page_layout('contents', $module);
								echo el_view_page($title, $content);
						}
						break;
				case 'covers':
						if(isset($album[2]) && $album[1] == 'profile') {
								$title = el_print('profile:covers');
								
								$user['user'] = el_user_by_guid($album[2]);
								if(empty($user['user']->guid)) {
										el_error_page();
								}
								//Missing back button to photos #570
								$back              = array(
										'text' => el_print('back'),
										'href' => el_site_url("u/{$user['user']->username}/photos"),
										'class' => 'button-grey'
								);
								$control           = el_plugin_view('output/url', $back);
								//view profile photos in module layout
								$contents          = array(
										'title' => el_print('covers'),
										'content' => el_plugin_view('photos/pages/profile/covers/all', $user),
										'controls' => $control,
										'module_width' => '850px'
								);
								$module['content'] = el_set_page_layout('module', $contents);
								//set page layout
								$content           = el_set_page_layout('contents', $module);
								echo el_view_page($title, $content);
						}
						break;
				case 'add':
						//add photos (ajax)
						echo el_plugin_view('output/elbox', array(
								'title' => el_print('add:album'),
								'contents' => el_plugin_view('photos/pages/album/add'),
								'callback' => '#el-album-submit'
						));
						break;
				
				default:
						el_error_page();
						break;
		}
}

/**
 * Register user photos page (profile subpage)
 *
 * @return mix data
 * @access private;
 */
function el_profile_photos_page($hook, $type, $return, $params) {
		$page = $params['subpage'];
		if($page == 'photos') {
				$user['user'] = $params['user'];
				$control      = false;
				//show add album if loggedin user is owner
				if(el_loggedin_user()->guid == $user['user']->guid) {
						$addalbum = array(
								'text' => el_print('add:album'),
								'href' => 'javascript:void(0);',
								'id' => 'el-add-album',
								'class' => 'button-grey'
						);
						$control  = el_plugin_view('output/url', $addalbum);
				}
				$friends = el_plugin_view('photos/pages/photos', $user);
				echo el_set_page_layout('module', array(
						'title' => el_print('photo:albums'),
						'content' => $friends,
						'controls' => $control
				));
		}
}

/**
 * Show a leftside menu on profile photo view
 *
 * @return mix data
 * @access private;
 */
function el_profile_photo_menu($hook, $type, $return, $params) {
		if($params->owner_guid == el_loggedin_user()->guid || el_isAdminLoggedin()) {
				return el_plugin_view('photos/views/profilephoto/menu', $params);
		}
}

/**
 * Show a leftside menu on album photo view
 *
 * @return mix data
 * @access private;
 */
function el_album_photo_menu($hook, $type, $return, $params) {
		$album = el_albums()->getAlbum($params->owner_guid);
		if($album->album->owner_guid == el_loggedin_user()->guid || el_isAdminLoggedin()) {
				return el_plugin_view('photos/views/albumphoto/menu', $params);
		}
}
/**
 * Show a leftside menu on profile cover photo vieww
 *
 * @return mix data
 * @access private;
 */
function el_album_cover_photo_menu($hook, $type, $return, $params) {
		if($params->owner_guid == el_loggedin_user()->guid || el_isAdminLoggedin()) {
				return el_plugin_view('photos/views/coverphoto/menu', $params);
		}
}
/**
 * Delete photos like
 *
 * @return voud;
 * @access private
 */
function el_photos_likes_comments_delete($name, $type, $params) {
		if(class_exists('elLikes')) {
				$likes = new elLikes;
				$likes->deleteLikes($params['photo']['guid'], 'entity');
				
				$comments = new elComments;
				//[B] getting orphan like records from comments when deleting a post #1687
				$comments->commentsDeleteAll($params['photo']['guid'], 'entity');
		}
		//[E] delete 'upload image' wall entries automatically if pic is deleted #1667
		if(class_exists('elWall')) {
				$photoguid                = $params['photo']['guid'];
				$Wall                     = new elWall;
				$vars['subtype']          = 'wall';
				$vars['type']             = 'user';
				$vars['entities_pairs'][] = array(
						'name' => 'item_type',
						'value' => 'album:photos:wall'
				);
				$vars['entities_pairs'][] = array(
						'name' => 'photos_guids',
						'value' => true,
						'wheres' => "(FIND_IN_SET('{$photoguid}', emd1.value) > 0)"
				);
				
				$List = $Wall->searchObject($vars);
				if($List) {
						$post  = $List[0];
						$guids = explode(',', $post->photos_guids);
						$key   = array_search($photoguid, $guids);
						if(strlen($key) > 0){
								unset($guids[$key]);
						}
						$total_photos = count($guids);
						if($total_photos < 1) {
								$post->deletePost($post->guid);
						} else {
								$post->data->photos_guids = implode(',', $guids);
								$post->save();
						}
				}
		}
}
function el_profile_photo_cover_like_participants_deny(){
	return false;	
}
el_register_callback('el', 'init', 'el_photos_initialize');
