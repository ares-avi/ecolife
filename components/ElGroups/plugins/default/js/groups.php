//<script>
el.RegisterStartupFunction(function() {
	$(document).ready(function() {
		$('#el-group-add').click(function() {
			el.MessageBox('groups/add');
		});
	});
});
el.RegisterStartupFunction(function() {
	$(document).ready(function() {
		$("#group-upload-cover").submit(function(event) {
			event.preventDefault();
			var formData = new FormData($(this)[0]);
			var $url = el.site_url + 'action/group/cover/upload';
			var fileInput = $('#group-upload-cover').find("input[type='file']")[0],
				file = fileInput.files && fileInput.files[0];

			if (file) {
				var img = new Image();

				img.src = window.URL.createObjectURL(file);

				img.onload = function() {
					var width = img.naturalWidth,
						height = img.naturalHeight;

					window.URL.revokeObjectURL(img.src);
					if (width < 1040 || height < 300) {
						el.trigger_message(el.Print('profile:cover:err1:detail'), 'error');
						return false;
					} else {
						$.ajax({
							url: el.AddTokenToUrl($url),
							type: 'POST',
							data: formData,
							async: true,
							beforeSend: function(xhr, obj) {
								if ($('.el-group-cover').length == 0) {
									$('.header-users').attr('style', 'opacity:0.7;');
								} else {
									$('.el-group-cover').attr('style', 'opacity:0.7;');
								}
								$('.el-group-profile').find('.groups-buttons').find('a').hide();
								$('.el-group-cover').prepend('<div class="el-covers-uploading-annimation"> <div class="el-loading"></div></div>');
							},
							cache: false,
							contentType: false,
							processData: false,
							success: function(callback) {
								if (callback['type'] == 1) {
									if ($('.el-group-cover').length == 0) {
										location.reload();
									} else {
										$('.el-group-cover').attr('style', '');
										$('.el-covers-uploading-annimation').remove();
										$('.el-group-profile').find('.groups-buttons').find('a').show();
										$('.el-group-cover').find('img').attr('style', '');
										$('.el-group-cover').find('img').show();
										$('.el-group-cover').find('img').attr('src', callback['url']);
									}
								}
								if (callback['type'] == 0) {
									el.MessageBox('syserror/unknown');
								}
							}
						});
					}
				};
			}
			return false;
		});

		$('#add-cover-group').click(function(e) {
			e.preventDefault();
			$('#group-upload-cover').find('.coverfile').click();
		});
	});
});

el.RegisterStartupFunction(function() {
	$(document).ready(function() {
		$('#reposition-group-cover').click(function() {
			$('.group-c-position').attr('style', 'display:inline-block !important;');
			$('.el-group-cover-button').hide();
			$('.el-group-cover').unbind('mouseenter').unbind('mouseleave');
			el.Drag();
		});
	});
});

el.RegisterStartupFunction(function() {
	$(document).ready(function() {
		$('.el-group-cover').hover(function() {
			$('.el-group-cover-button').show();
		}, function() {
			$('.el-group-cover-button').hide();
		});
	});
});

el.repositionGroupCOVER = function($group) {
	var cover_top  = parseInt($('.el-group-cover').find('img').css('top'));
	var cover_left = parseInt($('.el-group-cover').find('img').css('left'));
	var $url = el.site_url + "action/group/cover/reposition";
	$.ajax({
		async: true,
		type: 'post',
		data: '&top=' + cover_top + '&left=' + cover_left + '&group=' + $group,
		url: el.AddTokenToUrl($url),
		success: function(callback) {
			$("#draggable").draggable('destroy');
			$('.group-c-position').attr('style', 'display:none !important;');
			$('.el-group-cover').hover(function() {
				$('.el-group-cover-button').show();
			}, function() {
				$('.el-group-cover-button').hide();
			});
		},
	});
};
							
el.RegisterStartupFunction(function() {
	$(document).ready(function() {
		$('.el-group-change-owner').click(function(e) {
			e.preventDefault();
			var new_owner = $(this).attr('data-new-owner');
			var is_admin  = $(this).attr('data-is-admin');
			if (is_admin) {
				var del = confirm(el.Print('group:memb:make:owner:admin:confirm', [new_owner]));
			} else {
				var del = confirm(el.Print('group:memb:make:owner:confirm', [new_owner]));
			}
			if (del == true) {
				var actionurl = $(this).attr('href');
				window.location = actionurl;
			}
		});
	});
});
