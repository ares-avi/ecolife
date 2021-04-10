<?php


$ads = new ElAds;
$items 		= $ads->getAds(array(), false);
$count      = $ads->getAds(array(
				'count' => true,								 
));
?>
<div class="right margin-bottom-10">
	<div class="inline-block">
    	<a href="<?php echo el_site_url("administrator/component/ElAds?settings=add"); ?>" class="btn btn-success"><?php echo el_print('add'); ?></a>
    </div>
    <div class="inline-block">
      <input type="submit" class="btn btn-danger" value="<?php echo el_print('delete'); ?>"/>
   </div>   
</div>
<div>
<table class="table">
    <tbody>
    <tr class="table-titles">
        <td></td>
        <td><?php echo el_print('ad:title'); ?></td>
        <td><?php echo el_print('ad:site:url'); ?></td>
        <!-- <td><?php echo el_print('ad:clicks'); ?></td> -->
        <td><?php echo el_print('ad:browse'); ?></td>
        <td><?php echo el_print('edit'); ?></td>
    </tr>
    <?php
    if ($items) {
        foreach ($items as $ads) {
            ?>
            <tr>
                <td><input type="checkbox" name="entites[]" value="<?php echo $ads->guid; ?>"/></td>
                <td><?php echo $ads->title; ?></td>
                <td><?php echo $ads->description; ?></td>
                <!-- <td> 32</td> -->
                <td>
                    <a href="<?php echo el_site_url("administrator/component/ElAds?settings=view&id={$ads->guid}"); ?>">
                        <?php echo el_print('ad:browse'); ?></a></td>
                <td>
                    <a href="<?php echo el_site_url("administrator/component/ElAds?settings=edit&id={$ads->guid}"); ?>">
                        <?php echo el_print('edit'); ?></a></td>

            </tr>
        <?php
        }

    }?>
    </tbody>
</table>
</div>
<div class="row">
	<?php echo el_view_pagination($count); ?>
</div>
