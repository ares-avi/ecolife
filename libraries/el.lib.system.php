<?php
/*
 * EL ACCESS VALUES
 */
define('EL_FRIENDS', 3);
define('EL_PUBLIC', 2);
define('EL_PRIVATE', 1);
define('EL_POW', 'XQIIlW1dqHT35WJD28RkCYPZfVs3uyJjWOQRFcywfic');
define('EL_LNK', 'JB8tHVp+68D2HxVzxvE+B9qnMqriue4toCsGuOgF1P4h4aobZb45twBYU18uKo04n6VohKlpG0ZNKJor9XrTqQ');
/**
 * Constants
 */
define('REF', true);
/*
 * Load site settings , so the setting should not load agian and again
 */
global $El;
$settings           = new ElSite;
$El->siteSettings = $settings->getAllSettings();

/*
 * Set exceptions handler 
 */
set_exception_handler('_el_exception_handler');
/**
 * el_recursive_array_search 
 * Searches the array for a given value and returns the corresponding key if successful
 * @source: http://php.net/manual/en/function.array-search.php
 * 
 * @param mixed $needle The searched value. If needle is a string, the comparison is done in a case-sensitive manner.
 * @param array $haystack The array
 * @return false|integer
 */
function el_recursive_array_search($needle, $haystack) {
	foreach ($haystack as $key => $value) {
		$current_key = $key;
		if (($needle === $value) || (is_array($value) && el_recursive_array_search($needle, $value))) {
			return $current_key;
		}
	}
	return false;
}
/**
 * Get site url
 *
 * @params $extend =>  Extned site url like http://site.com/my/extended/path
 *
 * @return string
 */
function el_site_url($extend = '', $action = false) {
	global $El;
	$siteurl = "{$El->url}{$extend}";
	if ($action === true) {
		$siteurl = el_add_tokens_to_url($siteurl);
	}
	return $siteurl;
}

/**
 * Get data directory contaning user and system files
 *
 * @params $extend =>  Extned data directory path like /home/htdocs/userdata/my/extend/path
 *
 * @return string
 */
function el_get_userdata($extend = '') {
	global $El;
	return "{$El->userdata}{$extend}";
}

/**
 * Get database settings
 *
 * @return object
 */
function el_database_settings() {
	global $El;
	if (!isset($El->port)) {
		$El->port = false;
	}
	$defaults = array(
		'host' => $El->host,
		'port' => $El->port,
		'user' => $El->user,
		'password' => $El->password,
		'database' => $El->database
	);
	return arrayObject($defaults);
}

/**
 * Get version package file
 *
 * @return SimpleXMLElement
 */
function el_package_information() {
	return simplexml_load_file(el_route()->www . 'opensource-socialnetwork.xml');
}

/**
 * Add a hook to system, hooks are usefull for callback returns
 *
 * @param string $hook The name of the hook
 * @param string $type The type of the hook
 * @param callable $callback The name of a valid function or an array with object and method
 * @param int $priority The priority - 500 is default, lower numbers called first
 *
 * @return bool
 *
 * This part is contain code from project called Elgg 
 * 
 * See licenses/elgg/LICENSE.txt
 */
function el_add_hook($hook, $type, $callback, $priority = 200) {
	global $El;
	
	if (empty($hook) || empty($type)) {
		return false;
	}
	
	if (!isset($El->hooks)) {
		$El->hooks = array();
	}
	if (!isset($El->hooks[$hook])) {
		$El->hooks[$hook] = array();
	}
	if (!isset($El->hooks[$hook][$type])) {
		$El->hooks[$hook][$type] = array();
	}
	
	if (!is_callable($callback, true)) {
		return false;
	}
	
	$priority = max((int) $priority, 0);
	
	while (isset($El->hooks[$hook][$type][$priority])) {
		$priority++;
	}
	$El->hooks[$hook][$type][$priority] = $callback;
	ksort($El->hooks[$hook][$type]);
	return true;
	
}
/**
 * Unset a hook to system, hooks are usefull for callback returns
 *
 * @param string $hook The name of the hook
 * @param string $type The type of the hook
 * @param callable $callback The name of a valid function or an array with object and method
 *
 * @return bool
 * 
 */
