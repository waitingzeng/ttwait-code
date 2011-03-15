
<script language="javascript" type="text/javascript" src="<?php echo DIR_WS_CATALOG; ?>editors/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript">
		tinyMCE.init({
<?php if (strstr($PHP_SELF, 'newsletters') || strstr($PHP_SELF, 'mail') || (strstr($PHP_SELF, 'coupon_admin') && $_GET['action']=='email') ) { ?>
		mode : "exact",
		elements : "message_html",
		editor_selector : "editorHook",
<?php } else { ?>
		mode : "textareas",
<?php } ?>
		theme : "advanced",
		width : "100%",
		height : "460",
		relative_urls : false,
		remove_script_host : true,
		document_base_url : "<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		content_css : "<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>editors/tinymce.css",
		template_external_list_url : "<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>editors/lists/template_list.js",
		plugin_insertdate_dateFormat : "%d-%m-%Y",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "hr[class|width|size|noshade]",
		file_browser_callback : "fileBrowserCallBack",
		custom_undo_redo_levels : 10,
		paste_use_dialog : false

	});
	</script>
	
	<!-- start of calls Image Manager -->
	<script type="text/javascript" src="<?php echo DIR_WS_CATALOG; ?>editors/tiny_mce/plugins/ImageManager/assets/dialog.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WS_CATALOG; ?>editors/tiny_mce/plugins/ImageManager/IMEStandalone.js"></script>
	<script language="javascript" type="text/javascript">
			var connector = "<?php echo HTTP_SERVER . DIR_WS_CATALOG ; ?>editors/tiny_mce/plugins/ImageManager/manager.php";
			base = "<?php echo DIR_FS_CATALOG . DIR_WS_IMAGES ; ?>";	// file path to images dir
			path = "<?php echo DIR_WS_CATALOG . DIR_WS_IMAGES ; ?>";		// relative url to images dir
			//Create a new Imanager Manager, needs the directory and which language translation to use.
			var manager = new ImageManager('../ImageManager','en');	
	</script>
	<script language="javascript" type="text/javascript" src="<?php echo DIR_WS_CATALOG; ?>editors/tiny_mce/plugins/ImageManager/tinycall.js"></script>
	<!-- end of calls Image Manager-->