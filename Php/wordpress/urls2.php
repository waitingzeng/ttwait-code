<?php
	require( dirname(__FILE__) . '/wp-load.php' );
	$test = isset($_GET['test']);
	$ID = isset($_GET['id']) ? int($_GET['id']) : false;
	//DATE_SUB( now( ) , INTERVAL 24 HOUR ) < `post_date` and
	$posts = $wpdb->get_results(" SELECT * FROM $wpdb->posts WHERE state=0");
	foreach ($posts as $post) {
		if($ID && $post->ID != $ID){
			print $post->ID . 'not <br/>';
			continue;
		}
		$body = $post->post_content;
		$body = trip_selected_tags($body, array('a','iframe','script'));
		$data = array('post_content' => $body);
		if(!$test){
			$data['state'] = '1';
			$wpdb->update($wpdb->posts, $data, array('ID' => $post->ID));
			echo $post->ID;
			echo '<br/>';
		}else{
			echo $body;
			break;
			//echo $post->ID;
		}
	}
	
	function replace_url($found){
		$SITE = 'www.101waysmakemoney.com';
		if(strpos($found[1], 'onclick') !== false){
			$change = true;
			$res = "<a href=\"http://$SITE\">Make Money</a>";
		}
    	else if (strpos($found[1], 'yisec.com') !== false || strpos($found[1], '101waysmakemoney.com') !== false) {
    		$res = $found[0];
    	}else if(strpos($found[2], '.') !== false){
			$res = "<a href=\"http://$SITE\">$SITE</a>";
    	}else{
    		$res = "<a href=\"http://$SITE\">".$found[2].'</a>';
    	}
    	return $res;
	}
	
	function trip_selected_tags($text, $tags = array()) {
		$SITE = 'www.101waysmakemoney.com';
	    $args = func_get_args();
	    $text = array_shift($args);
	    $tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
	    foreach ($tags as $tag){
	    	$text = preg_replace_callback('#<'.$tag.' ([^>]*)>(.*?)</'. $tag .'>#ius', replace_url, $text);
	    }
	    $text = preg_replace('#(<('.join('|',$tags).')/>)#ius', '', $text);
	    //$text = preg_replace('#www.(.*?).com#i', $SITE, $text);
	    return $text;
	}
?>