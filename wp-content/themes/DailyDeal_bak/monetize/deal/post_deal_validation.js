var $c = jQuery.noConflict();
$c(document).ready(function(){

	//global vars
	var enquiryfrm = $c("#postdeal_frm");
	var user_fname = $c("#owner_name");
	var user_email = $c("#owner_email");
	var deal_title = $c("#post_title");
	var deal_desc = $c("#post_content");
	var coupon_website = $c("#coupon_website");
	var no_of_coupon = $c("#no_of_coupon");
	var our_price = $c("#our_price");
	var current_price = $c("#current_price");
	var coupon_type = $c("#coupon_type");
	
	var user_fname_Info = $c("#user_fname_Info");
	var user_emailInfo = $c("#user_emailInfo");
	var deal_titleInfo = $c("#deal_titleInfo");
	var deal_descInfo = $c("#deal_descInfo");
	var coupon_websiteInfo = $c("#coupon_websiteInfo");
	var no_of_couponInfo = $c("#no_of_couponInfo");
	var our_priceInfo = $c("#our_priceInfo");
	var current_priceInfo = $c("#current_priceInfo");
	var coupon_typeInfo = $c("#coupon_typeInfo");
	var coupon_code = $c("#coupon_code");
	var deal_startInfo = $c("#deal_startInfo");
	var coupon_start_date = $c("#coupon_start_date");
	
	//On blur
	user_fname.blur(validate_user_fname);
	user_email.blur(validate_user_email);
	deal_title.blur(validate_deal_title);
	//deal_desc.blur(validate_deal_desc);
	coupon_website.blur(validate_coupon_website);
	no_of_coupon.blur(validate_no_of_coupon);
	our_price.blur(validate_our_price);
	current_price.blur(validate_price);
	coupon_type.change(validate_coupon_type);
	coupon_type.blur(validate_coupon_type);
	coupon_code.keypress(validate_count_coupon);
	coupon_code.blur(validate_count_coupon_blur);
	
	coupon_start_date.blur(validate_deal_date);
	//On key press
	user_fname.keyup(validate_user_fname);
	user_email.keyup(validate_user_email);
	deal_title.keyup(validate_deal_title);
	//deal_desc.keyup(validate_deal_desc);
	coupon_website.keyup(validate_coupon_website);
	no_of_coupon.keyup(validate_no_of_coupon);
	//no_of_coupon.onfocus(validate_no_of_coupon);
	our_price.keyup(validate_our_price);
	current_price.keyup(validate_current_price);
	//coupon_start_date.keyup(validate_coupon_start_date);
	//coupon_type.keyup(validate_coupon_type);

	//On Submitting
	enquiryfrm.submit(function(){
		if(validate_user_fname() & validate_user_email() & validate_deal_title() & validate_coupon_website() & validate_no_of_coupon() & validate_our_price() & validate_current_price() & validate_price() & validate_coupon_type() & validate_count_coupon() & validate_deal_type() & validate_deal_date() )
		{
			return true
		}
		else if(!validate_count_coupon())
		{
			alert("enter valid coupons");
		}else
		{
			return false;
		}
	});

	//validation functions
	function validate_user_fname()
	{ 
		if($c("#owner_name").val() == '')
		{
			user_fname.addClass("error");
			user_fname.removeClass("textfield");
			user_fname.addClass("errortextfield");
			user_fname_Info.text("Your name is required");
			user_fname_Info.addClass("message_error");
			return false;
		}
		else
		{
			user_fname.removeClass("error");
			user_fname.addClass("textfield");
			user_fname.removeClass("errortextfield");
			user_fname.removeClass("errortextfield");
			user_fname_Info.text("");
			user_fname_Info.removeClass("message_error");
			return true;
		}
	}

	function validate_user_email()
	{
		var isvalidemailflag = 0;
		if($c("#owner_email").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if($c("#owner_email").val() != '')
		{
			var a = $c("#owner_email").val();
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
			//if it's valid email
			if(filter.test(a)){
				isvalidemailflag = 0;
			}else{
				isvalidemailflag = 1;	
			}
		}
		
		if(isvalidemailflag)
		{
			user_email.addClass("error");
			user_email.removeClass("textfield");
			user_email.addClass("errortextfield");
			user_emailInfo.text("A valid email address is required");
			user_emailInfo.addClass("message_error");
			return false;
		}else
		{
			user_email.removeClass("errortextfield");
			user_email.addClass("textfield");
			user_email.removeClass("error");
			user_emailInfo.text("");
			user_emailInfo.removeClass("message_error");
			return true;
		}
	}

	function validate_deal_title()
	{
		if($c("#post_title").val() == '')
		{
			deal_title.addClass("error");
			deal_title.removeClass("textfield");
			deal_title.addClass("errortextfield");
			deal_titleInfo.text("Please enter deal title");
			deal_titleInfo.addClass("message_error");
			return false;
		}
		else{
			deal_title.removeClass("errortextfield");
			deal_title.addClass("textfield");
			deal_title.removeClass("error");
			deal_titleInfo.text("");
			deal_titleInfo.removeClass("message_error");
			return true;
		}
	}

	function validate_deal_desc()
	{
		if($c("#post_content").val() == '')
		{
			deal_desc.addClass("error");
			deal_descInfo.text("Please enter deal description");
			deal_descInfo.addClass("message_error");
			return false;
		}
		else{
			deal_desc.removeClass("error");
			deal_descInfo.text("");
			deal_descInfo.removeClass("message_error");
			return true;
		}
	}
	
	function validate_coupon_website()
	{
		if(jQuery("#coupon_website").val() == '')
		{
			coupon_website.removeClass("textfield");
			coupon_website.addClass("errortextfield");
			coupon_websiteInfo.text("This field is required");
			coupon_websiteInfo.addClass("message_error");
			return false;
		}
		else{
			coupon_website.addClass("textfield");
			coupon_website.removeClass("errortextfield");
			coupon_website.removeClass("error");
			coupon_websiteInfo.text("");
			coupon_websiteInfo.removeClass("message_error");
			return true;
		}
	}
	
	function validate_no_of_coupon()
	{
	
		if($c("#no_of_coupon").val() == '')
		{
			
			no_of_coupon.removeClass("textfield");
			no_of_coupon.addClass("errortextfield");
			no_of_couponInfo.text("This field is required");
			no_of_couponInfo.addClass("message_error");
			return false;
		}else if(isNaN($c("#no_of_coupon").val()))
		{
			no_of_coupon.removeClass("textfield");
			no_of_coupon.addClass("errortextfield");
			no_of_couponInfo.text("Please maximum sales as number");
			no_of_couponInfo.addClass("message_error");
			return false;
		}
		else if(jQuery("#coupon_entry_1").attr("checked") == 'checked')
		{

				$c("#multicode").show();
				$c("#no_of_coupons").show();
				var couponcount = $c("#no_of_coupon").val();
				$c("#coupon").text(couponcount);
		}else{
			no_of_coupon.removeClass("errortextfield");
			no_of_coupon.addClass("textfield");
			no_of_coupon.removeClass("error");
			no_of_couponInfo.text("");
			no_of_couponInfo.removeClass("message_error");
			
			return true;
		}
	}
	
	function validate_our_price()
	{
		if($c("#our_price").val() == '' )
		{
			our_price.removeClass("textfield");
			our_price.addClass("errortextfield");
			our_priceInfo.text("This field is required");
			our_priceInfo.addClass("message_error");
			return false;
		}else if(isNaN($c("#our_price").val()))
		{
			our_price.removeClass("textfield");
			our_price.addClass("errortextfield");
			our_priceInfo.text("Please enter your price as number");
			our_priceInfo.addClass("message_error");
			return false;
		}
		else{
			
			our_price.removeClass("errortextfield");
			our_price.addClass("textfield");
			our_priceInfo.text("");
			our_priceInfo.removeClass("message_error");
			return true;
		}
	}
	function validate_current_price()
	{
		
		if(jQuery("#current_price").val() == '' || isNaN($c("#current_price").val()))
		{
			current_price.removeClass("textfield");
			current_price.addClass("errortextfield");
			current_priceInfo.text("Please enter the regular price of the product. Only numeric values allowed.");
			current_priceInfo.addClass("message_error");
			return false;
		}else{
			
			current_price.removeClass("errortextfield");
			current_price.addClass("textfield");
			current_price.removeClass("error");
			current_priceInfo.text("");
			current_priceInfo.removeClass("message_error");
			return true;
		}
	}
	
	function validate_price()
	{
		if(jQuery("#current_price").val() == '' || isNaN($c("#current_price").val()))
		{
			current_price.removeClass("textfield");
			current_price.addClass("errortextfield");
			current_priceInfo.text("Please enter the regular price of the product. Only numeric values allowed.");
			current_priceInfo.addClass("message_error");
			return false;
		}else if(parseInt(jQuery("#current_price").val()) < parseInt(jQuery("#our_price").val()))
		{
			our_price.removeClass("textfield");
			our_price.addClass("errortextfield");
			our_priceInfo.text("Discounted price should be less than the regular price.");
			our_priceInfo.addClass("message_error");
			return false;
		}else if ($c("#current_price").val() > $c("#our_price").val()){
			our_price.removeClass("errortextfield");
			our_price.addClass("textfield");
			our_priceInfo.text("");
			our_priceInfo.removeClass("message_error");
			return true;
		}else if(jQuery("#current_price").val() != ''){
			current_price.addClass("textfield");
			current_price.removeClass("errortextfield");
			current_priceInfo.text("");
			current_priceInfo.addClass("message_error");
			return true;
		}
	
	}
	function validate_coupon_type()
	{
		if(deal_val){
		
		var chklength = 5;
			var flag      = false;
			var temp	  ='';
			
			for(i=1;i<=chklength;i++)
			{
			   if(document.getElementById("coupon_type_"+i+"")){
			   temp = document.getElementById("coupon_type_"+i+"").selected; 
			   if(temp == true)
			   {
					flag = true;
					break;
				}
			   }
			}
			if(flag == false)
			{
				//document.getElementById("no_of_coupons").style.display = "none";
				coupon_type.removeClass("textfield");
				coupon_type.addClass("errortextfield");
				coupon_typeInfo.text("Please select deal type");
				coupon_typeInfo.addClass("message_error");
				return false;
			}
			else{	
				coupon_type.removeClass("errortextfield");
				coupon_type.addClass("textfield");
				coupon_typeInfo.text("");
				coupon_typeInfo.removeClass("message_error");
				return true;
			}
		}
	}
	
	function validate_count_coupon()
	{
		var chklength = document.getElementById("coupon_type").length - 1;
		var flag      = false;
		var temp	  ='';
	
		for(i=1;i<=chklength;i++)
		{
			if(document.getElementById("coupon_type_"+i+"")){
			temp = document.getElementById("coupon_type_"+i+"").selected; 
				if(temp == true)  {
					if(i > 2){
						var coupan_code = document.getElementById("coupon_code").value;
						var split_coupon_code = coupan_code.split(",");
	
						document.getElementById("count_no_of_coupon").value == split_coupon_code.length;
						document.getElementById("count_no_of_coupon").innerHTML = split_coupon_code.length-1;
						if(document.getElementById("no_of_coupon").value >= split_coupon_code.length && document.getElementById("coupon_code").value != "")	{
							document.getElementById("coupon_code").focus();
							return true;
						}else if(document.getElementById("no_of_coupon").value  < split_coupon_code.length && document.getElementById("coupon_code").value != ""){
			
							if(document.getElementById("no_of_coupon").value  < split_coupon_code.length) {
								var len = coupan_code.length;
								document.getElementById("coupon_code").setAttribute('maxlength',len);
								coupon_codeInfo.text("please enter all coupons value");
								coupon_codeInfo.addClass("message_error");
								return false;
							}else if(split_coupon_code.length < document.getElementById("no_of_coupon").value )
							{ 
							    coupon_codeInfo.addClass("message_error");
								coupon_codeInfo.text("please enter all coupons value");
								
								return false;
							}							
							
						}
					}
				}
			}
		}
		return true;
	}
	function validate_count_coupon_blur()
	{
		var chklength = document.getElementById("coupon_type").length - 1;
		var flag      = false;
		var temp	  ='';
		
		for(i=1;i<=chklength;i++)
		{
			if(document.getElementById("coupon_type_"+i+"")){
			temp = document.getElementById("coupon_type_"+i+"").selected; 
				if(temp == true)  {
					if(i > 2){
						var coupan_code = document.getElementById("coupon_code").value;
						var split_coupon_code = coupan_code.split(",");
						}
					}
			
		}
		
		}
	}
	function validate_deal_type()
	{
		if(deal_val){
		
		var chklength = 5;
			var flag      = false;
			var temp	  ='';
			
			for(i=1;i<=chklength;i++)
			{
			   if(document.getElementById("coupon_type_"+i+"")){
			   temp = document.getElementById("coupon_type_"+i+"").selected; 
			   if(temp == true)
			   {
					flag = true;
					break;
				}
			   }
			}
			if(flag == false)
			{
				//document.getElementById("no_of_coupons").style.display = "none";
				coupon_type.removeClass("textfield");
				coupon_type.addClass("errortextfield");
				coupon_typeInfo.text("Please select deal type");
				coupon_typeInfo.addClass("message_error");
				return false;
			}
			else{	
				oupon_type.removeClass("errortextfield");
				coupon_type.addClass("textfield");
				coupon_typeInfo.text("");
				coupon_typeInfo.removeClass("message_error");
				return true;
			}
		}
	}
	
	function validate_deal_date()
	{
		if(jQuery('#coupon_start_date').val() == " ")
		{
			var coupon_start_date = $c('#coupon_start_date');
			coupon_start_date.removeClass("textfield");
			coupon_start_date.addClass("errortextfield");
			jQuery('#deal_startInfo').addClass("error");
			jQuery('#deal_startInfo').text("Please enter start date");
			return false;
		}else{
			var coupon_start_date = $c('#coupon_start_date');
		
			coupon_start_date.removeClass("errortextfield");
			coupon_start_date.addClass("textfield");
			jQuery('#deal_startInfo').addClass("error");
			return true;
		}
	}
	
});

function no_of_coupon1()
{
	noofcoupon();
	return true;
}
function noofcoupon()
{
	document.getElementById("coupons").innerHTML =  document.getElementById("no_of_coupon").value+" coupons";
	return true;
}
/* function EnterNumber(e)	{
	var keynum;
	var keychar;
	if(document.getElementById('current_price').value != "" || document.getElementById('our_price').value != "")
	{
	if(window.event) // IE 
	{
		keynum = e.keyCode;
	}else if(e.which) // Netscape/Firefox/Opera
	{
		keynum = e.which;
	}			
	if(keynum == 8 || keynum == 9){
		var numcheck = new RegExp("^[^a-z^A-Z]");			
	}else{
		var numcheck = new RegExp("^[0-9.,]");
	}
	keychar = String.fromCharCode(keynum);	
	return numcheck.test(keychar);
	}
} */