<?php

Class HtmlFixer {
	public $dirtyhtml;
	public $fixedhtml;
	private $matrix;	//array used to store nodes
	public $debug;
	private $fixedhtmlDisplayCode;

	public function __construct() {
		$this->dirtyhtml = "";
		$this->fixedhtml = "";
		$this->debug = false;
		$this->fixedhtmlDisplayCode = "";
	}

	public function getFixedHtml($dirtyhtml) {
		$c = 0;
		$this->dirtyhtml = $dirtyhtml;
		$errorsFound=0;
		while ($c<10) {
			/*
				iterations, every time it's getting better...
			*/
			if ($c>0) $this->dirtyhtml = $this->fixedxhtml;
			$errorsFound = $this->charByCharJob();
			if (!$errorsFound) $c=10;	// if no corrections made, stops iteration
			$this->fixedxhtml=str_replace('<root>','',$this->fixedxhtml);
			$this->fixedxhtml=str_replace('</root>','',$this->fixedxhtml);
			$this->fixedxhtml = $this->removeSpacesAndBadTags($this->fixedxhtml);
			$c++;
		}
		return $this->fixedxhtml;
	}

	private function fixStrToLower($m){
		/*
			$m is a part of the tag: make the first part of attr=value lowercase
		*/
		$right = strstr($m, '=');
		$left = str_replace($right,'',$m);
		return strtolower($left).$right;
	}

	private function fixQuotes($s){
		if (!stristr($s,"=")) return $s;
		$out = $s;
		preg_match_all("|=(.*)|",$s,$o,PREG_PATTERN_ORDER);
		for ($i = 0; $i< count ($o[1]); $i++) {
			$t = trim ( $o[1][$i] ) ;
			$lc="";
			if ($t!="") {
				if ($t[strlen($t)-1]==">") {
					$lc= ($t[strlen($t)-2].$t[strlen($t)-1])=="/>"  ?  "/>"  :  ">" ;
					$t=substr($t,0,-1);
				}
				//missing " or ' at the beginning
				if (($t[0]!="\"")&&($t[0]!="'")) $out = str_replace( $t, "\"".$t,$out); else $q=$t[0];
				//missing " or ' at the end
				if (($t[strlen($t)-1]!="\"")&&($t[strlen($t)-1]!="'")) $out = str_replace( $t.$lc, $t.$q.$lc,$out);
			}
		}
		return $out;
	}

	private function fixTag($t){
		/* remove non standard attributes and call the fix for quoted attributes */
		$t = preg_replace (
			array(
				'/borderColor=([^ >])*/i',
				'/border=([^ >])*/i'
			), 
			array(
				'',
				''
			)
			, $t);
		$ar = explode(" ",$t);
		$nt = "";
		for ($i=0;$i<count($ar);$i++) {
			$ar[$i]=$this->fixStrToLower($ar[$i]);
			if (stristr($ar[$i],"=") && !stristr($ar[$i],"=\"")) $ar[$i] = $this->fixQuotes($ar[$i]);
			$nt.=$ar[$i]." ";
		}
		$nt=preg_replace("/<( )*/i","<",$nt);
		$nt=preg_replace("/( )*>/i",">",$nt);
		return trim($nt);
	}

	private function extractChars($tag1,$tag2,$tutto) { /*extract a block between $tag1 and $tag2*/
		if (!stristr($tutto, $tag1)) return '';
		$s=stristr($tutto,$tag1);
		$s=substr( $s,strlen($tag1));
		if (!stristr($s,$tag2)) return '';
		$s1=stristr($s,$tag2);
		return substr($s,0,strlen($s)-strlen($s1));
	}

	private function mergeStyleAttributes($s) {
		//
		// merge many style definitions in the same tag in just one attribute style
		//
		$x = "";
		$temp = "";
		$c = 0;
		while(stristr($s,"style=\"")) {
			$temp = $this->extractChars("style=\"","\"",$s);
			if ($temp=="") {
				// missing closing quote! add missing quote.
				return preg_replace("/(\/)?>/i","\"\\1>",$s);
			}
			if ($c==0) $s = str_replace("style=\"".$temp."\"","##PUTITHERE##",$s);
				$s = str_replace("style=\"".$temp."\"","",$s);
			if (!preg_match("/;$/i",$temp)) $temp.=";";
			$x.=$temp;
			$c++;
		}
		if ($c>0) $s = str_replace("##PUTITHERE##","style=\"".$x."\"",$s);
		return $s;
	}

	private function fixAutoclosingTags($tag,$tipo=""){
		/*
			metodo richiamato da fix() per aggiustare i tag auto chiudenti (<br/> <img ... />)
		*/
		if (in_array( $tipo, array ("img","input","br","hr")) ) {
			if (!stristr($tag,'/>')) $tag = str_replace('>','/>',$tag );
		}
		return $tag;
	}

	private function getTypeOfTag($tag) {
		$tag = trim(preg_replace("/[\>\<\/]/i","",$tag));
		$a = explode(" ",$tag);
		return $a[0];
	}


	private function checkTree() {
		// return the number of errors found
		$errorsCounter = 0;
		for ($i=1;$i<count($this->matrix);$i++) {
			$flag=false;
			if ($this->matrix[$i]["tagType"]=="div") { //div cannot stay inside a p, b, etc.
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em"))) $flag=true;
			}

			if (in_array( $this->matrix[$i]["tagType"], array( "b", "strong" )) ) { //b cannot stay inside b o strong.
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("b","strong"))) $flag=true;
			}

			if (in_array( $this->matrix[$i]["tagType"], array ( "i", "em") )) { //i cannot stay inside i or em
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("i","em"))) $flag=true;
			}

			if ($this->matrix[$i]["tagType"]=="p") {
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em"))) $flag=true;
			}

			if ($this->matrix[$i]["tagType"]=="table") {
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em","tr","table"))) $flag=true;
			}
			if ($flag) {
				$errorsCounter++;
				if ($this->debug) echo "<div style='color:#ff0000'>Found a <b>".$this->matrix[$i]["tagType"]."</b> tag inside a <b>".htmlspecialchars($parentType)."</b> tag at node $i: MOVED</div>";
				
				$swap = $this->matrix[$this->matrix[$i]["parentTag"]]["parentTag"];
				if ($this->debug) echo "<div style='color:#ff0000'>Every node that has parent ".$this->matrix[$i]["parentTag"]." will have parent ".$swap."</div>";
				$this->matrix[$this->matrix[$i]["parentTag"]]["tag"]="<!-- T A G \"".$this->matrix[$this->matrix[$i]["parentTag"]]["tagType"]."\" R E M O V E D -->";
				$this->matrix[$this->matrix[$i]["parentTag"]]["tagType"]="";
				$hoSpostato=0;
				for ($j=count($this->matrix)-1;$j>=$i;$j--) {
					if ($this->matrix[$j]["parentTag"]==$this->matrix[$i]["parentTag"]) {
						$this->matrix[$j]["parentTag"] = $swap;
						$hoSpostato=1;
					}
				}
			}

		}
		return $errorsCounter;

	}

	private function findSonsOf($parentTag) {
		// build correct html recursively
		$out= "";
		for ($i=1;$i<count($this->matrix);$i++) {
			if ($this->matrix[$i]["parentTag"]==$parentTag) {
				if ($this->matrix[$i]["tag"]!="") {
					$out.=$this->matrix[$i]["pre"];
					$out.=$this->matrix[$i]["tag"];
					$out.=$this->matrix[$i]["post"];
				} else {
					$out.=$this->matrix[$i]["pre"];
					$out.=$this->matrix[$i]["post"];
				}
				if ($this->matrix[$i]["tag"]!="") {
					$out.=$this->findSonsOf($i);
					if ($this->matrix[$i]["tagType"]!="") {
						//write the closing tag
						if (!in_array($this->matrix[$i]["tagType"], array ( "br","img","hr","input"))) 
							$out.="</". $this->matrix[$i]["tagType"].">";
					}
				}
			}
		}
		return $out;
	}

	private function findSonsOfDisplayCode($parentTag) {
		//used for debug
		$out= "";
		for ($i=1;$i<count($this->matrix);$i++) {
			if ($this->matrix[$i]["parentTag"]==$parentTag) {
				$out.= "<div style=\"padding-left:15\"><span style='float:left;background-color:#FFFF99;color:#000;'>{$i}:</span>";
				if ($this->matrix[$i]["tag"]!="") {
					if ($this->matrix[$i]["pre"]!="") $out.=htmlspecialchars($this->matrix[$i]["pre"])."<br>";
					$out.="".htmlspecialchars($this->matrix[$i]["tag"])."<span style='background-color:red; color:white'>{$i} <em>".$this->matrix[$i]["tagType"]."</em></span>";
					$out.=htmlspecialchars($this->matrix[$i]["post"]);
				} else {
					if ($this->matrix[$i]["pre"]!="") $out.=htmlspecialchars($this->matrix[$i]["pre"])."<br>";
					$out.=htmlspecialchars($this->matrix[$i]["post"]);
				}
				if ($this->matrix[$i]["tag"]!="") {
					$out.="<div>".$this->findSonsOfDisplayCode($i)."</div>\n";
					if ($this->matrix[$i]["tagType"]!="") {
						if (($this->matrix[$i]["tagType"]!="br") && ($this->matrix[$i]["tagType"]!="img") && ($this->matrix[$i]["tagType"]!="hr")&& ($this->matrix[$i]["tagType"]!="input"))
							$out.="<div style='color:red'>".htmlspecialchars("</". $this->matrix[$i]["tagType"].">")."{$i} <em>".$this->matrix[$i]["tagType"]."</em></div>";
					}
				}
				$out.="</div>\n";
			}
		}
		return $out;
	}

	private function removeSpacesAndBadTags($s) {
		$i=0;
		while ($i<10) {
			$i++;
			$s = preg_replace (
				array(
					'/[\r\n]/i',
					'/  /i',
					'/<p([^>])*>(&nbsp;)*\s*<\/p>/i',
					'/<span([^>])*>(&nbsp;)*\s*<\/span>/i',
					'/<strong([^>])*>(&nbsp;)*\s*<\/strong>/i',
					'/<em([^>])*>(&nbsp;)*\s*<\/em>/i',
					'/<font([^>])*>(&nbsp;)*\s*<\/font>/i',
					'/<small([^>])*>(&nbsp;)*\s*<\/small>/i',
					'/<\?xml:namespace([^>])*><\/\?xml:namespace>/i',
					'/<\?xml:namespace([^>])*\/>/i',
					'/class=\"MsoNormal\"/i',
					'/<o:p><\/o:p>/i',
					'/<!DOCTYPE([^>])*>/i',
					'/<!--(.|\s)*?-->/',
					'/<\?(.|\s)*?\?>/'
				), 
				array(
					' ',
					' ',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					' ',
					'',
					''
				)
				, trim($s));
		}
		return $s;
	}

	private function charByCharJob() {
		$s = $this->removeSpacesAndBadTags($this->dirtyhtml);
 		if ($s=="") return;
		$s = "<root>".$s."</root>";
		$contenuto = "";
		$ns = "";
		$i=0;
		$j=0;
		$indexparentTag=0;
		$padri=array();
		array_push($padri,"0");
		$this->matrix[$j]["tagType"]="";
		$this->matrix[$j]["tag"]="";
		$this->matrix[$j]["parentTag"]="0";
		$this->matrix[$j]["pre"]="";
		$this->matrix[$j]["post"]="";
		$tags=array();
		while($i<strlen($s)) {
			if ( $s[$i] =="<") {
				/*
					found a tag
				*/
				$contenuto = $ns;
				$ns = "";
				
				$tag="";
				while( $i<strlen($s) && $s[$i]!=">" ){
					// get chars till the end of a tag
					$tag.=$s[$i];
					$i++;
				}
				$tag.=$s[$i];
				
				if($s[$i]==">") {
					/*
						$tag contains a tag <...chars...>
						let's clean it!
					*/
					$tag = $this->fixTag($tag);
					$tagType = $this->getTypeOfTag($tag);
					$tag = $this->fixAutoclosingTags($tag,$tagType);
					$tag = $this->mergeStyleAttributes($tag);

					if (!isset($tags[$tagType])) $tags[$tagType]=0;
					$tagok=true;
					if (($tags[$tagType]==0)&&(stristr($tag,'/'.$tagType.'>'))) {
						$tagok=false;
						/* there is a close tag without any open tag, I delete it */
						if ($this->debug) echo "<div style='color:#ff0000'>Found a closing tag <b>".htmlspecialchars($tag)."</b> at char $i without open tag: REMOVED</div>";
					}
				}
				if ($tagok) {
					$j++;
					$this->matrix[$j]["pre"]="";
					$this->matrix[$j]["post"]="";
					$this->matrix[$j]["parentTag"]="";
					$this->matrix[$j]["tag"]="";
					$this->matrix[$j]["tagType"]="";
					if (stristr($tag,'/'.$tagType.'>')) {
						/*
							it's the closing tag
						*/
						$ind = array_pop($padri);
						$this->matrix[$j]["post"]=$contenuto;
						$this->matrix[$j]["parentTag"]=$ind;
						$tags[$tagType]--;
					} else {
						if (@preg_match("/".$tagType."\/>$/i",$tag)||preg_match("/\/>/i",$tag)) {
							/*
								it's a autoclosing tag
							*/
							$this->matrix[$j]["tagType"]=$tagType;
							$this->matrix[$j]["tag"]=$tag;
							$indexparentTag = array_pop($padri);
							array_push($padri,$indexparentTag);
							$this->matrix[$j]["parentTag"]=$indexparentTag;
							$this->matrix[$j]["pre"]=$contenuto;
							$this->matrix[$j]["post"]="";
						} else {
							/*
								it's a open tag
							*/
							$tags[$tagType]++;
							$this->matrix[$j]["tagType"]=$tagType;
							$this->matrix[$j]["tag"]=$tag;
							$indexparentTag = array_pop($padri);
							array_push($padri,$indexparentTag);
							array_push($padri,$j);
							$this->matrix[$j]["parentTag"]=$indexparentTag;
							$this->matrix[$j]["pre"]=$contenuto;
							$this->matrix[$j]["post"]="";
						}
					}
				}
			} else {
				/*
					content of the tag
				*/
				$ns.=$s[$i];
			}
			$i++;
		}
		/*
			remove not valid tags
		*/
		for ($eli=$j+1;$eli<count($this->matrix);$eli++) {
			$this->matrix[$eli]["pre"]="";
			$this->matrix[$eli]["post"]="";
			$this->matrix[$eli]["parentTag"]="";
			$this->matrix[$eli]["tag"]="";
			$this->matrix[$eli]["tagType"]="";
		}
		$errorsCounter = $this->checkTree();		// errorsCounter contains the number of removed tags
		$this->fixedxhtml=$this->findSonsOf(0);	// build html fixed
		if ($this->debug) {
			$this->fixedxhtmlDisplayCode=$this->findSonsOfDisplayCode(0);
			echo "<table border=1 cellspacing=0 cellpadding=0>";
			echo "<tr><th>node id</th>";
			echo "<th>pre</th>";
			echo "<th>tag</th>";
			echo "<th>post</th>";
			echo "<th>parentTag</th>";
			echo "<th>tipo</th></tr>";
			for ($k=0;$k<=$j;$k++) {
				echo "<tr><td>$k</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["pre"])."</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["tag"])."</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["post"])."</td>";
				echo "<td>&nbsp;".$this->matrix[$k]["parentTag"]."</td>";
				echo "<td>&nbsp;<i>".$this->matrix[$k]["tagType"]."</i></td></tr>";
			}
			echo "</table>";
			echo "<hr/>{$j}<hr/>\n\n\n\n".$this->fixedxhtmlDisplayCode;
		}
		return $errorsCounter;
	}
}

