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
class MessageTyping extends elAnnotation {
		public function getStatus(int $from, int $to, bool $full = false) {
				if(empty($from) || empty($to)) {
						return false;
				}
				$status = $this->searchAnnotation(array(
						'owner_guid' => $from, //here owner is from,
						'subject_guid' => $to, //to,  for who you wanna check status,  here we'll check if subjct_guid is typing.
						'type' => 'messagetypingstatus',
						'offset' => 1
				));
				if($status) {
						if(!$full) {
								if($status[0]->messagetypingstatus == 'yes') {
										//what if user struck at yes?
										//make timeout after 6 seconds
										if((time() - $status[0]->status_time_updated) > 5) {
												$status[0]->messagetypingstatus = 'no';
										}
								}
								return $status[0]->messagetypingstatus;
						} else {
								return $status[0];
						}
				}
				return false;
		}
		public function setStatus(int $from, int $to, $value = '') {
				if(empty($from) || empty($to) || empty($value)) {
						return false;
				}
				$user    = el_user_by_guid($from);
				$subject = el_user_by_guid($to);
				if(!$user || !$subject) {
						return false;
				}
				$status = $this->getStatus($from, $to, true);
				if(!$status) {
						$this->type                      = 'messagetypingstatus';
						$this->owner_guid                = $from;
						$this->subject_guid              = $to;
						$this->value                     = $value;
						$this->data->status_time_updated = time();
						return $this->addAnnotation();
				} else {
						if(isset($status->id)) {
								if(!isset($status->data)){
									$status->data = new stdClass();	
								}
								$status->data->messagetypingstatus = $value;
								$status->data->status_time_updated = time();
								return $status->save();
						}
				}
				return false;
		}
}
