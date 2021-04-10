<?php


echo '<div><div class="layout-installation">';
echo '<h2>' . el_installation_print('site:settings') . '</h2>';
$notification_email = parse_url(el_installation_paths()->url);
if(substr($notification_email['host'], 0, 4) == 'www.'){
	$notification_email['host'] = substr($notification_email['host'], 4);
}
?>
<form action="<?php echo el_installation_paths()->url; ?>?action=install" method="post">

    <div>
        <label> <?php echo el_installation_print('el:dbsettings'); ?>: </label>

        <input type="text" name="dbuser" placeholder="<?php echo el_installation_print('el:dbuser'); ?>"/>
        <input type="password" name="dbpwd" placeholder="<?php echo el_installation_print('el:dbpassword'); ?>"/>
        <input type="text" name="dbname" placeholder="<?php echo el_installation_print('el:dbname'); ?>"/>
        <input type="text" name="dbhost" placeholder="<?php echo el_installation_print('el:dbhost'); ?>"/>
    </div>

    <div>

        <label> <?php echo el_installation_print('el:sitesettings'); ?>: </label>

        <input type="text" name="sitename" placeholder="<?php echo el_installation_print('el:websitename'); ?>"/>

        <input type="text" name="owner_email" placeholder="<?php echo el_installation_print('owner_email'); ?>"/>
        <?php
		if(!filter_var($notification_email['host'], FILTER_VALIDATE_IP)){ ?>
        <input type="text" name="notification_email" placeholder="<?php echo el_installation_print('notification_email'); ?>" value="noreply@<?php echo $notification_email['host'];?>"/>
        <?php } else {  ?>
        <input type="text" name="notification_email" placeholder="<?php echo el_installation_print('notification_email'); ?>" value=""/>                
        <?php } ?>
    </div>

    <label> <?php echo el_installation_print('el:mainsettings'); ?>: </label>
    <br/>

  	<input type="hidden" name="url" value="<?php echo elInstallation::url(); ?>"/>

    <div>
        <label> <?php echo el_installation_print('el:datadir'); ?> </label>
        <input type="text" name="datadir" value="<?php echo elInstallation::DefaultDataDir(); ?>"/>
    </div>
	<div style="display:block;margin-top:10px;">
	    <input type="submit" value="<?php echo el_installation_print('el:install:install'); ?>" class="button-blue primary">
	</div>
</form>
</div>
