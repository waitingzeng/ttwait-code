// JavaScript Document
function get_server(){
	return server_list[parseInt(Math.random() * server_list.length)];
}

function show(i){
	var url = '/' + app_label + '/' + type_id + '/' + part_id + '/' + i + '/';
	$('#imgid')[0].src = url;
}

$(function(){
	var index = 0;
	show(index);
	
	$('#imgid').click(function(){
		show(index++);
	})
	
});