function wpr_gettr( $url, $post, $referer = "") {

	$options = unserialize(get_option("wpr_options"));	
	$proxy == "";
	if($options["wpr_trans_use_proxies"] == "yes") {
		$proxies = str_replace("\r", "", $options["wpr_trans_proxies"]);
		$proxies = explode("\n", $proxies);  
		$rand = array_rand($proxies);	
		list($proxy,$proxytype,$proxyuser)=explode("|",$proxies[$rand]);
	}
	
   /* echo $proxy."<br>";
	*/

	$blist[] = "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)";
	$blist[] = "Mozilla/5.0 (compatible; Konqueror/3.92; Microsoft Windows) KHTML/3.92.0 (like Gecko)";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; WOW64; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; Media Center PC 5.0; .NET CLR 1.1.4322; Windows-Media-Player/10.00.00.3990; InfoPath.2";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; Dealio Deskball 3.0)";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; NeosBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";
	$br = $blist[array_rand($blist)];
	if ( function_exists('curl_init') ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $br);
			if($proxy != "") {
				curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
				curl_setopt($ch, CURLOPT_PROXY, $proxy);
				if($proxyuser) {curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuser);}
				if($proxytype == "socks") {curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);}
			}			
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$buffer = curl_exec ($ch);
		if (!$buffer) {
			// remove dead
			/*if($options["wpr_trans_delete_proxies"] == "yes") {
				unset($proxies[$rand]);
				$proxies = implode("\r\n", $proxies);  
				$options["wpr_trans_proxies"] = $proxies;
				update_option("wpr_options", serialize($options));	
			}*/
			$return["error"]["module"] = "Translation";
			$return["error"]["reason"] = "cURL Error";
			$return["error"]["message"] = __("cURL Error ","wprobot").curl_errno($ch).": ".curl_error($ch);
			if(isset($proxy)) {$return["error"]["message"] .= " (Proxy $proxy)";}
			return $return;
		}				
		curl_close ($ch);
		return $buffer;
	} else { 				
		$return["error"]["module"] = "Translation";
		$return["error"]["reason"] = "cURL Error";
		$return["error"]["message"] = __("cURL is not installed on this server!","wprobot");	
		return $return;		
	}
}
function google_translate( $text, $destLang = 'es', $srcLang = 'en' ) {
	$text = urlencode( $text );
	$destLang = urlencode( $destLang );
	$srcLang = '';//urlencode( $srcLang );
	
	$url = "http://ajax.googleapis.com/ajax/services/language/translate?h1=en&v=1.0&q={$text}&langpair={$srcLang}%7C{$destLang}";
	//print_r($url);
	$trans = @file_get_contents($url);
	if(!function_exists(json_decode)){
		include_once(ABSPATH . './wp-includes/cls_json.php');
	}
	$json = json_decode( $trans, true );
	
	if( $json['responseStatus'] != '200' ){ 
		$return["error"]["module"] = "Translation";
		$return["error"]["reason"] = "googleapis error";
		$return["error"]["message"] = __($trans . $url, "wprobot");
		return $return;
	}
	else return $json['responseData']['translatedText'];

}


