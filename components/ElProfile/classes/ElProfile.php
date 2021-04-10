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
class elProfile extends elDatabase {
    /**
     * Reposition cover
     *
     * @params $guid: User guid
     *         $top : Position from top
     *         $left: Position from left
     *
     * @return bool;
     */
    public function repositionCOVER($guid, $top, $left) {
        $user = el_user_by_guid($guid);
        if (!isset($user->cover_position) && empty($user->cover_position)) {
            $position = array(
                $top,
                $left
            );
            $fields = new elEntities;
            $fields->owner_guid = $guid;
            $fields->type = 'user';
            $fields->subtype = 'cover_position';
            $fields->value = json_encode($position);
            if ($fields->add()) {
                return true;
            }
        } else {
            $this->statement("SELECT * FROM el_entities WHERE(
				             owner_guid='{$guid}' AND 
				             type='user' AND 
				             subtype='cover_position');");
            $this->execute();
            $entity = $this->fetch();
            $entity_id = $entity->guid;

            $position = array(
                $top,
                $left
            );
            $fields = new elEntities;
            $fields->owner_id = $guid;
            $fields->guid = $entity_id;
            $fields->type = 'user';

            $fields->subtype = 'cover_position';
            $fields->value = json_encode($position);
            if ($fields->updateEntity()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Reset cover back to it original position
     *
     * @params $guid: User guid
     *
     * @return bool;
     */
    public function ResetCoverPostition($guid) {
        $this->statement("SELECT * FROM el_entities WHERE(
				             owner_guid='{$guid}' AND 
				             type='user' AND 
				             subtype='cover_position');");
        $this->execute();
        $entity = $this->fetch();
        $position = array(
            '',
            ''
        );

        $fields = new elEntities;
        $fields->owner_id = $guid;
        $fields->guid = $entity->guid;
        $fields->type = 'user';

        $fields->subtype = 'cover_position';
        $fields->value = json_encode($position);
        if ($fields->updateEntity()) {
            return true;
        }
        return false;
    }

    /**
     * Get cover parameters
     *
     * @params $guid: User guid
     *
     * @return array;
     */
    public function coverParameters($guid) {
        $user = el_user_by_guid($guid);
        if (isset($user->cover_position)) {
            $parameters = $user->cover_position;
            return json_decode($parameters);
        }
        return false;
    }
    /**
     * Add a wall post for new profile/cover picture
     *
     * @param int $ownerguid = Guid of owner
	 * @param int $itemguid photo guid
	 * @param string $type profile photo/cover
     *
     * @return bool;
     */	
	public function addPhotoWallPost($ownerguid, $itemguid, $type = 'profile:photo'){
		if(empty($ownerguid) || empty($itemguid)){
			error_log("Empty item/owner guid has been provided for new cover wall post", 0);
			return false;
		}
		$this->wall = new elWall;
			
		$this->wall->item_type = $type;
		$this->wall->owner_guid = $ownerguid;
		$this->wall->poster_guid = $ownerguid;
		$this->wall->item_guid = $itemguid;
		
		if($this->wall->Post('null:data')){
			return true;
		}
	}
	/**
	 * Delete profile photo/cover wall post
	 * 
	 * @param int $fileguid Profile/Cover file id
	 * @return bool
	 */
	public function deletePhotoWallPost($fileguid){
		if(empty($fileguid)){
			return false;
		}
		//prepare a query to get post guid
		$statement = "SELECT * FROM el_entities, el_entities_metadata WHERE(
				  	  el_entities_metadata.guid = el_entities.guid 
				      AND  el_entities.subtype='item_guid'
				      AND  el_entities.type = 'object'
				      AND el_entities_metadata.value = '{$fileguid}'
				      );";	
		
		$this->statement($statement);
		$this->execute();
		$entity = $this->fetch();
		
		//check if post exists or not
		if($entity){
			//get object
			$object = el_get_object($entity->owner_guid);
			if($object && $object->subtype == 'wall'){
				$wall = new elWall;
				//delete wall post
				if($wall->deletePost($object->guid)){
					return true;
				}
			}
		}
		return false;
	}
	/**
	 * Get cover URL
	 *
	 * @param object $user elUser object
	 *
	 * @return string|boolean
	 */
	public function getCoverURL($user = ''){
		if(!empty($user) && $user instanceof elUser){
			if(!isset($user->cover_time) && empty($user->cover_time)){
				$user->cover_time = time();
				$user->data->cover_time = $user->cover_time;
				$user->save();
			}
			return el_site_url("cover/{$user->username}/".md5($user->cover_time).'.jpg');
		}
		return false;
	}
}//class
