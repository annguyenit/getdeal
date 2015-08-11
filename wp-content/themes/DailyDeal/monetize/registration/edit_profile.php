<?php
session_start();
ob_start();

if(!$current_user->data->ID)
{
	wp_redirect(get_settings('home').'/index.php?page=login');
	exit;
}
global $wpdb;

if($_POST)
{
	if($_REQUEST['chagepw'])
	{
		$new_passwd = $_POST['new_passwd'];
		if($new_passwd)
		{
			$user_id = $current_user->data->ID;
			wp_set_password($new_passwd, $user_id);
			$message1 = PW_CHANGE_SUCCESS_MSG;
		}		
	}else
	{
		$user_id = $current_user->data->ID;
		$user_add1 = $_POST['user_add1'];
		$user_add2 = $_POST['user_add2'];
		$user_city = $_POST['user_city'];
		$user_state = $_POST['user_state'];
		$user_country = $_POST['user_country'];
		$user_postalcode = $_POST['user_postalcode'];
		$user_web = $_POST['user_web'];
		
		$user_address_info = array(
							"user_add1"		=> $user_add1,
							"user_add2"		=> $user_add2,
							"user_city"		=> $user_city,
							"user_state"	=> $user_state,
							"user_country"	=> $user_country,
							"user_postalcode"=> $user_postalcode,
							"user_phone" 	=>	$_POST['user_phone'],
							);
	
		update_usermeta($user_id, 'user_address_info', serialize($user_address_info)); // User Address Information Here
		$userName = $_POST['user_fname'].' '.$_POST['user_lname'];
		$updateUsersql = "update $wpdb->users set user_url=\"$user_web\",user_nicename=\"$userName\", display_name=\"$userName\"  where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
		$_SESSION['session_message'] = INFO_UPDATED_SUCCESS_MSG;
		wp_redirect(get_option( 'siteurl' ).'/?page=profile');
		exit;
	}
}

$user_address_info = unserialize($current_user->data->user_address_info);
$user_add1 = $user_address_info['user_add1'];
$user_add2 = $user_address_info['user_add2'];
$user_city = $user_address_info['user_city'];
$user_state = $user_address_info['user_state'];
$user_country = $user_address_info['user_country'];
$user_postalcode = $user_address_info['user_postalcode'];
$user_phone = $user_address_info['user_phone'];
$display_name = $current_user->data->display_name;
$user_web = $current_user->data->user_url;
$display_name_arr = explode(' ',$display_name);
$user_fname = $display_name_arr[0];
$user_lname = $display_name_arr[2];
?>
<?php get_header(); ?>
<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>

	
 <div class="entry">
    <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
      <div class="post-meta">
        <?php templ_page_title_above(); //page title above action hook?>
        <?php echo templ_page_title_filter(EDIT_PROFILE_TITLE); //page tilte filter?>
        <?php templ_page_title_below(); //page title below action hook?>
      </div>
      <div >
        <div class="post-content">
          <div id="sign_up">
            <?php
if ( $_REQUEST['msg']=='success')
{
	echo "<p class=\"success_msg\"> ".EDIT_PROFILE_SUCCESS_MSG." </p>";
}else
if ( $_REQUEST['emsg']=='empty_email')
{
	echo "<p class=\"error_msg\"> ".EMPTY_EMAIL_MSG." </p>";
}elseif ( $_REQUEST['emsg']=='wemail')
{
	echo "<p class=\"error_msg\"> ".ALREADY_EXIST_MSG." </p>";
}elseif ( $_REQUEST['emsg']=='pw_nomatch')
{
	echo "<p class=\"error_msg\"> ".PW_NO_MATCH_MSG." </p>";
}
?>
           
<form name="userform" id="userform" action="<?php echo site_url().'/?ptype=profile'; ?>" method="post" enctype="multipart/form-data" >  
                <?php
