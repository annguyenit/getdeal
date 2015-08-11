<?php session_start();
ob_start();
global $wpdb;
	
if(isset($_REQUEST['save_deal']) && $_REQUEST['save_deal'] != '' && $_SESSION['deal_id'] == "")
{
	$count = 1;
	unset($_SESSION['deal_info']);
	$postDeal = $_SESSION;
	
	$lastid = 0;
	if($_SESSION != '')
	{
		
		$password = wp_generate_password(12,false);
		$user_registered = date("Y-m-d h:i:s");
		$user_db_table_name = get_user_table();
		if($current_user->data->ID == " " || !isset($current_user->data->ID)) {
			$user_a_id = wp_create_user( $_SESSION['owner_email'], $password, $_SESSION['owner_email'] );
			$user_qry = "select ID from $user_db_table_name order by ID desc limit 0,1";
			$authorlastid = $wpdb->get_var($user_qry);
			$userName = $_SESSION['owner_name'];
			update_usermeta($user_id, 'first_name', $_SESSION['owner_name']); // User First Name Information Here
			$user_nicename = $_SESSION['owner_name']; //generate nice name
			$updateUsersql = "update $user_db_table_name set user_nicename='".$user_nicename."' , display_name='".$userName."'  where ID='".$user_id."'";
			$wpdb->query($updateUsersql);
			
			if($_SESSION['post_title'] != '' && $_SESSION['post_content'] != '' ){
				 $my_post = array(
							'post_author' => $user_a_id,
							'post_title' => $_SESSION['post_title'],
							'post_excerpt' => $_SESSION['post_excerpt'],
							'post_content' =>$_SESSION['post_content'],
							'post_type' =>'seller');
	
				wp_insert_post($my_post);
				//echo $lastid = $wpdb->insert_id;
				 $lastid = $wpdb->get_col("SELECT LAST_INSERT_ID()" );
		global $password;
			}
		} else {
			if($_SESSION['post_title'] != '' )	{ 
				$my_post = array(
							'post_author' => $current_user->data->ID ,
							'post_title' => $_SESSION['post_title'],
							'post_excerpt' => $_SESSION['post_excerpt'],
							'post_content' =>$_SESSION['post_content'],
							'post_type' =>'seller');
				wp_insert_post($my_post);
				$_SESSION['post_title'];
				$lastid = $wpdb->get_col("SELECT LAST_INSERT_ID()" );
			}
		}
		
		
			
		$post_id = $lastid[0];
		foreach($postDeal as $key=>$val)
		{
			if($val != '' && $key!='captcha' && $key!='deal_info' && $key!='deal_image' && $key!='media_file' && $key!='post_title' && $key!='post_content' && $key!='qry_string')
				update_post_meta($post_id, "$key", $val);
		}
		
		
		
		if (isset( $mediafilename) && !empty( $_FILES ) ) {
	
			require_once(ABSPATH . 'wp-admin/includes/admin.php');
			$id = media_handle_upload('async-upload', $post_id); //post id of Client Files page
			unset($_FILES);
			if ( is_wp_error($id) ) {
				$errors['upload_error'] = $id;
				$id = false;
			}
		
			if ($errors) {
				echo "<p>There was an error uploading your file.</p>";
			} else {
				echo "<p>Your file has been uploaded.</p>";
			}
		}
		$mediafilename = $_SESSION['media_file'];
		$wp_filetype = wp_check_filetype(basename($mediafilename), null );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $post_id, $mediafilename );
	    wp_update_attachment_metadata($post_id,$mediafilename);
		
		update_post_meta($post_id, "status", '0');
		update_post_meta($post_id, "is_expired", '0');
		if($_SESSION['deal_category'] != '' )
		{ 
				$category_deal = explode(",",$_SESSION['deal_category']);
				for($deal =0 ; $deal <= count($category_deal) ; $deal ++)
				{
					$category_deal[$deal];
					if($category_deal[$deal] != "")
					{
					$termtable = $wpdb->prefix."term_relationships";
					$dealcat = $wpdb->query("insert into " . $termtable . " (object_id ,term_taxonomy_id,term_order) values( '".$post_id."','".$category_deal[$deal]."', '0')");
					}
				}
		}
	}
	
}

