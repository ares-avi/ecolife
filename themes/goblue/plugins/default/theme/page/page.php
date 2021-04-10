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
$sitename = el_site_settings('site_name');
$sitelanguage = el_site_settings('language');
if (isset($params['title'])) {
    $title = $params['title'] . ' : ' . $sitename;
} else {
    $title = $sitename;
}
if (isset($params['contents'])) {
    $contents = $params['contents'];
} else {
    $contents = '';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $sitelanguage; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?php echo el_add_cache_to_url(el_theme_url().'images/favicon.ico');?>" type="image/x-icon" />
	
    <?php echo el_fetch_extend_views('el/endpoint'); ?>
    <?php echo el_fetch_extend_views('el/site/head'); ?>

    <script>
        <?php echo el_fetch_extend_views('el/js/head'); ?>
    </script>
</head>

<body>
	<div class="el-page-loading-annimation">
    		<div class="el-page-loading-annimation-inner">
            	<div class="el-loading"></div>
            </div>
    </div>

	<div class="el-halt el-light"></div>
	<div class="el-message-box"></div>
	<div class="el-viewer" style="display:none"></div>
    
    <div class="opensource-socalnetwork">
    	<?php echo el_plugin_view('theme/page/elements/sidebar');?>
    	 <div class="el-page-container">
			  <?php echo el_plugin_view('theme/page/elements/topbar');?>
          <div class="el-inner-page">    
  	  		  <?php echo $contents; ?>
          </div>    
		</div>
    </div>
    <div id="theme-config" class="hidden" data-desktop-cover-height="200" data-minimum-cover-image-width="1040"></div>	
    <?php echo el_fetch_extend_views('el/page/footer'); ?>           
</body>
</html>
