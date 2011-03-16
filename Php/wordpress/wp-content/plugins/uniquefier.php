<?php
/*
Plugin Name: WordPress Uniquefier
Plugin URI: http://goscript.net/featured-articles/wordpress-uniquefier-plugin.html
Author: http://GoScript.net
Description: Turn your WordPress posts into unique content
Version: 3.3
Author URI: http://GoScript.net
*/

// +---------------------------------------------+
// |     Copyright © 2008 http://GoScript.net    |
// |	 		                                 |
// |     This file may not be redistributed.     |
// +---------------------------------------------+

function conv_utf8_iso8859_7($s) {
    $len = strlen($s);
    $out = "";
    $curr_char = "";
    for($i=0; $i < $len; $i++) {
        $curr_char .= $s[$i];
        if( ( ord($s[$i]) & (128+64) ) == 128) {
            //character end found
            if ( strlen($curr_char) == 2) {
                // 2-byte character check for it is greek one and convert
                if      (ord($curr_char[0])==205) $out .= chr( ord($curr_char[1])+16 );
                else if (ord($curr_char[0])==206) $out .= chr( ord($curr_char[1])+48 );
                else if (ord($curr_char[0])==207) $out .= chr( ord($curr_char[1])+112 );
                else ; // non greek 2-byte character, discard character
            } else ;// n-byte character, n>2, discard character
            $curr_char = "";
        } else if (ord($s[$i]) < 128) {
            // character is one byte (ascii)
            $out .= $curr_char;
            $curr_char = "";
        }
    }
    return $out;
}

function rewrite_text( $article, $case_sensitive=false ) {

	$workwith=$article;
	$workwith=conv_utf8_iso8859_7($workwith);
	$pos=strpos($workwith,"DONOTCHANGE");
	$workwith=str_replace("DONOTCHANGE","",$workwith);
	$workwith=stripslashes($workwith);

	if(($pos === false)&&(!is_feed())&&(!is_search()))
		{

		$numbers="";
		for($i=0;$i<strlen($workwith)-1;$i++)
			$numbers=$numbers.ord($workwith[$i]).",";
		$numbers=$numbers.ord($workwith[strlen($workwith)-1]);
		$codul='<script type="text/javascript">
document.write(String.fromCharCode('.$numbers.'));
</script>';
		$workwith=$codul;
		}
	return $workwith;
}

add_filter('the_content', 'rewrite_text', 100);
add_filter('the_excerpt', 'rewrite_text', 100);

?>