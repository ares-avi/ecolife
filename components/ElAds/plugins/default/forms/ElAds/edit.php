<?php

?>
<label><?php echo el_print('ad:title'); ?> </label>
<input type="text" name="title" value="<?php echo $params['entity']->title;?>"/>

<label><?php echo el_print('ad:site:url'); ?></label>
<input type="text" name="siteurl" value="<?php echo $params['entity']->site_url;?>"/>

<label><?php echo el_print('ad:desc'); ?></label>
<textarea name="description"><?php echo $params['entity']->description;?></textarea>

<label><?php echo el_print('ad:photo'); ?></label>
<input type="file" name="el_ads"/>
<input type="hidden" name="entity" value="<?php echo $params['entity']->guid;?>" />
<div class="el-ad-image" style="background:url('<?php echo el_ads_image_url($params['entity']->guid);?>') no-repeat;background-size: contain;"></div>
<br/>
<input type="submit" class="el-admin-button button-dark-blue" value="<?php echo el_print('save'); ?>"/>
