//<script>
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
el.ViewLikes = function($post, $type) {
    if (!$type) {
        $type = 'post';
    }
    el.MessageBox('likes/view?guid=' + $post + '&type=' + $type);
};

el.PostUnlike = function(post) {
    el.PostRequest({
        url: el.site_url + 'action/post/unlike',
        beforeSend: function() {
            $('#el-like-' + post).html('<img src="' + el.site_url + 'components/elComments/images/loading.gif" />');
        },
        params: '&post=' + post,
        callback: function(callback) {
            if (callback['done'] !== 0) {
                $('#el-like-' + post).html(callback['button']);
                $('#el-like-' + post).attr('data-reaction', 'el.PostLike(' + post + ', "<<reaction_type>>");');
				$('#el-like-' + post).removeAttr('onclick'); 
				//reactions
				$parent = $('#el-like-' + post).parent().parent().parent();				
				if(callback['container']){
						$parent.find('.like-share').remove();
						$parent.find('.menu-likes-comments-share').after(callback['container']);
				}
				if(!callback['container']){
						$parent.find('.like-share').remove();	
				}				
            } else {
                $('#el-like-' + post).html(el.Print('unlike'));
            }
        },
    });

};
el.PostLike = function(post, $reaction_type = '') {
    el.PostRequest({
        url: el.site_url + 'action/post/like',
        beforeSend: function() {
            $('#el-like-' + post).html('<img src="' + el.site_url + 'components/elComments/images/loading.gif" />');
        },
        params: '&post=' + post + '&reaction_type='+$reaction_type,
        callback: function(callback) {
            if (callback['done'] !== 0) {
                $('#el-like-' + post).html(callback['button']);
                $('#el-like-' + post).attr('onClick', 'el.PostUnlike(' + post + ');');
				$('#el-like-' + post).removeAttr('data-reaction'); 
				//reactions				
				if(callback['container']){
						$parent = $('#el-like-' + post).parent().parent().parent();
						$parent.find('.like-share').remove();
						$parent.find('.menu-likes-comments-share').after(callback['container']);
				}
            } else {
                $('#el-like-' + post).html(el.Print('like'));
            }
        },
    });

};

el.EntityUnlike = function(entity) {
    el.PostRequest({
        url: el.site_url + 'action/post/unlike',
        beforeSend: function() {
            $('#el-elike-' + entity).html('<img src="' + el.site_url + 'components/elComments/images/loading.gif" />');
        },
        params: '&entity=' + entity,
        callback: function(callback) {
            if (callback['done'] !== 0) {
                $('#el-elike-' + entity).html(callback['button']);
                $('#el-elike-' + entity).attr('data-reaction', 'el.EntityLike(' + entity + ', "<<reaction_type>>");');
				$('#el-elike-' + entity).removeAttr('onclick'); 
				//reactions				
				$parent = $('#el-elike-' + entity).parent().parent().parent();				
				if(callback['container']){
						$parent.find('.like-share').remove();
						$parent.find('.menu-likes-comments-share').after(callback['container']);
				}
				if(!callback['container']){
						$parent.find('.like-share').remove();	
				}
            } else {
                $('#el-elike-' + entity).html(el.Print('unlike'));
            }
        },
    });

};
el.EntityLike = function(entity, $reaction_type = '') {
    el.PostRequest({
        url: el.site_url + 'action/post/like',
        beforeSend: function() {
            $('#el-elike-' + entity).html('<img src="' + el.site_url + 'components/elComments/images/loading.gif" />');
        },
        params: '&entity=' + entity + '&reaction_type='+$reaction_type,
        callback: function(callback) {
            if (callback['done'] !== 0) {
                $('#el-elike-' + entity).html(callback['button']);
                $('#el-elike-' + entity).attr('onClick', 'el.EntityUnlike(' + entity + ');');
				$('#el-elike-' + entity).removeAttr('data-reaction'); 
				//reactions				
				if(callback['container']){
						$parent = $('#el-elike-' + entity).parent().parent().parent();
						$parent.find('.like-share').remove();
						$parent.find('.menu-likes-comments-share').after(callback['container']);
				}				
            } else {
                $('#el-elike-' + post).html(el.Print('like'));
            }
        },
    });

};

