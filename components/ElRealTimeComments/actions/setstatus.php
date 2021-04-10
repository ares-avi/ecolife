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
$guid    = input('guid');
$type    = input('type');

$RealTimeComments = new RealTimeComments;
header('Content-Type: application/json');
if($type == 'entity' && !el_get_entity($guid)){
			echo json_encode(array(
					'status' => 0,					   
			));		
			exit;
}
if($type == 'post' && !el_get_object($guid)){
			echo json_encode(array(
					'status' => 0,					   
			));		
			exit;	
}
if($RealTimeComments->setStatus($guid, $type)){
			echo json_encode(array(
					'status' => 1,					   
			));
			exit;
}	else {
			echo json_encode(array(
					'status' => 0,					   
			));	
			exit;
}
