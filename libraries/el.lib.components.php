<?php

global $El;
$ElComponents = new ElComponents;
$El->activeComponents = $ElComponents->getActive(true);

/**
 * Get components object
 *
 * @return ElComponents
 */
function el_components() {
		$coms = new ElComponents;
		return $coms;
}

/**
 * Check whether component is active or not.
 *
 * @param string $comn Component id
 *
 * @return bool
 */
function com_is_active($comn = '') {
		global $El;
		if(!empty($comn) && in_array($comn, $El->activeComponents)){
				return true;	
		}
		return false;
}

/**
 * Count total components
 *
 * @return integer
 */
function el_total_components() {
		$com = new ElComponents;
		return $com->total();
}

/**
 * Load the locales
 *
 * @return array
 */
el_default_load_locales();

/**
 * Includes all components and active theme
 *
 * @return bool
 */

//loads active theme
$theme = new ElThemes;
$theme->loadActive();

//load active components
$coms = new ElComponents;
$coms->loadComs();

/**
 * Initialize components
 *
 * @return false|null
 * @access private;
 */

function el_components_init() {
		$panels = el_registered_com_panel();
		if($panels) {
			foreach($panels as $configure) {
				el_register_menu_item('topbar_admin', array(
						'name' => ElTranslit::urlize($configure),
						'text' => $configure,
						'parent' => 'configure',
						'href' => el_site_url("administrator/component/{$configure}")
				));
			}
		}
}

el_register_callback('el', 'init', 'el_components_init');