function el_unset_hook($hook, $type, $callback) {
	global $El;
	
	if (empty($hook) || empty($type) || empty($callback)) {
		return false;
	}
	
	if (el_is_hook($hook, $type)) {
		$search = array_search($callback, $El->hooks[$hook][$type]);
		if (isset($search)) {
			unset($El->hooks[$hook][$type][$search]);
			return true;
		}
	}
	return false;
}
/**
 * Check if the hook exists or not
 *
 * @param string $hook The name of the hook
 * @param string $type The type of the hook
 *
 * @return bool
 */
function el_is_hook($hook, $type) {
	global $El;
	if (isset($El->hooks[$hook][$type])) {
		return true;
	}
	return false;
}

/**
 * Call a hook
 *
 * @param string $hook The name of the hook
 * @param string $type The type of the hook
 * @param mixed $params Additional parameters to pass to the handlers
 * @param mixed $returnvalue An initial return value
 *
 * @return mix data
 */
function el_call_hook($hook, $type, $params = null, $returnvalue = null) {
	global $El;
	$hooks = array();
	if (isset($El->hooks[$hook][$type])) {
		$hooks[] = $El->hooks[$hook][$type];
	}
	foreach ($hooks as $callback_list) {
		if (is_array($callback_list)) {
			foreach ($callback_list as $hookcallback) {
				if (is_callable($hookcallback)) {
					$args              = array(
						$hook,
						$type,
						$returnvalue,
						$params
					);
					$temp_return_value = call_user_func_array($hookcallback, $args);
					if (!is_null($temp_return_value)) {
						$returnvalue = $temp_return_value;
					}
				}
			}
		}
	}
	
	return $returnvalue;
}

/**
 * Trigger a callback
 *
 * @param string $event Callback event name
 * @param string $type The type of the callback
 * @param mixed $params Additional parameters to pass to the handlers
 *
 * @return bool
 */
function el_trigger_callback($event, $type, $params = null) {
	global $El;
	$events = array();
	if (isset($El->events[$event][$type])) {
		$events[] = $El->events[$event][$type];
	}
	foreach ($events as $callback_list) {
		if (is_array($callback_list)) {
			foreach ($callback_list as $eventcallback) {
				$args = array(
					$event,
					$type,
					$params
				);
				if (is_callable($eventcallback) && (call_user_func_array($eventcallback, $args) === false)) {
					return false;
				}
			}
		}
	}
	
	return true;
}

/**
 * Register a callback
 *
 * @param string $event Callback event name
 * @param string $type The type of the callback
 * @params $priority callback priority
 * @param string $callback
 *
 * @return bool
 */
function el_register_callback($event, $type, $callback, $priority = 200) {
	global $El;
	
	if (empty($event) || empty($type)) {
		return false;
	}
	
	if (!isset($El->events)) {
		$El->events = array();
	}
	if (!isset($El->events[$event])) {
		$El->events[$event] = array();
	}
	if (!isset($El->events[$event][$type])) {
		$El->events[$event][$type] = array();
	}
	
	if (!is_callable($callback, true)) {
		return false;
	}
	
	$priority = max((int) $priority, 0);
	
	while (isset($El->events[$event][$type][$priority])) {
		$priority++;
	}
	$El->events[$event][$type][$priority] = $callback;
	ksort($El->events[$event][$type]);
	return true;
	
}
/**
 * Unset a callback
 *
 * @param string $event Callback event name
 * @param string $type The type of the callback
 * @param string $callback
 *
 * @return bool
 */
function el_unset_callback($event, $type, $callback) {
	global $El;
	
	if (empty($event) || empty($type) || empty($callback)) {
		return false;
	}
	
	if (isset($El->events[$event][$type])) {
		$search = array_search($callback, $El->events[$event][$type]);
		if (isset($search)) {
			unset($El->events[$event][$type][$search]);
			return true;
		}
	}
	return false;
}
/**
 * Get a site settings
 *

 * @param string $setting Settings Name like (site_name, language)
 *
 * @return string or null
 */
