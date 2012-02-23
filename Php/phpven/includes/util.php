<?php
	 function alert($msg, $url=''){
		if($url == -1){
			$url = $_SERVER['HTTP_REFERER'];
		}
		if($url){
			$txt = "<script language=javascript>alert('$msg');window.location.href='$url';</script>";
			die($txt);
		}else{
			$txt = "<script language=javascript>setTimeout(function(){alert('$msg')}, 0);</script>";
			return $txt;
		}
	}
	
	function isEmail($email){
		return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/", $email);
	}

	function redirect($url=''){
		header("Location: http://".$_SERVER['HTTP_HOST'].SERVERPATH.$url);
		exit();
	}
	
	function goBack(){
		$url = $_SERVER["HTTP_REFERER"];
		if(empty($url))$url= "http://".$_SERVER['HTTP_HOST'].SERVERPATH;
		header("Location: $url");
		exit();
	}
	
	function getTime(){
		#date_default_timezone_set('Asia/Shanghai');
		return date('Y-m-d H:i:s');
	}
	
	function getClientIP(){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		if(empty($ip))$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;
	}
	
	function noCache(){
		header("Expires: -1");
		header("Cache-Control: no-cache, must-revalidate"); 
		header("Pragma: no-cache");
	}
?>