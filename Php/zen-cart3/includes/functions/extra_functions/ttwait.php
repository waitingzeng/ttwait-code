<?php
	
	function save_cache($key, $content){
		$cachefile = DIR_FS_SQL_CACHE.'/'.$key;
		file_put_contents($cachefile, $content);
		return true;
	}
	
	function get_cache($key,  $cachetime=86400)
	{
		$cachefile = DIR_FS_SQL_CACHE.'/'.$key;
		if(file_exists($cachefile) && (time() - filemtime($cachefile)) < $cachetime){
			return file_get_contents($cachefile);	
		}
		return false;
	}
?>