function el_site_settings($setting) {
	global $El;
	if (isset($El->siteSettings->$setting)) {
		//allow to override a settings
		return el_call_hook('load:settings', $setting, false, $El->siteSettings->$setting);
	}
	return false;
}
/**
 * Redirect a user to specific external url
 *
 * @param string $new uri of page
 *
 * @return boolean|void
 */
function redirect_external($url = '') {
	global $El;
	if (empty($url)) {
		return false;
	}
	if (el_is_xhr()) {
		$El->redirect = $url;
	} else {
		header("Location: {$url}");
		exit;
	}
}
/**
 * Redirect a user to specific url
 *
 * @param string $new uri of page. If it is REF then user redirected to the url that user just came from.
 *
 * @return return
 */
function redirect($new = '') {
	global $El;
	$url = el_site_url($new);
	if ($new === REF) {
		if (isset($_SERVER['HTTP_REFERER'])) {
			$url = $_SERVER['HTTP_REFERER'];
		} else {
			$url = el_site_url();
		}
	}
	if (el_is_xhr()) {
		$El->redirect = $url;
	} else {
		header("Location: {$url}");
		exit;
	}
}

/**
 * Get default access types
 *
 * @return integer[]
 */
function el_access_types() {
	return array(
		EL_FRIENDS,
		EL_PUBLIC,
		EL_PRIVATE
	);
}

/**
 * Validate Access
 *
 * @return bool
 */
function el_access_validate($access, $owner) {
	if ($access == EL_FRIENDS) {
		if (el_user_is_friend($owner, el_loggedin_user()->guid) || el_loggedin_user()->guid == $owner) {
			return true;
		}
	}
	if ($access == EL_PUBLIC) {
		return true;
	}
	return false;
}

/**
 * Check if the request is ajax or not
 *
 * @return bool
 */
function el_is_xhr() {
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
		return true;
	}
	return false;
}

/**
 * Serialize Array
 * This starts array from key 1
 * Don't use this for multidemension arrays
 *
 * @return array
 */
function arraySerialize($array = NULL) {
	if (isset($array) && !empty($array)) {
		array_unshift($array, "");
		unset($array[0]);
		return $array;
	}
}

/**
 * Limit a words in a string
 * @params $str = string;
 * @params $limit = words limit;
 * @param integer $limit
 *
 * @last edit: $arsalanshah
 * @return bool
 */
function strl($str, $limit = NULL, $dots = true) {
	if (isset($str) && isset($limit)) {
		if (strlen($str) > $limit) {
			if ($dots == true) {
				return substr($str, 0, $limit) . '...';
			} elseif ($dots == false) {
				return substr($str, 0, $limit);
			}
		} elseif (strlen($str) <= $limit) {
			return $str;
		}
		
	}
	return false;
}

/**
 * Update site settings
 *
 * @params $name => settings name
 *         $value => new value
 *         $id  =>  $settings name
 *
 * @todo remove $id and update without having $id as settings names must be unique
 * @return bool
 */
function el_site_setting_update($name, $value, $id) {
	$settings = new ElSite;
	if ($settings->UpdateSettings(array(
		'value'
	), array(
		$value
	), array(
		"setting_id='{$id}'"
	))) {
		return true;
	}
	return false;
}

/**
 * Add a system messages for users
 *
 * @params $messages => Message for user
 *         $type = message type
 *         $for  =>  for site/frontend or admin/backend
 *         $count => count the message
 *
 * @return bool
 */
