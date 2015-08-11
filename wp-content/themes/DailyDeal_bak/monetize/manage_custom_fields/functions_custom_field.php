<?php
function get_post_custom_fields_templ($post_types)
{
	global $wpdb,$custom_post_meta_db_table_name;
	$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where is_active=1 and post_type='$post_types' order by sort_order asc,admin_title asc");
	$return_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){	
			if($post_meta_info_obj->ctype){
				$options = explode(',',$post_meta_info_obj->option_values);
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values" => $post_meta_info_obj->option_values,
					"site_title"  => $post_meta_info_obj->site_title,
					"is_require"  => $post_meta_info_obj->is_require,
					"show_on_listing"  => $post_meta_info_obj->show_on_listing,
					"show_on_detail"  => $post_meta_info_obj->show_on_detail,
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
//$custom_metaboxes = get_post_custom_fields_templ();


function get_post_custom_listing_single_page($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_post_meta_db_table_name;
	 $sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " and ctype!='upload' order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
			}
			if($post_meta_info_obj->ctype=='upload'){
			//$image_var = get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true);
			$image_var = "<img src='".templ_thumbimage_filter(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true),100,100)."'/>";
			$replace_arr = array($post_meta_info_obj->site_title,$image_var);
			
			}
			
			$replace_arr = array($post_meta_info_obj->site_title,get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));
			if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))
			{
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}
		}	
	}
	
	return $return_str;
}

function get_post_custom_for_listing_page($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_post_meta_db_table_name;
	$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_listing=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
			}
			if($post_meta_info_obj->ctype!='upload'){
			//$image_var = get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true);
			$image_var = "<img src='".templ_thumbimage_filter(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true),100,100)."'/>";
			$replace_arr = array($post_meta_info_obj->site_title,$image_var);
			
			
			$replace_arr = array($post_meta_info_obj->site_title,get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));
			if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))
			{
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}
			}
		}	
	}
	return $return_str;
}
?>