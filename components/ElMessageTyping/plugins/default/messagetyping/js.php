//<script>
$(document).ready(function(){
	 $(document).on('focus', '.friend-tab-item input', function(){
		$id = $(this).attr('id').split("-").pop();
		$status = {
                url: el.site_url+'action/message/typing/status/save?status=yes&subject_guid='+$id,
                action: true,
                callback: function(){}
        };
		el.PostRequest($status);
		
	 });
	 $(document).on('blur', '.friend-tab-item input', function(){
 		$id = $(this).attr('id').split("-").pop();
		$status = {
                url: el.site_url+'action/message/typing/status/save?status=no&subject_guid='+$id,
                action: true,
                callback: function(){}
        };
		el.PostRequest($status);		
	});						   
});