<?php
/*

   Plugin Name: Auto Social Poster

   Plugin URI:  http://www.autosocialposter.com

   Description: Auto-bookmarks your blog post permalink to over 30 bookmarking sites.

   Version:     3.91

   Author:      Mass Automaton Tools

   Author URI:  http://www.mass-automation.com

 */

define ('MM_PLUGIN_NAME', 'Auto Social Poster');
define ('MM_GLOBAL_ID', 'mm_myautosocialposter');
define ('MM_CONF_FILE', dirname (__FILE__).'/mm_conf.php');
define ('ASP_ERROR_OK', 1);
define ('ASP_ERROR_LOGIN', 2);
define ('ASP_ERROR_POST', 3);
define ('ASP_CONNECT_TIMEOUT', 4);
define ('ASP_TRANSFER_TIMEOUT', 10);
define ('ASP_PING_LATER', 'asp_ping_later');
define ('ASP_DEBUG', false);
$asp_services = array(
  'backflip',
  'bibsonomy',
  'blinklist',
  'blogmarks',
  'buddymarks',
  'connectedy',
  'delicious',
  'delirious',
  'faves',
  'google',
  'linkagogo',
  'linkatopia',
  'linkroll',
  'magnolia',
  'markaboo',
  'misterWong',
  'myweb',
  'propeller',
  'scuttle',
  'scuttlePLUS',
  'searchles',
  'sphinn',
  'xilinus',
);

// 'reddit',
/* old ------------

$asp_services = array(

    'backflip', 'blinklist', 'blogmarks', 'blogmemes', 'connotea', 'delicious',

    'feedmelinks', 'furl',  'google', 'jots', 'linkagogo', 'linkroll', 'looklater',

    'magnolia', 'markaboo',  'myweb', 'rawsugar', 

    'shadows', 'simpy', 'scuttle','scuttlePLUS', 'spurl', 'smarking', 'wink'

);

clode old---------

*/

if (function_exists ('is_plugin_page') && is_plugin_page ())
{
  include (dirname (__FILE__).'/mm_options.php');
  return;
}
if ($_GET[offset] == "")
{
  $mm_offsetsec = get_settings ("gmt_offset");
}
else
{
  $mm_offsetsec = $_GET[offset];
}
$mm_currtime = mktime () + (18000 - ($mm_offsetsecs * 3600));

/**

 * Collects information about post for posting services.

 */

