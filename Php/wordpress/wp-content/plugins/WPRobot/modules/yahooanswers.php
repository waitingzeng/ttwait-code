<?php

function wpr_yahooanswersrequest($keyword,$num,$start,$yapcat) {	
	libxml_use_internal_errors(true);
	$options = unserialize(get_option("wpr_options"));	
	$appid = $options['wpr_yap_appkey'];
	$region = $options['wpr_yap_lang'];

	$keyword = str_replace(" ", "+", $keyword);			

    $request = "http://answers.yahooapis.com/AnswersService/V1/questionSearch?appid=".$appid."&query=".$keyword."&region=".$region."&type=resolved&start=".$start."&results=$num";
    if($yapcat != "") {
		$request .= "&category_id=$yapcat";
	}

	if ( function_exists('curl_init') ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $request);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$response = curl_exec($ch);
		if (!$response) {
			$return["error"]["module"] = "Yahoo Answers";
			$return["error"]["reason"] = "cURL Error";
			$return["error"]["message"] = __("cURL Error Number ","wprobot").curl_errno($ch).": ".curl_error($ch);	
			return $return;
		}		
		curl_close($ch);
	} else { 				
		$response = @file_get_contents($request);
		if (!$response) {
			$return["error"]["module"] = "Yahoo Answers";
			$return["error"]["reason"] = "cURL Error";
			$return["error"]["message"] = __("cURL is not installed on this server!","wprobot");	
			return $return;		
		}
	}
    
	$pxml = simplexml_load_string($response);
	if ($pxml === False) {
		$emessage = __("Failed loading XML, errors returned: ","wprobot");
		foreach(libxml_get_errors() as $error) {
			$emessage .= $error->message . ", ";
		}	
		libxml_clear_errors();
		$return["error"]["module"] = "Yahoo Answers";
		$return["error"]["reason"] = "XML Error";
		$return["error"]["message"] = $emessage;	
		return $return;			
	} else {
		return $pxml;
	}
}

function wpr_yap_getanswers($qid,$answercount) {

	$options = unserialize(get_option("wpr_options"));	
	$appid = $options['wpr_yap_appkey'];
	$requesturl = 'http://answers.yahooapis.com/AnswersService/V1/getQuestion?appid='.$appid.'&question_id='.$qid;

	if ( function_exists('curl_init') ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $requesturl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$response = curl_exec($ch);
		curl_close($ch);
	} else { 				
		$response = @file_get_contents($requesturl);
	}
    
    if ($response === False) {
    } else {
        $commentsFeed = simplexml_load_string($response);
    }	
	
	$answers = array();
	$i = 0;
	
	if(isset($commentsFeed->Question->Answers->Answer)) {
		foreach ($commentsFeed->Question->Answers->Answer as $answer) {
			$answers[$i]["author"] = $answer->UserNick;
			$answers[$i]["content"] = $answer->Content;	
			$i++;	
		}
	}
	
	return $answers;
}

