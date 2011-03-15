<?
/**
 * Image Manager configuration file.
 * @author $Author: Wei Zhuo $
 * @version $Id: config.inc.php 27 2004-04-01 08:31:57Z Wei Zhuo $
 * @package ImageManager
 */

/* 	IMPORTANT:
	Teixi 01/09/2007 both base_dir and base_url now are passed 
                  as GET parameters &b= &p=
*/

/*
  Possible values: true, false

  TRUE - If PHP on the web server is in safe mode, set this to true.
         SAFE MODE restrictions: directory creation will not be possible,
		 only the GD library can be used, other libraries require
		 Safe Mode to be off.

  FALSE - Set to false if PHP on the web server is not in safe mode.
*/
$IMConfig['safe_mode'] = true;

/* 
 Possible values: 'GD', 'IM', or 'NetPBM'

 The image manipulation library to use, either GD or ImageMagick or NetPBM.
 If you have safe mode ON, or don't have the binaries to other packages, 
 your choice is 'GD' only. Other packages require Safe Mode to be off.
*/
define('IMAGE_CLASS', 'GD');


/*
 After defining which library to use, if it is NetPBM or IM, you need to
 specify where the binary for the selected library are. And of course
 your server and PHP must be able to execute them (i.e. safe mode is OFF).
 GD does not require the following definition.
*/
//define('IMAGE_TRANSFORM_LIB_PATH', 'C:/"Program Files"/ImageMagick-5.5.7-Q16/');


/* ==============  OPTIONAL SETTINGS ============== */


/*
  The prefix for thumbnail files, something like .thumb will do. The
  thumbnails files will be named as "prefix_imagefile.ext", that is,
  prefix + orginal filename.
*/
$IMConfig['thumbnail_prefix'] = '.';

/*
  Thumbnail can also be stored in a directory, this directory
  will be created by PHP. If PHP is in safe mode, this parameter
  is ignored, you can not create directories. 

  If you do not want to store thumbnails in a directory, set this
  to false or empty string '';
*/
$IMConfig['thumbnail_dir'] = '.thumbs';

/*
  Possible values: true, false

 TRUE -  Allow the user to create new sub-directories in the
         $IMConfig['base_dir'].

 FALSE - No directory creation.

 NOTE: If $IMConfig['safe_mode'] = true, this parameter
       is ignored, you can not create directories
*/
$IMConfig['allow_new_dir'] = true;

/*
  Possible values: true, false

  TRUE - Allow the user to upload files.

  FALSE - No uploading allowed.
*/
$IMConfig['allow_upload'] = true;


/*
	Maxim Upload File Size Limit (in Bytes)
		and
	Maxim Storage Size for the Directory that contains uploaded files
	
	To calculate any size in bytes see:
	http://www.t1shopper.com/tools/calculate/
*/
$IMConfig['max_size'] = 1048576; // 1MB

$IMConfig['dir_max_size'] = 20971520; // 20MB


/*
 Possible values: true, false

 TRUE - If set to true, uploaded files will be validated based on the 
        function getImageSize, if we can get the image dimensions then 
        I guess this should be a valid image. Otherwise the file will be rejected.

 FALSE - All uploaded files will be processed.

 NOTE: If uploading is not allowed, this parameter is ignored.
*/
$IMConfig['validate_images'] = false;

/*
 The default thumbnail if the thumbnails can not be created, either
 due to error or bad image file.
*/
$IMConfig['default_thumbnail'] = 'img/default90.gif';

/*
  Thumbnail dimensions.
*/
$IMConfig['thumbnail_width'] = 90;
$IMConfig['thumbnail_height'] = 90;

/*
  Image Editor temporary filename prefix.
*/
$IMConfig['tmp_prefix'] = '.editor_';
?>