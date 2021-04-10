<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$members = $params['group']->getMembers();
$count = $params['group']->getMembers(true);
if ($members) {
    foreach ($members as $user) {
      ?>
		<div class="row">
	        <div class="el-group-members">
            	<div class="col-md-2 col-sm-2 hidden-xs">
    	        		<img src="<?php echo $user->iconURL()->large; ?>" width="100" height="100"/>
				</div>
                <div>
                   <div class="col-md-10 col-sm-10 col-xs-12">
    	    	        <div class="uinfo">
                          <?php
	    						echo el_plugin_view('output/url', array(
	    								'text' => $user->fullname,
	    								'href' =>  $user->profileURL(),
	    								'class' => 'userlink',
	    						));						
	    					?>
             	   		</div>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="right request-controls">
	                        <?php
	    						if ((el_isAdminLoggedin() || el_loggedin_user()->guid == $params['group']->owner_guid) && $user->guid !== $params['group']->owner_guid && $params['group']->isMember($params['group']->guid, $user->guid)) {
	    								echo el_plugin_view('output/url', array(
	    									'text' => el_print('group:memb:remove'),
	    									'href' =>  el_site_url("action/group/member/decline?group={$params['group']->guid}&user={$user->guid}", true),
		    								'class' => 'btn btn-warning btn-responsive el-make-sure'
		    						));
						        		echo el_plugin_view('output/url', array(
					    					'data-new-owner' => $user->fullname,
					    					'data-is-admin' => el_isAdminLoggedin(),
						    				'text' => el_print('group:memb:make:owner'),
						    				'href' =>  el_site_url("action/group/change_owner?group={$params['group']->guid}&user={$user->guid}", true),
						    				'class' => 'btn btn-danger btn-responsive el-group-change-owner'
						    		));
		    					}
		    				?>		
                        </div>
                    </div>
               </div>
            </div>           
        </div>
    <?php
    }
	echo el_view_pagination($count);
}?>
