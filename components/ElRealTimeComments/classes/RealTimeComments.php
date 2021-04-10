<?php

class RealTimeComments {
		public function isTyping(int $subject_guid, string $type) {
				if(empty($subject_guid) || empty($type)) {
						return false;
				}
				$loggedinuser = el_loggedin_user()->guid;
				$status       = el_get_relationships(array(
						'to' => $subject_guid,
						'type' => "rtctyping{$type}",
						'wheres' => "relation_from NOT IN($loggedinuser)",
						'order_by' => 'time DESC',
						'offset' => 1
				));
				if($status) {
						$status = (array) $status;
				}
				if($status) {
						if((time() - $status[0]->time) > 5) {
								return false;
						} else {
								return true;
						}
				}
				return false;
		}
		public function setStatus(int $subject_guid, string $type) {
				if(empty($subject_guid) || empty($type)) {
						return false;
				}
				$status = el_get_relationships(array(
						'to' => $subject_guid,
						'from' => el_loggedin_user()->guid,
						'type' => "rtctyping{$type}",
						'order_by' => 'relation_id DESC'
				));
				if($status) {
						$status = (array) $status;
				}
				if($status && isset($status[0]->relation_id)) {
						$update           = new elDatabase;
						$params['table']  = 'el_relationships';
						$params['names']  = array(
								'time'
						);
						$params['values'] = array(
								time()
						);
						$params['wheres'] = array(
								"relation_id={$status[0]->relation_id}"
						);
						return $update->update($params);
				}
				return el_add_relation(el_loggedin_user()->guid, $subject_guid, "rtctyping{$type}");
		}
}