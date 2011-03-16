<?php
	require( dirname(__FILE__) . '/wp-load.php' );
	require_once(dirname(__FILE__) . '/wp-content/plugins/wpcspinner/spinner.php');
	$test = isset($_GET['test']);
	//DATE_SUB( now( ) , INTERVAL 24 HOUR ) < `post_date` and
	$posts = $wpdb->get_results(" SELECT * FROM $wpdb->posts WHERE state=1 order by ID desc limit 5");
	foreach ($posts as $post) {
		$body = $post->post_content;
		$body = unique_content($body);
		$data = array('post_content' => $body);
		if(!$test){
			$data['state'] = '2';
			$wpdb->update($wpdb->posts, $data, array('ID' => $post->ID));
			echo $post->ID;
			echo '<br/>';
		}else{
			echo $body;
			break;
			//echo $post->ID;
		}
	}
?>