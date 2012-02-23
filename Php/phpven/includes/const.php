<?php
define('COOKIES_QUIZ', 		'__846266__');


define('ROOT_PATH', 		str_replace('/includes/const.php', '', str_replace('\\', '/', __FILE__)));
define('SERVERPATH',		'/');


define('COMPILE_DIR',			'templates_c');
define('CONFIG_DIR',			'config');
define('CACHE_DIR', 			'caches');
define('TRUSTED_DIR',			'includes');
define('CACHE',					false);
define('CACHELIFETIME',			36000);
define('AD_TEMPLATE',			'templates/admin');

require('includes/config.inc.php');
?>