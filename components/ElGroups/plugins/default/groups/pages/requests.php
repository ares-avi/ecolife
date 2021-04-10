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
$requests = $params['group']->getMembersRequests();
if (empty($requests)) {
    echo '<div class="el-group-no-requests">' . el_print('no:requests') . '</div>';
} else {
    foreach ($requests as $user) {
        ?>
		<div class="row">
	        <div class="el-group-members">
            	<div class="col-md-2 col-sm-2 hidden-xs">
    	        		<img src="<?php echo $user->iconURL()->large; ?>" width="100" height="100"/>
				</div>
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
                    <div class="right request-controls">
	                    <?php
							echo el_plugin_view('output/url', array(
									'text' => el_print('approve'),
									'href' =>  el_site_url("action/group/member/approve?group={$params['group']->guid}&user={$user->guid}", true),
									'class' => 'btn btn-primary',
							));
							echo el_plugin_view('output/url', array(
									'text' => el_print('decline'),
									'href' =>  el_site_url("action/group/member/decline?group={$params['group']->guid}&user={$user->guid}", true),
									'class' => 'btn btn-danger',
							));
						?>		
                   </div>
                </div>
            </div>
        </div>

    <?php
    }
}
