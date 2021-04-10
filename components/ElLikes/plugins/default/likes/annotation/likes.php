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
if(!isset($params['annotation_id']) || isset($params['annotation_id']) && empty($params['annotation_id'])){
	return;	
}
$datalikes   = ''; 
$elLikes	 = new elLikes;
$likes_total = $elLikes->CountLikes($params['annotation_id'], 'annotation');
$datalikes   = $likes_total;

if($datalikes  > 0){ 
	foreach($elLikes->__likes_get_all as $item){
			$last_three_icons[$item->subtype] = $item->subtype;
	}
	$last_three = array_slice($last_three_icons, -3);
?>
				<span class="el-likes-annotation-total">
					<?php
						// Show total likes
						echo el_plugin_view('output/url', array(
										'href' => 'javascript:void(0);', 
										'text' => $likes_total, 
										'onclick' => "el.ViewLikes({$params['annotation_id']}, 'annotation')",
										'class' => "el-total-likes el-total-likes-{$params['annotation_id']}",
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
						<?php if(isset($last_three['dislike'])){ ?>
						<li>
							<div class="emoji  emoji--dislike">
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
					</div>
<?php } ?>  