$(function(){
	var $cat1 = $("#cat1")
	var $cat2 = $("#cat2")
	var $cat3 = $("#cat3")
	
	var cat1 = $cat1[0]
	var cat2 = $cat2[0]
	var cat3 = $cat3[0]
	
	
	$cat1.change(function(){
		p = $(this).val()
		c = category[1]
		cat2.options.length = 0
		for(var i=0;i<c.length;i++){
			if(c[i].parent == p)
				cat2.options[cat2.options.length] = new Option(c[i].name, c[i].id)	
		}
		$cat2.change()
	})
	
	$cat2.change(function(){
		p = $(this).val()
		c3 = category[2]
		cat3.options.length = 0
		for(var i=0;i<c3.length;i++){
			if(c3[i].parent == p)
				cat3.options[cat3.options.length] = new Option(c3[i].name, c3[i].id)	
		}
		$cat3.change()
	})
	$cat3.change(function(){
		p = $(this).val()
		c = cat_price
		formcount = 0
		$('.changeprice').css("display",'none')
		for(var i=0;i<c.length;i++){
			if(c[i].cat_id == p){
				f = $("#tr"+formcount)
				f.css("display", "block")
				f.find("#pricelist").val(c[i].pricelist)
				f.find("#pricelist2").val(c[i].pricelist)
				f.find("#cat_id").val(c[i].cat_id)
				formcount +=1
			}	
		}
	});
	c1 = category[0]
	for(var i=0;i<c1.length;i++){
		cat1.options[i] = new Option(c1[i].name, c1[i].id)	
	}
	setTimeout(function(){$cat1.change()},10)
})