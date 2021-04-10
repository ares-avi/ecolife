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
class elAlbums extends elObject {
		/**
		 * Create a photo album
		 *
		 * @param integer $owner_id User guid who is creating album
		 * @param string $name Album name
		 * @param constant $access Album access
		 * @param string $type Album type (user, group, page etc)
		 *
		 * @return boolean
		 */
		public function CreateAlbum($owner_id, $name, $access = el_PUBLIC, $type = 'user') {
				//check if acess type is valid else set public
				if(!in_array($access, el_access_types())) {
						$access = el_PUBLIC;
				}
				//check if owner is valid user
				if(!empty($owner_id) && !empty($name) && $owner_id > 0) {
						$this->owner_guid   = $owner_id;
						$this->type         = $type;
						$this->subtype      = 'el:album';
						$this->data->access = $access;
						$this->title        = strip_tags($name);
						
						//add ablum
						if($this->addObject()) {
								$this->getObjectId = $this->getObjectId();
								return true;
						}
						return false;
				}
		}
		
		/**
		 * Get newly created album guid
		 *
		 * @return bool;
		 */
		public function GetAlbumGuid() {
				if(isset($this->getObjectId)) {
						return $this->getObjectId;
				}
				return false;
		}
		
		/**
		 * Get albums by owner id and owner type
		 *
		 * @param integer $owner_id User guid who is creating album
		 * @param array   $params Extra options,
		 *
		 * @return object
		 */
		public function GetAlbums($owner_id, $params = array()) {
				if(!empty($owner_id)) {
						$args = array(
							'type' => 'user',
							'subtype' => 'el:album',
							'owner_guid' => $owner_id,
						);
						$vars = array_merge($args, $params);
						return $this->searchObject($vars);
				}
				return false;
		}
		
		/**
		 * Get album by id
		 *
		 * @param integer $album_id Id of album
		 *
		 * @return void|object;
		 */
		public function GetAlbum($album_id) {
				if(!empty($album_id)) {
						$this->object_guid = $album_id;
						$this->album       = $this->getObjectbyId();
						if(!empty($this->album)) {
								$this->photos             = new elPhotos;
								//Photos limit issue, only 10 displays #523
								$this->photos->page_limit = false;
								$this->album              = array(
										'album' => $this->album,
										'photos' => $this->photos->GetPhotos($album_id)
								);
								return arrayObject($this->album, get_class($this));
						}
				}
		}
		
		/**
		 * Get user profile photos album
		 *
		 * @param integer $user User guid
		 *
		 * @return object
		 */
		public function GetUserProfilePhotos($user) {
				$photos             = new elFile;
				$photos->owner_guid = $user;
				$photos->type       = 'user';
				$photos->subtype    = 'profile:photo';
				$photos->order_by   = 'guid DESC';
				return $photos->getFiles();
		}
		/**
		 * Get user cover photos album
		 *
		 * @param integer $user User guid
		 *
		 * @return object
		 */
		public function GetUserCoverPhotos($user) {
				$photos             = new elFile;
				$photos->owner_guid = $user;
				$photos->type       = 'user';
				$photos->subtype    = 'profile:cover';
				$photos->order_by   = 'guid DESC';
				return $photos->getFiles();
		}
		/**
		 * Delete Album
		 *
		 * @param integer $guid Album Guid
		 *
		 * @return boolean
		 */
		public function deleteAlbum($guid) {
				if(!empty($guid)) {
						$album = $this->GetAlbum($guid);
						if($album->album->owner_guid == el_loggedin_user()->guid || el_isAdminLoggedin()) {
								$photos = new elPhotos;
								if($album->photos) {
										foreach($album->photos as $photo) {
												$photos->photoid = $photo->guid;
												$photos->deleteAlbumPhoto();
										}
								}
								if(class_exists('elWall')) {
										$wall      = new elWall();
										$wallposts = $wall->searchObject(array(
												'type' => 'user',
												'page_limit' => false,
												'entities_pairs' => array(
														array(
																'name' => 'item_type',
																'value' => 'album:photos:wall'
														),
														array(
																'name' => 'item_guid',
																'value' => $guid
														)
												)
										));
										if($wallposts) {
												foreach($wallposts as $post) {
														if(!empty($post->guid)) {
																$post->deletePost($post->guid);
														}
												}
										}
								}
								if($album->album->deleteObject()) {
										return true;
								}
						}
				}
				return false;
		}
		
}