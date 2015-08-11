var $cwidget = jQuery.noConflict();
$cwidget(document).ready(function(){

	//global vars
	var contact_widget_frm = $cwidget("#contact_widget_frm");
	var your_name = $cwidget("#widget_your-name");
	var your_email = $cwidget("#widget_your-email");
	var your_subject = $cwidget("#widget_your-subject");
	var your_message = $cwidget("#widget_your-message");
	
	var your_name_Info = $cwidget("#widget_your_name_Info");
	var your_emailInfo = $cwidget("#widget_your_emailInfo");
	var your_subjectInfo = $cwidget("#widget_your_subjectInfo");
	var your_messageInfo = $cwidget("#widget_your_messageInfo");
	
	//On blur
	your_name.blur(validate_widget_your_name);
	your_email.blur(validate_widget_your_email);
	your_subject.blur(validate_widget_your_subject);
	your_message.blur(validate_widget_your_message);

	//On key press
	your_name.keyup(validate_widget_your_name);
	your_email.keyup(validate_widget_your_email);
	your_subject.keyup(validate_widget_your_subject);
	your_message.keyup(validate_widget_your_message);

	//On Submitting
	contact_widget_frm.submit(function(){
		if(validate_widget_your_name() & validate_widget_your_email() & validate_widget_your_subject() & validate_widget_your_message())
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
	function validate_widget_your_name()
	{
		if($cwidget("#widget_your-name").val() == '')
		{
			your_name.addClass("error");
			your_name_Info.text("Please Enter Name");
			your_name_Info.addClass("message_error");
			return false;
		}
		else
		{
			your_name.removeClass("error");
			your_name_Info.text("");
			your_name_Info.removeClass("message_error");
			return true;
		}
	}

	function validate_widget_your_email()
	{
		var isvalidemailflag = 0;
		if($cwidget("#widget_your-email").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if($cwidget("#widget_your-email").val() != '')
		{
			var a = $cwidget("#widget_your-email").val();
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
			your_email.addClass("error");
			your_emailInfo.text("Please Enter valid Email");
			your_emailInfo.addClass("message_error");
			return false;
		}else
		{
			your_email.removeClass("error");
			your_emailInfo.text("");
			your_emailInfo.removeClass("message_error");
			return true;
		}
	}

	

	function validate_widget_your_subject()
	{
		if($cwidget("#widget_your-subject").val() == '')
		{
			your_subject.addClass("error");
			your_subjectInfo.text("Please Enter Subject");
			your_subjectInfo.addClass("message_error");
			return false;
		}
		else{
			your_subject.removeClass("error");
			your_subjectInfo.text("");
			your_subjectInfo.removeClass("message_error");
			return true;
		}
	}

	function validate_widget_your_message()
	{
		if($cwidget("#widget_your-message").val() == '')
		{
			your_message.addClass("error");
			your_messageInfo.text("Please Enter Message");
			your_messageInfo.addClass("message_error");
			return false;
		}
		else{
			your_message.removeClass("error");
			your_messageInfo.text("");
			your_messageInfo.removeClass("message_error");
			return true;
		}
	}

});