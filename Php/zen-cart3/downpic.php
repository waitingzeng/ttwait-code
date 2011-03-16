<?php
$basepath = dirname(__FILE__) . '/';
$picpath =  $basepath. 'pic/';
/*
if ($handle = opendir($picpath)) {
    while (false !== ($file = readdir($handle))) {
        if(is_dir($picpath.$file))continue;
        if(filesize($picpath.$file) == 0){
        	unlink($picpath.$file);
        	print $picpath . $file . "<br/>";
        }
    }
    closedir($handle);
}

if ($handle = opendir('.')) {
    while (false !== ($file = readdir($handle))) {
        if(is_dir($basepath . $file))continue;
        /
        if(filesize($basepath . $file) == 0){
        	unlink($basepath . $file);
        	print $basepath . $file . "<br/>";
        }
        elseif (file_exists($picpath . $file)) {
         	unlink($basepath . $file);
         	print $basepath . $file . " exists <br/>";
         }
         /
        rename($basepath . $file, $picpath . $file);
        print $file . " <br/>";
    }
    closedir($handle);
}
*/
$pics = file_get_contents('pic.txt');
$pics = explode("\n", $pics);
$output = array();
foreach ($pics as $pic)
{
	$pic = trim($pic);
	//print $picpath . $pic . '.jpg';
	//exit();
	if(!file_exists($picpath . $pic . '.jpg')){
		$output[] = $pic;
	}
}
file_put_contents($base_dir . 'no.txt', join("\n", $output));
/*
if ($handle = opendir($picpath)) {
    while (false !== ($file = readdir($handle))) {
        if(is_dir($picpath . $file))continue;
      	$pics[] = $file;
    }
    closedir($handle);
    file_put_contents($base_dir . 'pic.txt', join("\n", $pics));
}
*/
?>