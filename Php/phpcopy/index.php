<?php
require_once 'config.php';
require_once 'function.php';

$real_url = $_SERVER['REDIRECT_URL'];

if(array_key_exists('pid', $_GET)){
    $_GET['pid'] = PID;
}
$query_string = array();
foreach($_GET as $k => $v){
    $query_string[] = "$k=$v";
}
$query_string = implode('&', $query_string);

$site = "http://dianpu.tao123.com$real_url?$query_string";
var_dump($site);

$replace_array = array('http://dianpu.tao123.com/' => '/',
      'http://www.tao123.com/' => '/',
      'dianpu.tao123.com' => 'tb8.cn.com',
      'tao123.com' => 'tb8.cn.com',
      'tao123' => 'tb8',
      '淘网址' => '淘宝吧',
    );

include get_cached($site);
?>
