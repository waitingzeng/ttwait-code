<?php
	require_once('pics.php');
	header('Content-Type: text/plain');
	$path = '/home2/onli0911/public_html/images/pic/';
	$path = dirname(__FILE__).'/pic/';
	foreach ($pics as $k=>$v) {
		$filename = $path.$k;
		if(file_exists($filename)){
			print $k."esists\n";
			continue;
		}
		$url = 'http://onlyzilla.com/'.$v;
		$fp = fopen($url, "rb");
		if (!$fp){
			continue;
		    exit("Error: Download ". $url ." failed.\n\n");
		}

		//�򿪱����ļ�
		$sp = fopen($filename, "wb");
		if (!$sp){
		    exit("Error: Open local file ". $filename ." failed.\n\n");
		}

		//����Զ���ļ�
		echo "Downloading, please waiting...\n\n";
		while (!feof($fp)){
		    $tmpfile .= fread($fp, 1024);
		}
		//�����ļ�������
		fwrite($sp, $tmpfile);
		fclose($fp);
		fclose($sp);
		echo "Download file ". $k ." succeed!\n";
	}
?>