function wpr_gtrns($text, $from, $to) {
	if($to=="tw"||$to=="cn") {
		$to="zh-".strtoupper($to);
	}
	if($to=="nor") {$to=="no";}
	if(strlen($text) > 256){
		$texts = explode("\n", $text);
	}else{
		$texts = array($text);
	}
	$output = array();
	foreach ($texts as $value){
		if(!$value){
			$output[] = $value;
			continue;
		}
		$res = google_translate($value, $to, $from);
		if(!empty($res["error"]["reason"])) {
			$res['error']['message'] .= $text;
			return $res;
		}else{
			$output[] = $res;
		}
	}
	if(count($output) == 0){
		$return["error"]["module"] = "Translation";
		$return["error"]["reason"] = "cURL Error";
		$return["error"]["message"] = __("cURL Error ","wprobot");
		return $return;
	}else {
		return join("\n", $output);
	}
}

function wpr_trans_format($transtext) {
		// TO DO: 
		// - HTMLFIXER CLASS NECESSARY?
		$transtext =str_replace('&lt; / ','</',$transtext);
		$transtext =str_replace('&lt;/ ','</',$transtext);
		$transtext =str_replace('&lt; /','</',$transtext);
		$transtext =str_replace('&lt; ','<',$transtext);
		//$transtext =str_replace('&lt;','<',$transtext);
		//$transtext =str_replace('&gt;','>',$transtext);
		$transtext =str_replace('num = "','num="',$transtext);
		$transtext =str_replace('kw = "','kw="',$transtext);
		$transtext =str_replace('ebcat = "','ebcat="',$transtext);
		$transtext =str_replace('[Wprebay','[wprebay',$transtext);
		$transtext =str_replace('[/ ','[/',$transtext);
		$transtext =str_replace('Has_rating','has_rating',$transtext);
		//echo $transtext . "<br/>--------------------------------------------<br/>";
		$transtext = html_entity_decode($transtext);
		//echo $transtext . "<br/>--------------------------------------------<br/>";		
		$transtext = stripslashes($transtext);
		$a = new HtmlFixer();
		$transtext = $a->getFixedHtml($transtext);	
		//echo $transtext . "<br/>--------------------------------------------<br/>";		

		return $transtext;

}

