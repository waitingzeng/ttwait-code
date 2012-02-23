<?php
	//require('includes/sql.php');
	require('includes/const.php');
	require('includes/db.php');
	require('includes/base.php');
	require('includes/function.php');
	require('includes/util.php');
	require('includes/lib_insert.php');
	
	
	$config = $db->getRow('select * from system', true);
	$config['pic_url'] = PIC_URL;
	$config['msn'] = split(',', $config['msn']);
	
	$tpl->assign_by_ref('config', $config);
	
	function openad($result, $this){
		if(defined('OPENAD') && OPENAD){
			$result = str_replace('<!--TTwaitADBEGIN', '', $result);
			$result = str_replace('TTwaitADEND-->', '', $result);
			$result = str_replace('<!--TTwaitRemoveBegin-->', '<!--', $result);
			$result = str_replace('<!--TTwaitRemoveEnd-->', '-->', $result);
		}
		return $result;
	}
	
	$tpl->register_outputfilter(openad);
?>