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
define('__el_SITE_PAGES__', el_route()->com . 'elSitePages/');
require_once(__el_SITE_PAGES__ . 'classes/elSitePages.php');

function el_sitepages() {
    //css
    el_extend_view('css/el.default', 'css/pages');
    //register pages
    el_register_page('site', 'el_site_pages');
    //register admin panel page
    el_register_com_panel('elSitePages', 'settings');
    //actions
    el_register_action('sitepage/edit/terms', __el_SITE_PAGES__ . 'actions/edit/terms.php');
    el_register_action('sitepage/edit/about', __el_SITE_PAGES__ . 'actions/edit/about.php');
    el_register_action('sitepage/edit/privacy', __el_SITE_PAGES__ . 'actions/edit/privacy.php');

    //register menu links in footer
    el_register_menu_link('about', el_print('site:about'), el_site_url('site/about'), 'footer');
    el_register_menu_link('site', el_print('site:terms'), el_site_url('site/terms'), 'footer');
    el_register_menu_link('privacy', el_print('site:privacy'), el_site_url('site/privacy'), 'footer');
}

function el_site_pages($pages) {
    $page = $pages[0];
    if (empty($page)) {
        redirect(REF);
    }
    $elSitePages = new elSitePages;
    switch ($page) {
        case 'about':
            $elSitePages->pagename = 'about';
            $elSitePages = $elSitePages->getPage();

            if (isset($elSitePages->description)) {
                $params['contents'] = html_entity_decode(html_entity_decode($elSitePages->description));
            }
            $params['title'] = el_print('site:about');
            $title = $params['title'];
            $contents = array('content' => el_view('components/elSitePages/pages/page', $params),);
            $content = el_set_page_layout('contents', $contents);
            echo el_view_page($title, $content);
            break;

        case 'terms':
            $elSitePages->pagename = 'terms';
            $elSitePages = $elSitePages->getPage();
            if (isset($elSitePages->description)) {
                $params['contents'] = html_entity_decode(html_entity_decode($elSitePages->description));
            }
            $params['title'] = el_print('site:terms');
            $title = $params['title'];
            $contents = array('content' => el_view('components/elSitePages/pages/page', $params),);
            $content = el_set_page_layout('contents', $contents);
            echo el_view_page($title, $content);
            break;

        case 'privacy':
            $elSitePages->pagename = 'privacy';
            $elSitePages = $elSitePages->getPage();

            if (isset($elSitePages->description)) {
                $params['contents'] = html_entity_decode(html_entity_decode($elSitePages->description));
            }
            $params['title'] = el_print('site:privacy');
            $title = $params['title'];
            $contents = array('content' => el_view('components/elSitePages/pages/page', $params),);
            $content = el_set_page_layout('contents', $contents);
            echo el_view_page($title, $content);
            break;
        default:
            el_error_page();
    }
}

el_register_callback('el', 'init', 'el_sitepages');