function wpr_yahooanswerspost($keyword,$num,$start,$yapcat,$getcomments) {
	global $wpdb,$wpr_table_templates;
	
	if($keyword == "") {
		$return["error"]["module"] = "Yahoo Answers";
		$return["error"]["reason"] = "No keyword";
		$return["error"]["message"] = __("No keyword specified.","wprobot");
		return $return;	
	}	
	
	$options = unserialize(get_option("wpr_options"));	
	$template = $wpdb->get_var("SELECT content FROM " . $wpr_table_templates . " WHERE type = 'yahooanswers'");	
	if($template == false || empty($template)) {
		$return["error"]["module"] = "Yahoo Answers";
		$return["error"]["reason"] = "No template";
		$return["error"]["message"] = __("Module Template does not exist or could not be loaded.","wprobot");
		return $return;	
	}	
	$pxml = wpr_yahooanswersrequest($keyword,$num,$start,$yapcat);
	if(!empty($pxml["error"])) {return $pxml;}
	$x = 0;
	$posts = array();
	
	if ($pxml === False) {
		$posts["error"]["module"] = "Yahooanswers";
		$posts["error"]["reason"] = "Request fail";
		$posts["error"]["message"] = __("API request could not be sent.","wprobot");	
		return $posts;		
	} else {
		if (isset($pxml->Question)) {
			foreach($pxml->Question as $question) {
			
				$attrs = $question->attributes();
				$qid = $question['id']; 			
				$title = $question->Subject;
				$content = $question->Content;
				$url = $question->Link;
				$user = $question->UserNick;
				$answercount = $question->NumAnswers;
				
				if ($options['wpr_ya_striplinks_q']=='yes') {$content = wpr_strip_selected_tags($content, array('a','iframe','script'));}
				
				$post = $template;				
				$post = wpr_random_tags($post);
				
				// Answers
				$answerpost = "";
				preg_match('#\{answers(.*)\}#iU', $post, $rmatches);			
				if ($rmatches[0] != false || $getcomments == 1) {
					$answers = wpr_yap_getanswers($qid,$answercount);				
				}
				if ($rmatches[0] != false && !empty($answers)) {
					$answernum = substr($rmatches[1], 1);
					for ($i = 0; $i < $answercount; $i++) {
						if($i == $answernum) {break;} else {	
							$answerpost .= "<p><i>Answer by ".$answers[$i]["author"]."</i><br/>".$answers[$i]["content"]."</p>";
							// Remove posted answer from comments array
							unset($answers[$i]);
						}
					}
					$answers = array_values($answers);
					$post = str_replace($rmatches[0], $answerpost, $post);				
				} else {
					$post = str_replace($rmatches[0], "", $post);					
				}				
				
				$post = str_replace("{question}", $content, $post);							
				$post = str_replace("{keyword}", $keyword, $post);
				$post = str_replace("{url}", $url, $post);	
				$post = str_replace("{user}", $user, $post);	
				$post = str_replace("{title}", $title, $post);	
					if(function_exists("wpr_translate_partial")) {
						$post = wpr_translate_partial($post);
					}
					
				$posts[$x]["unique"] = $qid;
				$posts[$x]["title"] = $title;
				$posts[$x]["content"] = $post;	
				$posts[$x]["comments"] = $answers;	
				$x++;
			}
			
			if(empty($posts)) {
				$posts["error"]["module"] = "Yahooanswers";
				$posts["error"]["reason"] = "No content";
				$posts["error"]["message"] = __("No (more) Yahoo Answers content found.","wprobot");	
				return $posts;			
			} else {
				return $posts;	
			}				
			
		} else {
			if (isset($pxml->Message)) {
				$message = __('There was a problem with your API request. This is the error Yahoo returned:',"wprobot").' <b>'.$pxml->Message.'</b>';	
				$posts["error"]["module"] = "Yahooanswers";
				$posts["error"]["reason"] = "API fail";
				$posts["error"]["message"] = $message;	
				return $posts;				
			} else {
				$posts["error"]["module"] = "Yahooanswers";
				$posts["error"]["reason"] = "No content";
				$posts["error"]["message"] = __("No (more) Yahoo Answers content found.","wprobot");	
				return $posts;						
			}			
		}
	}	
}

function wpr_yahooanswers_options_default() {
	$options = array(
		"wpr_yap_appkey" => "",
		"wpr_yap_lang" => "us",
		"wpr_yap_yatos" => "no",
		"wpr_ya_striplinks_q" => "no",
		"wpr_ya_striplinks_a" => "no"
	);
	return $options;
}

