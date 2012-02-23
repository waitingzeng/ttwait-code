$(function(){
	var toggle = function(){
		obj = $(this).find(">ul");
		if(obj.css('display') == 'block'){
			if(obj.find(">li").length == 0){
				cat_id = parseInt(obj.attr("cat"));
				url = ServerPath+'ajax.asp?func=insort&cat_id='+cat_id
				jQuery.getJSON(url, function(data){
					str = []
					for(var i=0;i<data.length;i++){
						url = ServerPath + data[i].alias + '.html'
						if(menuurl){
							url = menuurl + "?cat_id="+data[i].id
						}
						str.push('<li><a href="'+url+'">'+data[i].name+'</a><ul cat="'+data[i].id+'" id="cat_'+data[i].id+'" depth="'+data[i].depth+'"></ul></li>')
					}
					str = str.join('')
					setTimeout(function(){
						var branches = $(str).prependTo('#cat_'+cat_id);
						$("#navigation").treeview({
							add: branches
						});
					},0)				   
				})
			}
				
		}
	}
	
	$('#navigation').treeview({
		persist: "cookie",
		collapsed: true,
		unique: true,
		toggle : toggle
	});
	
	$('#pinpailist').change(function(){
		var pinpai = $(this).val()
		var cat = $('#pinpai_cat')[0]
		cat.options.length = 0;
		if(pinpai=='')
			return;
		$.getJSON(ServerPath+'ajax.asp?func=pinpai_cat&pinpai='+ encodeURIComponent(pinpai), function(data){
			cat.options[0] = new Option('All Catetory', 0);
			l = data.length
			for(var i=0;i<l;i++){
				cat.options[i+1] = new Option(data[l-i-1].name, data[l-i-1].id);
			}																   
		
		})
		
	});
	
	$('#pinpaiform').submit(function(){
		var pinpai = $('#pinpailist').val();
		if(pinpai == ''){
			alert('please select brand!');
			return false;
		}else{
			return true;
		}
	});
	
	$('.payid').click(function(){
		var pid = $(this).val();
		$('.payidspan').css('display', 'none');
		$('#payid_'+pid).css('display', 'block');
	})
	
})