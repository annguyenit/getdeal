<?php
header('Content-Description: File Transfer');
header("Content-type: application/force-download");
header('Content-Disposition: inline; filename="transaction.csv"');
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
global $wpdb,$current_user,$transection_db_table_name,$qry_string;
echo "Title,Deal Coupon,Pay Date,Billing name,Billing address,Shipping name,Shipping address,Pay Method,Amount\r\n";
$transinfo = $wpdb->get_results($_SESSION['qry_string']);
$totamt=0;
if($transinfo)
{
	foreach($transinfo as $priceinfoObj)
	{
		$totamt = $totamt + $priceinfoObj->payable_amt;
		$post_title = str_replace(',',' ',$priceinfoObj->post_title);
		$billing_add = str_replace(array(',','<br />'),' ',$priceinfoObj->billing_add);
		$shipping_add = str_replace(array(',','<br />'),' ',$priceinfoObj->shipping_add);
		echo "$post_title,$priceinfoObj->deal_coupon,".date('d/m/Y',strtotime($priceinfoObj->payment_date)).",$priceinfoObj->billing_name,$billing_add,$priceinfoObj->shipping_name,$shipping_add,$priceinfoObj->payment_method,".get_currency_sym().number_format($priceinfoObj->payable_amt,2)." \r";
 }
echo " , , , , , , ,Total Amount :, ".get_currency_sym()." $totamt \r\n";

}else
{
echo "No record available";

}?>  