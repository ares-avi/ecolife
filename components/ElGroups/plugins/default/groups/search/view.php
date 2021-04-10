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
if ($params['groups']) {
	echo "<div class='group-search-items'>";
    foreach ($params['groups'] as $group) {
		$owner = el_user_by_guid($group->owner_guid);
        ?>
		
        <div class="row">
        	<div class="col-md-2 col-sm-2 col-xs-4">
	            <img src="<?php echo el_site_url("components/elGroups/images/search_group.png"); ?>" width="100" height="100"/>
            </div>
			<div class="col-md-10 col-sm-10 col-xs-8">
	            <div class="group-search-details">
    	            <a class="group-name" href="<?php echo el_site_url(); ?>group/<?php echo $group->guid; ?>"><?php echo $group->title; ?></a>
        	        <p class="el-group-search-by"><?php echo el_print('el:group:by');?><a href="<?php echo $owner->profileURL();?>"><?php echo $owner->fullname;?></a></p>
           	 	</div>
			</div>

        </div>


    <?php
    }
	echo "</div>";
}
?>
