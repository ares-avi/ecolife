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
if ($elLikes->UnLike($anotation, el_loggedin_user()->guid, 'annotation')) {
    if (!el_is_xhr()) {
        redirect(REF);
    } else {
		$likes_container = el_plugin_view('likes/annotation/likes', array(
					'annotation_id' => $anotation,																	
		));				
        header('Content-Type: application/json');
        echo json_encode(array(
                'done' => 1,
                'button' => el_print('like'),
				'container' => $likes_container,				
            ));
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
                'button' => el_print('unlike'),
				'container' => $likes_container,								
            ));
    }
}

exit;