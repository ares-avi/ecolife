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
echo '<div class="comments-likes">';
if (el_is_hook('post', 'likes:entity')) {
    $entity['entity_guid'] = $params['entity_guid'];
    echo el_call_hook('post', 'likes:entity', $entity);
}
if (el_is_hook('post', 'comments:entity')) {
    $entity['entity_guid'] = $params['entity_guid'];
    echo el_call_hook('post', 'comments:entity', $entity);
}
echo '</div>';