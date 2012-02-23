<?php

$MAILSEARCH = '/\w+([-+\.]\w+)*@\w+([-\.]\w+)*\.\w+([-\.]\w+)*/i';

if(empty($_REQUEST['ids'])){
	exit();
}

$id = $_REQUEST['ids'];
$fileurl = 'http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item='.$id;
$fp = @fopen($fileurl, 'rb');
$contents = "";
do {
   $data = @fread($fp, 8192);
   if (strlen($data) == 0) {
     break;
   }
   $contents .= $data;
} while (true);
@fclose($fp);        

preg_match_all($MAILSEARCH, $contents, $matches);
$data = array();
foreach ($matches[0] as $k=>$v){
	$data[strtolower($v)] = 1;
}
$data = implode('","', array_keys($data));
$data = '{"state" : "success", "data" : ["'.$data.'"]}';
echo $data;
?>