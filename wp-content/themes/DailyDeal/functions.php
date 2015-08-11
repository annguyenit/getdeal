<?php
load_theme_textdomain('templatic');
//load_textdomain( 'templatic', TEMPLATEPATH.'/language/en_US.mo' );
load_textdomain( 'templatic', TEMPLATEPATH.'/language/nl_NL.mo' );

/*** Theme setup ***/
define('TT_ADMIN_FOLDER_NAME','admin');
define('TT_ADMIN_FOLDER_PATH',TEMPLATEPATH.'/'.TT_ADMIN_FOLDER_NAME.'/'); //admin folder path

if(file_exists(TT_ADMIN_FOLDER_PATH . 'constants.php')){
include_once(TT_ADMIN_FOLDER_PATH.'constants.php');  //ALL CONSTANTS FILE INTEGRATOR
}

if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'custom_filters.php')){
include_once (TT_FUNCTIONS_FOLDER_PATH . 'custom_filters.php'); // manage theme filters in the file
}

if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'widgets.php')){
include_once (TT_FUNCTIONS_FOLDER_PATH . 'widgets.php'); // theme widgets in the file
}

add_role('affiliate', 'affiliate', array(
    'read' => true, // True allows that capability
    'edit_posts' => true,
    'delete_posts' => true,
));
add_filter('wp_dropdown_users', 'theme_post_author_override');
function theme_post_author_override($output)
{ global $post;
  // return if this isn't the theme author override dropdown
  if (!preg_match('/post_author_override/', $output)) return $output;

  // return if we've already replaced the list (end recursion)
  if (preg_match ('/post_author_override_replaced/', $output)) return $output;

  // replacement call to wp_dropdown_users
	$output = wp_dropdown_users(array(
	  'echo' => 0,
		'name' => 'post_author_override_replaced',
		'selected' => empty($post->ID) ? $user_ID : $post->post_author,
		'include_selected' => true
	));

	// put the original name back
	$output = preg_replace('/post_author_override_replaced/', 'post_author_override', $output);

  return $output;
}
// Theme admin functions
include_once (TT_FUNCTIONS_FOLDER_PATH . 'custom_functions.php');

include_once(TT_ADMIN_FOLDER_PATH.'admin_main.php');  //ALL ADMIN FILE INTEGRATOR

function temp_theme_settings_load() 
{
if(isset($_REQUEST['page']) && $_REQUEST['page'] != ""){
if($_GET['page']=='paymentoptions' || $_GET['page']=='notification' || $_GET['page']=='custom' || $_GET['page']=='custom_usermeta' || $_GET['page']=='report' || $_GET['page']=='affiliates' || $_GET['page']=='manageorders'){


// enqueue styles
wp_enqueue_style( 'option-tree-style',TT_THEME_OPTIONS_FOLDER_URL.'css/option_tree_style.css', false, 1, 'screen');	
// enqueue scripts
add_thickbox();
wp_enqueue_script( 'jquery-table-dnd', TT_THEME_OPTIONS_FOLDER_URL.'js/jquery.table.dnd.js', array('jquery'), 1 );
wp_enqueue_script( 'jquery-color-picker', TT_THEME_OPTIONS_FOLDER_URL.'js/jquery.color.picker.js', array('jquery'), 1 );
wp_enqueue_script( 'jquery-option-tree', TT_THEME_OPTIONS_FOLDER_URL.'js/jquery.option.tree.js', array('jquery','media-upload','thickbox','jquery-ui-core','jquery-ui-tabs','jquery-table-dnd','jquery-color-picker'), 1 );

// remove GD star rating conflicts
wp_deregister_style( 'gdsr-jquery-ui-core' );
wp_deregister_style( 'gdsr-jquery-ui-theme' );
}
}
}
add_action( 'admin_init', 'temp_theme_settings_load'); //adction to add js and css to wp-admin head section


if(file_exists(TT_WIDGET_FOLDER_PATH . 'widgets_main.php')){
include_once (TT_WIDGET_FOLDER_PATH . 'widgets_main.php'); // Theme admin WIDGET functions
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'modules_main.php')){
include_once (TT_MODULES_FOLDER_PATH . 'modules_main.php'); // Theme moduels include file
}
if(file_exists(TT_MODULES_FOLDER_PATH . 'registration/reg_main.php.php')){
include_once(TT_MODULES_FOLDER_PATH . 'registration/reg_main.php.php');
}
 // registration, login and edit profile
if(file_exists(TT_MODULES_FOLDER_PATH . 'deal/deal_main.php')){
include_once(TT_MODULES_FOLDER_PATH . 'deal/deal_main.php');
}


if(file_exists(TT_INCLUDES_FOLDER_PATH . 'auto_install/auto_install.php')){
include_once (TT_INCLUDES_FOLDER_PATH . 'auto_install/auto_install.php'); // sample data insert file
}
if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'captcha/captcha_function.php')){
include_once (TT_FUNCTIONS_FOLDER_PATH . 'captcha/captcha_function.php'); // manage theme filters in the file
}
if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'manage_custom_fields/functions_custom_field.php')){
include_once (TT_FUNCTIONS_FOLDER_PATH . 'manage_custom_fields/functions_custom_field.php'); // manage theme filters in the file
}
require(TEMPLATEPATH."/language.php");
require(TT_FUNCTIONS_FOLDER_PATH . "general_functions.php");
require(TT_FUNCTIONS_FOLDER_PATH . "theme_ui.php");	
$General = new General();
global $General;

add_theme_support( 'post-formats', array( 'aside', 'gallery','link', 'image','quote', 'status','video', 'audio','chat') );

@ini_set( 'upload_max_size' , '164M' );
@ini_set( 'post_max_size', '164M');
@ini_set( 'max_execution_time', '300' );
?>