function wpr_translate($text,$t1="",$t2="",$t3="",$t4="") {

	if(empty($text)) {
		$return["error"]["module"] = "Translation";
		$return["error"]["reason"] = "Translation Failed";
		$return["error"]["message"] = __("Empty text given.","wprobot");	
		return $return;		
	}
	
	if(empty($t2)) {
		$return["error"]["module"] = "Translation";
		$return["error"]["reason"] = "Translation Failed";
		$return["error"]["message"] = __("No target language specified.","wprobot");	
		return $return;		
	}		
	
	if($t1 == $t2) {
		$return["error"]["module"] = "Translation";
		$return["error"]["reason"] = "Translation Failed";
		$return["error"]["message"] = __("Same languages specified.","wprobot");	
		return $return;		
	}		
	
	// SAVE URLS
	//echo "<br/>------------------SAVE-----------------<br/>";
	preg_match_all('#href\s*=\s*"(.*)"#siU', $text, $matches, PREG_SET_ORDER);
	//print_r($matches);
	// SAVE SRC
	preg_match_all('#src\s*=\s*"(.*)"#siU', $text, $matches2, PREG_SET_ORDER);

	if ($t1!='no' && $t2!='no') {
		$transtext = wpr_gtrns($text, $t1, $t2);
		if(!empty($transtext["error"]["reason"])) {
			return $transtext;
		}		
		$transtext = wpr_trans_format($transtext);
	}
	if ($t1!='no'  && $t2!='no'  && $t3!='no') {
		$transtext = wpr_gtrns($transtext, $t2, $t3);
		if(!empty($transtext["error"]["reason"])) {
			return $transtext;
		}			
		$transtext = wpr_trans_format($transtext);
	}
	if ($t1!='no'  && $t2!='no'  && $t3!='no'  && $t4!='no') {
		$transtext = wpr_gtrns($transtext, $t3, $t4);
		if(!empty($transtext["error"]["reason"])) {
			return $transtext;
		}			
		$transtext = wpr_trans_format($transtext);
	}	

	$pos = strpos($transtext, "302 Moved");
	$pos2 = strpos($transtext, "301 Moved");	
	$pos3 = strpos($transtext, "404 Not Found");							
	if ($pos === false && $pos2 === false && $pos3 === false) {
		$moved = 2;
	} else {	
		$moved = 1;
	}				 

	if ( !empty($transtext) && $transtext != ' ' && $moved != 1) {
	
		// REPLACE URLS
		//echo "<br/>------------------REPLACE-----------------<br/>";\s*=\s*
		//preg_match_all('#href = "(.*)"#siU', $transtext, $rmatches, PREG_SET_ORDER);
		preg_match_all('#href\s*=\s*"(.*)"#siU', $transtext, $rmatches, PREG_SET_ORDER);
		if ($rmatches) {
			$i=0;
			foreach($rmatches as $rmatch) {	// HREF = $match[1]	
				//echo "<br/>ORIGINAL: ".$matches[$i][1];
				//echo "<br/>REPLACEMENT: ".$rmatch[1];
				$transtext = str_replace($rmatch[1], $matches[$i][1], $transtext);
				$i++;
			}
		}		//print_r($rmatches);
		// REPLACE SRC
		//preg_match_all('#src ="(.*)"#siU', $transtext, $rmatches2, PREG_SET_ORDER);
		preg_match_all('#src\s*=\s*"(.*)"#siU', $transtext, $rmatches2, PREG_SET_ORDER);
		if ($rmatches2) {
			$i=0;
			foreach($rmatches2 as $rmatch2) {	// HREF = $match[1]	
				$transtext = str_replace($rmatch2[1], $matches2[$i][1], $transtext);
				$i++;
			}
		}

		return $transtext;
	} else {
		$return["error"]["module"] = "Translation";
		$return["error"]["reason"] = "Translation Failed";
		$return["error"]["message"] = __("The post could not be translated.","wprobot");	
		return $return;		
	}
}

