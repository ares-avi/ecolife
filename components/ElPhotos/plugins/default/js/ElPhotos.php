/**
 * 	Open Source Social Network
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence 
 * @link      https://www.opensource-socialnetwork.org/
 */
//<script>
el.RegisterStartupFunction(function() {
    $(document).ready(function() {
        $('#el-add-album').click(function() {
            el.MessageBox('album/add');
        });
        $('#album-add').click(function() {
            el.MessageBox('album/add');
        });
        $('body').on('click', '#el-photos-edit-album', function(){
			$guid = $(this).attr('data-guid');
            el.MessageBox("album/edit/"+$guid);
        });		
        $('#el-add-photos').click(function() {
            $dataurl = $(this).attr('data-url');
            el.MessageBox('photos/add' + $dataurl);
        });
        $("#el-photos-show-gallery").click(function(e) {
            	e.preventDefault();
            	$(".el-gallery").eq(0).trigger("click");
        })
        if($('.el-gallery').length){
	        $(".el-gallery").fancybox();
        }
        $('body').delegate('#el-photos-add-button-inner', 'click', function(e){
        	e.preventDefault();
		$('.el-photos-add-button').find('input').click();
        });
	$('body').delegate('.el-photos-add-button input', 'change', function(e){
		$length = $(this)[0].files.length;
		$('.el-photos-add-button').find('.images').show();
		$('.el-photos-add-button').find('.images .count').html($length);
		$('#el-photos-add-button-inner').blur();
	});
    });
});
