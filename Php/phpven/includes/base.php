<?php
	require('smarty/Smarty.class.php');
	$tpl = new Smarty;
	//设置各个目录的路径，这里是安装的重点
	$tpl->template_dir = TEMPLATE_DIR;
	$tpl->compile_dir = COMPILE_DIR;
	$tpl->config_dir = CONFIG_DIR;
	$tpl->cache_dir = CACHE_DIR;
	$tpl->trusted_dir = TRUSTED_DIR;
	//$tpl->left_delimiter = '{{';
    //$tpl->right_delimiter = '}}';
	//smarty模板有高速缓存的功能，如果这里是true的话即打开caching，但是会造成网页不立即更新的问题，当然也可以通过其他的办法解决
	$tpl->caching = CACHE;
	$tpl->cache_lifetime = CACHELIFETIME;
	$tpl->assign('ServerPath', SERVERPATH);
	$tpl->assign('serverstyle', SITESTYLE);
?>