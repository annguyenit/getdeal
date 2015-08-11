<?php
define ("PLUGIN_DIR_REPORT", basename(dirname(__FILE__)));
define ("PLUGIN_URL_REPORT", get_template_directory_uri().'/monetize/'.PLUGIN_DIR_REPORT.'/');
define ("PLUGIN_STYLEURL_REPORT", get_template_directory_uri().'/monetize/');
global $wpdb,$table_prefix;
$transection_db_table_name = $table_prefix . "deal_transaction";
add_action('templ_admin_menu', 'report_add_admin_menu');
function report_add_admin_menu()
{
	add_submenu_page('templatic_wp_admin_menu', __("Manage Report",'templatic'), __("Report",'templatic'), TEMPL_ACCESS_USER, 'report', 'manage_report');
}
function manage_report()
{
	include_once(TT_MODULES_FOLDER_PATH . 'report/manage_report_list.php');
}
/////////admin menu settings end////////////////admin_deal_list
function saller_cmb($saller_id=''){
	$saller_display = '';
	global $wpdb;
	$post_table = $wpdb->prefix."posts";
	$post_meta_table = $wpdb->prefix."postmeta";
	$user_db_table_name1 = $wpdb->prefix . "users";
	if($wpdb->get_var("SHOW TABLES LIKE \"$user_db_table_name1\"") != $user_db_table_name1)
		{
			
			$tbl_users = $wpdb->get_var("SHOW TABLES LIKE \"%users\"");
			$user_db_table_name = $tbl_users;
		}else{
			
			$user_db_table_name = $user_db_table_name1;
		}

	$saller_sql = mysql_query("select DISTINCT u.ID, u.user_nicename from $user_db_table_name u,$post_table p where u.ID = p.post_author and p.post_type = 'seller' ");
	while($saller_res = mysql_fetch_array($saller_sql)){
		$saller_display .= '<option value="'.$saller_res['ID'].'">'.$saller_res['user_nicename'].'</option>';	
	}
	return $saller_display;
}
function deal_count_post($author_id){
	global $wpdb;
	$post_table = $wpdb->prefix."posts";
	$deal_cnt = mysql_query("select count(ID) as cnt from $post_table where post_author = '".$author_id."' and post_type='seller' and post_status = 'publish'");
	$deal_cnt_res = mysql_fetch_array($deal_cnt);
	return $deal_cnt_res['cnt'];
}
function deal_salecount_post($author_id){
	global $wpdb;
	$trans_table = $wpdb->prefix."deal_transaction";
	$res_sql = mysql_query("select count(trans_id) as cnt from $trans_table where user_id = '".$author_id."' and status = '1'");
	if(mysql_num_rows($res_sql) > 0) {
		$trans_res = mysql_fetch_array($res_sql);
		return $trans_res['cnt'];
	} 
}
function deal_list_perauthor($author_id){
	global $wpdb;
	$post_table = $wpdb->prefix."posts";
	$display_deal = '';
	$deal_cnt = mysql_query("select ID,post_title from $post_table where post_author = '".$author_id."' and post_type='seller' and post_status = 'publish'");
	if(mysql_num_rows($deal_cnt) > 0){
		echo '<table style="background-color:#f5f5f5;" width="100%">
				<tr>
					<th width="20">ID</th>
					<th>Title</th>
					<th>Original Price</th>
					<th>Discounted Price</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Status</th>
				</tr> ';
		while($deal_cnt_res = mysql_fetch_array($deal_cnt)){
		$status = ifetch_status(get_post_meta($deal_cnt_res['ID'],'status',true),get_post_meta($deal_cnt_res['ID'],'is_expired',true));
		if($status == 'Pending'){
				$status_dis = "<span class='color_pending'>Pending</span>";
			} else if($status == 'Expired') {
				$status_dis = "<span class='color_expire'>Expired</span>";
			} else if($status == 'Accepted') {
				$status_dis = "<span class='color_active'>Accepted</span>";
			} else if($status == 'Active') {
				$status_dis = "<span class='color_active'>Active</span>";
			}else if($status == 'Rejected') {
				$status_dis = "<span class='color_reject'><strong>Rejected</strong></span>";
			} else {
				$status_dis = "<span class='color_terminate'><strong>Terminated</strong></span>";
			}
		if(get_post_meta($deal_cnt_res['ID'],'coupon_start_date_time',true) != ''){
			$start_date = date("F d, Y H:i:s",get_post_meta($deal_cnt_res['ID'],'coupon_start_date_time',true));
		} if(get_post_meta($deal_cnt_res['ID'],'coupon_end_date_time',true) != '') {
			$end_date = date("F d, Y H:i:s",get_post_meta($deal_cnt_res['ID'],'coupon_start_date_time',true));
		}
		
		if(is_deal_in_trans($deal_cnt_res['ID'])){
			$post_title = '<a href="'.site_url().'/wp-admin/admin.php?page=report&deal_id='.$deal_cnt_res['ID'].'#option_deal_report">'.$deal_cnt_res['post_title'].'</a>';
		} else {
			$post_title =  $deal_cnt_res['post_title'];
		}
		echo '<tr>
					<td>'.$deal_cnt_res['ID'].'</td>
					<td>'.is_deal_in_trans($deal_cnt_res['ID']).$post_title.'</td>
					<td>'.get_post_meta($deal_cnt_res['ID'],'current_price',true).'</td>
					<td>'.get_post_meta($deal_cnt_res['ID'],'our_price',true).'</td>
					<td>'.$start_date.'</td>
					<td>'.$end_date.'</td>
					<td>'.$status_dis.'</td>
				</tr>';
				
		}
echo '</table>';		
	} 

}
function ifetch_status($sid,$isexpired)
{
	if($sid == '0')	{
		$st = 'Pending';
	}elseif($sid == '1'){
		if($isexpired == '1') {
			$st = 'Expired';
		}else {
			$st = 'Accepted';
		}
	}
	elseif($sid == '2')		{
			$st = 'Active';
		}elseif($sid == '3')
		{
			$st = 'Rejected';
		}elseif($sid == '4')
		{
			$st = 'Terminated';
		}
	return $st;
}
add_action('templatic_function','ifetch_status');
function upcoming_transaction_add_dashboard_widgets() {
	global $current_user;
	if(is_super_admin($current_user->ID)) {
	wp_add_dashboard_widget('templatic_upcoming_transaction', 'Recent Deal', 'upcoming_transaction_dashboard_widget');

	global $wp_meta_boxes;

	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

	$example_widget_backup = array('templatic_upcoming_appointments' => $normal_dashboard['templatic_upcoming_transaction']);
	unset($normal_dashboard['templatic_upcoming_transaction']);

	$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);

	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
}
add_action('wp_dashboard_setup', 'upcoming_transaction_add_dashboard_widgets' );
function upcoming_transaction_dashboard_widget() {
	$args = array('meta_key' =>'is_expired' ,'meta_value' =>'0','post_status' => 'publish','post_type' => 'seller','orderby' => 'DESC');
	$live_posts = get_posts( $args );

	if($live_posts){
		echo '<link href="'.get_template_directory_uri().'/monetize/admin.css" rel="stylesheet" type="text/css" />';
			echo '<table class="widefat"  width="100%" >
			<thead>	
			<tr>
				<th valign="top" align="left">ID</th>
				<th valign="top" align="left">Deal Title</th>
				<th valign="top" align="left">Total Transaction</th>
				<th valign="top" align="left">Original Price</th>
				<th valign="top" align="left">Discounted Price</th>
				<th valign="top" align="left">Status</th>
			</tr>';   
		foreach($live_posts as $post) {
			if(get_post_meta($post->ID,'status',true) == '1' || get_post_meta($post->ID,'status',true) == '2'){
			$status = ifetch_status(get_post_meta($post->ID,'status',true),get_post_meta($post->ID,'is_expired',true));
			if($status == 'Pending'){
				$status_dis = "<span class='color_pending'>Pending</span>";
			} else if($status == 'Expired') {
				$status_dis = "<span class='color_expire'>Expired</span>";
			} else if($status == 'Accepted') {
				$status_dis = "<span class='color_active'>Accepted</span>";
			} else if($status == 'Active') {
				$status_dis = "<span class='color_active'>Active</span>";
			}else if($status == 'Rejected') {
				$status_dis = "<span class='color_reject'><strong>Rejected</strong></span>";
			} else {
				$status_dis = "<span class='color_terminate'><strong>Terminated</strong></span>";
			}
			echo '<tr>
				<td valign="top" align="left">'.$post->ID.'</td>
				<td valign="top" align="left"><a href="'.site_url().'/wp-admin/admin.php?page=report&deal_id='.$post->ID.'#option_deal_report">'.$post->post_title.'</a></td>
				<td valign="top" align="left">'.deal_transaction($post->ID).'</td>
				<td valign="top" align="left">'.get_currency_sym().get_post_meta($post->ID,'current_price',true).'</td>
				<td valign="top" align="left">'.get_currency_sym().get_post_meta($post->ID,'our_price',true).'</td>
				<td valign="top" align="left">'.$status_dis.'</td>';
			} 
		}
		echo '</thead>	</table>';
	}   	
}
function deal_transaction($deal_id){
	global $wpdb;
	$trans_table = $wpdb->prefix."deal_transaction";
	$res_sql = mysql_query("select count(trans_id) as cnt from $trans_table where post_id = '".$deal_id."' and status = '1'");
	$trans_res = mysql_fetch_array($res_sql);
	return $trans_res['cnt'];
}
function deal_cmb($deal_id = ''){
	$deal_display = '';
	global $wpdb;
	$args = array('meta_key' =>'is_expired' ,'meta_value' =>'0','post_status' => 'publish','post_type' => 'seller','orderby' => 'DESC');
	$live_posts = get_posts( $args );
	foreach($live_posts as $post) {
		if(get_post_meta($post->ID,'status',true) == '1' || get_post_meta($post->ID,'status',true) == '2'){
			if($deal_id == $post->ID){
				$deal_select = "selected";
			}else {
				$deal_select = "";
			}
			$deal_display .= '<option value="'.$post->ID.'" '.$deal_select.'>'.$post->post_title.'</option>';
		}	
	}
	return $deal_display;
}
function deal_list_transaction($deal_id){
	global $wpdb;
	$trans_table = $wpdb->prefix."deal_transaction";
	$display_deal = '';
	$deal_cnt = mysql_query("select * from $trans_table where post_id = '".$deal_id."' and status = '1'");
	if(mysql_num_rows($deal_cnt) > 0){
		echo '<table style="background-color:#f5f5f5;" width="100%">
				<tr>
					<th width="20">ID</th>
					<th>Name</th>
					<th>Address</th>
					<th>Deal Coupon</th>
					<th>Pay Date</th>
					<th>Pay Method</th>
					<th>Amount</th>
				</tr> ';
		while($deal_cnt_res = mysql_fetch_array($deal_cnt)){
		echo '<tr>
					<td>'.$deal_cnt_res['trans_id'].'</td>
					<td>Billing Name : '.$deal_cnt_res['billing_name'].'<br />Shipping Name : '.$deal_cnt_res['shipping_name'].'</td>
					<td>Billing Address : '.$deal_cnt_res['billing_add'].'<br />Shipping Address : '.$deal_cnt_res['shipping_add'].'</td>
					<td>'.$deal_cnt_res['deal_coupon'].'</td>
					<td>'.$deal_cnt_res['payment_date'].'</td>
					<td>'.$deal_cnt_res['payment_method'].'</td>
					<td>'.number_format($deal_cnt_res['payable_amt'],2).'</td>
				</tr>';
			}
	echo '</table>';		
	} 
}
function is_deal_in_trans($deal_id){
	global $wpdb;
	$trans_table = $wpdb->prefix."deal_transaction";
	$tran_sele_sql = mysql_query("select * from $trans_table where post_id = '".$deal_id."' and status = '1'");
	if(mysql_num_rows > 0){
		return true;
	} else {
		return false;
	}
}
?>