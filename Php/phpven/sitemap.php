<?php
	require('includes/const.php');
	require('includes/db.php');
	
	header('Content-type: application/xml; charset=utf-8');
	header("Expires: -1");
	header("Cache-Control: no-cache, must-revalidate"); 
	header("Pragma: no-cache");
	SiteMap();
	function getRank(){
		return rand(7,9)/10;
	}
	function OneFile($urls){
		$str = '<?xml version="1.0" encoding="UTF-8"?>
				<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
		foreach ($urls as $u){
			$l = $u[0];
			$r = $u[1];
			$str .= '<url><loc>'.DOMAIN.'/'.$l.'</loc><priority>'.$r.'</priority></url>';
		}
		$str .= '</urlset>';
		return $str;
	}
	
	function IndexFile($filelist){
		$str = '<?xml version="1.0" encoding="UTF-8"?>
				<sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84">';
		foreach ($filelist as $f){
			$str .= '<sitemap><loc>'.DOMAIN.'/'.$f.'</loc></sitemap>';
		}
		$str .= '</sitemapindex>';
		return $str;
	}
	
	function SiteMap(){
		global $db;
		$urls = array();
		$urls[] = array('','1.0');
		$urls[] = array('index.html', '1.0');
		$sql = "select alias from category order by id desc";
		$all = $db->getAll($sql);
		foreach($all as $item){
			$urls[] = array($item['alias'].".html", getRank());
		}
		$sql = "select alias from hw where hw_kucun>0 order by hw_id desc";
		$all = $db->getAll($sql);
		foreach($all as $item){
			$urls[] = array($item['alias'].".html", getRank());
		}
		$l = count($urls);
		$page = 5000;
		if($l < $page){
			$result = OneFile($urls);
		}else{
			$filelist = array();
			$count = floor(($l-1)/$page)+1;
			$dir = dirname(__FILE__);
			for($i=1;$i<=$count;$i++){
				$url = array_slice($urls, ($i-1)*$page, $page);
				$one = OneFile($url);
				file_put_contents("$dir/sitemap/sitemap$i.xml", $one);
				$filelist[] = "sitemap/sitemap$i.xml"; 
			}
			$result = IndexFile($filelist);
		}
		echo $result;
	}
?>