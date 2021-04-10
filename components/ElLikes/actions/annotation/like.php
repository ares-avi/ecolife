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
$anotation = input('annotation');
$reaction_type = input('reaction_type');

if ($elLikes->Like($anotation, el_loggedin_user()->guid, 'annotation', $reaction_type)) {
    if (!el_is_xhr()) {
        redirect(REF);
    } else {
		$likes_container = el_plugin_view('likes/annotation/likes', array(
					'annotation_id' => $anotation,																	
		));			
        header('Content-Type: application/json');
        echo json_encode(array(
                'done' => 1,
				'container' => $likes_container,
        ));
	exit;
    }
} else {
    if (!el_is_xhr()) {
        redirect(REF);
    } else {
		$likes_container = el_plugin_view('likes/annotation/likes', array(
					'annotation_id' => $anotation,																	
		));					
        header('Content-Type: application/json');
        echo json_encode(array(
                'done' => 0,
				'container' => $likes_container,
        ));
	exit;
    }
}
