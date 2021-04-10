<?php

/**
 * Register a page handler;
 * @params: $handler = page;
 * @params: $function = function which handles page;
 * @param string $handler
 * @param string $function
 *
 * @last edit: $arsalanshah
 * @Reason: Initial;
 */
function el_register_page($handler, $function) {
		global $El;
		$pages = $El->page[$handler] = $function;
		return $pages;
}
/**
 * Unregister a page from syste,
 * @param (string) $handler Page handler name;
 *
 * @last edit: $arsalanshah
 * @return void;
 */
function el_unregister_page($handler) {
		global $El;
		unset($El->page[$handler]);
}

/**
 * Output a page.
 *
 * If page is not registered then user will see a 404 page;
 *
 * @param  (string) $handler Page handler name;
 * @param  (string) $page  handler/page;
 * @last edit: $arsalanshah
 * @Reason: Initial;
 *
 * @return mix|null data
 * @access private
 */

function el_load_page($handler, $page) {
		global $El;
		$context = $handler;
		if(isset($page) && !empty($page)) {
				$context = "$handler/$page";
		}
		//set context
		el_add_context($context);
		
		$page = explode('/', $page);
		if(isset($El->page) && isset($El->page[$handler]) && !empty($handler) && is_callable($El->page[$handler])) {
				//supply params to hook
				$params['page']    = $page;
				$params['handler'] = $handler;
				
				//[E] Allow to override page handler existing pages #1746
				$halt_view = el_call_hook('page', 'override:view', $params, false);
				if($halt_view === false) {
						//get page contents
						ob_start();
						call_user_func($El->page[$handler], $page, $handler);
						$contents = ob_get_clean();
				}
				if($halt_view) {
						$contents = "";
				}
				return el_call_hook('page', 'load', $params, $contents);
		} else {
				return el_error_page();
		}
		
}

/**
 * Set page owner guid, this is very useful
 *
 * @param (int) $guid  Guid of owner
 *
 * @return void
 */

function el_set_page_owner_guid($guid) {
		global $El;
		$El->pageOwnerGuid = $guid;
}

/**
 * Get page owner guid
 *
 * @return (int)
 */

function el_get_page_owner_guid() {
		global $El;
		return $El->pageOwnerGuid;
}