function wpr_translate_partial($content) {

	$checkcontent = $content;
	
	preg_match_all('#\[translate(.*)\](.*)\[/translate\]#smiU', $checkcontent, $matches, PREG_SET_ORDER);
	if ($matches) {
		foreach($matches as $match) {
			$match[1] = substr($match[1], 1);
			$langs = explode("|", $match[1]);
			if(!empty($langs)) {

				if(empty($langs[0])) {$langs[0] = "no";}
				if(empty($langs[1])) {$langs[1] = "no";}
				if(empty($langs[2])) {$langs[2] = "no";}
				if(empty($langs[3])) {$langs[3] = "no";}
				$transcontent = wpr_translate($match[2],$langs[0],$langs[1],$langs[2],$langs[3]);

			}
			
			if(!empty($transcontent) && !is_array($transcontent)) {
				$content = str_replace($match[0], $transcontent, $content);	
				return $content;
			} else {
				return $content;
			}
		}
	} else {
		return $content;	
	}	
	
	if(!empty($transcontent) && !is_array($transcontent)) {
		return $transcontent;
	} else {
		return $content;
	}

}

function wpr_translation_options_default() {
	$options = array(
		"wpr_trans_use_proxies" => "no",
		"wpr_trans_proxies" => "",
		"wpr_trans_fail" => "post",
		"wpr_trans_delete_proxies" => "yes",
		"wpr_trans_titles" => "yes"
	);
	return $options;
}

