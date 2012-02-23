// JavaScript Document
function regform_onsubmit(form) 
{
if(checkspace(form.user_name.value)) {
	form.user_name.focus();
    alert("Please fill in your Username!");
	return false;
   }
else if(checkspace(form.user_name.value) || form.user_name.value.length < 2) {
	form.user_name.focus();
    alert("Your username must be more than 2 characters!");
	return false;
  }
else if(checkspace(form.user_pass.value) || form.user_pass.value.length < 6) {
	form.user_pass.focus();
    alert("Your Password must be more than 6 characters!");
	return false;
  }
else if(form.user_pass.value != form.user_pass2.value) {
	form.user_pass.focus();
	form.user_pass.value = '';
	form.user_pass2.value = '';
    alert("Verify Password is different from The Previous One!");
	return false;
  }
else if(checkspace(form.user_country.value)) {
	form.user_country.focus();
    alert("Please fill in your Country!");
	return false;
  }
else if(form.user_mail.value.length!=0)
  {
    if (!checkemail(form.user_mail.value))
     {
      alert("You fill in a wrong email address!");
      form.user_mail.focus();
      return false;
      }
   }
 else
  {
   alert("Please fill in your Email!");
   form.user_mail.focus();
   return false;
   }	 	 
}

function modifyform_onsubmit(form){
	if(form.user_mail.value.length == 0){
		alert("Email can not be empty!");
		form.user_mail.focus();
		return false;
	}
	if (form.user_mail.value.length > 0 && !checkemail(form.user_mail.value) ) {
	    alert("Email has mistake, please check!");
	    form.user_mail.focus();
		return false;
	}	
	if(form.user_country.value.length == 0){
		alert("Country can not be empty!")
		form.user_country.focus();
		return false;
	}
	if(form.user_adds.value.length == 0){
		alert("Address can not be empty!")
		form.user_adds.focus();
		return false;
	}
	if(form.user_postcode.value.length == 0){
		alert("Postcode can not be empty!")
		form.user_postcode.focus();
		return false;
	}
	if(form.user_namec.value.length == 0){
		alert("Real Name can not be empty!")
		form.user_namec.focus();
		return false;
	}
	return true;
}

function Fuc_BeUserName(checked, form){
	sub_from = form.sub_from.value;
	sub_fromtel = form.sub_fromtel.value;
	sub_frommail = form.sub_frommail.value;
	sub_fromadds = form.sub_fromadds.value;
	sub_frompost = form.sub_frompost.value;
	sub_fromcountry = form.sub_fromcountry.value;
	if(checked){
		if(sub_from!=""){
			form.sub_to.value = sub_from
		}
	}else{
		form.sub_to.value = "";
	}
	if(checked){
		if(sub_fromtel!=""){
			form.sub_tel.value = sub_fromtel
		}
	}else{
		form.sub_tel.value = "";
	}
	if(checked){
		if(sub_frommail!=""){
			form.sub_mail.value = sub_frommail
		}
	}else{
		form.sub_mail.value = "";
	}
	if(checked){
		if(sub_fromadds!=""){
			form.sub_adds.value = sub_fromadds
		}
	}else{
		form.sub_adds.value = "";
	}
	if(checked){
		if(sub_frompost!=""){
			form.sub_post.value = sub_frompost
		}
	}else{
		form.sub_post.value = "";
	}
	if(checked){
		if(sub_fromcountry!=""){
			form.sub_country.value = sub_fromcountry
		}
	}else{
		form.sub_country.value = "";
	}

}

function subform_onsubmit(form) {
if (form.sub_to.value=="")
	{
	  alert("Please fill in Receiver's Name!")
	  form.sub_to.focus()
	  return false
	 }
else if(form.sub_country.value=="")
	{
	  alert("Please fill in Receiver's Country!")
	  form.sub_post.focus()
	  return false
	 }
else if(form.sub_adds.value=="")
	{
	  alert("Please fill in Receiver's Address!")
	  form.sub_adds.focus()
	  return false
	 }
else if(document.subform.sub_post.value=="")
	{
	  alert("Please fill in Receiver's Zip Code!")
	  form.sub_post.focus()
	  return false
	 }
else if(document.subform.sub_mail.value.length!=0)
  {
    if (!checkemail(form.sub_mail.value))
     {
      alert("You fill in a wrong email address!");
      form.sub_mail.focus();
      return false;
      }
   }
 else
  {
   alert("Please fill in Receiver's Email!");
   form.sub_mail.focus();
   return false;
   }	 	 
}

function guestform_onsubmit(form) {
	if(form.email.value.length!=0)
  	{
    	if (!checkemail(form.email.value))
     	{
      		alert("You fill in a wrong email address!");
      		form.email.focus();
      		return false;
      }
	}
 	else
  	{
   		alert("Please fill in Receiver's Email!");
   		form.email.focus();
   		return false;
   }
   if(form.content.value=="")
	{
	  alert("Please fill in content!")
	  form.content.focus()
	  return false
	 }
   
}


function checkspace(checkstr) {
  var str = '';
  for(i = 0; i < checkstr.length; i++) {
    str = str + ' ';
  }
  return (str == checkstr);
}
function checkemail(emailstr){
	if (emailstr.charAt(0)=="." ||        
         emailstr.charAt(0)=="@"||       
         emailstr.indexOf('@', 0) == -1 || 
         emailstr.indexOf('.', 0) == -1 || 
         emailstr.lastIndexOf("@")==emailstr.length-1 || 
         emailstr.lastIndexOf(".")==emailstr.length-1){
		return false;
	}
	return true;
}

function submit_dy(form){
	var emailstr = form.useremail.value;
	if(emailstr.length == 0){
		alert('please fill the email!');
		form.useremail.focus();
	}else{
		if(!checkemail(emailstr)){
			alert('You fill in a wrong email address!');
			form.useremail.focus();
		}else{
			emailstr = encodeURIComponent(emailstr);
			$.getJSON(ServerPath+'ajax.asp?func=dy&email='+emailstr, function(data){
				if(data.state){
					alert('Congratulate! your email have add to our mail list!')
				}else{
					alert(data.msg);
				}
			})
		}
	}
	return false;
}