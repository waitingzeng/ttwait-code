<?php
	require_once('includes/function.php');
	$help = getHelps();
	$this->assign_by_ref('types', $help['types']);
	$this->assign_by_ref('bookslist', $help['bookslist']);
	
?>