function wpr_translation_options($options) {
	?>
	<h3 style="text-transform:uppercase;border-bottom: 1px solid #ccc;"><?php _e("Translation Options","wprobot") ?></h3>			
		<table class="addt" width="100%" cellspacing="2" cellpadding="5" class="editform"> 		
			<tr valign="top"> 
				<td width="40%" scope="row"><?php _e("Use Proxies","wprobot") ?></td> 
				<td>
				<input name="wpr_trans_use_proxies" type="checkbox" id="wpr_trans_use_proxies" value="yes" <?php if ($options['wpr_trans_use_proxies']=='yes') {echo "checked";} ?>/> <?php _e("Yes, randomly select one of the following:","wprobot") ?>
				<textarea name="wpr_trans_proxies" rows="4" cols="32"><?php echo $options['wpr_trans_proxies'];?></textarea>	
				<!--Tooltip--><a class="tooltip" href="#">?<span><?php _e('Enter one proxy IP address per line. A random one will be selected for each post. Example:<br/><br/>222.77.14.55:80<br/>221.130.7.74:80<br/><br/>If you have socks5 proxies or private proxies you can use the following format to enter them:<br/><br/>IP|Type|User:Password<br/><br/>Example:<br/>221.130.7.74:80|socks|user:pass<br/>221.130.7.74:80|http|user:pass',"wprobot") ?></span></a>
				<br/>
				<!--<input name="wpr_trans_delete_proxies" type="checkbox" id="wpr_trans_delete_proxies" value="yes" <?php if ($options['wpr_trans_delete_proxies']=='yes') {echo "checked";} ?>/> <?php _e("Delete dead proxies automatically","wprobot") ?>-->
				</td> 
			</tr>
			<tr valign="top"> 
				<td width="40%" scope="row"><?php _e("If translation fails...","wprobot") ?></td> 
				<td>
				<select name="wpr_trans_fail" id="wpr_trans_fail">
					<option value="skip" <?php if($options['wpr_trans_fail']=="skip"){_e('selected');}?>><?php _e("Skip Post","wprobot") ?></option>
					<option value="post" <?php if($options['wpr_trans_fail']=="post"){_e('selected');}?>><?php _e("Create Untranslated Post","wprobot") ?></option>

				</select>				
				</td> 
			</tr>		
			<tr valign="top"> 
				<td width="40%" scope="row"><?php _e("Translate Titles","wprobot") ?></td> 
				<td>
				<input name="wpr_trans_titles" type="checkbox" id="wpr_trans_titles" value="yes" <?php if ($options['wpr_trans_titles']=='yes') {echo "checked";} ?>/> <?php _e("Yes","wprobot") ?>
				<!--Tooltip--><a class="tooltip" href="#">?<span><?php _e('Choose wether to translate post titles for translated content. If you are translating to a foreign language this has to be enabled or otherwise the titles will stay English. If using the translation feature for rewriting it is recommended to disable this setting in order to reduce requests to Google Translate.',"wprobot") ?></span></a>
				</td> 
			</tr>			
		</table>	
	<?php
}

?>