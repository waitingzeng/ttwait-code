<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function get_file($url, $referer='', $times=1){
    $opts = array( 
        'http'=>array('method'=>'GET','timeout'=>60,),
        'header' => array('referer' => $referer,),
    );
    $context = stream_context_create($opts);
    $html = '';
    while ($times > 0 && !$html){
        $html =file_get_contents($url, false, $context);
    }
    return $html;
}

function get_file_by_curl($url, $referer, $times=1){
    $ch = curl_init();
    $timeout = 60;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_REFERER, $referer);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}

function sub($html){
    global $replace_array;
    foreach($replace_array as $k => $v){
        $html = str_replace($k, $v, $html);
    }
    $html = preg_replace("/mm_\d+_0_0/i", PID, $html);
    return $html;
}

function get_cached($url, $referer){
    $cache_id = sprintf('%X', crc32($url));
    $filename = CACHE_ROOT . "$cache_id.html";
    $timecompre = time() - CACHE_TIME;
    if(file_exists($filename) && @filemtime($filename) > $timecompare) {
		return $filename;
	}
    $html = get_file_by_curl($url, $referer, 3);
    if($html){
        if($html == 'error')return false;
        $html = sub($html);
        file_put_contents($filename, $html);
        return $filename;
    }
    return false;
}
?>
