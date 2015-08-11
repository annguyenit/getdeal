<?php
if(file_exists(TT_MODULES_FOLDER_PATH . 'custom_post_type/custom_post_type_lang.php'))
{
	include_once(TT_MODULES_FOLDER_PATH.'custom_post_type/custom_post_type_lang.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'custom_post_type/custom_post_type.php'))
{
	include_once(TT_MODULES_FOLDER_PATH.'custom_post_type/custom_post_type.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'coupon/function_coupon.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'coupon/function_coupon.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'paymethods/paymethods_functons.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'paymethods/paymethods_functons.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'package/db_package.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'package/db_package.php');
}

if(is_wp_admin() && file_exists(TT_MODULES_FOLDER_PATH . 'notifications/notification_functions.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'notifications/notification_functions.php');
}

/********** Affiliates module *************/
if(is_wp_admin() && file_exists(TT_MODULES_FOLDER_PATH . 'affiliates/affiliates_function.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'affiliates/affiliates_function.php');
}
/********** Affiliates module *************/

if(file_exists(TT_MODULES_FOLDER_PATH . 'manage_city/city_functions.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'manage_city/city_functions.php');
}

if(is_wp_admin() && file_exists(TT_MODULES_FOLDER_PATH . 'bulk_upload/bulk_upload_function.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'bulk_upload/bulk_upload_function.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'manage_custom_fields/db_mange_custom_fields.php'))
{
	include_once(TT_MODULES_FOLDER_PATH . 'manage_custom_fields/db_mange_custom_fields.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'registration/registration_functions.php'))
{
	include_once(TT_MODULES_FOLDER_PATH . 'registration/registration_functions.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'add_post/add_main.php'))
{
	include_once(TT_MODULES_FOLDER_PATH . 'add_post/add_main.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'report/function_report.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'report/function_report.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'general_function.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'general_function.php');
}
?>