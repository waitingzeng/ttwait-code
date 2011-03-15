// Teixi 18/08/2007 dynamic vars from GET & custom_image_browser_callback
function fileBrowserCallBack(field_name, url, type, win) {
		src_field = field_name; // function __dlg_close(val) on popup.js needs this
		alt_field = 'alt'; 
		src_win = win;
		connector += "?b=" + base + "&p=" + path;
		window.open(connector, "ImageManager", "modal,width=750,height=400");
}