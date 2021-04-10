<?php

/**
 * Registers an action.
 *
 * @param string $action The name of the action
 * @param string $filename The filename where this action is located.
 *
 * @return void
 */
function el_register_action($action, $file) {
    global $El;
    $El->action[$action] = $file;
}

/**
 * Unregister action
 *
 * @param string $action The name of the action
 *
 * @return void
 */
function el_unregister_action($action) {
    global $El;
    unset($El->action[$action]);
}

/**
 * Load action.
 *
 * @param string $action The name of the action
 *
 * @return void
 */
function el_action($action) {
    global $El;
    if (isset($El->action) && array_key_exists($action, $El->action)
    ) {
        if (is_file($El->action[$action])) {
			$params['action'] = $action;
            el_trigger_callback('action', 'load', $params);
            include_once($El->action[$action]);
			if(el_is_xhr()){
				header('Content-Type: application/json');
				$vars = array();
				if(isset($_SESSION['el_messages']['success']) 
					&& !empty($_SESSION['el_messages']['success'])){
						$vars['success'] = $_SESSION['el_messages']['success'];
				}
				//danger = error bootstrap
				if(isset($_SESSION['el_messages']['danger']) 
					&& !empty($_SESSION['el_messages']['danger'])){
						$vars['error'] = $_SESSION['el_messages']['danger'];
				}
				if(isset($El->redirect) && !empty($El->redirect)){
					$vars['redirect'] = $El->redirect;
				}
				if(isset($El->ajaxData) && !empty($El->ajaxData)){
					$vars['data'] = $El->ajaxData;
				}
				unset($_SESSION['el_messages']);
				if(!empty($vars)){
					echo json_encode($vars);
				}
			}
        }
    } else {
        el_error_page();
    }
}