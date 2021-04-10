$(document).ready(function() {
		
	$('body').append('<div id="sounds"></div>');
		
	if (/android|ipod|iphone|ipad|blackberry|kindle/i.test(navigator.userAgent) && !window.matchMedia('(display-mode: standalone)').matches) {
		// android, iphones and other mobile devices need a least 1 initial click to enable sound
		// thus using cookies to remember a sound state='on' makes no sense
		// because with every new page load a new manual init from off -> on is necessary
		// so we have to start with 'off' in any case, except el is running as PWA 
		if ($('.el-chat-windows-long').length) {
			$('#sounds').append('<audio id="el-chat-sound" src="" preload="auto"></audio>');
			$('<div class="el-chat-pling"><i class="fa fa-bell-slash-o"></i></div>').prependTo('.el-chat-windows-long .inner');
			$('<div class="el-chat-pling"><i class="fa fa-bell-slash-o"></i></div>').prependTo('.el-chat-icon .el-chat-inner-text');
		}
		if ($('.message-form-form').length) {
			$('#sounds').append('<audio id="el-message-sound" src="" preload="auto"></audio>');
			$('<div class="el-message-pling"><i class="fa fa-bell-slash-o"></i></div>').appendTo('.message-form-form .controls');
		}
	}
	else {
		if ($('.el-chat-windows-long').length) {
			if (getCookie("el_chat_bell") == 'on') {
				$('#sounds').append('<audio id="el-chat-sound" src="<?php echo el_site_url("components/elSounds/audios/pling.mp3"); ?>" preload="auto"></audio>');
				$('<div class="el-chat-pling"><i class="fa fa-bell-o"></i></div>').prependTo('.el-chat-windows-long .inner');
				$('<div class="el-chat-pling"><i class="fa fa-bell-o"></i></div>').prependTo('.el-chat-icon .el-chat-inner-text');
			}
			else {
				$('#sounds').append('<audio id="el-chat-sound" src="" preload="auto"></audio>');
				$('<div class="el-chat-pling"><i class="fa fa-bell-slash-o"></i></div>').prependTo('.el-chat-windows-long .inner');
				$('<div class="el-chat-pling"><i class="fa fa-bell-slash-o"></i></div>').prependTo('.el-chat-icon .el-chat-inner-text');
				/* first time usage defaults to off */
				setCookie('el_chat_bell', 'off', 30);
			}
		}
		if ($('.message-form-form').length) {
			if (getCookie("el_message_bell") == 'on') {
				$('#sounds').append('<audio id="el-message-sound" src="<?php echo el_site_url("components/elSounds/audios/pling.mp3"); ?>" preload="auto"></audio>');
				$('<div class="el-message-pling"><i class="fa fa-bell-o"></i></div>').appendTo('.message-form-form .controls');
			}
			else {
				$('#sounds').append('<audio id="el-message-sound" src="" preload="auto"></audio>');
				$('<div class="el-message-pling"><i class="fa fa-bell-slash-o"></i></div>').appendTo('.message-form-form .controls');
				setCookie('el_message_bell', 'off', 30);
			}	
		}
	}
		
	$(".el-chat-pling").click(function(e) {
		e.stopImmediatePropagation();
		player = $('#el-chat-sound').get(0);
		pling  = '<?php echo el_site_url("components/elSounds/audios/pling.mp3"); ?>';
		bell   = $('.el-chat-pling').find('i');
		// sound is off - turn it on
		if (bell.hasClass('fa fa-bell-slash-o')) {
			bell.removeClass('fa fa-bell-slash-o');
			player.src = pling;
			player.play();
			bell.addClass('fa fa-bell-o');
			setCookie('el_chat_bell', 'on', 30);
		}
		// sound is on - turn it off
		else {
			player.src = '';
			bell.removeClass('fa fa-bell-o');
			bell.addClass('fa fa-bell-slash-o');
			setCookie('el_chat_bell', 'off', 30);
		}
	});

	$(".el-message-pling").click(function(e) {
		player = $('#el-message-sound').get(0);
		pling  = '<?php echo el_site_url("components/elSounds/audios/pling.mp3"); ?>';
		bell   = $('.el-message-pling').find('i');
		// sound is off - turn it on
		if (bell.hasClass('fa fa-bell-slash-o')) {
			bell.removeClass('fa fa-bell-slash-o');
			player.src = pling;
			player.play();
			bell.addClass('fa fa-bell-o');
			setCookie('el_message_bell', 'on', 30);
		}
		// sound is on - turn it off
		else {
			player.src = '';
			bell.removeClass('fa fa-bell-o');
			bell.addClass('fa fa-bell-slash-o');
			setCookie('el_message_bell', 'off', 30);
		}
	});
	
});


el.ChatplaySound = function() {
	var bell = document.getElementById('el-chat-sound');
	if(bell.readyState) {
		bell.play();
	}
};
el.MessageplaySound = function() {
	var bell = document.getElementById('el-message-sound');
	if(bell.readyState) {
		bell.play();
	}
};

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
} 

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
} 
