<?php
define('TEMPL_AFFILIATE_MODULE', __("Manage Affiliate",'templatic'));
define('TT_AFFILIATE_FOLDER','affiliates');
define('TT_AFFILIATE_MODULES_PATH',TT_MODULES_FOLDER_PATH . TT_AFFILIATE_FOLDER.'/');

define ("PLUGIN_DIR_REPORT", basename(dirname(__FILE__)));
define ("PLUGIN_STYLEURL_REPORT", get_template_directory_uri().'/monetize/');


global $wpdb,$table_prefix;
$transection_db_table_name = $table_prefix . "deal_transaction2";

/////////admin menu settings start////////////////
add_action('templ_admin_menu', 'affiliates_add_admin_menu');
function affiliates_add_admin_menu()
{
	add_submenu_page('templatic_wp_admin_menu', TEMPL_AFFILIATE_MODULE, TEMPL_AFFILIATE_MODULE, TEMPL_ACCESS_USER, 'affiliates', 'affiliates');
}

function affiliates()
{
	include_once(TT_AFFILIATE_MODULES_PATH . 'affiliates_settings.php');
}

/////////admin menu settings end////////////////
?>