<?php
/**
 * Open Source Social Network
 *
 * @package   (Informatikon.com).el
 * @author    el Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */

$album = el_get_object($params['post']->item_guid);
if(!$album) {
		return;
}
$photos_guid = $params['post']->photos_guids;
$count  	 = count(explode(',', $photos_guid));

$photos      = el_get_entities(array(
		'wheres' => "e.guid IN({$photos_guid})",
		'page_limit' => 17,
));
$total       = count((array) $photos);
$container   = 'el-photos-wall';

if($total == 1) {
		$container = 'el-photos-wall-plain';
}
?>
<div class="el-wall-item" id="activity-item-<?php echo $params['post']->guid; ?>">
	<div class="row">
		<div class="meta">
			<img class="user-img" src="<?php echo $params['user']->iconURL()->small; ?>" />
			<div class="post-menu">
				<div class="dropdown">
                 <?php
           			if (el_is_hook('wall', 'post:menu') && el_isLoggedIn()) {
                		$menu['post'] = $params['post'];
               			echo el_call_hook('wall', 'post:menu', $menu);
            			}
            		?>   
				</div>
			</div>
			<div class="user">
           <?php if ($params['user']->guid == $params['post']->owner_guid) { ?>
                <a class="owner-link" href="<?php echo $params['user']->profileURL(); ?>"> <?php echo $params['user']->fullname; ?> </a>
                <div class="el-wall-item-type el-photos-wall-title"><a target="_blank" href="<?php echo el_site_url("album/view/{$album->guid}");?>"><?php echo $album->title;?></a></div>
            <?php } ?>
			</div>
			<div class="post-meta">
				<span class="time-created el-wall-post-time" title="<?php echo date('d/m/Y', $params['post']->time_created);?>" onclick="el.redirect('<?php echo("post/view/{$params['post']->guid}");?>');"><?php echo el_user_friendly_time($params['post']->time_created); ?></span>
				<?php
					echo el_plugin_view('privacy/icon/view', array(
							'privacy' => $params['post']->access,
							'text' => '-',
							'class' => 'time-created',
					));
				?>                
			</div>
		</div>

       <div class="post-contents <?php echo $container;?>">
				<?php
					if($photos > 0){
							foreach($photos as $photo){
									$file = str_replace('album/photos/', '', $photo->value);
									$url  = el_site_url("album/getphoto/{$album->guid}/{$file}?size=album");			
									if($total > 2){
											$class = 'el-photo-wall-item-small';	
									} else {
											$class = 'el-photo-wall-item-medium';											
									}
									$view = "<a target='_blank' href='".el_site_url("photos/view/{$photo->guid}")."'><img class='img-thumbnail el-photos-wall-item {$class}' src='{$url}' /></a>";
									
									if($total == 1){
										$url  = el_site_url("album/getphoto/{$album->guid}/{$file}?size=view");									
										$view = "<a target='_blank' href='".el_site_url("photos/view/{$photo->guid}")."'><img class='img-thumbnail' src='{$url}' /></a>";
									}
									echo $view;
							}
							if($count > 17){
										$url  = el_site_url("/components/elPhotos/images/more.jpg");									
										echo "<a target='_blank' href='".el_site_url("album/view/{$album->guid}")."'><img class='img-thumbnail el-photos-wall-item el-photo-wall-item-small' src='{$url}' /></a>";								
							}
					}
					if(!$photos){
								$url  = el_site_url("/components/elPhotos/images/nophoto-album.png");									
								$view = "<img class='img-thumbnail' src='{$url}' />";		
								echo $view;
					}
				?>
    	</div>
	</div>
</div>
