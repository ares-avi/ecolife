<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@softlab24.com>
 * @copyright 2014-2018 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/
 */
define('__el_SOUNDS__', el_route()->com . 'elSounds/');
function el_sounds_init() {
	el_extend_view('css/el.default', 'css/sounds');
	el_extend_view('js/opensource.socialnetwork', 'js/sounds');
}
el_register_callback('el', 'init', 'el_sounds_init');
