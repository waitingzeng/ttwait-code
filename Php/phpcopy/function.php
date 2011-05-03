<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function get_file($url, $times=1){
    $opts = array( 'http'=>array('method'=>'GET','timeout'=>60,));
    $context = stream_context_create($opts);
    $html = '';
    while ($times > 0 && !$html){
        $html =file_get_contents($url, false, $context);
    }
    return $html;
}

function sub($html){
    global $replace_array;
    foreach($replace_array as $k => $v){
        $html = str_replace($k, $v, $html);
    }
    $html = preg_replace("/mm_\d+_0_0/i", PID, $html);
    return $html;
}

function get_cached($url){
    $cache_id = sprintf('%X', crc32($url));
    $filename = CACHE_ROOT . "$cache_id.html";
    $timecompre = time() - CACHE_TIME;
    if(file_exists($filename) && @filemtime($filename) > $timecompare) {
		return $filename;
	}
    $html = get_file($url, 3);
    if($html){
        $html = sub($html);
        file_put_contents($filename, $html);
        return $filename;
    }
    return false;
}
?>
