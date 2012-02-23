<?php

	function insert_title($tpl){
		global $config;
		$title = $GLOBALS['title'];
		if(!empty($title)){
			return $title.'-'.$config['defaulttitle'];
		}
		return $config['defaulttitle'];
	}
	function insert_keywords(&$tpl){
		global $config;
		$keywords =$GLOBALS['keywrods'];
		if(!empty($keywords)){
			return $keywords.'-'.$config['defaultkeyword'];
		}
		return $config['defaultkeyword'];
	}
	function insert_description($tpl){
		global $config;
		$description = $GLOBALS['description'];
		if(!empty($description)){
			return $description.'-'.$config['defaultdescription'];
		}
		return $config['defaultdescription'];
	}
?>