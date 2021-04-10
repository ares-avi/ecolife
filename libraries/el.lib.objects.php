<?php

 
/**
 * El get object
 *
 * @param int $guid Guid of object
 *
 * @return object
 */
function el_get_object($guid){
	if(!empty($guid)){
		$object = new ElObject;
		$search = $object->searchObject(array(
			'wheres'=> "o.guid='{$guid}'",
			'offset' => 1
		));
		if($search && isset($search[0]->guid)){
			return $search[0];
		}
	}
	return false;
}
/**
 * Get entities of object
 *
 * @param object $object Must be valid object
 * @param array $params Options
 *
 * @return object
 */
function el_get_object_entities($object, $params = array()){
	if(isset($object->guid)){
		$vars['owner_guid'] = $object->guid;
		$vars['type'] = 'object';
		$vars = array_merge($vars, $params);
		
		return el_get_entities($vars);	
	}
	return false;
}
/**
 * Get objects
 *
 * @param array $params Options
 * @param int $params['owner_guid'] object owner guid
 * @param string $params['type'] object type
 * @param string $params['subtype'] object subtype
 * @param string $params['limit'] limit of fetch data
 * @param string $params['order_by'] order fetch data
 *
 * @return object
 */
function el_get_objects(array $params){		
		$object = new ElObject;
		return $object->searchObject($params);
}
/**
 * Get objects by type
 *
 * @param array $params Options
 * @param string $params['type'] object type
 * @param string $params['subtype'] object subtype
 * @param string $params['limit'] limit of fetch data
 * @param string $params['order_by'] order fetch data
 *
 * @return object
 */
function el_get_objects_by_type(array $params){
	return el_get_objects($params);
}
