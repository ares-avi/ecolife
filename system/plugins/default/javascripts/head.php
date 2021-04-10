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
$timestamp = time();
$token     = el_generate_action_token($timestamp);

$token   = array(
		'el_ts' => $timestamp,
		'el_token' => $token
);
$configs = array(
		'token' => $token,
		'cache' => array(
				'last_cache' => hash('crc32b', el_site_settings('last_cache')),
				'el_cache' => el_site_settings('cache')
		)
);
?> 	
	el.site_url = '<?php echo el_site_url();?>';
	el.Config = <?php echo json_encode($configs);?>;
	el.Init();
