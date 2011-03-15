var isWin = (navigator.platform == "Win32") || (navigator.platform == "Windows");        
var isIE=navigator.userAgent.indexOf("IE")>0;
var isIE5=navigator.userAgent.indexOf("IE 5.0")>0;
var isIE6=navigator.userAgent.indexOf("IE 6.0")>0;
var isNav=(navigator.appName.indexOf("Netscape")!=-1);
var element;
function $(obj){
	return typeof(obj) == "string" ? document.getElementById(obj) : obj;
}
String.prototype.trim=function(){
	return this.replace(/(^[\s]*)|([\s]*$)/g, "");
};
function hide(el) {
	element = $(el);
	element.style.display = 'none';
}
function show(el) {
	element = $(el);
	element.style.display = '';
}
function remove(el){
	element = $(el);
	element.parentNode.removeChild(element);
}
function toggle(el) {
    el = $(el);
	if(el.style.display=="none"){
		el.style.display='block';
	}else{
		el.style.display='none';
	}
}

/*==================================================*/

function scrollup(o,h,d){	
	timer_flg = false;
	if(d==h){
	   var t = o.firstChild;
	   o.appendChild(t);
	   t.style.marginTop=o.firstChild.style.marginTop='0px';
	   d=0;
	   timer_flg = true;
	}
	else{
	   var s=3,d=d+s,l=(d>=h?d-h:0);
	   o.firstChild.style.marginTop=-d+l+'px';
	   window.setTimeout(function(){scrollup(o,h,d-l)},20);
	}
}


function scrollup_online(o,h,d){
	online_timer_flg = false;
	if(d==h){
	   var t = o.firstChild;
	   o.appendChild(t);
	   t.style.marginTop=o.firstChild.style.marginTop='0px';
	   d=0;
	   online_timer_flg = true;
	}
	else{
	   var s=3,d=d+s,l=(d>=h?d-h:0);
	   o.firstChild.style.marginTop=-d+l+'px';
	   window.setTimeout(function(){scrollup_online(o,h,d-l)},20);
	}
}

///////////////
function addListener(element, type, expression, bubbling)
{
  bubbling = bubbling || false;
  if(window.addEventListener)	{ // Standard
    element.addEventListener(type, expression, bubbling);
    return true;
  } else if(window.attachEvent) { // IE
    element.attachEvent('on' + type, expression);
    return true;
  } else return false;
}

var ImageLoader = function(url){
  this.url = url;
  this.image = null;
  this.loadEvent = null;
};

ImageLoader.prototype = {
  load:function(){
    this.image = document.createElement('img');
    var url = this.url;
    var image = this.image;
    var loadEvent = this.loadEvent;
    addListener(this.image, 'load', function(e){
      if(loadEvent != null){
        loadEvent(url, image);
      }
    }, false);
    this.image.src = this.url;
  },
  getImage:function(){
    return this.image;
  }
};

function loadImage(objId,urls){
var loader = new ImageLoader(urls);
loader.loadEvent = function(url){
 obj = $(objId);
 obj.src = url;
}
loader.load();
}

