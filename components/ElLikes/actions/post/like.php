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
$elLikes = new elLikes;
$anotation = input('post');
$entity = input('entity');
$reaction_type = input('reaction_type');

if (!empty($anotation)) {
    $subject = $anotation;
    $type = 'post';
}
if (!empty($entity)) {
    $subject = $entity;
    $type = 'entity';

}
if ($elLikes->Like($subject, el_loggedin_user()->guid, $type, $reaction_type)) {
    if (!el_is_xhr()) {
        redirect(REF);
    } else {
		if($type == 'entity'){
			$likes_container = el_plugin_view('likes/post/likes_entity', array(
					'entity_guid' => $subject,														  
			));	
		}
		if($type == 'post'){
			$object = new stdClass;
			$object->guid = $subject;
			$likes_container = el_plugin_view('likes/post/likes', $object);	
		}		
        header('Content-Type: application/json');
        echo json_encode(array(
                'done' => 1,
				'container' => $likes_container,
                'button' => el_print('el:unlike'),
        ));
    }
} else {
    if (!el_is_xhr()) {
        redirect(REF);
    } else {
        header('Content-Type: application/json');
        echo json_encode(array(
                'done' => 0,
				'container' => false,
                'button' => el_print('el:like'),
            ));
    }
}
exit;
