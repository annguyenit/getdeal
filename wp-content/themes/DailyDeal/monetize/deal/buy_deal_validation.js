var $c = jQuery.noConflict();
$c(document).ready(function(){

	//global vars
	var enquiryfrm = $c("#dealpaynow_frm");
	var enquiryfrm1 = $c("#dealpaynow_frm1");
	var user_fname = $c("#owner_name");
	var user_email = $c("#owner_email");
	var billing_name = $c("#user_billing_name");
	var user_add = $c("#user_add1");
	var user_city = $c("#user_city");
	var user_state = $c("#user_state");
	var user_country = $c("#user_country");
	var user_postalcode = $c("#user_postalcode");
	
	var user_fname_Info = $c("#user_fname_Info");
	var user_emailInfo = $c("#user_emailInfo");
	var billing_nameInfo = $c("#billing_nameInfo");
	var user_addInfo = $c("#user_addInfo");
	var user_cityInfo = $c("#user_cityInfo");
	var user_stateInfo = $c("#user_stateInfo");
	var user_countryInfo = $c("#user_countryInfo");
	var user_postalcodeInfo = $c("#user_postalcodeInfo");
	
	//On blur
	user_fname.blur(validate_user_fname);
	user_email.blur(validate_user_email);
	billing_name.blur(validate_billing_name);
	user_add.blur(validate_user_add);
	user_city.blur(validate_user_city);
	user_state.blur(validate_user_state);
	user_country.blur(validate_user_country);
	user_postalcode.blur(validate_user_postalcode);

	//On key press
	user_fname.keyup(validate_user_fname);
	user_email.keyup(validate_user_email);
	billing_name.keyup(validate_billing_name);
	user_add.keyup(validate_user_add);
	user_city.keyup(validate_user_city);
	user_state.keyup(validate_user_state);
	user_country.keyup(validate_user_country);
	user_postalcode.keyup(validate_user_postalcode);

	//On Submitting
	enquiryfrm.submit(function(){
		if(validate_billing_name() & validate_user_add() & validate_user_city() & validate_user_state() & validate_user_country() & validate_user_postalcode())
		{
			hideform();
			return true
		}
		else
		{
			return false;
		}
	});

	enquiryfrm1.submit(function(){
		if(validate_user_fname() & validate_user_email())
		{
			hideform();
			return true
		}
		else
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
			user_emailInfo.text("Please Enter valid Email Address");
			user_emailInfo.addClass("message_error");
			return false;
		}else
		{
			user_email.removeClass("error");
			user_emailInfo.text("");
			user_emailInfo.removeClass("message_error");
			return true;
		}
	}

	

	function validate_billing_name()
	{
		if($c("#user_billing_name").val() == '')
		{
			billing_name.addClass("error");
			billing_name.removeClass("textfield");
			billing_name.addClass("errortextfield");
			billing_nameInfo.text("This field is required");
			billing_nameInfo.addClass("message_error");
			return false;
		}
		else{
			billing_name.removeClass("error");
			billing_name.removeClass("errortextfield");
			billing_name.addClass("textfield");
			billing_nameInfo.text("");
			billing_nameInfo.removeClass("message_error");
	
			return true;
		}
	}

	function validate_user_add()
	{
		if($c("#user_add1").val() == '')
		{
			user_add.addClass("error");
			user_add.removeClass("textfield");
			user_add.addClass("errortextfield");
			user_addInfo.text("This field is required");
			user_addInfo.addClass("message_error");
			return false;
		}
		else{
			user_add.removeClass("error");
			user_add.addClass("textfield");
			user_add.removeClass("errortextfield");
			user_addInfo.text("");
			user_addInfo.removeClass("message_error");
			
			return true;
		}
	}
	
	function validate_user_city()
	{
		if($c("#user_city").val() == '')
		{
			user_city.addClass("error");
			user_city.removeClass("textfield");
			user_city.addClass("errortextfield");
			user_cityInfo.text("This field is required");
			user_cityInfo.addClass("message_error");
			return false;
		}
		else{
			user_city.removeClass("error");
			user_city.addClass("textfield");
			user_city.removeClass("errortextfield");
			user_cityInfo.text("");
			user_cityInfo.removeClass("message_error");
			return true;
		}
	}
	
	function validate_user_state()
	{
		if($c("#user_state").val() == '')
		{
			user_state.addClass("error");
			user_state.removeClass("textfield");
			user_state.addClass("errortextfield");
			user_stateInfo.text("This field is required.");
			user_stateInfo.addClass("message_error");
			return false;
		}
		else{
			user_state.removeClass("error");
			user_state.addClass("textfield");
			user_state.removeClass("errortextfield");
			user_stateInfo.text("");
			user_stateInfo.removeClass("message_error");
			return true;
		}
	}
	
	function validate_user_country()
	{
		if($c("#user_country").val() == '')
		{
			user_country.addClass("error");
			user_country.removeClass("textfield");
			user_country.addClass("errortextfield");
			user_countryInfo.text("This field is required.");
			user_countryInfo.addClass("message_error");	
			return false;
		}
		else{
		
			user_country.removeClass("error");
			user_country.addClass("textfield");
			user_country.removeClass("errortextfield");
			user_countryInfo.text("");
			user_countryInfo.removeClass("message_error");	
	
			return true;
		}
	}
	function validate_user_postalcode()
	{
		if($c("#user_postalcode").val() == '')
		{
			user_postalcode.addClass("error");
			user_postalcode.removeClass("textfield");
			user_postalcode.addClass("errortextfield");
			user_postalcodeInfo.text("This field is required.");
			user_postalcodeInfo.addClass("message_error");	
			
			return false;
		}
		else{
			user_postalcode.removeClass("error");
			user_postalcode.addClass("textfield");
			user_postalcode.removeClass("errortextfield");
			user_postalcodeInfo.text("");
			user_postalcodeInfo.removeClass("message_error");	
			return true;
		}
	}


});

function set_login_registration_frm(val) {
	if(val=='existing_user') {
		document.getElementById('contact_detail_id').style.display = 'none';
		document.getElementById('login_user_frm_id').style.display = '';
		document.getElementById('user_login_or_not').value = val;
	}else  //new_user
	{
		document.getElementById('contact_detail_id').style.display = '';
		document.getElementById('login_user_frm_id').style.display = 'none';
		document.getElementById('user_login_or_not').value = val;
	}
}