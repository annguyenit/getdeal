<?php
header('Content-Description: File Transfer');
header("Content-type: application/force-download");
header('Content-Disposition: inline; filename="report.csv"');
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
include_once(TT_MODULES_FOLDER_PATH . 'report/function_report.php');
global $wpdb,$current_user,$transection_db_table_name;
$post_table = $wpdb->prefix."posts";
$post_meta_table = $wpdb->prefix."postmeta";
$user_db_table_name1 = $wpdb->prefix . "users";
if($wpdb->get_var("SHOW TABLES LIKE \"$user_db_table_name1\"") != $user_db_table_name1)	{
	$tbl_users = $wpdb->get_var("SHOW TABLES LIKE \"%users\"");
	$user_db_table_name = $tbl_users;
} else{
	$user_db_table_name = $user_db_table_name1;
}

$authorsql_select = "select DISTINCT u.ID,u.user_nicename ";
$authorsql_from= " from $user_db_table_name u,$post_table p ";
$authorsql_conditions= " where u.ID = p.post_author and p.post_type = '".CUSTOM_POST_TYPE1."' ";
if($_REQUEST['id'] != ''){
	$authorsql_conditions .= " and p.post_author = '".$_REQUEST['id']."'";
}
$authorinfo = $wpdb->get_results($authorsql_select.$authorsql_from.$authorsql_conditions);
if($authorinfo)
{
	foreach($authorinfo as $authorObj)
	{
		echo "ID,Seller,Deal,Sale,Customer\r ";
		echo "$authorObj->ID,$authorObj->user_nicename,".deal_count_post($authorObj->ID).",".deal_salecount_post($authorObj->ID).",".deal_salecount_post($authorObj->ID)." \r\n\r\n" ;
		
		$deal_cnt = $wpdb->get_results("select ID,post_title from $post_table where post_author = '".$authorObj->ID."' and post_type='".CUSTOM_POST_TYPE1."' and post_status = 'publish'");
		if($deal_cnt){
			$cnt = 0;
			$count = count($deal_cnt);
			echo "Post ID,Title,Original Price,Discounted Price,Start Time,End Time,Status\r\n";
			foreach($deal_cnt as $postObj){
				$cnt++;
				$post_title = str_replace(',',' ',$postObj->post_title);
				$status = ifetch_status(get_post_meta($postObj->ID,'status',true),get_post_meta($postObj->ID,'is_expired',true));
				if(get_post_meta($postObj->ID,'coupon_start_date_time',true) != ''){
					$start_date = date("Y-m-d H:i:s",get_post_meta($postObj->ID,'coupon_start_date_time',true));
				} if(get_post_meta($postObj->ID,'coupon_end_date_time',true) != '') {
					$end_date = date("Y-m-d H:i:s",get_post_meta($postObj->ID,'coupon_start_date_time',true));
				}
				echo "$postObj->ID,$post_title,".get_post_meta($postObj->ID,'current_price',true).",".get_post_meta($postObj->ID,'our_price',true).",$start_date,$end_date,$status\r\n";
				if($cnt == $count ){
					echo "\r\n";
				}
			}
		}			
	}
}else
{
echo "No record available";

}?>  