function el_system_message_add($message = null, $register = "success", $count = false) {
	if (!isset($_SESSION['el_messages'])) {
		$_SESSION['el_messages'] = array();
	}
	if (!isset($_SESSION['el_messages'][$register]) && !empty($register)) {
		$_SESSION['el_messages'][$register] = array();
	}
	if (!$count) {
		if (!empty($message) && is_array($message)) {
			$_SESSION['el_messages'][$register] = array_merge($_SESSION['el_messages'][$register], $message);
			return true;
		} else if (!empty($message) && is_string($message)) {
			$_SESSION['el_messages'][$register][] = $message;
			return true;
		} else if (is_null($message)) {
			if ($register != "") {
				$returnarray                          = array();
				$returnarray[$register]               = $_SESSION['el_messages'][$register];
				$_SESSION['el_messages'][$register] = array();
			} else {
				$returnarray               = $_SESSION['el_messages'];
				$_SESSION['el_messages'] = array();
			}
			return $returnarray;
		}
	} else {
		if (!empty($register)) {
			return sizeof($_SESSION['el_messages'][$register]);
		} else {
			$count = 0;
			foreach ($_SESSION['el_messages'] as $submessages) {
				$count += sizeof($submessages);
			}
			return $count;
		}
	}
	return false;
}

/**
 * Add a system messages for users
 *
 * @params $messages => Message for user
 *         $type = message type
 *
 * @return void
 */
function el_trigger_message($message, $type = 'success') {
	if ($type == 'error') {
		el_system_message_add($message, 'danger');
	}
	if ($type == 'success') {
		el_system_message_add($message, 'success');
	}
}
/**
 * Display a error if post size exceed
 * 
 * @param string $error Langauge string
 * @param string $redirect Custom redirect url
 */
function el_post_size_exceed_error($error = 'el:post:size:exceed', $redirect = null) {
	if (!empty($_SERVER['CONTENT_LENGTH']) && empty($_POST)) {
		if (empty($redirect)) {
			$redirect = null;
		}
		el_trigger_message(el_print($error), 'error');
		redirect($redirect);
	}
}
/**
 * Display a system messages
 *
 * @params  $for  =>  for site/frontend or admin/backend
 *
 * @return string|null data
 */
function el_display_system_messages() {
	if (isset($_SESSION['el_messages'])) {
		$dermessage = $_SESSION['el_messages'];
		if (!empty($dermessage)) {
			
			if (isset($dermessage) && is_array($dermessage) && sizeof($dermessage) > 0) {
				foreach ($dermessage as $type => $list) {
					foreach ($list as $message) {
						$m = "<div class='alert alert-$type'>";
						$m .= '<a href="#" class="close" data-dismiss="alert">&times;</a>';
						$m .= $message;
						$m .= '</div>';
						$ms[] = $m;
						unset($_SESSION['el_messages'][$type]);
					}
				}
			}
			
		}
		
	}
	if (isset($ms) && is_array($ms)) {
		return implode('', $ms);
	}
}

/**
 * Count total themes
 *
 * @return (int)
 */
function el_site_total_themes() {
	$themes = new ElThemes;
	return $themes->total();
}

/**
 * Validate filepath , add backslash to end of path
 *
 * @param string $path
 * @return string;
 */
function el_validate_filepath($path, $append_slash = TRUE) {
	$path = str_replace('\\', '/', $path);
	$path = str_replace('../', '/', $path);
	
	$path = preg_replace("/([^:])\/\//", "$1/", $path);
	$path = trim($path);
	$path = rtrim($path, " \n\t\0\x0B/");
	
	if ($append_slash) {
		$path = $path . '/';
	}
	
	return $path;
}

/**
 * Output El Error page
 *
 * @return mix data
 */
function el_error_page() {
	if (el_is_xhr()) {
		header("HTTP/1.0 404 Not Found");
	} else {
		$title                  = el_print('page:error');
		$contents['content']    = el_plugin_view('pages/contents/error');
		$contents['background'] = false;
		$content                = el_set_page_layout('contents', $contents);
		$data                   = el_view_page($title, $content);
		echo $data;
	}
	exit;
}

/**
 * Acces id to string
 *
 * @return string
 */
function el_access_id_str($id) {
	$access = array(
		'3' => 'friends',
		'2' => 'public',
		'1' => 'private'
	);
	if (isset($access[$id])) {
		return $access[$id];
	}
	return false;
}

