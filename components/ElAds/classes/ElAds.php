<?php

class ElAds extends ElObject {
		/**
		 * Add a new ad in system.
		 *
		 * @return bool;
		 */
		public function addNewAd($params) {
				self::initAttributes();
				
				$this->title          = $params['title'];
				$this->description    = $params['description'];
				$this->data->site_url = $params['siteurl'];
				
				$this->owner_guid = 1;
				$this->type       = 'site';
				$this->subtype    = 'elads';
				if(empty($_FILES['el_ads']['tmp_name'])) {
						return false;
				}
				if($this->addObject()) {
						if(isset($_FILES['el_ads'])) {
								$this->ElFile->owner_guid = $this->getObjectId();
								$this->ElFile->type       = 'object';
								$this->ElFile->subtype    = 'elads';
								$this->ElFile->setFile('el_ads');
								$this->ElFile->setExtension(array(
										'jpg',
										'png',
										'jpeg',
										'gif'
								));
								$this->ElFile->setPath('elads/images/');
								$this->ElFile->addFile();
						}
						return true;
				}
				return false;
		}
		
		/**
		 * Initialize the objects.
		 *
		 * @return void;
		 */
		public function initAttributes() {
				$this->ElDatabase = new ElDatabase;
				$this->ElFile     = new ElFile;
				$this->data         = new stdClass;
		}
		
		/**
		 * Get site ads.
		 *
		 * @param array $params option values
		 * @param boolean $random do you wanted to see ads in ramdom order?
		 *
		 * @return array|boolean|integer
		 */
		public function getAds(array $params = array(),  $random = true) {
				$options = array(
						'owner_guid' => 1,
						'type' => 'site',
						'subtype' => 'elads',
						'order_by' => 'rand()'
				);
				if(!$random){
						unset($options['order_by']);			
				}
				$args    = array_merge($options, $params);
				return $this->searchObject($args);
		}
		/**
		 * Get ad entity
		 * 
		 * @param (int) $guid ad guid
		 *
		 * @return object;
		 */
		public function getAd($guid) {
				$this->object_guid = $guid;
				return $this->getObjectById();
		}
		/**
		 * Delete ad
		 * 
		 * @param (int) $ad ad guid
		 *
		 * @return bool;
		 */
		public function deleteAd($ad) {
				if($this->deleteObject($ad)) {
						return true;
				}
				return false;
		}
		/**
		 * Edit
		 * 
		 * @param (array) $params Contain title , description and guid of ad
		 *
		 * @return bool;
		 */
		public function EditAd($params) {
				self::initAttributes();
				if(!empty($params['guid']) && !empty($params['title']) && !empty($params['description']) && !empty($params['siteurl'])) {
						$entity               = get_ad_entity($params['guid']);
						$fields               = array(
								'title',
								'description'
						);
						$data                 = array(
								$params['title'],
								$params['description']
						);
						$this->data->site_url = $params['siteurl'];
						if($this->updateObject($fields, $data, $entity->guid)) {
								if(isset($_FILES['el_ads']) && $_FILES['el_ads']['size'] !== 0) {
										$path         = $entity->getParam('file:elads');
										$replace_file = el_get_userdata("object/{$entity->guid}/{$path}");
										if(!empty($path)) {
												$regen_image = el_resize_image($_FILES['el_ads']['tmp_name'], 2048, 2048);
												file_put_contents($replace_file, $regen_image);
										}
								}
								return true;
						}
				}
				return false;
		}
		
} //class
