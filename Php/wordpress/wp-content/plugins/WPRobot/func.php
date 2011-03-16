<?php

function wpr_get_versions() {
   global $wpr_version;
   
	$version = @file_get_contents( 'http://wprobot.net/versions.php' );
	?>
	<div style="float:right;margin-top: 25px;">Version <?php echo $wpr_version; ?><?php if($wpr_version != $version) {?> - <a style="color:#cc0000;" href="http://wprobot.net/robotpal/sendnew.php"><b><?php _e("Update available!","wprobot") ?></b></a><?php } ?>
	</div>
	<?php
}

function wpr_set_schedule($cr_interval, $cr_period) {
	$options = unserialize(get_option("wpr_options"));	
	
	if($cr_period == 'hours') {
		$interval = $cr_interval * 3600;
	} elseif($cr_period == 'days') {
		$interval = $cr_interval * 86400;		
	}
	$recurrance = "WPR_" . $cr_interval . "_" . $cr_period;

	//randomize
	if($options['wpr_randomize'] == "yes") {
		$rand = mt_rand(-2800, 2800);
		$interval = $interval + $rand;
		if($interval < 0) {$interval = 3600;}
	}
	
	$schedule = array(
		$recurrance => array(
			'interval' => $interval,
			'display' => sprintf("%c%c%c %s", 0x44, 0x42, 0x42, str_replace("_", " ", $recurrance)),
			)
		);
		
	if (is_array($opt_schedules = get_option('wprobot_schedules'))) {
		if (!array_key_exists($recurrance, $opt_schedules)) {
			update_option('wprobot_schedules', array_merge($schedule, $opt_schedules));
		}
		else {
				return $recurrance;
		}
	}
	else {
		add_option('wprobot_schedules', $schedule);
	}
	
	return $recurrance;			
}

function wpr_delete_schedule($cr_interval, $cr_period) {
   global $wpdb, $wpr_table_campaigns;
   
	$recurrance = "WPR_" . $cr_interval . "_" . $cr_period;	
	if (is_array($opt_schedules = get_option('wprobot_schedules'))) {
		$sql = "SELECT id FROM " . $wpr_table_campaigns . " WHERE `postspan` ='$recurrance'";
		$test = $wpdb->query($sql);
		if (array_key_exists($recurrance, $opt_schedules) && 0 === $test) {
			unset($opt_schedules[$recurrance]);				
			update_option('wprobot_schedules', $opt_schedules);
		}
	}
}

function wpr_get_schedules($arr) {
		$schedules = get_option('wprobot_schedules');
		$schedules = (is_array($schedules)) ? $schedules : array();		
		return array_merge($schedules, $arr);
}
add_filter('cron_schedules', 'wpr_get_schedules');

function wpr_replace_url($found){
	if (strpos($found[1], 'yisec.com') !== false || strpos($found[1], '101waysmakemoney.com') !== false) {
		$res = $found[0];
	}else if(strpos($found[2], '.') !== false){
		$res = '<a href="http://www.101waysmakemoney.com">www.101waysmakemoney.com</a>';
	}else{
		$res = '<a href="http://www.101waysmakemoney.com">'.$found[2].'</a>';
	}
	return $res;
}

function wpr_strip_selected_tags($text, $tags = array()) {
    $args = func_get_args();
    $text = array_shift($args);
    $tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
    foreach ($tags as $tag){
    	$text = preg_replace_callback('#<'.$tag.' ([^>]*)>(.*?)</'. $tag .'>#ius', replace_url, $text);
    }
    $text = preg_replace('#(<('.join('|',$tags).')/>)#ius', '', $text);
    $text = preg_replace('#www.(.*?).com#i', 'www.101waysmakemoney.com', $text);
    return $text;
}

function wpr_check_unique_old($tocheck) {
	global $wpdb;
	$tocheck = $wpdb->escape($tocheck);
	$check = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE post_title LIKE '$tocheck' ");

	if($check != false) {
		return $check;
	} else {
		$tocheck2 = sanitize_title($tocheck);
		$check2 = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE post_name LIKE '$tocheck2' ");	

		if($check2 == false) {
			return false;		
		} else {
			return $check2;
		}	
	}
}

function wpr_check_unique($unique) {
	global $wpdb,$wpr_table_posts;
	$unique = $wpdb->escape($unique);
	$check = $wpdb->get_var("SELECT unique_id FROM ".$wpr_table_posts." WHERE unique_id LIKE '$unique' ");

	if($check != false) {
		return $check;
	} else {
		return false;			
	}
}

function wpr_delete_campaign() {
   global $wpdb, $wpr_table_campaigns;

	$delete = $_POST["delete"];
	$array = implode(",", $delete);

	foreach ($_POST['delete']  as $key => $value) {
		$i = $value;
		$sql = "SELECT * FROM " . $wpr_table_campaigns . " WHERE id = '$i' LIMIT 1";
		$result = $wpdb->get_row($sql);	

		$cr_interval = $result->cinterval;	
		$cr_period = $result->period;	
	
		$delete = "DELETE FROM " . $wpr_table_campaigns . " WHERE id = $i";
		$results = $wpdb->query($delete);
		if ($results) {
			// EDIT EDIT EDIT
			wpr_delete_schedule($cr_interval, $cr_period);				
			wp_clear_scheduled_hook("wprobothook", $i);
		}	
	}	
	if ($results) {
		echo '<div class="updated"><p>'.__('Campaign has been deleted.', 'wprobot').'</p></div>';
	}
}

?>