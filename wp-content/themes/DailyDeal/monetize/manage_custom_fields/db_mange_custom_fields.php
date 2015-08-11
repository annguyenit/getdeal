<?php
global $wpdb,$table_prefix;
$custom_post_meta_db_table_name = $table_prefix . "templatic_custom_post_fields";
//$wpdb->query('drop table `'.$custom_post_meta_db_table_name.'`');
if($wpdb->get_var("SHOW TABLES LIKE \"$custom_post_meta_db_table_name\"") != $custom_post_meta_db_table_name)
{
$wpdb->query('CREATE TABLE IF NOT EXISTS `'.$custom_post_meta_db_table_name.'` (
	  `cid` int(11) NOT NULL AUTO_INCREMENT,
	  `post_type` varchar(255) NOT NULL,
	  `admin_title` varchar(255) NOT NULL,
	  `htmlvar_name` varchar(255) NOT NULL,
	  `admin_desc` text NOT NULL,
	  `site_title` varchar(255) NOT NULL,
	  `ctype` varchar(255) NOT NULL COMMENT "text,checkbox,date,radio,select,textarea,upload",
	  `default_value` text NOT NULL,
	  `option_values` text NOT NULL,
	  `clabels` text NOT NULL,
	  `sort_order` int(11) NOT NULL,
	  `is_active` tinyint(4) NOT NULL DEFAULT "1",
	  `is_delete` tinyint(4) NOT NULL DEFAULT "0",
	  `is_require` tinyint(4) NOT NULL DEFAULT "0",
	  `show_on_listing` tinyint(4) NOT NULL DEFAULT "1",
	  `show_on_detail` tinyint(4) NOT NULL DEFAULT "1",
	  `extrafield1` text NOT NULL,
	  `extrafield2` text NOT NULL,
	  PRIMARY KEY (`cid`)
	)');
}

$cname = $wpdb->get_var("select * from ".$custom_post_meta_db_table_name." where `htmlvar_name` LIKE '%voucher_text%'");
if($cname =="")
{ 
	$wpdb->query('INSERT INTO '.$custom_post_meta_db_table_name.' (`cid`, `post_type`, `admin_title`, `htmlvar_name`, `admin_desc`, `site_title`, `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`, `is_delete`, `is_require`, `show_on_listing`, `show_on_detail`, `extrafield1`, `extrafield2`) VALUES (NULL, "seller", "Voucher ", "voucher_text", "", "Voucher", "text", "", "", "Voucher Text", "", "1", "0", "0", "1", "1", "", "")');
}

/////////admin menu settings start////////////////
add_action('templ_admin_menu', 'post_custom_fields_add_admin_menu');
function post_custom_fields_add_admin_menu()
{
	add_submenu_page('templatic_wp_admin_menu', __("Manage Custom Fields",'templatic'), __("Post Custom Fields",'templatic'), TEMPL_ACCESS_USER, 'custom', 'manage_custom');
}

function manage_custom()
{
	global $wpdb,$custom_post_meta_db_table_name;
	if($_REQUEST['act']=='addedit')
	{
		apply_filters( 'templatic_custom_fields', include_once(TT_MODULES_FOLDER_PATH . 'manage_custom_fields/admin_manage_custom_fields_edit.php') )	;
	}else
	{
		apply_filters( 'templatic_custom_fields', include_once(TT_MODULES_FOLDER_PATH . 'manage_custom_fields/admin_manage_custom_fields_list.php') )	;
	}
}
/////////admin menu settings end////////////////
include_once (TT_MODULES_FOLDER_PATH . 'manage_custom_fields/functions_custom_field.php');
include_once(TT_MODULES_FOLDER_PATH.'manage_custom_fields/manage_post_custom_fields.php');
?>