/**
 * Check if loggedin is friend with item owner or if owner is loggedin user;
 *
 * @return bool;
 */
function el_validate_access_friends($owner) {
	if (el_user_is_friend(el_loggedin_user()->guid, $owner) || el_loggedin_user()->guid == $owner || el_isAdminLoggedin()) {
		return true;
	}
	return false;
}
/**
 * El padding of key if its less then 16 bytes
 *
 * @param string $key key for decode
 *
 * @return string|boolean
 */
function el_string_encrypt_key_cycled($key = "") {
	if(empty($key)) {
		return false;
	}
	$required_length = 16;
	//[B]PHP 7.4 pseudo_bytes throws warning | migration from bow-fish #1673
	// Move from bf-ecb to aes
	// key must be 128 bits
	$keylen    = mb_strlen($key, 'utf-8');
	if($keylen < $required_length){ //lets say we need to generate 16 bytes / 128bits
		$ceil = ceil($required_length / $keylen);
		$key  = str_repeat($key, $ceil);
	}
	return substr($key, 0, $required_length); 
	//key cycling and truncating end 	
}
/**
 * El encrypt string
 *
 * @param string $string a string you want to decrypt
 * @param string $key key for decode
 *
 * @return string|boolean
 */
function el_string_encrypt($string = '', $key = '') {
	if (empty($string)) {
		return false;
	}
	if(empty($key)) {
		$key = el_site_settings('site_key');
	}
	//[B]PHP 7.4 pseudo_bytes throws warning | migration from bow-fish #1673
	// Move from bf-ecb to aes	
	$key    = el_string_encrypt_key_cycled($key);
	$size    = openssl_cipher_iv_length('aes-128-cbc');
	$mcgetvi = openssl_random_pseudo_bytes($size);
	
	return $mcgetvi.openssl_encrypt($string, "aes-128-cbc", $key, OPENSSL_RAW_DATA, $mcgetvi);	
}

/**
 * El decrypt string
 *
 * @param string $string a string you want to decrypt
 * @param string $key key for decode
 *
 * @return string|boolean
 */
function el_string_decrypt($string = '', $key = '') {
	if (empty($string)) {
		return false;
	}
	if (empty($key)) {
		$key = el_site_settings('site_key');
	}
	//[B]PHP 7.4 pseudo_bytes throws warning | migration from bow-fish #1673
	// Move from bf-ecb to aes
	$key 	 = el_string_encrypt_key_cycled($key);	
	$size    = openssl_cipher_iv_length('aes-128-cbc');
	$mcgetvi = substr($string, 0, $size);
	$string  = substr($string, $size);
	//padding is removed you may still use trim if you getting some padding at start or end
	return openssl_decrypt($string, "aes-128-cbc", $key, OPENSSL_RAW_DATA, $mcgetvi);
}
/**
 * El php display erros settings
 *
 * @return (void);
 * @access pritvate;
 */
function el_errros() {
	$settings = el_site_settings('display_errors');
	if ($settings == 'on' || is_file(el_route()->www . 'DISPLAY_ERRORS')) {
		error_reporting(E_NOTICE ^ ~E_WARNING);
		
		ini_set('log_errors', 1);
		ini_set('error_log', el_route()->www . 'error_log');
		
		set_error_handler('_el_php_error_handler');
	} elseif ($settings !== 'on') {
		ini_set("log_errors", 0);
		ini_set('display_errors', 'off');
	}
}
/**
 * Intercepts catchable PHP errors.
 *
 * @warning This function should never be called directly.
 *
 * @internal
 * For catchable fatal errors, throws an Exception with the error.
 *
 * For non-fatal errors, depending upon the debug settings, either
 * log the error or ignore it.
 *
 * @see http://www.php.net/set-error-handler
 *
 * @param int    $errno    The level of the error raised
 * @param string $errmsg   The error message
 * @param string $filename The filename the error was raised in
 * @param int    $linenum  The line number the error was raised at
 * @param array  $vars     An array that points to the active symbol table where error occurred
 *
 * @return boolean
 * @throws Exception
 * @access private
 */
