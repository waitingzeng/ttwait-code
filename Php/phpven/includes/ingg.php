<?php
	require_once('includes/function.php');
	$pubs = getPubs();
	if(count($pubs) > 0){
		$this->assign_by_ref('pubs', getPubs());
	}
?>