el.RegisterStartupFunction(function() {								  
    $(document).ready(function(){
	var $htmlreactions = '<div class="el-like-reactions-panel"> <li class="el-like-reaction-like"> <div class="emoji  emoji--like"> <div class="emoji__hand"> <div class="emoji__thumb"></div> </div> </div> </li> <li class="el-like-reaction-dislike"> <div class="emoji  emoji--dislike"> <div class="emoji__hand"> <div class="emoji__thumb"></div> </div> </div> </li> <li class="el-like-reaction-love"> <div class="emoji  emoji--love"> <div class="emoji__heart"></div> </div> </li> <li class="el-like-reaction-haha"> <div class="emoji  emoji--haha"> <div class="emoji__face"> <div class="emoji__eyes"></div> <div class="emoji__mouth"> <div class="emoji__tongue"></div> </div> </div> </div> </li> <li class="el-like-reaction-yay"> <div class="emoji  emoji--yay"> <div class="emoji__face"> <div class="emoji__eyebrows"></div> <div class="emoji__mouth"></div> </div> </div> </li> <li class="el-like-reaction-wow"> <div class="emoji  emoji--wow"> <div class="emoji__face"> <div class="emoji__eyebrows"></div> <div class="emoji__eyes"></div> <div class="emoji__mouth"></div> </div> </div> </li> <li class="el-like-reaction-sad"> <div class="emoji  emoji--sad"> <div class="emoji__face"> <div class="emoji__eyebrows"></div> <div class="emoji__eyes"></div> <div class="emoji__mouth"></div> </div> </div> </li> <li class="el-like-reaction-angry"> <div class="emoji  emoji--angry"> <div class="emoji__face"> <div class="emoji__eyebrows"></div> <div class="emoji__eyes"></div> <div class="emoji__mouth"></div> </div> </div> </li> </div>';					   
	$('body').on('click',function(e){
			$class = $(e.target).attr('class');
			//console.log($class);
			if($class && !$(e.target).hasClass('post-control-like') && !$(e.target).hasClass('entity-menu-extra-like') && !$(e.target).hasClass('el-like-comment') && !$(e.target).hasClass('el-like-reactions-panel')){					
				$('.el-like-reactions-panel').remove();
			}
	});
	$MenuReactions = function($elem){
			 $parent = $($elem).parent();
			 $('.el-like-reactions-panel').remove(); //remove from all places , remove panel.
			 $onclick = $($elem).attr('data-reaction');
			 if(!$onclick || $parent.find('.el-like-reactions-panel').length > 0){
					return false; 
			 }
			 $parent.append($htmlreactions);			 
			 $like	  = $onclick.replace("<<reaction_type>>", 'like');
			 $dislike	  = $onclick.replace("<<reaction_type>>", 'dislike');
			 $love	  = $onclick.replace("<<reaction_type>>", 'love');
			 $haha	  = $onclick.replace("<<reaction_type>>", 'haha');
			 $yay	  = $onclick.replace("<<reaction_type>>", 'yay');
			 $wow	  = $onclick.replace("<<reaction_type>>", 'wow');
			 $sad	  = $onclick.replace("<<reaction_type>>", 'sad');
			 $angry	  = $onclick.replace("<<reaction_type>>", 'angry');
			 
			 $parent.find('.el-like-reaction-like').attr('onclick', $like);
			 $parent.find('.el-like-reaction-dislike').attr('onclick', $dislike);
			 $parent.find('.el-like-reaction-love').attr('onclick', $love);
			 $parent.find('.el-like-reaction-haha').attr('onclick', $haha);
			 $parent.find('.el-like-reaction-yay').attr('onclick', $yay);
			 $parent.find('.el-like-reaction-wow').attr('onclick', $wow);
			 $parent.find('.el-like-reaction-sad').attr('onclick', $sad);
			 $parent.find('.el-like-reaction-angry').attr('onclick', $angry);
   	};
	$("body").on('mouseenter touchstart', '.post-control-like, .entity-menu-extra-like',function(){
			 $MenuReactions($(this));
	});		
	/*** for comments ***/
	$("body ").on('mouseenter touchstart', '.el-like-comment', function(){
			 $parent = $(this).parent().parent();
			 $('.el-like-reactions-panel').remove(); //remove from all places , remove panel.
			 if($(this).attr('data-type') == 'Unlike' ||  $parent.find('.el-like-reactions-panel').length > 0 || !$(this).attr('data-id')){
					return true; 
			 }
			 $parent.append($htmlreactions);
			 $parent.find('.el-like-reaction-like')
			 					.addClass('el-like-comment-react')
								.attr('data-reaction', 'like')
								.attr('data-id', $(this).attr('data-id'))
								.attr('data-type', 'Like')
								.attr('href', $(this).attr('href'));
			 $parent.find('.el-like-reaction-dislike')
			 					.addClass('el-like-comment-react')
								.attr('data-reaction', 'dislike')
								.attr('data-id', $(this).attr('data-id'))
								.attr('data-type', 'Like')
								.attr('href', $(this).attr('href'));								
			 $parent.find('.el-like-reaction-love')
			 					.addClass('el-like-comment-react')
								.attr('data-reaction', 'love')
								.attr('data-id', $(this).attr('data-id'))
								.attr('data-type', 'Like')
								.attr('href', $(this).attr('href'));
								
			 $parent.find('.el-like-reaction-haha')
			 					.addClass('el-like-comment-react')
								.attr('data-reaction', 'haha')
								.attr('data-id', $(this).attr('data-id'))
								.attr('data-type', 'Like')
								.attr('href', $(this).attr('href'));
								
			 $parent.find('.el-like-reaction-yay')
			 					.addClass('el-like-comment-react')
								.attr('data-reaction', 'yay')
								.attr('data-id', $(this).attr('data-id')).
								attr('data-type', 'Like')
								.attr('href', $(this).attr('href'));
								
			 $parent.find('.el-like-reaction-wow')
			 					.addClass('el-like-comment-react')
								.attr('data-reaction', 'wow')
								.attr('data-id', $(this).attr('data-id'))
								.attr('data-type', 'Like')
								.attr('href', $(this).attr('href'));
								
			 $parent.find('.el-like-reaction-sad')
			 					.addClass('el-like-comment-react')
								.attr('data-reaction', 'sad')
								.attr('data-id', $(this).attr('data-id'))
								.attr('data-type', 'Like')
								.attr('href', $(this).attr('href'));
								
			 $parent.find('.el-like-reaction-angry')
			 					.addClass('el-like-comment-react')
								.attr('data-reaction', 'angry')
								.attr('data-id', $(this).attr('data-id'))
								.attr('data-type', 'Like')
								.attr('href', $(this).attr('href'));
	});			
    $(document).delegate('.el-like-comment-react, .el-like-comment', 'click', function(e) {
            e.preventDefault();
            var $item = $(this);
            var $type = $.trim($item.attr('data-type'));
            var $url = $item.attr('href');
			if($(this).attr('class') == 'el-like-comment' && $type == 'Like'){
				return false;	
			}
            el.PostRequest({
                url: $url,
                action: false,
				params: '&reaction_type='+$item.attr('data-reaction'),
                beforeSend: function() {
                    $item.html('<img src="' + el.site_url + 'components/elComments/images/loading.gif" />');
                },
                callback: function(callback) {
                    if (callback['done'] == 1) {
                        $total_guid = el.UrlParams('annotation', $url);
                        $total = $('.el-total-likes-' + $total_guid).attr('data-likes');
                        if ($type == 'Like') {
                            $('#el-like-comment-'+$total_guid).html(el.Print('unlike'));
                            $('#el-like-comment-'+$total_guid).attr('data-type', 'Unlike');                            
                           
						    var unlike = $url.replace("like", "unlike");
                            $('#el-like-comment-'+$total_guid).attr('href', unlike);
                            
							$total_likes = $total;
                            
							/**$total_likes++;
                            $('.el-total-likes-' + $total_guid).attr('data-likes', $total_likes);
                            $('.el-total-likes-' + $total_guid).html('<i class="fa fa-thumbs-up"></i>' + $total_likes); */
							$('.el-like-reactions-panel').remove(); //remove from all places , remove panel.
                        }
                        if ($type == 'Unlike') {
                           $('#el-like-comment-'+$total_guid).html(el.Print('like'));
                            $('#el-like-comment-'+$total_guid).attr('data-type', 'Like');                            
                            var like = $url.replace("unlike", "like");
							
                           $('#el-like-comment-'+$total_guid).attr('href', like);
                           
						   /*if ($total > 1) {
                                $like_remove = $total;
                                0
                                $like_remove--;
                                $('.el-total-likes-' + $total_guid).attr('data-likes', $like_remove);
                                $('.el-total-likes-' + $total_guid).html('<i class="fa fa-thumbs-up"></i>' + $like_remove);
                            }
                            if ($total == 1) {
                                $('.el-total-likes-' + $total_guid).attr('data-likes', 0);
                                $('.el-total-likes-' + $total_guid).html('');

                            }*/
                        }
						//update total likes
						if(callback['container']){
								$('#comments-item-'+$total_guid).find('.el-likes-annotation-total').remove();
								$('#comments-item-'+$total_guid).find('.el-reaction-list').remove();
								$('#comments-item-'+$total_guid).find('.comment-metadata').append(callback['container']);
						}						
                    }
                    if (callback['done'] == 0) {
                        if ($type == 'Like') {
                            $('#el-like-comment-'+$total_guid).html(el.Print('like'));
                            $('#el-like-comment-'+$total_guid).attr('data-type', 'Like');
                            el.MessageBox('syserror/unknown');
                        }
                        if ($type == 'Unlike') {
                            $('#el-like-comment-'+$total_guid).html(el.Print('unlike'));
                            $('#el-like-comment-'+$total_guid).attr('data-type', 'Unlike');
                            el.MessageBox('syserror/unknown');
                        }
                    }
                },
            });
        });
    });
});
