<?php
if($_POST)
{
	$yourname = $_POST['yourname'];
	$youremail = $_POST['youremail'];
	$frnd_subject = $_POST['frnd_subject'];
	$frnd_comments = $_POST['frnd_comments'];
	$deal_id = $_POST['deal_id'];
	$to_email = $_POST['to_email'];
	$to_name = $_POST['to_name'];
	if($_REQUEST['deal_id'])
	{
		$productinfosql = "select ID,post_title from $wpdb->posts where ID =".$_REQUEST['deal_id'];
		$productinfo = $wpdb->get_results($productinfosql);
		foreach($productinfo as $productinfoObj)
		{
			$post_title = $productinfoObj->post_title; 
		}
	}
	///////Inquiry EMAIL START//////
	global $General;
	global $upload_folder_path;
	$store_name = get_option('blogname');
	
	$email_content = get_option('post_send_to_friend_email_content');
	$email_subject = get_option('post_send_to_friend_email_subject');
	
	
	if($email_content == "" && $email_subject=="")
	{
		$message1 =  __('[SUBJECT-STR]You might be interested in.. [SUBJECT-END]
		<p>[#$to_name#],</p>
		<p>[#$frnd_comments#]</p>
		<p>LinkBekijk \'m hier: <b>[#$post_title#]</b> </p>
		<p>Groeten, [#$your_name#]</p>');
		$filecontent_arr1 = explode('[SUBJECT-STR]',$message1);
		$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
		$subject = $filecontent_arr2[0];
		if($subject == '')
		{
			$subject = $frnd_subject;
		}
		$client_message = $filecontent_arr2[1];
	}
	$subject = $frnd_subject;
	
	$post_url_link = '<a href="'.get_permalink($_REQUEST['deal_id']).'">'.$post_title.'</a>';
	/////////////customer email//////////////
	//$yourname_link = $yourname.'<br>Sent from - <b><a href="'.get_option('siteurl').'">'.get_option('blogname').'</a></b>.';
        $yourname_link = $yourname.'.';
	$search_array = array('[#$to_name#]','[#$post_title#]','[#$frnd_comments#]','[#$your_name#]','[#$post_url_link#]');
	$replace_array = array($to_name,$post_url_link,nl2br($frnd_comments),$yourname_link,$post_url_link);
	$client_message = str_replace($search_array,$replace_array,$client_message);
	/*echo "From : $youremail  Name : $yourname <br>";
	echo "To : $to_email  Name : $to_name <br>";
	echo "Subject $subject <br>";
	echo "$client_message";
	exit;*/
	templ_sendEmail($youremail,$yourname,$to_email,$to_name,$subject,$client_message,$extra='');///To clidne email
	//////Inquiry EMAIL END////////	
	if(get_option('siteurl').'/' == $_REQUEST['request_uri']){
			echo "<script>alert('Email sent successfully');location.href='".get_option('siteurl')."'</script>";
	} else {
		echo "<script>alert('Email sent successfully');location.href='".$_REQUEST['link_url']."'</script>";
	}
	
}?>