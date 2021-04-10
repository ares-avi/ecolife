//<script>
$(document).ready(function(){
		var $listsbg = <?php echo json_encode(__PostBackground_List__);?>;
		if($('.el-wall-container-data').length){
				$('<div id="el-wall-postbg" style="display:none;"></div>').insertAfter('.el-wall-container-data textarea');
				$.each($listsbg, function(){
					$('#el-wall-postbg').append('<span class="" data-postbg-type="'+this['name']+'" style="background:url(\''+this['url']+'\'";background-position: center; background-size: cover;"></div>');
				});
				$('#el-wall-form').append('<input class="postbg-input" name="postbackground_type" type="hidden"/>');
		}
		$('body').on('click', '.el-wall-container-control-menu-postbg-selector', function(){
				$('.el-wall-container-data div').each(function(){
						$id = $(this).attr('id');
						if($id && $id.indexOf('el-wall-') >= 0){
								$(this).hide();
						}	
				});
				if($('#el-wall-postbg').attr('data-toggle') == 0 || !$('#el-wall-postbg').attr('data-toggle')){
					$('#el-wall-postbg').attr('data-toggle', 1);
					$('#el-wall-postbg').show();
				} else {
					
					$('.el-wall-container-data .postbg-container').attr('style', '');
     					$('.el-wall-container-data textarea').removeClass('postbg-container');
					if($('.postbg-input').length){
						$('.postbg-input').val('');
					}
					
					$('#el-wall-postbg').attr('data-toggle', 0);
					$('#el-wall-postbg').hide();
				}
		});
 		$('.el-wall-container-data textarea').keyup(function(){
   				var length = $.trim(this.value).length;
				if(length > 125) {
					$('.el-wall-container-data .postbg-container').attr('style', '');
     				$('.el-wall-container-data textarea').removeClass('postbg-container');
					if($('.postbg-input').length){
						$('.postbg-input').val('');
					}
    			}
		});		
		$('body').on('click', '#el-wall-postbg span', function(){
					$type = $(this).attr('data-postbg-type');	
					var i = 0;
					for(i=0;i<=$listsbg.length;i++){
							if($listsbg[i]['name'] == $type){
								$('.el-wall-container-data textarea').addClass('postbg-container');
								$('.el-wall-container-data .postbg-container').css({
											'background': 'url("'+$listsbg[i]['url']+'")',
											'background-position': 'center',
											'background-size': 'cover',
											'color': $listsbg[i]['color_hex'],
								});
								$('.postbg-input').val($type);
								break;	
							}
					}
		});
		$(document).ajaxComplete(function(event, xhr, settings) {
			var $url = settings.url;
			$pagehandler = $url.replace(el.site_url, '');
			
			if($pagehandler.indexOf('action/wall/post/a') >= 0 || $pagehandler.indexOf('action/wall/post/g') >= 0 || $pagehandler.indexOf('action/wall/post/u') >= 0 || $pagehandler.indexOf('action/wall/post/bpage') >= 0){
					$('.el-wall-container-data .postbg-container').attr('style', '');
     				$('.el-wall-container-data textarea').removeClass('postbg-container');
					if($('.postbg-input').length){
						$('.postbg-input').val('');
					}
					//hide panel
					$('.el-wall-container-data div').each(function(){
						$id = $(this).attr('id');
						if($id && $id.indexOf('el-wall-') >= 0){
								$(this).hide();
						}
					});					
			}
			if($pagehandler.indexOf('wall/post/embed') >= 0){
					$data = settings.data;
					$listsdata = $data.split('&');
					if($listsdata.length > 0){
						$.each($listsdata, function($key, $value){
							if($value.indexOf('guid=') >=0){
									$guid = $value.replace('guid=', '');
									$element = $('#activity-item-'+$guid);
									if($element.length && $element.find('.postbg-container')){
											$text = $element.find('.postbg-container').text();
											if($text && $text.length > 125){
												$element.find('.postbg-container').removeClass('postbg-container').attr('style', '');
												$element.find('.postbg-text').removeClass('postbg-text');
											}
									}
							}
						});
					}
			}
		});		
});
