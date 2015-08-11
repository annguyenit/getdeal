<?php
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	require($file . "/wp-load.php");
	
$dealid = $_REQUEST['delete_id'];
global $wpdb;
do_action($dealid);
global $current_user;
$deal_data = get_post($dealid);
if($deal_data->post_author == $current_user->ID){
wp_delete_post($dealid);
echo "<div class='submitedsuccess'>".DEAL_DELETED."</div>";
}else{
echo "<div class='error' style='color:red'>You are not authorized to delete this deal</div>";
}

?>