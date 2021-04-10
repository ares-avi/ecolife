<div class="hidden">
	<?php
	if ($params['photos']) {
    	foreach ($params['photos'] as $photo) {	
		$img = str_replace('album/photos/', '', $photo->value);
	?>
	<a data-fancybox="gallery" class="el-gallery" href="<?php echo el_site_url("album/getphoto/") . $photo->owner_guid; ?>/<?php echo $img; ?>?size=view"></a>
    <?php
		}
	}
	?>
</div>