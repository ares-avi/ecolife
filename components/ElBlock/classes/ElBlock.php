<?php


class ElBlock extends ElEntities {
		/**
		 * Check if loggedin user is blocked by $user.
		 *
		 * @params $user entity of user a
		 *
		 * @return boolean
		 * @access public
		 */
		public static function UserBlockCheck($user) {
				return self::isBlocked($user, el_loggedin_user());
		}
		/**
		 * Check if loggedin user is block UserB.
		 *
		 * @param $user entity of user B
		 *
		 * @return boolean
		 * @access public
		 */		
		public static function selfBlocked($user){
			return self::isBlocked(el_loggedin_user(), $user);
		}
		/**
		 * Check if loggedin user is blocked by $user.
		 *
		 * @param  object $usera From object
		 * @param  object $userb To object
		 *
		 * @return boolean
		 * @access public
		 */
		public static function isBlocked($usera, $userb) {
				if(isset($usera->guid) && $usera->guid != $userb->guid){
						return el_relation_exists($usera->guid, $userb->guid, 'userblock');
				}
				return false;
		}
		
		/**
		 * Add new user to block.
		 *
		 * @params $from Guid of user, who is blocking
		 *         $to Guid of user which is going to be blocked
		 *
		 * @return boolean
		 * @access public
		 */
		public function addBlock($from, $to) {
				if($from == $to) {
						return false;
				}
				if($this->isBlocked($from, $to)){
						return true;	
				}
				if(el_add_relation($from, $to, 'userblock')) {
						return true;
				}
				return false;
		}
		
		/**
		 * Remove user block
		 *
		 * @param int $from guid of user, who blocked other
		 * @param int $to guid of user which is going to be unblocked
		 *
		 * @return boolean
		 * @access public
		 */
		public function removeBlock($from, $to) {
				if($from == $to || empty($from) || empty($to)) {
						return false;
				}
				return el_delete_relationship(array(
						'from' => $from,
						'to' => $to,
						'type' => 'userblock',
				));
		}
		/**
		 * Get list of all blocked users
		 *
		 * @return object|boolean
		 */
		public static function getBlocking(){
				return el_get_relationships(array(
						'from' => el_loggedin_user()->guid,
						'type' => 'userblock',
						'page_limit' => false,
				));
		}
} //class