function rewrite_url(pname , pid){
	if(pid == null || pid == "undefined" ) {return ""};
	var re = /[^a-zA-Z0-9]/ig;
	var url = "";
	if(FRIENDLY_URLS != null && FRIENDLY_URLS == 'true'){
		url = baseURL + pname.replace(re,"-") + "_p" + pid + ".html";
	}
	else{
		url = linkURL+pid;
	}
	return url;
}
/////////////////
/*the li scroll*/
function page_go(id,num, c,t,cid){
	var Prev = id + "Prev";
	var Next = id + "Next";	
	var pageId = id + "Page";
	var Page = 0;
	var currentPage = 1;
	var PageNumber = Math.ceil(t/num);
	var activeClick = true;
	var gopage = 0;

	if(num>t){activeClick = false;}
	if(c >= num){
		if(t!=null){
			gopage = Math.ceil(c/num);
			if(c % num == 0) gopage++; 		
		}
		updateProduct('goto', gopage);
	}
	
	function updateProduct(type, gopage) {
		if(type=='pre') {Page -= parseInt(num);currentPage--};
		if(type=='next') {Page += parseInt(num);currentPage++};
		if(type=='goto' && gopage != null) {Page = (gopage-1) * num ; currentPage = gopage;}
		if(Page<0) {
			Page=num*(PageNumber-1);
			currentPage=PageNumber;
		}
		if(Page>=t) {
			Page=0;
			currentPage=1;
		}
		
		$(pageId).innerHTML = currentPage +'/'+PageNumber;
		
		for(i=0;i<num;i++){
			if(i >= productPrice.length){
				break;
			}
			n_page = i + Page;
			$('cell_price'+i).innerHTML=productPrice[n_page];
			$('cell_link'+i).href = rewrite_url(productName[n_page], productID[n_page]);
			$('cell_link'+i).title = productName[n_page];
			
			$('li'+i).style.display='block';
			if(productID[n_page] == null){
				$('li'+i).style.display='none';
				continue;
			}
			if(num==4)$('cell_img'+i).src=baseURL+"images/root/loading_img_b.gif";
			if(num==8)$('cell_img'+i).src=baseURL+"images/root/loading_img_s.gif";
			$('cell_img'+i).alt=productName[n_page];
			$('cell_img'+i).title=productName[n_page];
			loadImage('cell_img'+i,imgURL+productIMG[n_page]);
			if(cid != null){
				if(cid == productID[n_page]){
					$('cell_img'+i).className = 'allborder';
				}
				else{
					$('cell_img'+i).className = '';
				}
			}
			
			if(productSourcePrice != null){
				$('cell_source_price'+i).innerHTML=productSourcePrice[n_page];
			}
			if(productSubName != null && productName != null){
				$('cell_name_link'+i).innerHTML=productSubName[n_page];
				$('cell_name_link'+i).href=rewrite_url(productName[n_page], productID[n_page]);
				$('cell_name_link'+i).title=productName[n_page];
			}
			if(productFlg != null){
				var tmp = productFlg[n_page].split('#');
				if(tmp.length < 4) continue;
				$('sold_out_s'+i).style.display = (tmp[0] > 0) ? 'block' : 'none';
				$('almost_sold_out_s'+i).style.display = (tmp[1] > 0) ? 'block' : 'none';				
				if(tmp[2] > 0){
					$('product_count_s'+i).innerHTML=tmp[2];
				}
				$('product_count_s'+i).style.display = (tmp[2] > 0) ? 'block' : 'none';				
				$('sale_item_s'+i).style.display = (tmp[3] > 0) ? 'block' : 'none';				
			}
		}
	}

	$(pageId).innerHTML = currentPage +'/'+PageNumber;
	$(Prev).onclick = function () {
		if(!activeClick) return false;
		updateProduct('pre');
	}
	$(Next).onclick = function () {
		if(!activeClick) return false;
		updateProduct('next');
	}	
}

function postAjax(url,content,onComplete){
	var options=new Object();
	options.method="post";
	options.asynchronous=true;
	options.parameters=content;
	options.onComplete=onComplete;
	return new Ajax.Request(url, options);
}

function checkWholesalNewsletter(id){
	if ($(id) == null) return;	
	if(checkEmail(id)){
		hide('wholesale_newsletter_text');
		show('wholesale_newsletter_loading');
			postAjax(window.location.pathname + '?main_page=wholesale_newsletter' , id + '=' + $(id).value, function(ajax){
			if(ajax.readyState==4&&ajax.status == 200){		
				$('wholesale_newsletter_text').innerHTML = ajax.responseText;
				hide('wholesale_newsletter_loading');
				show('wholesale_newsletter_text');
				if(ajax.responseText.indexOf('touch')>0){
					$(id).value = '';
				}
			}
		});	
	}
}

