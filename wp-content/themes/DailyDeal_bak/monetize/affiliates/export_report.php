<?php
global $Cart,$General,$wpdb,$prd_db_table_name,$ord_db_table_name;
?>
<?php if($_REQUEST['user_id'])
{
	include_once(TEMPLATEPATH . '/monetize/affiliates/export_report_user.php');
}else
{
	include_once(TEMPLATEPATH . '/monetize/affiliates/export_report_month.php');	
}?>
<?php
echo $exportstr .= '</table>';
header('Content-Description: File Transfer');
header("Content-type: application/force-download");
header('Content-Disposition: inline; filename="report.xls"');
//readfile($exportstr);
?>