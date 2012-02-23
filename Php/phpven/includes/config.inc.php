<?php
define("DB_HOST",    		"localhost"); 
define("DB_USER_NAME",   	"root"); 
define("DB_USER_PASS",   	"846266");
define("DB_DATABASE",   	"phpven");

define('DOMAIN',			'http://www.caataltd.com');
define('SITESTYLE',			SERVERPATH.'style/caatainc/');
define('TEMPLATE_DIR',		'templates/caatainc');
define('PIC_URL',			'/pic/');

define('LANGUAGE',			'language/zh_cn.php');
#define('PRICEUP', 			1.3);

define('INDEXSQL', 			"hw_kucun>0");
#define('INDEXSQL', 			"hw_kucun>0 and cat_id in (select distinct id from category where depth=3 and parent in (select id from category where code='AF' or code = 'DQ'))");
#define('INDEXSQL', 			"hw_kucun>0 and cat_id in (select distinct id from category where depth=3 and parent in (select id from category where name='Ed hardy'))");
#define('INDEXSQL', 			"hw_kucun>0 and cat_id in (select id from category where parent in (select id from category where name='Juicy'))");

define('NEWDAYS',			20);
define('INDEXTEJIANUM',		5);
define('DEFAULTQUALIST', 	'1/3/5/12/24');
define('OPENAD', False);
?>