function checkEmail(id){
	var email = $(id) == null ? '' : $(id).value;
	if(!/(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/.test(email.replace(/-|\//g,""))){
		$(id).focus();
		alert('Please check your email address.\nYour email addresses should look like "myname@gmail.com"');
		return false;
	}
	else{
		return true;	
	}
}


function show_chat_div(obj){
	var name = obj.getAttribute("title");
	var email1 = obj.getAttribute("email1");
	var email2 = obj.getAttribute("email2");
	var email3 = obj.getAttribute("email3");
	var email4 = obj.getAttribute("email4");
	
	var skype1 = obj.getAttribute("skype1");
	var skype2 = obj.getAttribute("skype2");
	var skype3 = obj.getAttribute("skype3");
	var skype4 = obj.getAttribute("skype4");
	
	var str = "";//"<strong class='red in_1em big'>"+name+"</strong>";
	    str += "<ul class='gray_trangle_list'>";
		    str += "<li class='msn_img'><b>MSN & Email</b></li>";
			
	    if(email1!=null && email1 != ""){
	    	str += "<li><a href='mailto:" + email1 + "'>" + email1 + "</a> - showQ</li>";
	    }
	   if(email2!=null && email2 != ""){
	    	str += "<li><a href='mailto:" + email2 + "'>" + email2 + "</a> - showQ</li>";
	    }
		if(email3!=null && email3 != ""){
	    	str += "<li><a href='mailto:" + email3 + "'>" + email3 + "</a> - showQ</li>";
	    }
		if(email4!=null && email4 != ""){
	    	str += "<li><a href='mailto:" + email4 + "'>" + email4 + "</a> - showQ</li>";
	    }
	    	str += "<li class='skype_img'><b>Skype Talk</b></li>";
	    
	    if(skype1!=null && skype1 != ""){
	   		str += "<li><a href='skype:"+ skype1 +"?call'>" + skype1 + "</a> - showQ</li>";
	    }
	   if(skype2!=null && skype2 != ""){
	   		str += "<li><a href='skype:"+ skype2 +"?call'>" + skype2 + "</a> - showQ</li>";
	    }
		if(skype3!=null && skype3 != ""){
	   		str += "<li><a href='skype:"+ skype3 +"?call'>" + skype3 + "</a> - showQ</li>";
	    }
		if(skype4!=null && skype4 != ""){
	   		str += "<li><a href='skype:"+ skype4 +"?call'>" + skype4 + "</a> - showQ</li>";
	    }
		
	    str += "</ul>";	
	$('chat_div_name').innerHTML = str;
	
	hide_select('in');
			
	toggle('chat_div');
	
	return false;
}

function close_chat_div(){
	hide('chat_div');
	hide_select("out");
}

function hide_select(what){	
  var anchors = document.getElementsByTagName("select");
  if (what=="in") {
 	 for (var i=0; i<anchors.length; i++) {
 	 	if(anchors[i].getAttribute("rel")=="dropdown"){
 			anchors[i].style.visibility="hidden";
 	 	}
 	 }
  } 
  else {
 	for (var i=0; i<anchors.length; i++) {
 		if(anchors[i].getAttribute("rel")=="dropdown"){
 	    	anchors[i].style.visibility="visible";
 		}
	}
  }
}

function back(num){
	history.go(num);
	return false;
}
function floatBox(posEL,element){
	var posX,posY,pos,offTop;
	var width = 339;
	var height = 328; 
	if(isIE){
		pos = $(posEL).childNodes[0];
		offTop = 120;
	}else{
		pos = $(posEL);
		offTop = 130;
	}
	posX = pos.offsetLeft-width;
	posY = pos.offsetTop-offTop;
	
	var box = $('pop_window');
    box.style.position = 'absolute';   
    box.style.zIndex = 999;
    box.style.top = posY + 'px';    
    box.style.left = posX + 'px';    
    box.style.width = width + 'px';    
    box.style.height = height + 'px';
	var str ="<img onclick='close_box(this)' src='"+baseURL+"images/root/close.gif' class='hand' title='close' alt='close' id='floatBox_img'/><div class='png'>";
	switch (element){
		case 'shipping_info':
		                     str += shipping_info;
		                     break;
        case 'payment_option':
                              str += payment_option;
                              break;
        case 'costs':
                              str += costs;
                              break;
		case 'questions':
                              str += questions;
                              break;                              
		default : str += content;
		          break;
		
	}	
	str += "</div>";
	box.innerHTML = str;
	show('pop_window');
	return false;
}
function close_box(obj){	
	hide(obj.parentNode);
}


function g(o){return document.getElementById(o);}
function HoverLi(n)
{
	for(var i=1;i<=2;i++){g('tb_'+i).className='normaltab';g('tbc_0'+i).className='undis';}
	g('tbc_0'+n).className='dis';g('tb_'+n).className='hovertab';
}

function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function ap_showHideLayers() { //v9.0
  var i,p,v,obj,args=ap_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function aps_showHideLayers() { //v9.0
  var i,p,v,obj,args=aps_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function aps_showHideLayers() { //v9.0
  var i,p,v,obj,args=aps_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function img_showHideLayers() { //v9.0
  var i,p,v,obj,args=img_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-