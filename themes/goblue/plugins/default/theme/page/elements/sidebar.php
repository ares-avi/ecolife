<?php
	if(!el_isLoggedin()){
		return;
	}
?>
        <div class="sidebar ">
            <div class="sidebar-contents">

           		 <?php
          			  if (el_is_hook('newsfeed', "sidebar:left")) {
                			$newsfeed_left = el_call_hook('newsfeed', "sidebar:left", NULL, array());
               				 echo implode('', $newsfeed_left);
            		}
					echo el_view_form('search', array(
								'component' => 'elSearch',
								'class' => 'el-search',
								'autocomplete' => 'off',
								'method' => 'get',
								'security_tokens' => false,
								'action' => el_site_url("search"),
					), false);
           		 ?>                
            </div>
        </div>