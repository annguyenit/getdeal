<?php
if($_POST)
{
	ob_start();
	if(!$current_user->ID) {
		wp_redirect(get_settings('home').'/index.php?page=login');
		exit;
	}
	$user_id = $current_user->ID;
	$user_email = $_POST['user_email'];
	$userName = $_POST['user_fname'];
	$user_website = $_POST['user_website'];
	$pwd = $_POST['pwd'];
	$cpwd = $_POST['cpwd'];
	if(isset($_REQUEST['Update']))	{
		if($user_email)	{
			$check_users=$wpdb->get_var("select ID from $wpdb->users where user_email like \"$user_email\" where ID!=\"$user_id\"");
			if($check_users){
				wp_redirect(site_url().'/?ptype=profile&emsg=wemail');exit;	
			}
		}else {
			wp_redirect(site_url().'/?ptype=profile&emsg=empty_email');exit;
		} if($pwd!=$cpwd)	{
			wp_redirect(site_url().'/?ptype=profile&emsg=pw_nomatch');exit;
		}
	}
	if($userName){
		if($pwd)
		{
			$pwd = md5($pwd);
			$subsql = " , user_pass=\"$pwd\"";	
		}
		$updateUsersql = "update $wpdb->users set user_email=\"$user_email\", display_name=\"$userName\" $subsql  where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
		
		global $upload_folder_path;
		global $form_fields_usermeta;
		$custom_metaboxes = templ_get_usermeta();

		foreach($form_fields_usermeta as $fkey=>$fval)
		{
			$fldkey = "$fkey";
			$$fldkey = $_POST["$fkey"];
			if($fval['type']=='upload')
			{	
				if($_FILES[$fkey]['name'] && $_FILES[$fkey]['size']>0) {
					$dirinfo = wp_upload_dir();
					$path = $dirinfo['path'];
					$url = $dirinfo['url'];
					$destination_path = $path."/";
					$destination_url = $url."/";
					
					$src = $_FILES[$fkey]['tmp_name'];
					$file_ame = date('Ymdhis')."_".$_FILES[$fkey]['name'];
					$target_file = $destination_path.$file_ame;
					if(move_uploaded_file($_FILES[$fkey]["tmp_name"],$target_file))
					{
						$image_path = $destination_url.$file_ame;
					}else
					{
						$image_path = '';	
					}					
					$_POST[$fkey] = $image_path;
					$fldkey = $image_path;			
				}
				else{
					$_POST[$fkey]=$_POST['prev_upload'];
				}
			}		
			update_usermeta($user_id, $fkey, $$fldkey); // User Custom Metadata Here
		}
	}
	
	if(isset($_REQUEST['update_profile']))
	{
	
	global $upload_folder_path;
	
		$custom_metaboxes = templ_get_usermeta();
		
		foreach($custom_metaboxes as $fkey=>$fval)
		{
			$fldkey = "$fkey";
			$$fldkey = $_POST["$fkey"];
			if($fval['type']=='upload')
			{
				
				if($_FILES[$fkey]['name'] && $_FILES[$fkey]['size']>0) {
					$dirinfo = wp_upload_dir();
					$path = $dirinfo['path'];
					$url = $dirinfo['url'];
					$destination_path = $path."/";
					$destination_url = $url."/";
					
					$src = $_FILES[$fkey]['tmp_name'];
					$file_ame = date('Ymdhis')."_".$_FILES[$fkey]['name'];
					$target_file = $destination_path.$file_ame;
					if(move_uploaded_file($_FILES[$fkey]["tmp_name"],$target_file))
					{
						$image_path = $destination_url.$file_ame;
					}else
					{
						$image_path = '';	
					}				
					$_POST[$fkey] = $image_path;
					$fldkey = $image_path;
					
				}
				else{
					$_POST[$fkey]=$_POST['prev_upload'];
				}
			}
			update_usermeta($user_id, $fkey, $$fldkey);
			 // User Custom Metadata Here
		}
			
		$user_id = $current_user->ID;
		$user_facebook = $_REQUEST['user_facebook'];
		$user_twitter = $_REQUEST['user_twitter'];
		$description = $_REQUEST['description'];

		update_usermeta($user_id, 'user_facebook', $user_facebook);
		update_usermeta($user_id, 'user_twitter',$user_twitter);		
		update_usermeta($user_id, 'description', trim($description));	
			// User Address Information Here
		$user_website = $_POST['user_website'];
		$userName = $_POST['user_fname'].' '.$_POST['user_lname'];
		$updateUsersql = "update $wpdb->users set user_url=\"$user_website\" where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
		$_SESSION['session_message'] = INFO_UPDATED_SUCCESS_MSG;
	}	
}

$page_title = EDIT_PROFILE_TITLE;
global $page_title;
get_header(); ?>

<?php if ( get_option('ptthemes_breadcrumbs' )) {  ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><a href="<?php echo site_url(); ?>"><?php _e('Home','templatic'); ?></a> &raquo; <?php echo EDIT_PROFILE_TITLE; ?> </div>
    </div>
<?php } ?>
<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		editor_selector : "mce",
		mode : "textareas",
		theme : "advanced",
		plugins :"advimage,advlink,emotions,iespell,",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,link,unlink,image",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<div  class="content content_full editprofile_page" >
