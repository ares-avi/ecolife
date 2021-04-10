<?php

/**
 * El Installation Url
 * Get a installation path url
 *
 * @return string
 */
function el_installation_url() {
    $type = true;
    $protocol = 'http';
    $uri = $_SERVER['REQUEST_URI'];
    if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $protocol = 'https';
    }
    $port = ':' . $_SERVER["SERVER_PORT"];
    if ($port == ':80' || $port == ':443') {
        if ($type == true) {
            $port = '';
        }
    }
    $url = "$protocol://{$_SERVER['SERVER_NAME']}$port{$uri}";
    return preg_replace('/\\?.*/', '', $url);
}
/**
 * El Url
 * Get a root url
 *
 * @return string
 */
function el_url() {
    return str_replace('installation/', '', el_installation_url());
}
/**

 *
 * @return object
 */
 function el_installation_paths() {
    global $ElInstall;
    $path = str_replace("\\", "/", dirname(dirname(__FILE__)));
    $defaults = array(
        'root' => "{$path}/",
        'url' => el_installation_url(),
        'el_url' => el_url(),

    );
    foreach ($defaults as $name => $value){
        if (empty($ElInstall->$name)) {
            $ElInstall->$name = $value;
       } 
    }
    return $ElInstall;
}
/**
 * El Instalaltion Include
 * Include a file 
 *
 * @return string|null data
 */
function el_installation_include($file = '', $params = array()) {
    $file = el_installation_paths()->root . $file;
    if (!empty($file) && is_file($file)) {
        ob_start();
        $params = $params;
        include($file);
        $contents = ob_get_clean();
        return $contents;
    }

}
/**
 * El Installation Register Languages
 * Register a labguages need for installation
 *
 * @return void
 */
function el_installation_register_languages($strings = array()) {
    global $ElInstall;
    $ElInstall->langStrings = $strings;
}
/**
 * El load a installation language
 *
 * @return arrays
 */
function el_installation_languages() {
    include_once(el_installation_paths()->root . 'locales/el.en.php');
}
el_installation_languages();
/**
 * El print language string
 *
 * @return string
 */
function el_installation_print($string) {
    global $ElInstall;
    if (isset($ElInstall->langStrings[$string])) {
        return $ElInstall->langStrings[$string];
    } else {
        return $string;
    }
}
/**
 * El view instalaltion page
 *
 * @param string|null $content
 * @param string $title
 * @return string|null
 */
function el_installation_view_page($content, $title) {
    return el_installation_include("templates/page.php", array(
        'contents' => $content,
        'title' => el_installation_print($title),
    ));
}
/**
 * Handle insallation pages
 *
 * @return mixed data
 */
function el_installation_page() {
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    }
    if (!isset($page)) {
        $page = 'requirments';
    }
    switch ($page) {
        case 'requirments':
            $data = el_installation_include('pages/check.php');
            echo el_installation_view_page($data, 'el:check');
            break;
        case 'license':
            $data = el_installation_include('pages/license.php');
            echo el_installation_view_page($data, 'el:check');
            break;
        case 'settings':
            $data = el_installation_include('pages/settings.php');
            echo el_installation_view_page($data, 'el:settings');
            break;
        case 'account':
            $data = el_installation_include('pages/account.php');
            echo el_installation_view_page($data, 'el:setting:account');
            break;
        case 'installed':
            $data = el_installation_include('pages/installed.php');
            echo el_installation_view_page($data, 'el:installed');
            break;
    }
}
/**
 * Handle insallation actions
 *
 * @return false|null data
 */
function el_installation_actions() {
    if (isset($_REQUEST['action'])) {
        $page = $_REQUEST['action'];
    }
    if (!isset($page)) {
        return false;
    }
    switch ($page) {
        case 'install':
            include_once(el_installation_paths()->root . 'actions/install.php');
            break;
        case 'account':
            include_once(el_installation_paths()->root . 'actions/account.php');
            break;
        case 'finish':
            include_once(el_installation_paths()->root . 'actions/finish.php');
            break;
    }
}
/**
 * Handle insallation error massages
 *
 * @return void
 */
function el_installation_message($message, $type) {
    $_SESSION['el-installation-messages']["el-installation-{$type}"][] = $message;
}
/**
 * View installation error messages
 *
 * @return false|string data
 */
function el_installation_messages() {
    if (!isset($_SESSION['el-installation-messages'])) {
        return false;
    }
    foreach ($_SESSION['el-installation-messages'] as $message => $data) {
        foreach ($data as $msg) {
            $msgs[] = "<div class='el-installation-message {$message}'>{$msg}</div>";
        }
    }
    unset($_SESSION['el-installation-messages']);
    return implode('', $msgs);
}
/**
 * Simple curl, get content of url
 *
 * @return mixed data
 */
function el_installation_simple_curl($url = '') {	
if(isset($url)){
	$curlinit = curl_init();
	curl_setopt($curlinit, CURLOPT_URL, $url);
	curl_setopt($curlinit, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curlinit);
	curl_close($curlinit);
}
return $result;
}
/**
 * Generate .htaccess file
 *
 * @return ooolean;
 */
/**function el_generate_server_config_setup($type){
 *	if($type == 'apache'){
 *		$path = str_replace('installation/', '', el_installation_paths()->root);
 *		$file = el_installation_paths()->root . 'configs/htaccess.dist';
 * 		$file = file_get_contents($file);
 *		return file_put_contents($path . '.htaccess', $file);
 *	}elseif($type == 'nginx'){
 *		return false;
 *	}
 *	return false;
}
 */