//update post

if(isset($_POST['update_deal']) || $_SESSION['deal_id'] != ""){


	$count = 1;
	unset($_SESSION);
	$postDeal = $_SESSION;
	
	$lastid = 0;
	if($_SESSION != '')
	{
		
		$password = wp_generate_password(12,false);
		$user_registered = date("Y-m-d h:i:s");
	
		$_SESSION['password'] = $password;
		$user_db_table_name = get_user_table();
		if($current_user->data->ID == " " || !isset($current_user->data->ID))
		{
			$user_id = wp_create_user( $_SESSION['owner_email'], $password, $_SESSION['owner_email'] );
			$userName = $_SESSION['user_fname'];
			update_usermeta($user_id, 'first_name', $_SESSION['owner_name']); // User First Name Information Here
			$user_nicename = get_user_nice_name($_SESSION['owner_name']); //generate nice name
			$updateUsersql = 'update $user_db_table_name set user_nicename="'.$user_nicename.'" , display_name="'.$userName.'"  where ID="'.$user_id.'"';
			$wpdb->query($updateUsersql);
		
			$authorlastid = $user_id;

			if($_SESSION['post_title'] != '' )
			{
				 $my_post = array(
							'post_author' => $authorlastid[0],
							'post_title' => $_SESSION['post_title'],
							'post_excerpt' => $_SESSION['post_excerpt'],
							'post_content' =>$_SESSION['post_content'],
							'post_type' =>'seller');
	
				wp_update_post($my_post);
				
				//echo $lastid = $wpdb->insert_id;
				echo $lastid = $wpdb->get_col("SELECT LAST_INSERT_ID()" );
			}
		}else{
		
			if($_SESSION['post_title'] != '' )
			{ 
				 $my_post = array(
							'post_author' => $current_user->data->ID ,
							'post_title' => $_SESSION['post_title'],
							'post_excerpt' => $_SESSION['post_excerpt'],
							'post_content' =>$_SESSION['post_content'],
							'post_type' =>'seller');
	
				wp_update_post($my_post);
				$lastid = $wpdb->get_col("SELECT LAST_UPDATE_ID()" );
				$lastid =  $_REQUEST['updateid'];
				$lastid = $_SESSION['deal_id'];
				
			}
			
		}
		$post_id = $lastid;
		
		foreach($postDeal as $key=>$val)
		{
			echo "";
			if($val != '' && $key!='captcha' && $key!='deal_info' && $key!='deal_image' && $key!='media_file' && $key!='post_title' && $key!='post_content' && $key!='qry_string')
			update_post_meta($post_id, "$key", $val);
		}
		
		if($_SESSION['deal_category'] != '' )
		{ 
				$category_deal = explode(",",$_SESSION['deal_category']);
				for($deal =0 ; $deal <= count($category_deal) ; $deal ++)
				{
					$category_deal[$deal];
					if($category_deal[$deal] != "")
					{
					$termtable = $wpdb->prefix."term_relationships";
					$dealcat = $wpdb->query("UPADTE " . $termtable . " set object_id = '".$post_id."',term_taxonomy_id = '".$category_deal[$deal]."',term_order = '0'");
					}
				}
		}
		
		if (isset( $mediafilename) && !empty( $_FILES ) ) {
	
			require_once(ABSPATH . 'wp-admin/includes/admin.php');
			$id = media_handle_upload('async-upload', $post_id); //post id of Client Files page
			unset($_FILES);
			if ( is_wp_error($id) ) {
				$errors['upload_error'] = $id;
				$id = false;
			}
		
			if ($errors) {
				echo "<p>There was an error uploading your file.</p>";
			} else {
				echo "<p>Your file has been uploaded.</p>";
			}
		}
		$mediafilename = $_SESSION['media_file'];
		$wp_filetype = wp_check_filetype(basename($mediafilename), null );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $lastid, $mediafilename );
	    wp_update_attachment_metadata($lastid,$mediafilename);
		
		$updatestatus = get_post_meta($lastid, "status",true);
		$updateexpired = get_post_meta($lastid, "is_expired",true);
		update_post_meta($lastid, "status", $updatestatus);
		update_post_meta($lastid, "is_expired", $updateexpired);
		wp_redirect(site_url("/?ptype=success_deal&edit_success=yes"));
	}

}




