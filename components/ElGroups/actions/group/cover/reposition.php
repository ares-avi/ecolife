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
$group = el_get_group_by_guid(input('group'));
if ($group->owner_guid !== el_loggedin_user()->guid && !el_isAdminLoggedin()) {
    exit;
}
if ($group->repositionCOVER($group->guid, input('top'), input('left'))) {
    $params = $group->coverParameters($group->guid);
    echo json_encode(array(
            'top' => $params[0],
            'left' => $params[1]
        ));
    exit;
}
