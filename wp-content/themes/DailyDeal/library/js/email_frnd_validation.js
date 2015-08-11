$(document).ready(function(){

//global vars

	var enquiryfrm = $("#send_to_frnd");

	var to_name = $("#to_name");

	var to_nameInfo = $("#to_nameInfo");

	var to_email = $("#to_email");

	var to_emailInfo = $("#to_emailInfo");

	var yourname = $("#yourname");

	var yournameInfo = $("#yournameInfo");

	var youremail = $("#youremail");

	var youremailInfo = $("#youremailInfo");

	var frnd_comments = $("#frnd_comments");

	var frnd_commentsInfo = $("#frnd_commentsInfo");

	

	//On blur

	to_name.blur(validate_to_name);

	to_email.blur(validate_to_email);

	yourname.blur(validate_yourname);

	youremail.blur(validate_youremail);

	frnd_comments.blur(validate_frnd_comments);

	

	//On key press

	to_name.keyup(validate_to_name);

	to_email.keyup(validate_to_email);

	yourname.keyup(validate_yourname);

	youremail.keyup(validate_youremail);

	frnd_comments.keyup(validate_frnd_comments);

	

	//On Submitting

	enquiryfrm.submit(function(){

		if(validate_to_name() & validate_to_email() & validate_yourname() & validate_youremail() & validate_frnd_comments())

		{

			function reset_send_email_agent_form()
			{
				document.getElementById('to_name').value = '';
				document.getElementById('to_email').value = '';
				document.getElementById('yourname').value = '';
				document.getElementById('youremail').value = '';	
				document.getElementById('frnd_subject').value = '';
				document.getElementById('frnd_comments').value = '';	
			}
			//hideform();
			setTimeout("document.getElementById('to_name').value = ''; document.getElementById('to_email').value = ''; document.getElementById('yourname').value = ''; document.getElementById('youremail').value = ''; document.getElementById('frnd_subject').value = ''; document.getElementById('frnd_comments').value = '';",1000);
			setTimeout("document.getElementById('reply_send_success').style.display='';document.getElementById('reply_send_success').innerHTML = 'Message Send Successfully!'",500);
			return true

		}

		else

		{

			return false;

		}

	});



	//validation functions

	function validate_to_name()

	{

		if($("#to_name").val() == '')

		{

			to_name.addClass("error");

			to_nameInfo.text("Please Enter To Name");

			to_nameInfo.addClass("message_error2");

			return false;

		}

		else{

			to_name.removeClass("error");

			to_nameInfo.text("");

			to_nameInfo.removeClass("message_error2");

			return true;

		}

	}

	function validate_to_email()

	{

		var isvalidemailflag = 0;

		if($("#to_email").val() == '')

		{

			isvalidemailflag = 1;

		}else

		if($("#to_email").val() != '')

		{

			var a = $("#to_email").val();

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

			to_email.addClass("error");

			to_emailInfo.text("Please Enter valid Email Address");

			to_emailInfo.addClass("message_error2");

			return false;

		}else

		{

			to_email.removeClass("error");

			to_emailInfo.text("");

			to_emailInfo.removeClass("message_error");

			return true;

		}

		

	}

	

	function validate_yourname()

	{

		if($("#yourname").val() == '')

		{

			yourname.addClass("error");

			yournameInfo.text("Please Enter Your Name");

			yournameInfo.addClass("message_error2");

			return false;

		}

		else{

			yourname.removeClass("error");

			yournameInfo.text("");

			yournameInfo.removeClass("message_error2");

			return true;

		}

	}

	

	function validate_youremail()

	{

		var isvalidemailflag = 0;

		if($("#youremail").val() == '')

		{

			isvalidemailflag = 1;

		}else

		if($("#youremail").val() != '')

		{

			var a = $("#youremail").val();

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

			youremail.addClass("error");

			youremailInfo.text("Please Enter valid Email Address");

			youremailInfo.addClass("message_error2");

			return false;

		}else

		{

			youremail.removeClass("error");

			youremailInfo.text("");

			youremailInfo.removeClass("message_error");

			return true;

		}

		

	}

	function validate_frnd_comments()

	{

		if($("#frnd_comments").val() == '')

		{

			frnd_comments.addClass("error");

			frnd_commentsInfo.text("Please Enter Comments");

			frnd_commentsInfo.addClass("message_error2");

			return false;

		}

		else{

			frnd_comments.removeClass("error");

			frnd_commentsInfo.text("");

			frnd_commentsInfo.removeClass("message_error2");

			return true;

		}

	}



});