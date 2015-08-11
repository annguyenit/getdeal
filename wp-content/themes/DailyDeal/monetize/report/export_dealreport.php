<?php
header('Content-Description: File Transfer');
header("Content-type: application/force-download");
header('Content-Disposition: inline; filename="dealreport.csv"');
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
include_once(TT_MODULES_FOLDER_PATH . 'report/function_report.php');
global $wpdb,$current_user,$transection_db_table_name;
$trans_table = $wpdb->prefix."deal_transaction";
$post_table = $wpdb->prefix."posts";
$ordersql_select = "select t.*,p.ID ";
$ordersql_from= " from $trans_table t,$post_table p ";
$ordersql_conditions= " where p.ID = t.post_id and t.status = '1'";

if($_REQUEST['deal_id'] != '')
{
	$id = $_REQUEST['deal_id'];
	$ordersql_conditions .= " and t.post_id = $id";
}
$ordersql_conditions .= " group by p.ID";
$priceinfo_count = $wpdb->get_results($ordersql_select.$ordersql_from.$ordersql_conditions);

if($priceinfo_count > 0)
{
	foreach($priceinfo_count as $priceinfoObj)
	{
		$post_title = str_replace(',',' ',$priceinfoObj->post_title);
		echo "ID,Title,Total Transaction,Status\r ";
		echo "$priceinfoObj->ID,$post_title,".deal_transaction($priceinfoObj->ID).",".$status = ifetch_status(get_post_meta($post->ID,'status',true),get_post_meta($post->ID,'is_expired',true))." \r\n \r\n" ;
		
		$deal_cnt = $wpdb->get_results("select * from $trans_table where post_id = '".$priceinfoObj->ID."' and status = '1'");
		if(count($deal_cnt) > 0 ){
			echo "Title,Deal Coupon,Pay Date,Billing name,Billing address,Shipping name, Shipping address,Pay Method,Amount\r\n";
			$trans_table = $wpdb->prefix."deal_transaction";
				
				foreach($deal_cnt as $postObj){
				$sub_post_title = str_replace(',',' ',$postObj->post_title);	
				$billing_add = str_replace(array(',','<br />'),' ',$postObj->billing_add);
				$shipping_add = str_replace(array(',','<br />'),' ',$postObj->shipping_add);
				echo "$sub_post_title,$postObj->deal_coupon,".date('d/m/Y',strtotime($postObj->payment_date)).",$postObj->billing_name,$billing_add,$postObj->shipping_name,$shipping_add,$postObj->payment_method,".get_currency_sym().number_format($postObj->payable_amt,2)." \r";
			}
		}			
	echo "\r\n";
	}
}else
{
echo "No record available";

}?>  