if(isset($_REQUEST['save_deal']) && $_REQUEST['save_deal'] != '' && $_SESSION['deal_id'] == "")
{
	$uploadpath = wp_upload_dir(); 
	$tmpfolder = $uploadpath['baseurl'].'/tmp/';
	$imgstr = '';
	if($_SESSION["file_info"] != ''){
	foreach($_SESSION["file_info"] as $key=>$val)
	{
		$imagepath =  $tmpfolder.$key.'.jpg';	
		$imgstr .= '<a href="'.$imagepath.'" target="_blank" ><img src="'.$imagepath.'" height="100" width="100" alt="" /></a> &nbsp; &nbsp;';
	}}
	$user_fname = $_SESSION['owner_name'];
	$user_email = $_SESSION['owner_email'];
	$deal_title = $_SESSION['post_title'];
	$deal_desc = $_SESSION['post_content'];
	
	$coupon_website = $_SESSION['coupon_website'];
	$no_of_coupon = $_SESSION['no_of_coupon'];
	$our_price = $_SESSION['our_price'];
	$current_price =$_SESSION['current_price'];
	$coupon_type = $_SESSION['coupon_type'];
	$single_coupon_code = $_SESSION['single_coupon_code'];
	$coupon_code= $_SESSION['coupon_code'];
	if($single_coupon_code == "" && $coupon_code == "")
	{
		$coupon_code = $_SESSION['coupon_code'];
	}
	$coupon_address = $_SESSION['coupon_address'];
	$coupon_link = $_SESSION['coupon_link'];
	$mediafilename = $_SESSION['media_file'];
	if($coupon_type=='1')
	   $coupon_type='Custom Link Deal';
	 elseif($coupon_type=='2')
	   $coupon_type='Fixed Deal';
	 elseif($coupon_type=='3')
	   $coupon_type='Custom Generated Deal';
	 elseif($coupon_type=='4')
	   $coupon_type='Physical Barcode Deal';
	 elseif($coupon_type=='5')
	$coupon_type='Physical Product Deal';
	
	// Start All Transection Details With Deal
	if($coupon_address!="")	{
			$transaction_details = sprintf(__("
			<p><strong>".DEAL_DETAILS_TEXT."</strong> \r</p>
			<p><strong>".DEAL_TITLE_TEXT.": </strong>%s \r	</p>
			<p><strong>".DEAL_CONTENT_TEXT.": </strong>%s \r	</p>
			<p><strong>".NO_OF_ITEMS.": </strong>%s \r	</p>
			<p><strong>".DEAL_TYPE.": </strong>%s \r	</p>
			<p><strong>".DEAL_CPRICE_TEXT.": </strong>%s \r	</p>
			<p><strong>".DEAL_YOUR_PRICE_TEXT.": </strong>%s \r	</p>
			<p><strong>".STORE_ADDRESS.":</strong> %s \r	</p>
			",'templatic'),$deal_title,$deal_desc,$no_of_coupon,get_currency_sym().$current_price,get_currency_sym().$our_price,$current_price,$coupon_address);
	} else	{
			$transaction_details = sprintf(__("
			<p><strong>".DEAL_DETAILS_TEXT."</strong> \r</p>
			<p><strong>".DEAL_TITLE_TEXT.": </strong>%s \r	</p>
			<p><strong>".DEAL_CONTENT_TEXT.": </strong>%s \r	</p>
			<p><strong>".NO_OF_ITEMS.": </strong>%s \r	</p>
			<p><strong>".DEAL_TYPE.": </strong>%s \r	</p>
			<p><strong>".DEAL_CPRICE_TEXT.": </strong>%s \r	</p>
			<p><strong>".DEAL_YOUR_PRICE_TEXT.": </strong>%s \r	</p>
			",'templatic'),$deal_title,$deal_desc,$no_of_coupon,$coupon_type,get_currency_sym().$current_price,get_currency_sym().$our_price);
	}
	// End All Transection Details With Deal
	
	// Start User Details With Deal
	$users_details = sprintf(__("
	<p><strong>".SELLER_DETAIL."</strong> \r</p>
	<p><strong>".NAME.":</strong> %s \r	</p>
	<p><strong>".EMAIL.":</strong> %s \r	</p><p><strong>Password :</strong> %s \r</p>",'templatic'),$user_fname,$user_email,$password);
	$fromEmail = get_site_emailId();
	$fromEmailName = get_site_emailName();
	/*-------Fetch Email details --------*/
		$client_message = get_option('post_submited_success_email_content');
		if($client_message == "")
		{
			$client_message = $transaction_details;
		}
		$subject = get_option('post_submited_success_email_subject');
		if($subject == "")
		{
			$subject = 'A new deal is submitted';
		}
		$site_name = get_option('blogname');
		$search_array = array('[#to_name#]','[#deal_details#]','[#seller_details#]','[#site_name#]');
		$replace_array = array($fromEmailName.",",$transaction_details,$users_details,$site_name);
		$email_seller_content = str_replace($search_array,$replace_array,$client_message);	
				
		$_SESSION['deal_info']='';
		/*sendEmail($fromEmail,$fromEmailName,$user_email,$user_fname,$subject,$email_seller_content,$extra='');*/
			
		/*-------Sent Email to admin --------*/
		if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {	
			templ_sendEmail($user_email,$user_fname,$fromEmail,$fromEmailName,$subject,$email_seller_content,$extra='');
			
		}
		if ( $current_user->data->ID == '' && !isset($current_user->data->ID) ) {
			///////REGISTRATION EMAIL START//////
			$user_fname = $_SESSION['owner_name'];
			$user_login = $_SESSION['owner_email'];
			$store_name = get_option('blogname');
			$password = $_SESSION['password'];
			$client_message = get_option('registration_success_email_content');
			if($client_message == "")
			{
				$client_message = $users_details;
			}
			$subject = get_option('registration_success_email_subject');
			if($subject == "")
			{
				$subject = 'Registration completed successfully.';
			}
			$store_login = '<a href="'.site_url().'/?ptype=login">'.site_url().'/?ptype=login</a>';
			$store_login_link = site_url().'/?ptype=login';
			/////////////customer email//////////////
			$search_array = array('[#user_name#]','[#user_login#]','[#user_password#]','[#site_name#]','[#site_login_url#]','[#site_login_url_link#]');
			$replace_array = array($user_fname,$user_login,$password,$store_name,$store_login,$store_login_link);
			$client_message = str_replace($search_array,$replace_array,$client_message);	
			if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {	
				templ_sendEmail($fromEmail,$fromEmailName,$user_login,$user_fname,$subject,$client_message,$extra='');
			}///To clidne email
			//////REGISTRATION EMAIL END////////
		}
		if(isset($_REQUEST['save_deal']) && $_REQUEST['save_deal'] != '' && $_SESSION['deal_id'] == "")
		{
		wp_redirect(site_url("/?ptype=success_deal"));
		}
		unset($_SESSION['deal_info']);
}
?>