if (!function_exists ("mm_get_post_infomm"))
{

  function mm_get_post_infomm ($postID)
  {
    global $post, $id;
    $saved_global_post = $post;
    $saved_global_id = $id;
    $id = $postID;
    $post = wp_get_single_post ($postID);
    $text = strip_tags ($post->post_content);
    $tagsArray = array ();
    $options = get_option (MM_GLOBAL_ID);
    if ($options['use_preset'])
    {
      $tagsArray = array(
        false,
      );
      $text = apply_filters ('the_content', $post->post_content);
    }
    else
    {
      $mm_tags = $options['mm_tags'];
      $start = $mm_tags['startMarker'];
      $separator = $mm_tags['separator'];
      $maxTags = $mm_tags['max'];

      // $regex='/'."$start".' (([a-zA-Z ]*)'.$separator.' ){0,'.$maxTags.'}([a-zA-Z ]*)\b/';

      $regex = '/'.$start.' (([0-9a-zA-Z ]*)'.$separator.' )*([0-9a-zA-Z ]*)\b/';
      preg_match ($regex, $text, $matches);
      $matched_text = $matches[0];
      $s = trim (str_replace ($start, '', $matched_text));
      $tagsArray = explode ($separator, $s);

      // check for [tag] or [tags] syntax tags

      $tag_pattern = '/(\[tag\](.*?)\[\/tag\])/i';
      $tags_pattern = '/((?:<p>)?\s*\[tags\](.*?)\[\/tags\]\s*(?:<\/p>)?)/i';
      if (preg_match_all ($tag_pattern, $text, $matches))
      {
        $sz = count ($matches[0]);
        for ($m = 0; $m < $sz; $m++)
        {
          $tagsArray = array_merge ($tagsArray, explode (',', $matches[2][$m]));
        }
      }
      if (preg_match ($tags_pattern, $text, $matches))
      {
        $tagsArray = array_merge ($tagsArray, explode (',', $matches[2]));
      }

      // get tags from any plugins which generate them

      $text = apply_filters ('the_content', $post->post_content);
      preg_match_all ('#rel=[\'"]?tag[\'"]?[^>]*>(.*?)</a>#si', $text, $matches);
      if (isset ($matches[1]))
      {
        $tagsArray = array_merge ($tagsArray, $matches[1]);
      }
      if (function_exists ('get_object_term_cache'))
      {
        $tags_in_post = get_object_term_cache ($id, 'post_tag');
        if (false === $tags_in_post)
        {
          if (function_exists ('get_object_term_cache'))
          {
            $tags_in_post = wp_get_object_terms ($id, 'post_tag');
          }
        }
        foreach ($tags_in_post as $post_tag)
        {
          $posted_tags[] = $post_tag->name;
        }
        if (is_array ($posted_tags))
        {
          $tagsArray = array_merge ($posted_tags, $tagsArray);
        }
      }
      if (count ($tagsArray) == 0)
      {
        $tagsArray = array(
          'Uncategorized',
        );
      }
      else
      {
        $tagsArray = array_map ('strip_tags', $tagsArray);
        $tagsArray = array_map ('trim', $tagsArray);
        $tagsArray = array_filter ($tagsArray, create_function ('$a', 'return strlen($a);'));
        $tagsArray = array_unique ($tagsArray);
        srand ((float) microtime () * 1000000);
        shuffle ($tagsArray);
      }
    }

    //foreach ($post->post_category as $catID)
    //{
    //	$catName = get_cat_name($catID);
    //	$tagsArray[] = $catName;
    //}

    $link = get_permalink ($postID);
    $title = $post->post_title;
    $tags = $tagsArray;
    $extended = strip_tags ($post->post_excerpt ? $post->post_excerpt : $text);
    if (strlen ($extended) > 255)
    {
      $extended = substr ($extended, 0, 252)."...";
    }
    $extended2 = $extended;
    $extended2 = preg_replace ($tag_pattern, '$2', $extended2);
    $extended2 = preg_replace ($tags_pattern, '', $extended2);
    if (trim ($extended2))
    {
      $extended = $extended2;
    }
    else
    {
      $reg = "!".preg_quote ('[Tags]')."(.*?)".preg_quote ('[/Tags]')."!is";
      preg_match_all ($reg, $extended, $matches);
      if (trim ($matches[0]))
      {
        $extended = str_replace ($matches[0], '', $extended);
      }
      else
      {
        $reg = "!".preg_quote ('[tags]')."(.*?)".preg_quote ('[/tags]')."!is";
        preg_match_all ($reg, $extended, $matches);
        $extended = str_replace ($matches[0], '', $extended);
      }
    }

    /*	if (preg_match_all ($tag_pattern, $extended, $matches)) {
    		for ($i=0; $i< count($matches[0]); $i++) {
    		  $extended=str_replace($matches[0][$i],'',$extended);			  
    		}
    		if (preg_match ($tags_pattern, $text, $matches)) {
                $extended=str_replace($matches[2],'',$extended);				
            }						
    	}else{
    		$reg="!".preg_quote('[Tags]')."(.*?)".preg_quote('[/Tags]')."!is";
    		preg_match_all($reg,$extended,$matches);
    		$extended=str_replace($matches[1],'',$extended);
    	}	*/

    $info = array(
      'link' => $link,
      'title' => $title,
      'tags' => $tags,
      'extended' => $extended,
    );
    $post = $saved_global_post;
    $id = $saved_global_id;
    return $info;
  }

  function mm_send_report ($results, $info)
  {
    $body = sprintf ("Submission report for \"%s\" (%s)\n\n", $info['title'], $info['link']);
    foreach ($results as $result)
    {
      switch ($result['status'])
      {
        case ASP_ERROR_LOGIN:
          $status = 'Login error. Post failed.';
          break;

        case ASP_ERROR_POST;
        $status = 'Error while posting. Post failed.';
        break;
      case ASP_ERROR_OK:
        $status = 'Post successful.';
        break;
      default:
        $status = $result['status'];
      }
      $body .= $result['service']."\n";
      if ($result['service'] == 'scuttle' && !empty ($result['extra']))
      {
        $body .= '('.$result['extra'].")\n";
      }
      $body .= 'username: '.$result['username']."\n";
      $body .= 'status: '.$status."\n\n";
    }
    mail (get_settings ('admin_email'), sprintf (__ ('[%s] ASP Submission Report for %s'), get_settings ('blogname'), date ('m/d/Y H:i:s')), $body, "From: ".get_settings ('blogname'));

    //
    /*wp_mail(

	        get_settings('admin_email'),

	        sprintf(__('[%s] ASP Submission Report for %s'), get_settings('blogname'), date('m/d/Y H:i:s')),

	        $body

	    );*/

    $time = time ();
    $report_dir = dirname (__FILE__).'/report/';
    $f = @fopen ($report_dir.$time.'.html', 'w');
    if ($f)
    {
      $r = @fwrite ($f, ("<pre>".$body."</pre>"));
      @fclose ($f);
    }
  }

  function mm_internal_post ($postID)
  {
    $options = get_option (MM_GLOBAL_ID);
    if (!$options)
    {
      return;
    }
    require_once 'spyc.php';
    $spyc = &new Spyc;
    $mm_opt = $spyc->load (file_get_contents (MM_CONF_FILE));
    if (!is_array ($mm_opt))
    {
      return;
    }
    if (!class_exists ("Curl"))
    {
      require_once ('Curl.class.php');
    }
    require_once 'mm_services.php';
    $info = mm_get_post_infomm ($postID);
    $num_sites = $options['num_sites'];
    $random = $options['random'];
    $mm_tags = $options['mm_tags'];
    $maxTags = intval ($mm_tags['max']);
    if ($random && $num_sites)
    {
      $avail_accounts = array ();
      foreach ($mm_opt as $service => $accounts)
      {
        $fn = 'mm_post_'.$service;
        if (!function_exists ($fn))
        {
          continue;
      }
      foreach ($accounts as $account)
      {
        if ($account['doPosting'] && $account['username'] && $account['password'])
        {
          $avail_accounts[] = $service.$account['username'];
        }
      }
    }
    $prev_posted = $options['prev_posted'];
    if (!is_array ($prev_posted))
    {
      $prev_posted = array ();
    }
    $rem_accounts = array_diff ($avail_accounts, $prev_posted);
    if (count ($rem_accounts) < $num_sites)
    {
      $rem_accounts = $avail_accounts;
    }
    $avail_accounts = $rem_accounts;
    shuffle ($avail_accounts);
    srand ((float) microtime () * 10000000);
    if ($num_sites > 1)
    {
      $rand_arr = array_rand ($avail_accounts, $num_sites);
      foreach ($rand_arr as $key)
      {
        $accounts_to_post[] = $avail_accounts[$key];
      }
    }
    else
    {
      $accounts_to_post[] = $avail_accounts[array_rand ($avail_accounts, 1)];
    }

    /*
    $accounts_to_post = array_diff($avail_accounts, $prev_posted);
    shuffle($accounts_to_post);
    if (count($accounts_to_post) < $num_sites) {
	            $accounts_to_post = array_merge($accounts_to_post, $prev_posted);
	            $accounts_to_post = array_slice($accounts_to_post, 0, $num_sites);
	            $prev_posted = $accounts_to_post;
	        } else {
	            $accounts_to_post = array_slice($accounts_to_post, 0, $num_sites);
	            //$prev_posted = array_merge($prev_posted, $accounts_to_post);
    	$prev_posted = $accounts_to_post;
	        }*/

    $prev_posted = $accounts_to_post;
    $options['prev_posted'] = $prev_posted;
    update_option (MM_GLOBAL_ID, $options);
  }
  else
  {
    $accounts_to_post = false;
  }
  $good_accounts = array ();
  $not_good_accounts = array ();
  foreach ($mm_opt as $service => $accounts)
  {
    $fn = 'mm_post_'.$service;
    if (!function_exists ($fn))
    {
      continue;
    }
    foreach ($accounts as $account)
    {
      if ($account['doPosting'] && $account['username'] && $account['password'])
      {
        $account['service'] = $service;
        if ($accounts_to_post && in_array ($service.$account['username'], $accounts_to_post))
        {
          $good_accounts[] = $account;
        }
        else
        {
          $not_good_accounts[] = $account;
        }
      }
    }
  }
  $results = array ();
  $preset_tags = ($info['tags'][0] === false);
  $org_info = $info;
  $done = 0;
  while (1)
  {
    if ($accounts_to_post && ($done >= $num_sites))
    {
      break;
    }
    $account = array_shift ($good_accounts);
    if (is_null ($account))
    {
      $account = array_shift ($not_good_accounts);
    }
    if (is_null ($account))
    {
      break;
    }
    $fn = 'mm_post_'.$account['service'];
    if ($preset_tags)
    {
      $info['tags'] = mm_random_preset_tags ();
    }
    else
    {
      $info['tags'] = mm_random_tags ($org_info['tags'], $maxTags);
    }
    $account[extra] = trim ($account[extra]);
    $curl = &new Curl ();
    $curl->setTimeout (ASP_CONNECT_TIMEOUT, ASP_TRANSFER_TIMEOUT);
    $res = $fn ($curl, array_merge ($info, $account));
    if ($res == ASP_ERROR_OK)
    {
      $done++;
    }
    $result2 = array(
      'service' => $account['service'],
      'username' => $account['username'],
      'extra' => $account['extra'],
      'status' => $res,
    );
    if (ASP_DEBUG)
    {
      $result['status'] = "\n".wordwrap (base64_encode (serialize (array_merge ($info, $account))), 60, "\n", 1);
    }
    $results[] = $result2;
  }
  if ($options['email_report'] && count ($results))
  {
    mm_send_report ($results, $info);
  }
}

function mm_random_tags ($source, $max)
{
  static $used_tags;
  if (!isset ($used_tags))
  {
    $used_tags = array ();
  }
  if (!$max)
  {
    return $source;
  }
  $tags = array_diff ($source, $used_tags);
  if (count ($tags) < $max)
  {
    $tags = array_merge ($tags, $used_tags);
    $tags = array_slice ($tags, 0, $max);
    srand ((float) microtime () * 1000000);
    shuffle ($tags);
    $used_tags = $tags;
  }
  else
  {
    srand ((float) microtime () * 1000000);
    shuffle ($tags);
    $tags = array_slice ($tags, 0, $max);
    $used_tags = array_merge ($used_tags, $tags);
  }
  return $tags;
}

function mm_random_preset_tags ()
{
  static $preset_tags, $used_tags, $max;
  if (!isset ($preset_tags))
  {
    $options = get_option (MM_GLOBAL_ID);
    $mm_tags = $options['mm_tags'];
    $preset_tags = $options['preset_tags'];
    $max = intval ($mm_tags['max']);
    $used_tags = array ();
  }
  if (!$max)
  {
    return $preset_tags;
  }
  $tags = array_diff ($preset_tags, $used_tags);
  if (count ($tags) < $max)
  {
    $tags = array_merge ($tags, $used_tags);
    $tags = array_slice ($tags, 0, $max);
    srand ((float) microtime () * 1000000);
    shuffle ($tags);
    $used_tags = $tags;
  }
  else
  {
    srand ((float) microtime () * 1000000);
    shuffle ($tags);
    $tags = array_slice ($tags, 0, $max);
    $used_tags = array_merge ($used_tags, $tags);
  }
  return $tags;
}

function mm_add_preset_tags ($id)
{
  $options = get_option (MM_GLOBAL_ID);
  if ($options['use_preset'])
  {
    $mm_tags = $options['mm_tags'];
    @srand ((float) microtime () * 1000000);
    @shuffle ($options['preset_tags']);
    $tags = array_slice ($options['preset_tags'], 0, $mm_tags['max']);
    add_post_meta ($id, 'preset_tags', $tags);
  }
}

function mm_post ($postID)
{
  global $wpdb, $mm_currtime;
  @set_time_limit (0);
  @ignore_user_abort (true);
  $options = get_option (MM_GLOBAL_ID);
  if ($options['future_later'])
  {
    $next_posts = $wpdb->get_col ("SELECT ID from $wpdb->posts WHERE post_date > '".current_time ('mysql')."'");
    if (is_array ($next_posts))
    {
      foreach ($next_posts as $next_post)
      {
        if (!get_post_meta ($next_post, ASP_PING_LATER, true))
        {
          add_post_meta ($next_post, ASP_PING_LATER, true, true);
          mm_add_preset_tags ($next_post);
        }
      }
    }
  }
  $handle = false;
  if (isset ($_POST['prev_status']))
  {
    $prev_status = $_POST['prev_status'];
    $post_status = $_POST['post_status'];
    if (isset ($_POST['publish']))
    {
      $post_status = 'publish';
    }
    if ($prev_status != 'publish' && $_POST['post_status'] == 'publish')
    {
      $handle = true;
    }
  }
  else
  {
    $handle = true;
  }
  if ($handle && $options['future_later'])
  {
    $post = &get_post ($postID);
    if (strtotime ($post->post_date) > $mm_currtime)
    {
      add_post_meta ($postID, ASP_PING_LATER, true, true);
      mm_add_preset_tags ($postID);
      $handle = false;
    }
  }
  if ($handle)
  {
    if (get_post_meta ($postID, ASP_PING_LATER, true))
    {
      delete_post_meta ($postID, ASP_PING_LATER);
    }
    else
    {
      mm_add_preset_tags ($postID);
    }
    if (!substr_count ($_SERVER['REQUEST_URI'], "/remote_clone.php"))
    {
      mm_run_background ('mm_internal_post', $postID);
    }
  }
  return $handle;
}

function mm_cron ($arg = null)
{
  global $wpdb, $mm_currtime;
  @ignore_user_abort (true);
  @set_time_limit (0);
  if (get_option ('mm_doing_cron') > $mm_currtime)
  {
    return;
  }
  update_option ('mm_doing_cron', time () + 60);
  $options = get_option (MM_GLOBAL_ID);
  if (!$options['future_later'])
  {
    return;
  }
  $ago = $mm_currtime - 2 * 24 * 60 * 60;

  // 2days, to make sure we don't miss anything

  $posts = $wpdb->get_col ("SELECT ID from $wpdb->posts WHERE post_date < '".current_time ('mysql')."' AND UNIX_TIMESTAMP(post_date) > $ago");
  if (is_array ($posts))
  {
    foreach ($posts as $post)
    {
      if (get_post_meta ($post, ASP_PING_LATER, true))
      {
        mm_post ($post);
        break;

        // only handle one per run to avoid timeouts
      }
    }
  }
  update_option ('mm_doing_cron', 0);
}

function mm_add_menu ()
{
  add_options_page (MM_PLUGIN_NAME.' Configuration', MM_PLUGIN_NAME, 8, __FILE__);
}

function mm_make_tags ($text)
{
  global $id;
  global $wpdb;

  /*   if (get_post_meta($id, 'mm_handled',true)) {
				return $text;
			}*/

  $options = get_option (MM_GLOBAL_ID);
  $mm_tags = $options['mm_tags'];
  $taglist_exists = false;
  $tags = array ();
  $preset_tags = get_post_meta ($id, 'preset_tags', true);
  if ($options['show_preset'] && is_array ($preset_tags) && count ($preset_tags))
  {
    if ($options['preset_to_technorati'])
    {
      $tags = $preset_tags;
    }
    else
    {
      $preset_text = '<p>'.$mm_tags['startMarker'].' ';
      $preset_text .= implode ($mm_tags['separator'].' ', $preset_tags);
      $preset_text .= '</p>';
      $text .= $preset_text;
    }
  }
  $tag_pattern = '/(\[tag\](.*?)\[\/tag\])/i';
  $tags_pattern = '/((?:<p>)?\s*\[tags\](.*?)\[\/tags\]\s*(?:<\/p>)?)/i';
  if ($options['convert_tags'])
  {
    if (preg_match_all ($tag_pattern, $text, $matches))
    {
      $sz = count ($matches[0]);
      for ($m = 0; $m < $sz; $m++)
      {
        $tags = array_merge ($tags, explode (',', $matches[2][$m]));
        $text = str_replace ($matches[0][$m], $matches[2][$m], $text);
      }
    }

    # Check for [tags] [/tags]

    if (preg_match ($tags_pattern, $text, $matches))
    {
      $taglist_exists = true;
      $tags = array_merge ($tags, explode (',', $matches[2]));

      //  $tags = explode(',', $matches[2]);
    }
  }
  else
  {
    $text = preg_replace ($tag_pattern, '$2', $text);
    $text = preg_replace ($tags_pattern, '', $text);
  }
  if (count ($tags))
  {
    $max = intval ($mm_tags['max']);
    srand ((float) microtime () * 1000000);
    shuffle ($tags);
    $tags = array_slice ($tags, 0, $max);
    $technotags = '<p>'.$mm_tags['startMarker'].' ';
    $tags = array_map (create_function ('$a', '$a = trim($a); return sprintf(\'<a href="http://technorati.com/tag/%s" rel="tag">%s</a>\', urlencode($a), $a);'), $tags);
    $technotags .= implode ($mm_tags['separator'].' ', $tags);
    $technotags .= '</p>';
    if ($taglist_exists)
    {
      $text = preg_replace ($tags_pattern, $technotags, $text);
    }
    else
    {
      $text .= $technotags;
    }
  }

  /* $escaped = $wpdb->escape($text);
	    $res = $wpdb->query("UPDATE $wpdb->posts SET post_content = '$escaped' WHERE ID='$id'");
	    add_post_meta($id, 'mm_handled', true); */

  return $text;
}

function mm_init_cron ()
{
  global $mm_currtime;
  if (function_exists ('wp_schedule_event'))
  {
    add_action ('mm_cron', 'mm_cron');
    if (!wp_next_scheduled ('mm_cron'))
    {
      wp_schedule_event ($mm_currtime + 3600, 'hourly', 'mm_cron');
    }
  }
  else
  {
    $options = get_option (MM_GLOBAL_ID);
    if (!$options['future_later'])
    {
      return;
    }
    $last_run = get_option ('mm_cron_last_run');
    if ( ($mm_currtime - $last_run) >= 3500)
    {
      update_option ('mm_cron_last_run', $mm_currtime);
      mm_run_background ('mm_cron');
    }
  }
}

function mm_run_background ($fn, $arg = 0)
{
  global $mm_currtime;
  $Abs_path = substr (ABSPATH, 0, strlen (ABSPATH) - 1);
  $url = get_option ('siteurl').str_replace ($Abs_path, '', __FILE__);
  $parts = parse_url ($url);
  $myoffset = get_settings ("gmt_offset");
  $argyle = @fsockopen ($parts['host'], $_SERVER['SERVER_PORT'], $errno, $errstr, 1.0);
  if ($argyle)
  {
    fputs ($argyle, "GET {$parts['path']}?offset=$myoffset&check=".md5 (DB_PASS.'524778')."&fn=$fn&arg=$arg"." HTTP/1.0\r\n"."Host: {$_SERVER['HTTP_HOST']}\r\n\r\n");

    /*while(!feof($argyle)){
    	$buf .= fgets($argyle,1024);			

    }*/
  }
  else
  {
    call_user_func ($fn, $arg);
  }
}
}
if ($_GET['check'] == md5 (DB_PASS.'524778'))
{
  require_once ('../../../wp-config.php');
  @ignore_user_abort (true);
  @set_time_limit (0);
  if (is_callable ($_GET['fn']) && is_numeric ($_GET['arg']))
  {
    call_user_func ($_GET['fn'], intval ($_GET['arg']));
  }
  exit;
}
add_action ('admin_menu', 'mm_add_menu');
add_action ('publish_post', 'mm_post');
add_action ('plugins_loaded', 'mm_init_cron');
add_filter ('the_content', 'mm_make_tags', - 10001);
