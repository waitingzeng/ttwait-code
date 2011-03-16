<?php
	require( dirname(__FILE__) . '/wp-load.php' );
	if(isset($_GET['content']))$s = ', post_content';
	else $s = '';
	$ct = isset($_GET['limit']) ? intval($_GET['limit']) : 1000;
	if(isset($_GET['minid'])){
		$where = ' and ID>=' . intval($_GET['minid']);
	}
	$sql = "SELECT ID, post_name, post_title $s FROM $wpdb->posts where post_type='post' and post_status='publish' $where order by rand() limit $ct ";
	$posts = $wpdb->get_results($sql);
	$urls = array();
    $site = get_bloginfo('url') . '/';
	foreach ($posts as $post){
		$item = array('url' => $site .$post->post_name.'/', 'title' => $post->post_title, 'desc' => $post->post_title, 'id' => $post->ID);
		if($s){
			$item['content'] = $post->post_content;
		}
		$urls[] = $item;
	}
	echo json_encode($urls);
	//var_dump($urls);
?>