<?php
function templ_get_usermeta($types='registration')
{
	global $wpdb,$custom_usermeta_db_table_name;
	$user_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where is_active=1 and post_type=\"$types\" order by sort_order asc,admin_title asc");
	$return_arr = array();
	if($user_meta_info){
		foreach($user_meta_info as $post_meta_info_obj){	
			if($post_meta_info_obj->ctype){
				$options = explode(',',$post_meta_info_obj->option_values);
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"site_title" 	=> $post_meta_info_obj->site_title,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values" => $post_meta_info_obj->option_values,
					"is_require"  => $post_meta_info_obj->is_require,
					"on_registration"  => $post_meta_info_obj->show_on_listing,
					"on_profile"  => $post_meta_info_obj->show_on_detail,
					"extrafield1"  => $post_meta_info_obj->extrafield1,
					"extrafield2"  => $post_meta_info_obj->extrafield2,
					);
			if($options)
			{
				$custom_fields["options"]=$options;
			}
			$return_arr[$post_meta_info_obj->htmlvar_name] = $custom_fields;
		}
	}
	return $return_arr;
}
function get_custom_usermeta_single_page($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_usermeta_db_table_name;
	$sql = "select * from $custom_usermeta_db_table_name where is_active=1 and show_on_detail=1 ";
	 
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " and ctype!='upload' and ctype!='texteditor' order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $user_meta_info_obj){
			
			if($user_meta_info_obj->site_title)
			{
				$replace_arr[] = $user_meta_info_obj->site_title;	
			}
			if($user_meta_info_obj->ctype=='upload'){
			//$image_var = get_usermeta($pid,$user_meta_info_obj->htmlvar_name,true);
			$image_var = "<img src='".templ_thumbimage_filter(get_usermeta($pid,$user_meta_info_obj->htmlvar_name,true),100,100)."'/>";
			$replace_arr = array($user_meta_info_obj->site_title,$image_var);
			
			}
			if($user_meta_info_obj->ctype=='multicheckbox'){
					$val_category = get_usermeta($pid,$user_meta_info_obj->htmlvar_name,true);
					if(is_array($val_category)){
						$val_category_value = implode(",",$val_category);
					}else{
						$val_category_value = $val_category;
					}
				
				$replace_arr = array($user_meta_info_obj->site_title,$val_category_value);
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}else{
			
				$replace_arr = array($user_meta_info_obj->site_title,get_usermeta($pid,$user_meta_info_obj->htmlvar_name,true));
				if(get_usermeta($pid,$user_meta_info_obj->htmlvar_name,true))
				{
					
					$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
				}
			}
		}	
	}
	
	return $return_str;
}
?>