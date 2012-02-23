<?php
header('ContentType', 'text/plain');

$check = true;
if(empty($_REQUEST['begin'])){
	$check = false;
}else{
	$begin = $_REQUEST['begin'];
}
$dir = dirname(__FILE__);

$txt = file_get_contents($dir.'/pic.txt');

$pics = explode("\n",str_replace("\r",'', $txt));
$result = array();
print count($pics);
exit();
foreach ($pics as $v) {
	if($check){
		if ($v == $begin){
			$check = false;
		}
		continue;
	}
	$picname = "$dir/pic/$v.jpg";
	if(!file_exists($picname)){
		$result[] = $v;
		echo $v;
		echo "\n";
	}
}
echo 'finish'
?>