<!--  CONTENT AREA START -->
  <div class="entry">
    <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
      <div class="post-meta">
        <?php //templ_page_title_above(); //page title above action hook?>
        <?php echo templ_page_title_filter(EDIT_PROFILE_TITLE); //page tilte filter?>
        <?php //templ_page_title_below(); //page title below action hook?>
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
<div class="registration_form_box">
  <?php 
  if($_SESSION['session_message'])
	{
		echo '<p class="success_msg">'.$_SESSION['session_message'].'</p>';
		$_SESSION['session_message'] = '';
	}
   ?>
 
  <form name="personal_info" id="personal_info" action="<?php echo site_url().'/?ptype=profile'; ?>" method="post" enctype="multipart/form-data" >  
 
<?php do_action('templ_profile_form_end');?>  
      <h5><?php _e(PERSONAL_INFO_TEXT);?></h5>
	  <?php
	 do_action('templ_profile_form_start');?>

<?php
global $form_fields_usermeta1;
$validation_info1 = array();

?>
       <div class="form_row clearfix">
        <label><?php _e(FACEBOOK_TEXT) ?></label>
        <input type="text" name="user_facebook" id="user_facebook" class="textfield" value="<?php echo get_user_meta($current_user->ID,'user_facebook',true); ?>" size="25" tabindex="20" />
        <span class="message_error2" id="user_fname_span"></span>
      </div>
        <div class="form_row clearfix">
        <label><?php _e(TWITTER_TEXT) ?></label>
        <input type="text" name="user_twitter" id="user_twitter" class="textfield" value="<?php echo get_user_meta($current_user->ID,'user_twitter',true); ?>" size="25" tabindex="20" />
      </div>
       <div class="form_row clearfix">
        <label><?php _e(YR_WEBSITE_TEXT) ?></label>
        <input type="text" name="user_website" id="user_website" class="textfield" value="<?php echo $current_user->user_url; ?>" size="25" tabindex="20" />
      </div>
        <div class="form_row clearfix">
        <label><?php _e(ABOUT_TEXT) ?></label>	
       	<textarea name="description" id="description" class="textfield" cols="30" rows="7"><?php echo trim(get_user_meta($current_user->ID,'description',true)); ?></textarea>
		<small><?php _e(ABOUT_U_TEXT) ?></small><span id="descInfo" class="error"></span>
		</div>
      
   <input type="submit" name="update_profile" value="<?php _e(EDIT_PROFILE_UPDATE_BUTTON);?>" class="b_registernow"  />
   
   <input type="button" name="Cancel" value="Cancel" class="button_cancel" onclick="window.location.href='<?php echo get_author_posts_url($current_user->ID);?>'"/>
   
</form>

 
<form name="userform" id="userform" action="<?php echo site_url().'/?ptype=profile'; ?>" method="post" enctype="multipart/form-data" >  
	
     <h5><?php _e(EDIT_PROFILE_PAGE_TITLE);?></h5>

                <?php
if($_POST)
{
	$user_email = $_POST['user_email'];	
	$user_fname = $_POST['user_fname'];	
}else
{
	$user_email = $current_user->user_email;	
	$user_fname = $current_user->display_name;
}
?>
<?php do_action('templ_profile_form_start');?>

<?php
global $form_fields_usermeta;
$validation_info = array();

$custom_metaboxes = templ_get_usermeta();

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
		$fval = get_user_meta($current_user->ID,$key,true);
	}
	if($val['type']=='text')
	{ 
		if($key == 'user_email'){
			$fval = $current_user->user_email;
		}
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
		$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.get_user_meta($current_user->ID,$key,true).'">';	
		$str .= '<img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.userform.'.$key.',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" class="calendar_img" />';
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
				$str .='<img src="'.templ_thumbimage_filter($fval,'&amp;w=121&amp;h=115&amp;zc=1&amp;q=80').'" width="121" height="115" alt="" />
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
  <div class="form_row clearfix">
    <label> <?php echo PASSWORD_TEXT; ?> <span>*</span></label>
    <input type="password" name="pwd" id="pwd" class="textfield" value="" size="25"  />
    <span id="pwdInfo"></span>
  </div>
  <div class="form_row clearfix">
    <label> <?php echo CONFIRM_PASSWORD_TEXT ?> <span>*</span></label>
    <input type="password" name="cpwd" id="cpwd" class="textfield" value="" size="25"  />
    <span id="cpwdInfo"></span> 
  </div>
  
  
    <input type="submit" name="update" value="<?php echo EDIT_PROFILE_UPDATE_BUTTON;?>" class="b_registernow" />
  
     <input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON; ?>" class="button_cancel" onclick="window.location.href='<?php echo get_author_posts_url($current_user->ID);?>'"/>
  
  </form>
  

            </div>
          </div>
        </div>
        <!-- post content #end -->
      </div>
    </div>
  </div>
  </div>
<?php include_once(TT_REGISTRATION_FOLDER_PATH . 'registration_validation.php');?>
<?php  // get_sidebar(); ?>
<?php get_footer(); ?>