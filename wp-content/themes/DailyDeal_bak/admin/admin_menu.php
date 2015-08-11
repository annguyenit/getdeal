<?php
/////////////////////////////////////////
// ************* Theme Options Page *********** //
$admin_menu_access_level = apply_filters('templ_admin_menu_access_level_filter',8);
define('TEMPL_ACCESS_USER',$admin_menu_access_level);
add_action('admin_menu', 'templ_admin_menu'); //Add new menu block to admin side

add_action('templ_admin_menu', 'templ_add_admin_menu');
function templ_admin_menu()
{
	do_action('templ_admin_menu');	
}
function templ_add_admin_menu(){
	$menu_title = apply_filters('templ_admin_menu_title_filter',__('Theme Settings','templatic'));
	if(function_exists(add_object_page))
    {
       add_object_page("Admin Menu",  $menu_title, TEMPL_ACCESS_USER, 'templatic_wp_admin_menu', 'design', TT_ADMIN_FOLDER_URL.'images/favicon.ico'); // title of new sidebar
    }
    else
    {
       add_menu_page("Admin Menu",  $menu_title, TEMPL_ACCESS_USER, 'templatic_wp_admin_menu', 'design', TT_ADMIN_FOLDER_URL.'images/favicon.ico'); // title of new sidebar
    }	
}
?>