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
class elPhotos extends elFile {
		/**
		 * Add photo to album
		 *
		 * @params = $album Album guid
		 *           $photo Photo type
		 *           $access Private or Public ( its actually depend on album privacy)
		 *
		 * @return bool;
		 */
		public function AddPhoto($album, $photo = 'elphoto', $access = el_PUBLIC) {
				//check access
				if(!in_array($access, el_access_types())) {
						$access = el_PUBLIC;
				}
				//album initialize
				$this->album = new elAlbums;
				$this->album = $this->album->GetAlbum($album);
				
				//check if album guid is not less than 0 and validate photo uploader
				if(!empty($album) && $album > 0 && $this->album->album->owner_guid == el_loggedin_user()->guid) {
						
						//initialize variables
						$this->owner_guid = $album;
						$this->type       = 'object';
						$this->subtype    = 'el:aphoto';
						$this->setFile($photo);
						$this->permission = $access;
						$this->setPath('album/photos/');
						$this->setExtension(array(
								'jpg',
								'png',
								'jpeg',
								'gif'
						));
						
						//add file
						if($fileguid = $this->addFile()) {
								$sizes  = el_photos_sizes();
								$resize = $this->getFiles();
								
								if(isset($resize->{0}->value)) {
										$datadir   = el_get_userdata("object/{$album}/{$resize->{0}->value}");
										$file_name = str_replace('album/photos/', '', $resize->{0}->value);
										//crop photos and create new photos from source
										$sizes     = el_photos_sizes();
										foreach($sizes as $size => $params) {
												$params = explode('x', $params);
												$width  = $params[1];
												$height = $params[0];
												
												if($size !== 'view') {
														$resized = el_resize_image($datadir, $width, $height, true);
												} else {
														$resized = el_resize_image($datadir, $width, $height, false);
												}
												//create newly created image
												$image = el_get_userdata("object/{$album}/album/photos/{$size}_{$file_name}");
												file_put_contents($image, $resized);
										}
										//return true if photos is added to database
										$args['guid']  = $fileguid;
										$args['album'] = $this->album;
										el_trigger_callback('el:photo', 'add', $args);
										return $fileguid;
								}
						}
						return false;
				}
		}
		
		/**
		 * Get photos of album
		 *
		 * @params = $album Album guid
		 *
		 * @return object;
		 */
		public function GetPhotos($album) {
				$this->owner_guid = $album;
				$this->subtype    = 'el:aphoto';
				$this->type       = 'object';
				return $this->getFiles();
		}
		
		/**
		 * Get photo of album
		 *
		 * @params = $photo Photo id
		 *
		 * @return object;
		 */
		public function GetPhoto($photo) {
				$this->file_id = $photo;
				$this->type    = 'object';
				return $this->fetchFile();
		}
		
		/**
		 * Delete profile photo
		 *
		 * @return bool;
		 */
		public function deleteProfilePhoto() {
				if(isset($this->photoid)) {
						
						$this->file_id = $this->photoid;
						$this->entity  = new elEntities;
						$file          = $this->fetchFile();
						$source        = el_get_userdata("user/{$file->owner_guid}/{$file->value}");
						
						//delete cropped photos
						unlink($source);
						foreach(el_user_image_sizes() as $size => $dimensions) {
								$filename = str_replace('profile/photo/', '', $file->value);
								$filename = el_get_userdata("user/{$file->owner_guid}/profile/photo/{$size}_{$filename}");
								if(is_file($filename)) {
										unlink($filename);
								}
						}
						//delete photo from database
						if($this->deleteEntity($file->guid)) {
								$params['photo'] = get_object_vars($file);
								el_trigger_callback('delete', 'profile:photo', $params);
								return true;
						}
						
				}
				return false;
		}
		/**
		 * Delete profile cover photo
		 *
		 * @return bool;
		 */
		public function deleteProfileCoverPhoto() {
				if(isset($this->photoid)) {
						
						$this->file_id = $this->photoid;
						$this->entity  = new elEntities;
						$file          = $this->fetchFile();
						$source        = el_get_userdata("user/{$file->owner_guid}/{$file->value}");
						
						if($this->deleteEntity($this->file_id)) {
								//delete file
								unlink($source);
								$params['photo'] = get_object_vars($file);
								el_trigger_callback('delete', 'profile:cover:photo', $params);
								return true;
						}
						
				}
				return false;
		}
		
		/**
		 * Delete profile photo
		 *
		 * @params = $this->photoid Id of photo
		 *
		 * @return bool;
		 */
		public function deleteAlbumPhoto() {
				if(isset($this->photoid)) {
						
						$this->file_id = $this->photoid;
						$this->entity  = new elEntities;
						$file          = $this->fetchFile();
						$source        = el_get_userdata("object/{$file->owner_guid}/{$file->value}");
						
						//delete croped photos
						unlink($source);
						foreach(el_photos_sizes() as $size => $dimensions) {
								$filename = str_replace('album/photos/', '', $file->value);
								$filename = el_get_userdata("object/{$file->owner_guid}/album/photos/{$size}_{$filename}");
								unlink($filename);
						}
						//delete photo from database
						if($this->deleteEntity($file->guid)) {
								$params['photo'] = get_object_vars($file);
								el_trigger_callback('delete', 'album:photo', $params);
								return true;
						}
						
				}
				return false;
		}
		/**
		 * Add images to wall
		 *
		 * @param integer $itemguid A album guid
		 *
		 * @return boolean
		 */
		public function addWall($itemguid = '', array $images_guid = array()) {
				$album = el_get_object($itemguid);
				if(!$album || !class_exists("elWall")) {
						return false;
				}
				$this->wall                     = new elWall;
				$this->wall->type               = 'user';
				$this->wall->item_type          = 'album:photos:wall';
				$this->wall->owner_guid         = el_loggedin_user()->guid;
				$this->wall->poster_guid        = el_loggedin_user()->guid;
				$this->wall->item_guid          = $itemguid;
				$this->wall->data->photos_guids = implode(',', $images_guid);
				if($this->wall->Post('null:data', '', '', $album->access)) {
						return true;
				}
				return false;
		}
} //class