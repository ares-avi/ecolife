<?php
class ElBase extends ElSession {
		/**
		 * 
		 *
		 * @return false|int;
		 */
		public function getGUID() {
				if(isset($this->guid)) {
						return $this->guid;
				}
				return false;
		}
		/**
		 * Get Id.
		 *
		 * @return false|int;
		 */
		public function getID() {
				if(isset($this->id)) {
						return $this->id;
				}
				return false;
		}
		/**
		 * Get a parameter from object
		 *
		 * @param string $param
		 *
		 * @return string;
		 */
		public function getParam($param) {
				if(isset($this->$param)) {
						return $this->$param;
				}
				return false;
		}
		/**
		 * isParam
		 *
		 * @param string $param
		 *
		 * @return string;
		 */
		public function isParam($param) {
				if(!empty($param) && isset($this->$param)) {
						return true;
				}
				return false;
		}
		/**
		 * 
		 * @param string $method Name of method
		 * @param array  $args A arguments
		 * 
		 * @return mixed|boolean|string|init|float|resource
		 */
		public function __call($method, $args) {
				$name = get_class($this);
				if(!el_is_hook('el/class/register/method', "{$name}:{$method}")) {
						throw new exception("Call to undefined method {$name}:{$method}");
				}
				$hooked = el_call_hook('el/class/register/method', "{$name}:{$method}", $args, $this);
				if($hooked->params == false && !empty($args)) {
						throw new exception("Function expects no arguments, but arguments are supplied {$name}:{$method}({args})");
				}
				return $hooked->return;
		}
} //CLASS
