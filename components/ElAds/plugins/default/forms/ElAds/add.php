<?php

?>
<label><?php echo el_print('ad:title'); ?> </label>
<input type="text" name="title"/>

<label><?php echo el_print('ad:site:url'); ?></label>
<input type="text" name="siteurl"/>

<label><?php echo el_print('ad:desc'); ?></label>
<textarea name="description"></textarea>

<label><?php echo el_print('ad:photo'); ?></label>
<input type="file" name="el_ads"/>
<br/>
<input type="submit" class="btn btn-primary" value="<?php echo el_print('add'); ?>"/>