function wpr_yahooanswers_options($options) {
	?>
	<h3 style="text-transform:uppercase;border-bottom: 1px solid #ccc;"><?php _e("Yahoo Answers Options","wprobot") ?></h3>	
		<table class="addt" width="100%" cellspacing="2" cellpadding="5" class="editform"> 
			<tr <?php if($options['wpr_yap_appkey'] == "") {echo 'style="background:#F8E0E0;"';} ?> valign="top"> 
				<td width="40%" scope="row"><?php _e("Yahoo Application ID:","wprobot") ?></td> 
				<td><input size="40" name="wpr_yap_appkey" type="text" id="wpr_yap_appkey" value="<?php echo $options['wpr_yap_appkey'] ;?>"/>
				<!--Tooltip--><a target="_blank" class="tooltip" href="http://developer.yahoo.com/answers/">?<span><?php _e('This setting is required for the Yahoo Answers module to work!<br/><br/><b>Click to go to the Yahoo API sign up page!</b>',"wprobot") ?></span></a>
			</td> 
			</tr>			
			<tr valign="top"> 
				<td width="40%" scope="row"><?php _e('Add "Powered by Yahoo! Answers" text to footer?',"wprobot") ?></td> 
				<td><input name="wpr_yap_yatos" type="checkbox" id="wpr_yap_yatos" value="yes" <?php if ($options['wpr_yap_yatos']=='yes') {echo "checked";} ?>/> <?php _e("Yes","wprobot") ?>
				<!--Tooltip--><a class="tooltip" href="#">?<span><?php _e('By the Yahoo Answers TOS it is required that you display the text \'Powered by Yahoo! Answers\' on pages you use the API on. If you disable this option you can display the text anywhere else on your weblog.',"wprobot") ?></span></a></td> 
			</tr>	
			<tr valign="top"> 
				<td width="40%" scope="row"><?php _e("Country:","wprobot") ?></td> 
				<td>
				<select name="wpr_yap_lang" id="wpr_yap_lang">
							<option value="us" <?php if($options['wpr_yap_lang']=="us"){_e('selected');}?>><?php _e("USA","wprobot") ?></option>
							<option value="uk" <?php if($options['wpr_yap_lang']=="uk"){_e('selected');}?>><?php _e("United Kingdom","wprobot") ?></option>								
							<option value="ca" <?php if($options['wpr_yap_lang']=="ca"){_e('selected');}?>><?php _e("Canada","wprobot") ?></option>	
							<option value="au" <?php if($options['wpr_yap_lang']=="au"){_e('selected');}?>><?php _e("Australia","wprobot") ?></option>			
							<option value="de" <?php if($options['wpr_yap_lang']=="de"){_e('selected');}?>><?php _e("Germany","wprobot") ?></option>
							<option value="fr" <?php if($options['wpr_yap_lang']=="fr"){_e('selected');}?>><?php _e("France","wprobot") ?></option>
							<option value="it" <?php if($options['wpr_yap_lang']=="it"){_e('selected');}?>><?php _e("Italy","wprobot") ?></option>	
							<option value="es" <?php if($options['wpr_yap_lang']=="es"){_e('selected');}?>><?php _e("Spain","wprobot") ?></option>		
							<option value="br" <?php if($options['wpr_yap_lang']=="br"){_e('selected');}?>><?php _e("Brazil","wprobot") ?></option>
							<option value="ar" <?php if($options['wpr_yap_lang']=="ar"){_e('selected');}?>><?php _e("Argentina","wprobot") ?></option>
							<option value="mx" <?php if($options['wpr_yap_lang']=="mx"){_e('selected');}?>><?php _e("Mexico","wprobot") ?></option>
							<option value="sg" <?php if($options['wpr_yap_lang']=="sg"){_e('selected');}?>><?php _e("Singapore","wprobot") ?></option>								
				</select>
			</td> 
			</tr>					
			<tr valign="top"> 
				<td width="40%" scope="row"><?php _e("Strip All Links from...","wprobot") ?></td> 
				<td><input name="wpr_ya_striplinks_q" type="checkbox" id="wpr_ya_striplinks_q" value="yes" <?php if ($options['wpr_ya_striplinks_q']=='yes') {echo "checked";} ?>/> <?php _e("Questions","wprobot") ?><br/>
				<input name="wpr_ya_striplinks_a" type="checkbox" id="wpr_ya_striplinks_a" value="yes" <?php if ($options['wpr_ya_striplinks_a']=='yes') {echo "checked";} ?>/> <?php _e("Answers","wprobot") ?></td> 
			</tr>				
		</table>	
	<?php
}

function wpr_yap_showtos() {
	$options = unserialize(get_option("wpr_options"));	
	if ($options['wpr_yap_yatos'] == 'yes') {
		echo '<p>Powered by Yahoo! Answers</p>';
	}
}
add_action('wp_footer', 'wpr_yap_showtos'); 
?>