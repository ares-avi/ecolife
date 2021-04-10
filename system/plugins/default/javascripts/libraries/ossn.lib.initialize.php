//<script>
/**
 * Register some init functionality
 * Example user signup,  update check, message boxes etc
 */
el.register_callback('el', 'init', 'el_startup_functions_compatibility');
el.register_callback('el', 'init', 'el_image_url_cache');
el.register_callback('el', 'init', 'el_administrator_update_widget');
el.register_callback('el', 'init', 'el_administrator_user_delete');
el.register_callback('el', 'init', 'el_makesure_confirmation');
el.register_callback('el', 'init', 'el_component_delelte_confirmation');
el.register_callback('el', 'init', 'el_system_messages');
el.register_callback('el', 'init', 'el_user_signup_form');
el.register_callback('el', 'init', 'el_topbar_dropdown');	
/**
 * Setup ajax request for user register
 *
 * @return void
 */
function el_user_signup_form(){
	el.ajaxRequest({
		url: el.site_url + "action/user/register",
		form: '#el-home-signup',

		beforeSend: function(request){
			var failedValidate = false;
			$('#el-submit-button').show();
			$('#el-home-signup .el-loading').addClass("el-hidden");

			$('#el-home-signup').find('#el-signup-errors').hide();
			$('#el-home-signup input').filter(function(){
				$(this).closest('span').removeClass('el-required');
				if(this.type == 'radio' && !$(this).hasClass('el-field-not-required')){
					if(!$("input[name='gender']:checked").val()){
						$(this).closest('span').addClass('el-required');
						failedValidate = true;
					}
				}
				if(this.value == "" && !$(this).hasClass('el-field-not-required')){
					$(this).addClass('el-red-borders');
					failedValidate = true;
					request.abort();
					return false;
				}
			});
			if(failedValidate == false){
				$('#el-submit-button').hide();
				$('#el-home-signup .el-loading').removeClass("el-hidden");
			}
		},
		callback: function(callback){
			if(callback['dataerr']){
				$('#el-home-signup').find('#el-signup-errors').html(callback['dataerr']).fadeIn();
				$('#el-submit-button').show();
				$('#el-home-signup .el-loading').addClass("el-hidden");
			} else if(callback['success'] == 1){
				$('#el-home-signup').html(el.MessageDone(callback['datasuccess']));
			} else {
				$('#el-home-signup .el-loading').addClass("el-hidden");
				$('#el-submit-button').attr('type', 'submit')
				$('#el-submit-button').attr('style', 'opacity:1;');
			}
		}
	});
}
/**
 * Setup system messages
 *
 * @return void
 */
function el_system_messages(){
	$(document).ready(function(){
		if($('.el-system-messages').find('a').length){
			$('.el-system-messages').find('.el-system-messages-inner').show();

			setTimeout(function(){
				$('.el-system-messages').find('.el-system-messages-inner').hide().empty();
			}, 10000);
		}
		//Clicking close in system messages should close it complete #1137
		$('body').on('click', '.el-system-messages .close', function(){
			$('.el-system-messages').find('.el-system-messages-inner').hide().empty();
		});
	});
}
/**
 * Topbar dropdown button
 *
 * @return void
 */
function el_topbar_dropdown(){
	$(document).ready(function(){
		$('.el-topbar-dropdown-menu-button').click(function(){
			if($('.el-topbar-dropdown-menu-content').is(":not(:visible)")){
				$('.el-topbar-dropdown-menu-content').show();
			} else {
				$('.el-topbar-dropdown-menu-content').hide();
			}
		});

	});
}
/**
 * Show exception on component delete
 *
 * @return void
 */
function el_component_delelte_confirmation(){
	$(document).ready(function(){
		//show a confirmation mssage before delete component #444
		$('.el-com-delete-button').click(function(e){
			e.preventDefault();
			var del = confirm(el.Print('el:component:delete:exception'));
			if(del == true){
				var actionurl = $(this).attr('href');
				window.location = actionurl;
			}
		});
	});
}
/**
 * Show exception , are you sure?
 *
 * @return void
 */
function el_makesure_confirmation(){
	$(document).ready(function(){
		$('.el-make-sure').click(function(e){
			e.preventDefault();
			var del = confirm(el.Print('el:exception:make:sure'));
			if(del == true){
				var actionurl = $(this).attr('href');
				window.location = actionurl;
			}
		});
	});
}
/**
 * Show exception on user delete
 *
 * @return void
 */
function el_administrator_user_delete(){
	$(document).ready(function(){
		$('.userdelete').click(function(e){
			e.preventDefault();
			var del = confirm(el.Print('el:user:delete:exception'));
			if(del == true){
				var actionurl = $(this).attr('href');
				window.location = actionurl;
			}

		});
	});
}
/**
 * Checks for the updates in administrator panel
 *
 * @return void
 */
function el_administrator_update_widget(){
	$(document).ready(function(){
		if($('.avaiable-updates').length){
			el.PostRequest({
				url: el.site_url + "administrator/version",
				action: false,
				callback: function(callback){
					if(callback['version']){
						$('.avaiable-updates').html(callback['version']);
					}
				}
			});
		}
	});
}
/**
 * Add cache tag to the local images
 * 
 * @param string		$callback	el
 * @param string		$type		init
 * @param array|object 	$params		null
 *
 * @added in v5.0 
 * @return void
 */
function el_image_url_cache($callback, $type, $params){
	$(document).ready(function(){
		if(el.Config.cache.el_cache == 1){
			$('img').each(function(){
				var data = $(this).attr('src');
				$site_url = el.ParseUrl(el.site_url);
				var parts = el.ParseUrl(data),
					args = {},
					base = '';
				if(parts['host'] == $site_url['host']){
					if(parts['host'] === undefined){
						if(data.indexOf('?') === 0){
							// query string
							base = '?';
							args = el.ParseStr(parts['query']);
						}
					} else {
						// full or relative URL
						if(parts['query'] !== undefined){
							// with query string
							args = el.ParseStr(parts['query']);
						}
						var split = data.split('?');
						base = split[0] + '?';
					}
					args["el_cache"] = el.Config.cache.last_cache;
					$(this).attr('src', base + jQuery.param(args));
				}
			});
		}
	});
}
/**
 * Startup functions support
 * 
 * @param string		$callback	el
 * @param string		$type		init
 * @param array|object 	$params		null
 * 
 * @return void
 */
function el_startup_functions_compatibility($callback, $type, $params){
	for (var i = 0; i <= el.Startups.length; i++){
		if(typeof el.Startups[i] !== "undefined"){
			el.Startups[i]();
		}
	}
}
/**
 * Initialize el startup functions
 *
 * @return void
 */
el.Init = function(){
	el.trigger_callback('el', 'init');
};
