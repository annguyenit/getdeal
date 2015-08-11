<?php
session_start();
ob_start();?>
<?php get_header();?>
<script>var rootfolderpath = "<?php bloginfo('template_directory'); ?>/images/";</script>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/timer.js"></script>
<?php

if($_POST)
{
	//auto generate coupon code if coupon code is null
	if($_POST["coupon_type"]=="3" || $_POST["coupon_type"]=="4")
	{
		
		if($_POST["coupon_code"]=="")
		{
			
			$sys_gen_coupon = '';
			if($_POST['single_coupon_code'] == '')
			{
			for($c=0;$c<$_POST["no_of_coupon"];$c++)
			{   
			    $user_coup = wp_generate_password(3,false);
				$sys_gen_coupon.=$user_coup.",";
			}
			$sys_gen_coupon = trim($sys_gen_coupon,",");
			}
			else
			{
				$sys_gen_coupon = $_POST['single_coupon_code'];
			}
			$_POST["coupon_code"] = $sys_gen_coupon;
		}
	}
	$_SESSION = $_POST;
	
	if(file_exists(ABSPATH.'wp-content/plugins//wp-recaptcha/recaptchalib.php')){
		require_once( ABSPATH.'wp-content/plugins//wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	}
	if (!$resp->is_valid && isset($_POST['recaptcha_response_field']) && isset($_POST['recaptcha_challenge_field'])) {
		if(!isset($_REQUEST['editdeal']) || ($_REQUEST['editdeal'] == ""))	{
			wp_redirect(site_url("/?ptype=dealform&amp;emsg=captch"));
		}else{
			wp_redirect(site_url("/?ptype=dealform&amp;emsg=captch&editdeal=".$_REQUEST['editdeal']));
		}
	} else {
	// What happens when the CAPTCHA was entered incorrectly
	$current_date = date('Y-m-d');
	$_SESSION['owner_name'] 		= $_REQUEST['owner_name'];
	$_SESSION['owner_email'] 	= $_REQUEST['owner_email'];
	$_SESSION['post_title'] 	= $_REQUEST['post_title'];
	$_SESSION['post_excerpt'] =  $_REQUEST['post_excerpt'];
	$_SESSION['post_content'] =  $_REQUEST['post_content'];
	$_SESSION['coupon_website'] 	= $_REQUEST['coupon_website'];
	$_SESSION['no_of_coupon'] 	= $_REQUEST['no_of_coupon'];
	$_SESSION['our_price'] 		= $_REQUEST['our_price'];
	$_SESSION['current_price'] 	= $_REQUEST['current_price'];
	$_SESSION['current_price'] 	= $_REQUEST['current_price'];
	$_SESSION['min_purchases'] = $_REQUEST['min_purchases'];
	$_SESSION['max_purchases_user'] = $_REQUEST['max_purchases_user'];
	$_SESSION['coupon_type'] = $_REQUEST['coupon_type'];
	$_SESSION['thankyou_page_url'] = $_REQUEST['thankyou_page_url'];
	$_SESSION['coupon_expired_date'] = $_REQUEST['coupon_expired_date'];
	$_SESSION['geo_latitude'] = $_REQUEST['geo_latitude'];
	$_SESSION['geo_longitude'] = $_REQUEST['geo_longitude'];
	$_SESSION['coupon_entry'] =  $_REQUEST['coupon_entry'];   
	$_SESSION['is_expired'] = '0';
	$_SESSION['coupon_code'] = $_POST['coupon_code'];
	$coupon_type = $_REQUEST['coupon_type'];
	$coupon_type = $_REQUEST['coupon_type'];
	$_SESSION['affiliate_link'] = "";
	$_SESSION['deal_id'] =  $_REQUEST['updateid'];
	$_SESSION['shipping_address'] = $_REQUEST['shipping_address'];
	$_SESSION['shipping_cost'] = $_REQUEST['shipping_cost'];
	$dcat = $_REQUEST['deal_category'];
	$countc = count($_REQUEST['deal_category']);
	$sep = "";
	$a = "";
	$dealcat1 = "";
	
	if($coupon_type == '1')
	{
		$_SESSION['coupon_link'] = $_REQUEST['coupon_link'];
		
	}
	if($_REQUEST['coupon_entry'] == "coupon_entry_0")
	{
		$_SESSION['coupon_code'] = $_REQUEST['single_coupon_code'];
	}
	elseif($_REQUEST['coupon_entry'] == "coupon_entry_1")
	{
		 $_SESSION['coupon_code'] = $_REQUEST['coupon_code'];
	}elseif($_REQUEST['single_coupon_code'] == "" && $_REQUEST['coupon_code'] == "" )
	{
		 $_SESSION['coupon_code'] = rand();
	}
	
	$_SESSION['coupon_start_date_time']=strtotime($_POST["coupon_start_date"]." ".$_POST["coupon_start_time_hh"].":".$_POST["coupon_start_time_mm"].":".$_POST["coupon_start_time_ss"]);
	
	$tardate= date("Y m d,H:i:s",$_SESSION['coupon_end_date_time']);
	if((isset($_SESSION['coupon_end_date']) || $_SESSION['coupon_end_date'] != "") && ($_SESSION['enddate'] == 0 ))
	{ 
	$_SESSION['coupon_end_date_time']=strtotime($_POST["coupon_end_date"]." ".$_POST["coupon_end_time_hh"].":".$_POST["coupon_end_time_mm"].":".$_POST["coupon_end_time_ss"]);
	}else{
	$_SESSION['coupon_end_date_time'] == "";
	}
	
	if($dcat != "")
	{
		for($dc = 0; $dc < $countc; $dc ++ )
		{
			if($dc == $countc - 1)
			{
				$sep = "";
			}
			else
			{
				$sep =",";
			}
			$termtable = $wpdb->prefix."terms";
			$dealcat = $wpdb->get_row("select * from $termtable where term_id = '".$dcat[$dc]."'");
			
			$a .= $dcat[$dc].$sep;
			$dealcat1 .= $dealcat->name.$sep;
			
			
		}
	}

	$coupon_code 	= "";
	$_SESSION['deal_category'] = $a;
		
		
	}
	
}
?>

<?php

				$dirinfo = wp_upload_dir();
				$path = $dirinfo['path'];
				$url = $dirinfo['url'];
				$destination_path = $path."/";
				$destination_url = $url."/";
	if (!file_exists(ABSPATH.'/wp-content')){
	  mkdir(ABSPATH.'/wp-content', 0777);
	}
	if (!file_exists(ABSPATH.'/wp-content/uploads/')){
		mkdir(ABSPATH.'/wp-content/uploads/', 0777);
	}
						
	$current_date = date('Y-m-d');
	$_SESSION['owner_name'] 		= $_REQUEST['owner_name'];
	$_SESSION['owner_email'] 	= $_REQUEST['owner_email'];
	$_SESSION['post_title'] 	= $_REQUEST['post_title'];
	$_SESSION['post_content'] =  htmlspecialchars_decode($_REQUEST['post_content']);
	$_SESSION['coupon_website'] 	= $_REQUEST['coupon_website'];
	$_SESSION['no_of_coupon'] 	= $_REQUEST['no_of_coupon'];
	$_SESSION['our_price'] 		= $_REQUEST['our_price'];
	$_SESSION['current_price'] 	= $_REQUEST['current_price'];
	$_SESSION['min_purchases'] = $_REQUEST['min_purchases'];
	$_SESSION['max_purchases_user'] = $_REQUEST['max_purchases_user'];
	$_SESSION['coupon_type'] = $_REQUEST['coupon_type'];
	$_SESSION['thankyou_page_url'] = $_REQUEST['thankyou_page_url'];
	$_SESSION['coupon_expired_date'] = $_REQUEST['coupon_expired_date'];
	$_SESSION['geo_latitude'] = $_REQUEST['geo_latitude'];
	$_SESSION['geo_longitude'] = $_REQUEST['geo_longitude'];
	$_SESSION['coupon_entry'] =  $_REQUEST['coupon_entry'];   
	$_SESSION['is_expired'] = '0';
	$coupon_type = $_REQUEST['coupon_type'];
	$coupon_type = $_REQUEST['coupon_type'];
	$_SESSION['affiliate_link'] = "";
	$_SESSION['deal_id'] =  $_REQUEST['updateid'];
	$_SESSION['shipping_address'] = $_REQUEST['shipping_address'];
	$_SESSION['shipping_cost'] = $_REQUEST['shipping_cost'];
	$_SESSION['enddate'] = $_REQUEST['enddate'];
	$dcat = $_REQUEST['deal_category'];
	$countc = count($_REQUEST['deal_category']);
	$sep = "";
	$a = "";
	$dealcat1 = "";
	if($dcat != "")
	{
		for($dc = 0; $dc < $countc; $dc ++ )
		{
			if($dc == $countc)
			{
				$sep = "";
			}
			else
			{
				$sep =",";
			}
			$termtable = $wpdb->prefix."terms";
			$dealcat = $wpdb->get_row("select * from $termtable where term_id = '".$dcat[$dc]."'");
			
			$a .= $dcat[$dc].$sep;
			$dealcat1 .= $dealcat->name.$sep;
			
			
		}
	}
	
	$coupon_code 	= "";
	$_SESSION['deal_category'] = $a;
	$totdiff = $_SESSION['current_price'] - $_SESSION['our_price'];
				$percent = $totdiff * 100;
				$percentsave = $percent/$_SESSION['current_price'];
	if($coupon_type == '1')
	{
		$_SESSION['coupon_link'] = $_REQUEST['coupon_link'];
		
	}
	if($_REQUEST['coupon_entry'] == "coupon_entry_0")
	{
		$_SESSION['coupon_code'] = $_REQUEST['single_coupon_code'];
	}
	elseif($_REQUEST['coupon_entry'] == "coupon_entry_1")
	{
		 $_SESSION['coupon_code'] = $_REQUEST['coupon_code'];
	}
	$_SESSION['coupon_code'] = $_POST['coupon_code'];
	$_SESSION['coupon_start_date_time']=strtotime($_POST["coupon_start_date"]." ".$_POST["coupon_start_time_hh"].":".$_POST["coupon_start_time_mm"].":".$_POST["coupon_start_time_ss"]);
	

	if($_REQUEST['enddate'] == 0)
	{ 
		$_SESSION['coupon_end_date_time'] == "";
		$_SESSION['enddate'] == 0;

		
	}else{ 
		$_SESSION['coupon_end_date_time']=strtotime($_POST["coupon_end_date"]." ".$_POST["coupon_end_time_hh"].":".$_POST["coupon_end_time_mm"].":".$_POST["coupon_end_time_ss"]);
		$_SESSION['enddate'] == "";
	}
	
	if(isset($_FILES["deal_image"]["name"]) && $_FILES["deal_image"]["name"] != '' )
	{
	$filename = $_FILES["deal_image"]["name"];
	$exts = '';
	
		//function for finding an extension for an image starts here
		function findexts ($filename) 
		{ 
			return substr(strrchr($filename,'.'),1);
		}
		//function for finding an extension for an image ends here
		if(isset($filename) && $filename!='')
		{
			 $exts = findexts ($filename);
			 $iname = time().rand().".".$exts;
			 $_SESSION['file_name'] = $destination_url.$iname;
			 $target_file = $destination_path.$iname;
			 $_SESSION['deal_image'] =  $target_file; 
			 
      	}
	
		if(isset($_FILES["deal_image"]["name"]) && !file_exists($target_file))
		{
			move_uploaded_file($_FILES["deal_image"]["tmp_name"], $target_file);
		}
		
	}else{
			echo $_SESSION['deal_image'] = $_REQUEST['edit_image'];
			
	
	}
	
	if($coupon_type != " "  && $coupon_type == '2')
	{
		$media_file = $_FILES["media_file"]["name"];
		$exts1 = " ";
		function findexts_media($media_file) 
		{ 
			return substr(strrchr($media_file,'.'),1);
		}
		//function for finding an extension for an image ends here
		if(isset($media_file) && $media_file !='')
		{
			$exts1 = findexts_media($media_file);
			 
			 $iname = time().rand().".".$exts1;
			 $_SESSION['_wp_attached_file'] = $destination_url.$iname;
			 $target_mediafile = $destination_path.$iname;
			 $_SESSION['_wp_attached_file1'] =  $target_mediafile;
	
      	}
	
		if(isset($_FILES["media_file"]["name"]) && !file_exists($target_mediafile ))
		{
			move_uploaded_file($_FILES["media_file"]["tmp_name"], $target_mediafile );
		}else{
			move_uploaded_file($_FILES["media_file"]["tmp_name"], $target_mediafile );
		
		}
	}
?>
<?php

function get_date_format()
{
	global $wpdb;
	$tbl_option = $wpdb->prefix."options";
	$getDate = $wpdb->get_row("select * from  $tbl_option where option_name like 'ptthemes_date_format' ");
	if($getDate == "" )
	{
		$getDate = "yyyy - mm - dd";
	}
	else
	{
		$getDate = $getDate->option_value;
	}
	return $getDate;
}?>
		
        <div class="content content_full">
      
         
           <form id="postdeal_frm" name="postdeal_frm" action="<?php echo site_url('/?ptype=postdeal');?>" method="post" enctype="multipart/form-data">
        
			<div class="entry">
				<div class="post-meta">
					<h1><?php echo PREVIEW_DEAL;?></h1>
				</div>
			</div>
			  <div class="deal_steps step2bg">
                    	<ul>
                        	<li class="current"><?php echo BUY_STEP_1;?></li>
                            <li class="step2 current"><?php echo BUY_STEP_2;?></li>
                            <li class="step3"><?php echo BUY_STEP_3;?></li>
                        </ul>
                    </div>
 			 <?php if($_REQUEST['msg']=='success'){?>
            <p class="error"><?php _e('We have receive your Details Get back to you as soon as possible','templatic');?></p>
            <?php }?>
			
			<div class="preview_info"> 
                
					<input type="hidden" value="" name="price_select">
					<p><?php _e('This is a preview of your deal and it is not yet published. To edit any information, click "Go back and edit" button or click the "Submit" button to submit the deal. If your submitted information does not violate our terms and conditions, the administrator will publish your deal.','templatic');?></p>
					<?php
					if(isset($_REQUEST['updateid']) || $_REQUEST['updateid'] != "" || isset($_POST['update_deal']) )
					{  ?>
					<input type="submit" name="update_deal" class="b_publish" value="Update">
					<?php }else{
					?>
					<input type="submit" name="save_deal" class="b_publish" value="Submit">
					<?php } ?>
					<div>
					<a class="b_goback " href="<?php if($_SESSION['deal_id'] != "") { ?>?ptype=dealform&amp;deal=edit&amp;editdeal=<?php echo $_SESSION['deal_id']; }else{ echo "?ptype=dealform&amp;deal=edit"; }?>"><?php echo GO_BACK_EDIT;?></a>
					<a href="?ptype=dealform" class="b_cancel" onclick="return postDeal();"><?php echo CANCEL_TXT;?></a></div>
				
                		<input type="hidden" name="did" value="<?php echo $did;?>" />
              
            </div>   
                    
			
            
            <!-- BOF Listing -->
			    <div class="content_left">
					<?php if($_SESSION['file_name'] != "" || $_REQUEST['dealsession_image'] != "") { ?>
						<img src="<?php echo templ_thumbimage_filter($_SESSION['file_name'],285,275); ?>" width="285" height="275" alt="" />
					<?php }else{ ?>
						<img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="285" height="275" alt="" />
					<?php } ?>
                </div>

                 <div class="content_right">
					<span class="title_grey"><?php echo PROVIDE_BY." : ".$_SESSION['owner_name']; ?> </span>
                    
                     <h3 class="preview_title"><?php echo  $_SESSION['post_title']; ?></h3>    
						
					
					
                     <div class="deal_time_box"> <?php $tardate= date("Y m d,H:i:s",$_SESSION['coupon_end_date_time']); ?>
                            <div id="countdowncontainer1"></div>
                            <script type="text/javascript">
                            var dealexpire=new cdtime("countdowncontainer1", "<?php echo $tardate; ?>")
                            dealexpire.displaycountdown("days", formatresults)
							</script>
                    
                    <ul class="rate_summery">
                         <li class="rate_current_price"><span><?php echo CURRENT_PRICE;?></span> <strong><small><?php echo get_currency_sym();?></small><?php _e($_SESSION['current_price'],'templatic');?></strong></li>
                        <li class="rate_our_price"><span><?php echo OUR_PRICE;?></span> <strong><small><?php echo get_currency_sym();?></small><?php _e($_SESSION['our_price'],'templatic');?></strong></li>
                        <li class="rate_percentage"><span><?php echo YOU_SAVE;?></span> <strong><small></small><?php echo @number_format($percentsave,2);?>%</strong></li>
                        <li class="bdr_none rate_item_sold"><span><?php echo ITEMS_SOLD;?></span> <strong><small></small>0</strong></li>                    
                    </ul> 
					<?php if($dealcat1 != '') { ?>
					<span class="post_category"><?php echo "Category : ".$dealcat1; ?> </span>
					<?php }?>
					
					<?php _e(htmlspecialchars_decode($_SESSION['post_content']),'templatic'); ?>
					
					
							<div class="content_deal_li">
								<?php _e($totactive_obj->post_content,'templatic'); 
								if(isset($_SESSION['coupon_expired_date']) || $_SESSION['coupon_expired_date'] != "")
								{ ?>
								<strong> <?php echo DEAL_START_FROM; ?>  : </strong> <?php echo  " : ".date('F d, Y H:i:s' ,$_SESSION['coupon_start_date_time']); ?> 
								<?php
								}else{
								?>
								
								<strong><?php echo DEAL_DURATION; ?> : </strong><strong><?php echo FROM;?></strong><?php echo  " : ".date('F d, Y H:i:s' ,$_SESSION['coupon_start_date_time']); ?> <strong> <?php echo TO;?> </strong><?php echo " : ".date('F d, Y H:i:s',$_SESSION['coupon_end_date_time']); ?> 
								<?php } ?>
								<ul class="deal_li">
									<li><span class="field"><?php echo TOTAL_ITEMS;?></span><?php echo " : ".$_SESSION['no_of_coupon']; ?></li>
									<li><span class="field"><?php echo DEAL_TYPE;?></span> : <?php fetch_deal($_SESSION['coupon_type']); ?></li>
									<li><span class="field"><?php echo MIN_PURCHASE;?></span><?php echo " : ".$_SESSION['min_purchases']; ?></li>
								
									<li><span class="field"><?php echo MAX_PURCHASE;?></span><?php echo " : ".$_SESSION['max_purchases_user']; ?></li>
									<?php if($_SESSION['coupon_type'] == 3 || $_SESSION['coupon_type'] == 4) { ?>
									<li><span class="field"><?php echo DEAL_CODE_TEXT;?></span><?php echo " : ".$_SESSION['coupon_code']; ?></li>
									<?php } ?>
								</ul>						
								
							</div>
						
            
        </div>
				</div>	
                   		
       	</form>         

</div>


 
<script type="text/javascript">
function postDeal()
{
	window.locaton.href = ""<?php echo site_url('/?ptype=dealform'); ?>;
}
</script>
<?php // get_sidebar(); ?>
<?php get_footer(); ?>
