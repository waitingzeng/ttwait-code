<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Cheap Bags Wholesale <?=$_GET['cnm']?> Partners</TITLE>
<META NAME="Description" CONTENT="Cheap Bags Wholesale, Cheap Handbags Wholesale, Cheap Designer Bags Wholesale, Cheap   Designer Handbags Wholesale, Fashion Bags Wholesale, Fashion Handbags Wholesale, Replica Bags Wholesale, Replica Handbags Wholesale">

<STYLE type="text/css" media="screen">
.link { margin-bottom: 3px;  margin-top: 3px;}
.cattable { width: 700px; border:1px solid black; }
.linktable { width: 700px; border:1px solid black; }
.catcell { border:1px solid black; text-align: center; }
.keywordsearch { font-size:9pt; font-family: arial, helvetica, sans-serif; }
.navlinks { color: blue; font-family: arial, helvetica, sans-serif;}
.topnavlinks { color: blue; font-family: arial, helvetica, sans-serif;}
.submitsearch { font-size:9pt; font-family:verdana, arial, helvetica, sans-serif; }
.url { font-weight: bold; font-family: arial, helvetica, sans-serif; font-size:10pt; color: blue;}
.catlink { font-weight: bold; color: blue; font-family:verdana, arial, helvetica, sans-serif; font-size:10pt; }
.description { font-size:10pt; color: black; margin-bottom: 5px; font-family: arial, helvetica, sans-serif; margin-top: 5px; }
.title { color: blue; margin-bottom: 5px; font-weight: bold; font-size:10pt; font-family:arial, helvetica, sans-serif; margin-top: 5px;}
.topnav { text-align: left; color: black; margin-top: 5px; font-family: arial, helvetica, sans-serif; margin-bottom: 5px; font-size:10pt;}
.navigationtext { font-size:10pt; margin-bottom: 5px; color: black; font-family: arial, helvetica, sans-serif; margin-top: 5px; text-align: center;}
</STYLE>

</HEAD>

<BODY>

<?php

// ********************************************************************
// You may change the variables below to customize the look and feel of 
// your links page
// ********************************************************************

// This option defines the number of columns used to display categories
$GLCatCol = "2";

// This option defines the number of links displayed per page
$GLLPP = "25";

// This option defines whether links are opened in a new web browser window
// (1 = Yes, 0 = No)
$GLNW = "1";

// This option determines whether the search function is enabled
// for your links page (1 = Yes, 0 = No)
$GLAS = "1";

$GLKey = "MKZM-676S-3JFM";

// ********************************************************************
// *****Please DO NOT make any edits or changes to the code below******
// ********************************************************************

$PageName = $_SERVER["PHP_SELF"];

$GLQS  = "script=php&UserKey=".urlencode($GLKey)."&ScriptName=".urlencode($PageName)."&CatCols=" .urlencode($GLCatCol)."&LinksPerPage=".urlencode($GLLPP)."&OpenInNewWindow=" .urlencode($GLNW)."&AllowSearch=".urlencode($GLAS);

if(!is_array($_GET)) $_GET = $HTTP_GET_VARS;

foreach ($_GET as $key => $value) {
    $GLQS .= "&$key=".urlencode(stripslashes($value));
}

if(intval(get_cfg_var('allow_url_fopen')) && function_exists('readfile')) {
    if(!@readfile("http://www.gotlinks.com/engine2.php?".$GLQS)) {
        print "Error processing request";
    }
}
elseif(intval(get_cfg_var('allow_url_fopen')) && function_exists('file')) {
    if(!($content = @file("http://www.gotlinks.com/engine2.php?".$GLQS))) {
        print "Error processing request";
    }
    else {
        print @join('', $content);
    }
}
elseif(function_exists('curl_init')) {
    $ch = curl_init ("http://www.gotlinks.com/engine2.php?".$GLQS);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_exec ($ch);

    if(curl_error($ch))
        print "Error processing request";

    curl_close ($ch);
}
else {
    print "It seems that your web host has disabled all functions for handling remote pages and as a result the GotLinks software will not function on your web site. Please contact your web host and ask them to enable PHP curl or fopen.";
}
?>

</BODY>
</HTML>
