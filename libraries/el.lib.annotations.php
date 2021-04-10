<?php

 
/**
 * El get annotation
 *
 * @param int $guid Guid of annotation
 *
 * @return object
 */
function el_get_annotation($id){
	if(!empty($id)){
		$annotation = new ElAnnotation;
		$annotation->annotation_id = $id;
		$annotation = $annotation->getAnnotationById();
		if($annotation){
			return $annotation;
		}
	}
	return false;
} 
/**
 * Get entities of annotation
 *
 * @param object $annotation Must be valid annotation object
 * @param array $params Options
 *
 * @return object
 */
function el_get_annotation_entities($annotation, $params = array()){
	if(isset($annotation->id)){
		$vars['owner_guid'] = $annotation->id;
		$vars['type'] = 'annotation';
		$vars = array_merge($vars, $params);
		
		return el_get_entities($vars);	
	}
	return false;
}
/**
 * Get Annotations
 *
 * @param array $params Options
 * @param int $params['owner_guid'] annotation owner guid
 * @param string $params['type'] annotation type
 * @param string $params['subtype'] annotation subtype
 * @param string $params['limit'] limit of fetch data
 * @param string $params['order_by'] order fetch data
 *
 * @return object
 */
function el_get_annotations(array $params){
	$annotation = new ElAnnotation;
	return $annotation->searchAnnotation($params);
}
/**
 * Get annotations by types
 *
 * @param array $params Options
 * @param string $params['type'] object type
 * @param string $params['subtype'] object subtype
 * @param string $params['limit'] limit of fetch data
 * @param string $params['order_by'] order fetch data
 *
 * @return object
 */
function el_get_annotations_by_type(array $params){
	$annotation = new ElAnnotation;
	return $annotation->searchAnnotation($params);
}