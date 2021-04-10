<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

define('__el_SEARCH__', el_route()->com . 'elSearch/');
require_once(__el_SEARCH__ . 'classes/elSearch.php');

function el_search() {
    el_register_page('search', 'el_search_page');
    el_add_hook('search', "left", 'search_menu_handler');

    el_extend_view('css/el.default', 'css/search');
}

function search_menu_handler($hook, $type, $return) {
    $return[] = el_view_menu('search');
    return $return;
}

function el_search_page($pages) {
    $page = $pages[0];
    if (empty($page)) {
        $page = 'search';
    }
    el_trigger_callback('page', 'load:search');
    switch ($page) {
        case 'search':
            $query = input('q');
            $type = input('type');
            $title = el_print("search:result", array($query));
            if (empty($type)) {
                $params['type'] = 'users';
            } else {
                $params['type'] = $type;
            }
            $type = $params['type'];
            if (el_is_hook('search', "type:{$type}")) {
                $contents['contents'] = el_call_hook('search', "type:{$type}", array('q' => input('q')));
            }
            $contents = array('content' => el_plugin_view('search/pages/search', $contents),);
            $content = el_set_page_layout('search', $contents);
            echo el_view_page($title, $content);
            break;
        default:
            el_error_page();
            break;
    }
}

el_register_callback('el', 'init', 'el_search');