function _el_php_error_handler($errno, $errmsg, $filename, $linenum, $vars) {
	$error = date("Y-m-d H:i:s (T)") . ": \"$errmsg\" in file $filename (line $linenum)";
	switch ($errno) {
		case E_USER_ERROR:
			error_log("PHP ERROR: $error");
			el_trigger_message("ERROR: $error", 'error');
			
			// Since this is a fatal error, we want to stop any further execution but do so gracefully.
			throw new Exception($error);
			break;
		
		case E_WARNING:
		case E_USER_WARNING:
		case E_RECOVERABLE_ERROR: // (e.g. type hint violation)
			
			// check if the error wasn't suppressed by the error control operator (@)
			if (error_reporting()) {
				error_log("PHP WARNING: $error");
			}
			break;
		
		default:
			global $El;
			if (isset($El->DebugNotice) && $El->DebugNotice == true) {
				error_log("PHP NOTICE: $error");
			}
	}
	
	return true;
}
/**
 * Check el update version
 *
 * @return (bool);
 * @access public;
 */
function el_check_update() {
	$url             = 'https://api.github.com/repos/opensource-socialnetwork/opensource-socialnetwork/contents/opensource-socialnetwork.xml';
	$args['method']  = 'GET';
	$args['header']  = "Accept-language: en\r\n" . "Cookie: opensourcesocialnetwork=system\r\n" . "User-Agent: Mozilla/5.0\r\n";
	$options['http'] = $args;
	$context = stream_context_create($options);
	$file    = file_get_contents($url, false, $context);
	$data    = json_decode($file);
	$file    = simplexml_load_string(base64_decode($data->content));
	if (!empty($file->stable_version)) {
		if(el_site_settings('site_version') < $file->stable_version) {
			return el_print('el:version:avaialbe', $file->stable_version);
		} else {
			return el_print('el:version:avaialbe', '---');
		}
	}
	return el_print('el:update:check:error');
}
/**
 * Add exception handler
 *
 * @return (html);
 * @access public;
 */
function _el_exception_handler($exception){
	$time	= time();
	$session_id = session_id();
	
	$params['exception'] = $exception;
	$params['time'] = $time;
	$params['session_id'] = '';
	if($session_id){
		$params['session_id'] = strtoupper($session_id);
	}	
	//[E] Improve Error Reporting 
	//support at least exception message  #1014
	error_log("[#{$time}|{$params['session_id']}] ".$params['exception']);
	echo el_view('system/handlers/errors', $params);
}
/**
 * Set Ajax Data
 * Use only in action files
 *
 * @param array $data A data array
 *
 * @return void
 */
function el_set_ajax_data(array $data = array()) {
	global $El;
	if (el_is_xhr()) {
		$El->ajaxData = $data;
	}
}
/**
 * Generate .htaccess file
 *
 * @return ooolean;
 */
function el_generate_server_config($type) {
	if ($type == 'apache') {
		$file = el_route()->www . 'installation/configs/htaccess.dist';
		$file = file_get_contents($file);
		return file_put_contents(el_route()->www . '.htaccess', $file);
	} elseif ($type == 'nginx') {
		return false;
	}
	return false;
}
/**
 * El Dump
 * 
 * Dump a variable
 *
 * @param array}object}string}integer}boolean $param A variable you wanted to dump.
 *
 * @return string
 */
function el_dump($params = '', $clean = true) {
	if (!empty($params)) {
		ob_start();
		echo "<pre>";
		if ($clean === true) {
			print_r($params);
		} elseif ($clean === false) {
			var_dump($params);
		}
		echo "</pre>";
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	return false;
}
/**
 * El validate offset
 *
 * @return void
 */
function el_offset_validate() {
	//pagination offset should be better protected #627
	$offset = input('offset');
	if (!ctype_digit($offset)) {
		unset($_REQUEST['offset']);
	}
}
el_errros();
el_register_callback('el', 'init', 'el_offset_validate');
el_register_callback('el', 'init', 'el_system');