if($_POST)
{
	$user_email = $_POST['user_email'];	
	$user_fname = $_POST['user_fname'];	
}else
{
	$user_email = $current_user->data->user_email;	
	$user_fname = $current_user->data->display_name;
}
?>
<?php do_action('templ_profile_form_start');?>

<?php
global $form_fields_usermeta;
$validation_info = array();
foreach($form_fields_usermeta as $key=>$val)
{
	if($val['on_profile']){
	$str = ''; $fval = '';
	$field_val = $key.'_val';
	if($$field_val){$fval = $$field_val;}else{$fval = $val['default'];}
	
	if($val['is_require'])
	{
		$validation_info[] = array(
								   'name'	=> $key,
								   'espan'	=> $key.'_error',
								   'type'	=> $val['type'],
								   'text'	=> $val['label'],
								   );
	}
	if($key)
	{
		$fval = $current_user->data->$key;
	}
	if($val['type']=='text')
	{
		$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';
		}
	}elseif($val['type']=='hidden')
	{
		$str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'">';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='textarea')
	{
		$str = '<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='texteditor')
	{
		
		$str = $val['tag_before'].'<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>'.$val['tag_after'];
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='file')
	{
		$str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'">';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='include')
	{
		$str = @include_once($val['default']);
	}else
	if($val['type']=='head')
	{
		$str = '';
	}else
	if($val['type']=='date')
	{
		$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catselect')
	{
		$term = get_term( (int)$fval, CUSTOM_CATEGORY_TYPE1);
		$str = '<select name="'.$key.'" '.$val['extra'].'>';
		$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
		$all_categories = get_categories($args);
		foreach($all_categories as $key => $cat) 
		{
		
			$seled='';
			if($term->name==$cat->name){ $seled='selected="selected"';}
			$str .= '<option value="'.$cat->name.'" '.$seled.'>'.$cat->name.'</option>';	
		}
		$str .= '</select>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catdropdown')
	{
		$cat_args = array('name' => 'post_category', 'id' => 'post_category_0', 'selected' => $fval, 'class' => 'textfield', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
		$cat_args['show_option_none'] = __('Select Category','templatic');
		$str .=wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='select')
	{
		$str = '<select name="'.$key.'" '.$val['extra'].'>';
		$option_values_arr = explode(',', $val['options']);
		for($i=0;$i<count($option_values_arr);$i++)
		{
			$seled='';
			
			if($fval==$option_values_arr[$i]){ $seled='selected="selected"';}
			$str .= '<option value="'.$option_values_arr[$i].'" '.$seled.'>'.$option_values_arr[$i].'</option>';	
		}
		$str .= '</select>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catcheckbox')
	{
		$fval_arr = explode(',',$fval);
		$str .= $val['tag_before'].get_categories_checkboxes_form(CUSTOM_CATEGORY_TYPE1,$fval_arr).$oval.$val['tag_after'];
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catradio')
	{
		$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
		$all_categories = get_categories($args);
		foreach($all_categories as $key1 => $cat) 
		{
			
			
				$seled='';
				if($fval==$cat->term_id){ $seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.'> '.$cat->name.$val['tag_after'];	
			
		}
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='checkbox')
	{
		if($fval){ $seled='checked="checked"';}
		$str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.'>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='upload')
	{
		$str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" > ';
			if($fval!=''){
				$str .='<img src="'.templ_thumbimage_filter($fval,121,115).'" width="121" height="115" alt="" />
				<br />
				<input type="hidden" name="prev_upload" value="'.$fval.'" />
				';	
			}
		if($val['is_require'])
		{
			$str .='<span id="'.$key.'_error"></span>';	
		}
	}
	else
	if($val['type']=='radio')
	{
		$options = $val['options'];
		if($options)
		{
			$option_values_arr = explode(',',$options);
			for($i=0;$i<count($option_values_arr);$i++)
			{
				$seled='';
				if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
			}
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
		}
	}else
	if($val['type']=='multicheckbox')
	{
		$options = $val['options'];
		if($options)
		{  $chkcounter = 0;
			
			$option_values_arr = explode(',',$options);
			for($i=0;$i<count($option_values_arr);$i++)
			{
				$chkcounter++;
				$seled='';
				if(in_array($option_values_arr[$i],$fval)){ $seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
			}
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
		}
	}
	else
	if($val['type']=='packageradio')
	{
		$options = $val['options'];
		foreach($options as $okey=>$oval)
		{
			$seled='';
			if($fval==$okey){$seled='checked="checked"';}
			$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.'> '.$oval.$val['tag_after'];	
		}
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='geo_map')
	{
		do_action('templ_submit_form_googlemap');	
	}else
	if($val['type']=='image_uploader')
	{
		do_action('templ_submit_form_image_uploader');	
	}
	if($val['is_require'])
	{
		$label = '<label>'.$val['label'].' <span>*</span> </label>';
	}else
	{
		$label = '<label>'.$val['label'].'</label>';
	}
	echo $val['outer_st'].$label.$val['tag_st'].$str.$val['tag_end'].$val['outer_end'];
	}
}
?>
<?php do_action('templ_profile_form_end');?>
<div  class="<?php templ_content_css();?>" >

 </div>
<h5><?php _e(EDIT_PROFILE_PAGE_TITLE);?></h5>


 <form name="userform" id="userform" action="<?php echo site_url().'/?ptype=profile'; ?>" method="post" enctype="multipart/form-data" >  

  <?php 
  if($_SESSION['session_message'])
	{
		echo '<p>'.$_SESSION['session_message'].'</p>';
		$_SESSION['session_message'] = '';
	}
   ?>
 
    
      <h5><?php _e(PERSONAL_INFO_TEXT);?></h5>
       <div class="form_row clearfix">
        <label><?php _e(FIRST_NAME_TEXT) ?> <span class="indicates">*</span></label>
        <input type="text" name="user_fname" id="user_fname" class="textfield" value="<?php echo esc_attr(stripslashes($user_fname)); ?>" size="25" tabindex="20" />
        <span class="message_error2" id="user_fname_span"></span>
      </div>
        <div class="form_row clearfix">
        <label><?php _e(LAST_NAME_TEXT) ?></label>
        <input type="text" name="user_lname" id="user_lname" class="textfield" value="<?php echo esc_attr(stripslashes($user_lname)); ?>" size="25" tabindex="20" />
      </div>
       <div class="form_row clearfix">
        <label><?php _e(ADDRESS1_TEXT) ?></label>
        <input type="text" name="user_add1" id="user_add1" class="textfield" value="<?php echo esc_attr(stripslashes($user_add1)); ?>" size="25" tabindex="20" />
      </div>
        <div class="form_row clearfix">
        <label><?php _e(ADDRESS2_TEXT) ?></label>
        <input type="text" name="user_add2" id="user_add2" class="textfield" value="<?php echo esc_attr(stripslashes($user_add2)); ?>" size="25" tabindex="20" />
      </div>
        <div class="form_row clearfix">
        <label><?php _e(CITY_TEXT) ?></label>
        <input type="text" name="user_city" id="user_city" class="textfield" value="<?php echo esc_attr(stripslashes($user_city)); ?>" size="25" tabindex="20" />
      </div>
        <div class="form_row clearfix">
        <label><?php _e(STATE_TEXT) ?></label>
        <input type="text" name="user_state" id="user_state" class="textfield" value="<?php echo esc_attr(stripslashes($user_state)); ?>" size="25" tabindex="20" />
      </div>
        <div class="form_row clearfix">
        <label><?php _e(COUNTRY_TEXT) ?></label>
        <input type="text" name="user_country" id="user_country" class="textfield" value="<?php echo esc_attr(stripslashes($user_country)); ?>" size="25" tabindex="20" />
      </div>
        <div class="form_row clearfix">
        <label><?php _e(POSTAL_CODE_TEXT) ?></label>
        <input type="text" name="user_postalcode" id="user_postalcode" class="textfield" value="<?php echo esc_attr(stripslashes($user_postalcode)); ?>" size="25" tabindex="20" />
      </div>
       <div class="form_row clearfix">
        <label><?php _e(YR_WEBSITE_TEXT) ?></label>
        <input type="text" name="user_web" id="user_web" class="textfield" value="<?php echo esc_attr(stripslashes($user_web)); ?>" size="25" tabindex="20" />
      </div>
        <div class="form_row clearfix">
        <label>
        <?php _e(PHONE_NUMBER_TEXT) ?>
        </label>
        <input type="text" name="user_phone" id="user_phone" class="textfield" value="<?php echo esc_attr(stripslashes($user_phone)); ?>" size="25" tabindex="20" />
      </div>
   <input type="submit" name="Update" value="<?php _e(EDIT_PROFILE_UPDATE_BUTTON);?>" class="normal_button " onclick="return chk_edit_profile();" />
   
   <input type="button" name="Cancel" value="Cancel" class="normal_button " onclick="window.location.href='<?php echo get_option('siteurl');?>/?page=dashboard'" />
   
</form>
<script language="javascript">
function chk_edit_profile()
{
	document.getElementById('user_fname').className = 'textfield';		
	document.getElementById('user_fname_span').innerHTML = '';
	if(document.getElementById('user_fname').value == '')
	{
		//alert("<?php _e('Please enter '.FIRST_NAME_TEXT) ?>");
		document.getElementById('user_fname').className = 'textfield error';		
		document.getElementById('user_fname_span').innerHTML = '<?php _e('Please enter '. FIRST_NAME_TEXT);?>';
		document.getElementById('user_fname').focus();
		return false;
	}
	return true;
}
</script>


<h5><?php _e(CHANGE_PW_TEXT); ?></h5>
<form name="registerform" id="registerform" action="<?php echo get_option( 'siteurl' ).'/?page=profile&chagepw=1'; ?>" method="post">
<?php if($message1) { ?>
  <div class="sucess_msg"> <?php _e(PW_CHANGE_SUCCESS_MSG); ?> </div>
  </td>
  <?php } ?>

          <div class="form_row clearfix">
        <label>
        <?php _e(NEW_PW_TEXT); ?> <span class="indicates">*</span></label>   
        <input type="password" name="new_passwd" id="new_passwd"  class="textfield" />
             
        </div>
          <div class="form_row clearfix">
        <label>
        <?php _e(CONFIRM_NEW_PW_TEXT); ?> <span class="indicates">*</span></label>
        <input type="password" name="cnew_passwd" id="cnew_passwd"  class="textfield" />
        </div>
        
        
         <input type="submit" name="Update" value="<?php _e(EDIT_PROFILE_UPDATE_BUTTON) ?>" class="normal_button " onclick="return chk_form_pw();" />
         
       
     
</form>
</div>
<script language="javascript">
function chk_form_pw()
{
	if(document.getElementById('new_passwd').value == '')
	{
		alert("<?php _e('Please enter '.NEW_PW_TEXT) ?>");
		document.getElementById('new_passwd').focus();
		return false;
	}
	if(document.getElementById('new_passwd').value.length < 4 )
	{
		alert("<?php _e('Please enter '.NEW_PW_TEXT.' minimum 5 chars') ?>");
		document.getElementById('new_passwd').focus();
		return false;
	}
	if(document.getElementById('cnew_passwd').value == '')
	{
		alert("<?php _e('Please enter '.CONFIRM_NEW_PW_TEXT) ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
	if(document.getElementById('cnew_passwd').value.length < 4 )
	{
		alert("<?php _e('Please enter '.CONFIRM_NEW_PW_TEXT.' minimum 5 chars') ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
	if(document.getElementById('new_passwd').value != document.getElementById('cnew_passwd').value)
	{
		alert("<?php _e(NEW_PW_TEXT.' and '.CONFIRM_NEW_PW_TEXT.' should be same') ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
}
</script>
	

<?php get_sidebar(); ?>
<?php get_footer(); ?>