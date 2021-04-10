//<script>
/**
 * Add action token to url
 *
 * @param string data Full complete url
 */
el.AddTokenToUrl = function(data) {
	// 'http://example.com?data=sofar'
	if (typeof data === 'string') {
		// is this a full URL, relative URL, or just the query string?
		var parts = el.ParseUrl(data),
			args = {},
			base = '';

		if (parts['host'] === undefined) {
			if (data.indexOf('?') === 0) {
				// query string
				base = '?';
				args = el.ParseStr(parts['query']);
			}
		} else {
			// full or relative URL
			if (parts['query'] !== undefined) {
				// with query string
				args = el.ParseStr(parts['query']);
			}
			var split = data.split('?');
			base = split[0] + '?';
		}
		args["el_ts"] = el.Config.token.el_ts;
		args["el_token"] = el.Config.token.el_token;

		return base + jQuery.param(args);
	}
};