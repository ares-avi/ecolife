<?php

?>
<h4><?php echo $params['entity']->title;?></h4>
<a href="<?php echo $params['entity']->site_url;?>"><?php echo $params['entity']->site_url;?></a>
<p><?php echo $params['entity']->description;?></p>
<div class="el-ad-image" style="background:url('<?php echo el_ads_image_url($params['entity']->guid);?>') no-repeat;background-size: contain;"></div>
