<?php
/////////////////DEAL EXPIRY SETTINGS CODING START/////////////////
global $table_prefix, $wpdb,$transection_db_table_name;
$table_name = $table_prefix . "deal_expire_session";
$current_date = date('Y-m-d');
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
{
   global $table_prefix, $wpdb,$table_name;
   $sql = 'DROP TABLE `' . $table_name . '`';  // drop the existing table
   mysql_query($sql);

	$sql = 'CREATE TABLE `'.$table_name.'` (
			`session_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`execute_date` DATE NOT NULL ,
			`is_run` TINYINT( 4 ) NOT NULL DEFAULT "0"
			) ENGINE = MYISAM ;';
   mysql_query($sql);
}
$today_executed = $wpdb->get_var("select session_id from $table_name where execute_date=\"$current_date\"");
if($today_executed && $today_executed>0)
{
}else
{
		$wpdb->query("delete from $transection_db_table_name where date_format(payment_date,'%Y-%m-%d')!=\"$current_date\" and status=0");
		$wpdb->query("insert into $table_name (execute_date,is_run) values (\"$current_date\",'1')");
}

/////////////////DEAL EXPIRY SETTINGS CODING END/////////////////
?>