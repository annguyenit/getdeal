<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>

<!-- /TinyMCE -->
<div id="sign_up">
  <div class="login_content"> <?php echo stripslashes(get_option('ptthemes_reg_page_content'));?> </div>
  <div class="registration_form_box">
    <h4>
      <?php 
			 if($_REQUEST['page']=='login' && $_REQUEST['page1']=='sign_up')
			{
				echo REGISTRATION_NOW_TEXT;
			}else
			{
				echo REGISTRATION_NOW_TEXT;
			}
			 ?>
    </h4>
    <?php
if ( $_REQUEST['emsg']==1)
{
	echo "<p class=\"error_msg\"> ".EMAIL_USERNAME_EXIST_MSG." </p>";
}elseif($_REQUEST['emsg']=='regnewusr')
{
	echo "<p class=\"error_msg\"> ".REGISTRATION_DESABLED_MSG." </p>";
}elseif($_REQUEST['reg'] == 1)
{
	echo "<p class=\"success_msg\"> ".REGISTRATION_SUCCESS_MSG."</p>";
}
?>
    <form name="userform" id="userform" action="<?php echo site_url().'/?ptype=login&amp;action=register'; ?>" method="post" enctype="multipart/form-data" >  
      <input type="hidden" name="reg_redirect_link" value="<?php echo $_SERVER['HTTP_REFERER'];?>" />
      <?php do_action('templ_registration_form_start');?>
		<?php
		global $form_fields_usermeta;
        $validation_info = array();
        foreach($form_fields_usermeta as $key=>$val)
        {
		if($val['on_registration']){
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
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
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
                    $str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
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
                    $fval_arr = explode(',',$fval);
                    if(in_array($option_values_arr[$i],$fval_arr)){ $seled='checked="checked"';}
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
            $label = '<label>'.$val['label'].' <span class="indicates">*</span> </label>';
        }else
        {
            $label = '<label>'.$val['label'].'</label>';
        }
        echo $val['outer_st'].$label.$val['tag_st'].$str.$val['tag_end'].$val['outer_end'];
        }
		}
		if(get_option('pttthemes_captcha')=='Enable' && file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha')  ){
			 echo '<div class="form_row clearfix">';
			$a = get_option("recaptcha_options");
			echo '<label>Word verification</label>';
			$publickey = $a['public_key']; // you got this from the signup page
			echo recaptcha_get_html($publickey); 
			 echo '</div>';
		}
	if(get_option('is_active_affiliate')){ 
	$aff_link = sprintf(BE_AFFILIATES_MEMBER,"<a href='http://localhost/wpthemes/dailydeal/?ptype=affiliate&type=reg' >Click Here</a>");
	echo "<p class='fl'>".$aff_link."</p>";
	 }

		do_action('templ_registration_form_end');?>
      <input type="submit" name="registernow" value="<?php echo REGISTER_NOW_TEXT;?>" class="b_registernow" />
    </form>
  </div>
</div>
<?php include_once(TT_REGISTRATION_FOLDER_PATH . 'registration_validation.php');?>