// JavaScript Document
function get_sel_text1(elm)
{
	elm = jQuery(elm)[0];
    word='';
    if (document.selection) {
        var sel = document.selection.createRange();
        if (sel.text.length > 0) {
            word = sel.text;
        }
    }
    else if (elm.selectionStart || elm.selectionStart == '0') {
        var start_pos = elm.selectionStart;
        var end_pos = elm.selectionEnd;
        if (start_pos != end_pos) {
            word = elm.value.substring(start_pos, end_pos);
        }
    }
    return word;
}

// JavaScript Document
var console = window.console || {
	log : function(){},
	debug : function(){},
	warn : function(){},
	error : function(){},
}

function compare_position(a, b){
	return a.compareDocumentPosition ?
		a.compareDocumentPosition(b) :
		a.contains ?
		( a != b && a.contains(b) && 16 ) +
		( a != b && b.contains(a) && 8 ) +
		( a.sourceIndex >= 0 && b.sourceIndex >= 0 ?
		(a.sourceIndex < b.sourceIndex && 4 ) +
		(a.sourceIndex > b.sourceIndex && 2 ) :
		1 ) : 0;
}

function get_sel_text(elm)
{
	elm = jQuery(elm)[0];
    // 正文元素
	if(!elm) {
		return "";
	}

	if(window.getSelection && window.getSelection().rangeCount > 0) {
		var sel = window.getSelection();
		var range = sel.getRangeAt(0),
			ancestor = range.commonAncestorContainer;
		if((ancestor == elm)
			|| ((compare_position(elm, ancestor) & 0x10) == 0x10)) {					
			return range.toString().replace(/^\s*|\s*$/g,"");
		}
	} else if(document.selection) {
		var range = document.selection.createRange(),
			ancestor = range.parentElement();
			console.debug('ancestor2 %s', ancestor);
		if((ancestor == elm)
			|| ((compare_position(elm, ancestor) & 0x10) == 0x10)) {	
			return range.text;
		}
	} else if (elm.selectionStart || elm.selectionStart == '0') {
        var start_pos = elm.selectionStart;
        var end_pos = elm.selectionEnd;
        if (start_pos != end_pos) {
            return elm.value.substring(start_pos, end_pos);
        }
    }
	return "";
}


jQuery(function(){
	var $ = jQuery;
});