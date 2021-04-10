<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
header('Content-Type: application/json');
$pos = new elProfile;
if ($pos->repositionCOVER(el_loggedin_user()->guid, input('top'), input('left'))) {
    $params = $pos->coverParameters(el_loggedin_user()->guid);
    echo json_encode(array(
            'top' => $params[0],
            'left' => $params[1]
        ));
    exit;
}
