<?php

class PostBackground {
		public function setBackground($params) {
				if(isset($params['object_guid']) && !empty($params['object_guid'])) {
						$object = el_get_object($params['object_guid']);
				} elseif(isset($params['object']) && $params['object'] instanceof ElObject) {
						$object = $params['object'];
				}
				$postbg = input('postbackground_type');
				if($object && $postbg && (!isset($_FILES['el_photo']) || (isset($_FILES['el_photo']) && empty($_FILES['el_photo']['name'])) )) {
						if(!empty($postbg) && strlen($postbg) <= 125) {
								$this->saveSettings($object, $postbg);
						}
				}
		}
		private function saveSettings($object, $postbg) {
				if(!isset($object->guid) || empty($postbg)) {
						return false;
				}
				$json = html_entity_decode($object->description);
				$data = json_decode($json, true);
				
				$text = el_input_escape($data['post']);
				$text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
				$text = el_restore_new_lines($text);
				
				$data['post']        = htmlspecialchars($data['post'], ENT_QUOTES, 'UTF-8');
				$data['post']        = el_input_escape($data['post']);
				$object->description = json_encode($data, JSON_UNESCAPED_UNICODE);
				
				$object->data->postbackground_type = $postbg;
				$object->save();
		}
		public static function getById($id){
				if(__PostBackground_List__){
					foreach(__PostBackground_List__ as $item){
							if($item['name'] == $id){
								return $item;	
							}
					}
				}
				return false;
		}
}
