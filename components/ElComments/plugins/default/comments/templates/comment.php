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
el_trigger_callback('comment', 'load', $params['comment']);
$comment = arrayObject($params['comment'], 'elWall');
$user = el_user_by_guid($comment->owner_guid);
if ($comment->type == 'comments:post' || $comment->type == 'comments:entity') {
    $type = 'annotation';
}
$datalikes = '';
if(class_exists('elLikes')) {
	$elLikes = new elLikes;
	$likes_total = $elLikes->CountLikes($comment->id, $type);
	$datalikes = $likes_total;
} else {
	$likes_total = 0;
}
$last_three = array();
if($datalikes  > 0){ 
	foreach($elLikes->__likes_get_all as $item){
			$last_three_icons[$item->subtype] = $item->subtype;
	}
	$last_three = array_slice($last_three_icons, -3);
}
?>
<div class="comments-item" id="comments-item-<?php echo $comment->id; ?>">
	<div class="row">
		<div class="col-md-1">
			<img class="comment-user-img" src="<?php echo $user->iconURL()->smaller; ?>" />
		</div>
		<div class="col-md-11">
			<div class="comment-contents">
				<p>
					<?php
						echo el_plugin_view('output/url', array(
											'href' => $user->profileURL(), 
											'text' => $user->fullname, 
											'class' => 'owner-link',
						 ));
						echo "<span class='comment-text'>";
						        if ($comment->type == 'comments:entity') {
						            echo ' '.nl2br($comment->getParam('comments:entity'));
						        } elseif ($comment->type == 'comments:post') {
						            echo ' '.nl2br($comment->getParam('comments:post'));
						        }
						echo "</span>";
						        $image = $comment->getParam('file:comment:photo');
						        if (!empty($image)) {
						            $image = str_replace('comment/photo/', '', $image);
						            $image = el_site_url("comment/image/{$comment->id}/{$image}");
						            echo "<img src='{$image}' />";
						        }
						        ?>
				</p>
				<div class="comment-metadata">
					<div class="time-created"><?php echo el_user_friendly_time($comment->time_created); ?></div>
					<?php
						if (class_exists('elLikes')) {
							if (el_isLoggedIn()) {
						             	 if (!$elLikes->isLiked($comment->id, el_loggedin_user()->guid, $type)) {
												echo el_plugin_view('output/url', array(
													'href' => el_site_url("action/annotation/like?annotation={$comment->id}"), 
													'text' => el_print('like'), 
													'class' => 'el-like-comment',
													'id' => 'el-like-comment-'.$comment->id,
													'data-type' => 'Like',
													'data-id' => $comment->id,
													'action' => true
												));
						             		 } else { 
									 			echo el_plugin_view('output/url', array(
													'href' => el_site_url("action/annotation/unlike?annotation={$comment->id}"), 
													'text' => el_print('unlike'), 
													'class' => 'el-like-comment',
													'id' => 'el-like-comment-'.$comment->id,									
													'data-type' => 'Unlike',
													'data-id' => $comment->id,
													'action' => true
												));
						             		 }
						
						         	} // Likes only for loggedin users end 
						} ?>
					<div class="el-comment-menu">
						<div class="dropdown">
							<?php
								echo el_view_menu('comments', 'comments/menu/comments');
								?>
						</div>
					</div>
					<?php if (class_exists('elLikes')) { ?>
					<span class="el-likes-annotation-total">
					<?php
						// Show total likes
						echo el_plugin_view('output/url', array(
										'href' => 'javascript:void(0);', 
										'text' => $likes_total, 
										'onclick' => "el.ViewLikes({$params['comment']['id']}, 'annotation')",
										'class' => "el-total-likes el-total-likes-{$params['comment']['id']}",
										'data-likes' => $datalikes,
						));
						?>
					</span>                    
					<div class="el-reaction-list">
						<?php if(isset($last_three['like'])){ ?>
						<li>
							<div class="emoji  emoji--like">
								<div class="emoji__hand">
									<div class="emoji__thumb"></div>
								</div>
							</div>
						</li>
						<?php } ?>        
						<?php if(isset($last_three['love'])){ ?>
						<li>
							<div class="emoji emoji--love">
								<div class="emoji__heart"></div>
							</div>
						</li>
						<?php } ?>
						<?php if(isset($last_three['haha'])){ ?>
						<li>
							<div class="emoji  emoji--haha">
								<div class="emoji__face">
									<div class="emoji__eyes"></div>
									<div class="emoji__mouth">
										<div class="emoji__tongue"></div>
									</div>
								</div>
							</div>
						</li>
						<?php } ?> 
						<?php if(isset($last_three['yay'])){ ?>        
						<li>
							<div class="emoji  emoji--yay">
								<div class="emoji__face">
									<div class="emoji__eyebrows"></div>
									<div class="emoji__mouth"></div>
								</div>
							</div>
						</li>
						<?php } ?>
						<?php if(isset($last_three['wow'])){ ?>
						<li>
							<div class="emoji  emoji--wow">
								<div class="emoji__face">
									<div class="emoji__eyebrows"></div>
									<div class="emoji__eyes"></div>
									<div class="emoji__mouth"></div>
								</div>
							</div>
						</li>
						<?php } ?>
						<?php if(isset($last_three['sad'])){ ?>
						<li>
							<div class="emoji  emoji--sad">
								<div class="emoji__face">
									<div class="emoji__eyebrows"></div>
									<div class="emoji__eyes"></div>
									<div class="emoji__mouth"></div>
								</div>
							</div>
						</li>
						<?php } ?>
						<?php if(isset($last_three['angry'])){ ?>
						<li>
							<div class="emoji  emoji--angry">
								<div class="emoji__face">
									<div class="emoji__eyebrows"></div>
									<div class="emoji__eyes"></div>
									<div class="emoji__mouth"></div>
								</div>
							</div>
						</li>
						<?php } ?>
					</div>  <!-- reaction list panel -->
					<?php } // elLikes class check end ?>              
				</div> <!-- comment metadata -->
			</div>
		</div>
	</div>
</div>
