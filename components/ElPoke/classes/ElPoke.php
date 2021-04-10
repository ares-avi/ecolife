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
class elPoke extends elDatabase {
    /**
     * Add poke
     *
     * @params $poker guid of user who is trying to poke
     *         $owner guid of user who is going to be poked
     *
     * @return bool;
     * @access public;
     */
    public function addPoke($poker, $owner) {
        /*
        * Check if user is blocked or not
        */
        if (com_is_active('elBlock')) {
            $user = el_user_by_guid($owner);
            if (elBlock::UserBlockCheck($user)) {
                return false;
            }
        }
        /*
        * Send notification
        */
        $type = 'elpoke:poke';
        $params['into'] = 'el_notifications';
        $params['names'] = array(
            'type',
            'poster_guid',
            'owner_guid',
            'subject_guid',
            'item_guid',
            'time_created'
        );
        $params['values'] = array(
            $type,
            $poker,
            $owner,
            0,
            0,
            time()
        );
        if ($this->insert($params)) {
            return true;
        }
        return false;
    }

}
