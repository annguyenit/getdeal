var $c = jQuery.noConflict();
$c(document).ready(function(){

	//global vars
	var enquiryfrm = $c("#dealpaynow_frm");
	var user_fname = $c("#user_fname");
	var user_email = $c("#user_email");
	
	var user_fname_Info = $c("#user_fname_Info");
	var user_emailInfo = $c("#user_emailInfo");
	
	//On blur
	user_fname.blur(validate_user_fname);
	user_email.blur(validate_user_email);

	//On key press
	user_fname.keyup(validate_user_fname);
	user_email.keyup(validate_user_email);

	//On Submitting
	enquiryfrm.submit(function(){
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
		if($c("#user_fname").val() == '')
		{
			user_fname.addClass("error");
			user_fname_Info.text("Please Enter Your Name");
			user_fname_Info.addClass("message_error");
			return false;
		}
		else
		{
			user_fname.removeClass("error");
			user_fname_Info.text("");
			user_fname_Info.removeClass("message_error");
			return true;
		}
	}

	function validate_user_email()
	{
		var isvalidemailflag = 0;
		if($c("#user_email").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if($c("#user_email").val() != '')
		{
			var a = $c("#user_email").val();
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


});