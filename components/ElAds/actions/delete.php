<?php

$delete = new ElAds;
$entites = $_REQUEST['entites'];
foreach($entites as $entity){
   $entity = get_ad_entity((int)$entity);
   if(empty($entity->guid)){
 	  el_trigger_message(el_print('ad:delete:fail'), 'error');
   } else {
       if (!$delete->deleteAd($entity->guid)) {
		el_trigger_message(el_print('ad:delete:fail'), 'error');
	   } else {
		el_trigger_message(el_print('ad:deleted', array($entity->title)), 'success');  
	   }	   
   }
}

redirect(REF);