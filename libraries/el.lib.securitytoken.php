<?php
/*
 * Generate token using timestamp
 * 
 * @param array $timestamp current timestamp
 * @return string
 */ 
function el_generate_action_token($timestamp){
	if(!isset($timestamp) && empty($timestamp)){
		$timestamp = time();
	}
	$site_secret = el_site_settings('site_key');
	$session_id = session_id();
	$user_guid  = el_loggedin_user()->guid;
	return md5($timestamp . $site_secret . $session_id . $user_guid);
}
/**
 * Build url from parts
 * 
 * @param array $parts	Url parts
 * @return string
 */
function el_build_token_url($parts){
	$scheme = isset($parts['scheme']) ? "{$parts['scheme']}://" : '';
	$host = isset($parts['host']) ? "{$parts['host']}" : '';
	$port = isset($parts['port']) ? ":{$parts['port']}" : '';
	$path = isset($parts['path']) ? "{$parts['path']}" : '';
	$query = isset($parts['query']) ? "?{$parts['query']}" : '';
   
	$string = $scheme . $host . $port . $path . $query;
	return $string;
}
/**
 * Add action tokens to url
 * 
 * @param string $url	Full complete url
 * 
 * @return string
 *
 * This file contain code from other project
 *
 * See licenses/elgg/LICENSE.txt 
 */
function el_add_tokens_to_url($url){
	$params = parse_url($url);
	
	$query = array();
	if(isset($params['query'])){
		parse_str($params['query'],  $query);
	}
	$tokens['el_ts'] = time();
	$tokens['el_token'] = el_generate_action_token($tokens['el_ts']);
	$tokens = array_merge($query, $tokens);
	
	$query = http_build_query($tokens);
	
	$params['query'] = $query;
	return  el_build_token_url($params);	
}
/**
 * Validate given tokens
 *
 * @return (bool)
 */
function el_validate_actions(){
	$elts = input('el_ts');
	$eltoken = input('el_token');
	if(empty($elts) || empty($eltoken)){
		return false;
	}
	$generate = el_generate_action_token($elts);
	if($eltoken == $generate){
		return true;
	}
	return false;
}
/**
 * Validate an action token on requested action.
 *
 * Calls to actions will automatically validate tokens. If token is invalid
 * the action stops and user will be redirected with warning of invalid token.
 *
 * @param string $callback	Name of callback
 * @param string $type	Type of callback
 * @param array $params
 *
 * @access private
 * @return void
 */
function el_action_validate_callback($callback, $type, $params){
	$action = $params['action'];
	$bypass = array();
	$bypass = el_call_hook('action', 'validate:bypass', null, $bypass);
	
	//validate post request also
	el_post_size_exceed_error();
	
	if(!in_array($action, $bypass)){
		if(!el_validate_actions()){
			if(el_is_xhr()){
				header("HTTP/1.0 404 Not Found");
				exit;
			} else {
				el_trigger_message(el_print('el:securitytoken:failed'), 'error');
				redirect(REF);
			}
		}
	}
	
}
el_register_callback('action', 'load', 'el_action_validate_callback');
