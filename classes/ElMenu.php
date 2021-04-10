<?php

class ElMenu {
		/**
		 * Initialize the ElMenu
		 *
		 * @return void
		 */
		public function __construct($type = '', $options = '') {
				$this->menutype = $type;
				$this->options  = $options;
		}
		/**
		 * Register menu item
		 *
		 * @return void
		 */
		public function register() {
				global $El;
				$menutype = $this->menutype;
				$options  = $this->options;
				if(!empty($options['name'])) {
						$name = $options['name'];
						if(isset($options['parent']) && !empty($options['parent'])) {
								$name = $options['parent'];
						}
						
						$maxpriority = $this->maxPriority($menutype);
						$priorities  = $this->priorities($menutype);
						
						$priority = 100;
						while(in_array($priority, $priorities)) {
								$priority++;
						}
						if(!isset($options['priority'])) {
								$options['priority'] = $priority;
						}
						$El->menu[$menutype][$name][] = $options;
				}
		}
		/**
		 * Get the menu item priorities
		 *
		 * @param string $menutype A key of menu
		 * 
		 * @return array
		 */
		public function priorities($menutype) {
				global $El;
				if(isset($El->menu[$menutype])) {
						$list = array();
						foreach($El->menu[$menutype] as $items) {
								foreach($items as $item) {
										$list[] = $item['priority'];
								}
						}
						return array_unique($list);
				}
				return array();
		}
		/**
		 * Get the menu max priority
		 *
		 * @param string $menutype A key of menu
		 * 
		 * @return array
		 */
		public function maxPriority($menutype) {
				global $El;
				if(isset($El->menu[$menutype])) {
						$list = array();
						foreach($El->menu[$menutype] as $items) {
								foreach($items as $item) {
										if(isset($item['priority'])) {
												$list[] = $item['priority'];
										}
								}
						}
						if(!empty($list)){
							return max($list);
						}
				}
				return false;
		}
		/**
		 * Sort menu with priority
		 *
		 * @param string $menutype A key of menu
		 * 
		 * @return void
		 */
		public function sortMenu($menutype) {
				global $El;
				if(empty($menutype)) {
						return false;
				}
				foreach($El->menu[$menutype] as $name => $items) {
						foreach($items as $item) {
								$custom[$menutype][$item['priority']][$name] = $item;
						}
				}

				if(empty($custom[$menutype]) || !is_array($custom[$menutype])){
					return false;
				}
				ksort($custom[$menutype]);
				unset($El->menu[$menutype]);
				foreach($custom[$menutype] as $nitems) {
						foreach($nitems as $nname => $nitem) {
								if(isset($nitem['priority'])){
									unset($nitem['priority']);
								}
								$El->menu[$menutype][$nname][] = $nitem;
						}
				}
		}
} //class
