<?php

$site_name = el_site_settings('site_name');
if (isset($params['title'])) {
    $title = $params['title'] . ' : ' . $site_name;
} else {
    $title = el_site_settings('site_name');
}
if (isset($params['contents'])) {
    $contents = $params['contents'];
} else {
    $contents = '';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?php echo el_add_cache_to_url(el_theme_url().'images/favicon.ico');?>" type="image/x-icon" />	
    <title><?php echo $title; ?></title>
    
    <?php echo el_fetch_extend_views('el/endpoint'); ?>   
    <?php echo el_fetch_extend_views('el/admin/head'); ?>

    <script>
        <?php echo el_fetch_extend_views('el/admin/js/head'); ?>

    </script>
    <script>
        tinymce.init({
            toolbar: "bold italic underline alignleft aligncenter alignright bullist numlist image media link unlink emoticons autoresize fullscreen insertdatetime print spellchecker preview",
            selector: '.el-editor',
            plugins: "code image media link emoticons fullscreen insertdatetime print spellchecker preview",
            convert_urls: false,
            relative_urls: false,
            language: "<?php echo el_site_settings('language'); ?>",
		content_css: el.site_url + 'css/view/bootstrap.min.css'
        });
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
    
	<div class="header">
    	<div class="container">
        
        	<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
            			<?php if(el_site_settings('cache') == true){?>
            			<img src="<?php echo el_theme_url(); ?>images/logo_admin.jpg"/>
                        <?php } else { ?>
            			<img src="<?php echo el_theme_url(); ?>images/logo_admin.jpg?ver=<?php echo time();?>"/>                        
                        <?php } ?> 
            		</div>
                <?php if(el_isAdminLoggedin()){ ?>
            	<div class="col-md-6 col-sm-6 col-xs-6 header-dropdown">
					<ul class="navbar-right">	
                        <div class="dropdown">
                        	<a id="dLabel" role="button" data-toggle="dropdown" data-target="#"><i class="fa fa-bars fa-3"></i></a> 
    						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
             					 <li><a href="<?php echo el_site_url("action/admin/logout", true);?>"><?php echo el_print('admin:logout');?></a></li>
           					 </ul>
      		    		</div>
                     </ul>   
           		</div>
                <?php } ?>
        	</div>        
        
        </div>
    </div>
    <?php if(el_isAdminLoggedin()){ ?>
    <div class="row no-right-margins">
		<div class="topbar-menu">
    	  <?php echo el_view_menu('topbar_admin'); ?>
    	</div>
    </div>    
    <?php } ?>
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
            	 <?php echo $contents; ?>
            </div>
        </div>
        
        <!-- footer -->
        <footer>
      	  	<div class="row">
        		<div class="col-md-6">
 				<?php echo el_print('copyright'); ?> <?php echo date("Y"); ?> <a href="<?php echo el_site_url(); ?>"><?php echo $site_name; ?></a>            			
           	 	</div>
                <div class="col-md-6 text-right">
                	 <?php echo 'POWERED <a href="http://www.opensource-socialnetwork.org">OPEN SOURCE SOCIAL NETWORK</a>'; ?>
                </div>
        	</div>
        </footer>
        <!-- /footer -->
    </div> <!-- /container -->
</body>
</html>