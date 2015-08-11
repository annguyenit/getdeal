<?php 

function addUploadMimes($mimes) {
     $mimes = array_merge($mimes, array(
                                        // Adobe Extensions
										 'ico' => 'image/ico',
                                        'psd' => 'application/octet-stream',
                                        'ai|eps' => 'application/postscript'
                                        ));
     return $mimes;
}
add_filter('upload_mimes', 'addUploadMimes');
	
function fetch_deal($dealid)
{ 
	if($dealid == '1')
	{
		echo "Custom Link Deal";
	}elseif($dealid == '2')
	{
		echo "Digital Product deal";
	}
	elseif($dealid == '3')
	{
		echo "Coupon deal/print - Online";
	}elseif($dealid == '4')
	{
		echo "Coupon deal/print - Product";
	}
}

function fetch_status($sid,$isexpired)
{
		if($sid == '0')
		{
			echo "<span class='color_pending'>Pending</span>";
		}elseif($sid == '1')
		{
			if($isexpired == '1')
			{
			echo "<span class='color_expire'>Expired</span>";
			}else
			{
			echo "<span class='color_active'>Accepted</span>";
			}
		}
		elseif($sid == '2')
		{
			echo "<span class='color_active'>Active</span>";
		}elseif($sid == '3')
		{
			echo "<span class='color_reject'><b>Rejected</b></span>";
		}elseif($sid == '4')
		{
			echo "<span class='color_terminate'><b>Terminated</b></span>";
		}

}
add_action('templatic_function','fetch_status');
/**
* A pagination function
* @param integer $range: The range of the slider, works best with even numbers
* Used WP functions:
* get_pagenum_link($i) - creates the link, e.g. http://site.com/page/4
* previous_posts_link(' « '); - returns the Previous page link
* next_posts_link(' » '); - returns the Next page link
*/
function get_pagination1($range = 4){
  // $paged - number of the current page
  global $paged, $wp_query;
  // How much pages do we have?
  if ( !$max_page ) {
    $max_page = $wp_query->max_num_pages;
  }
  // We need the pagination only if there are more than 1 page
  if($max_page > 1){
    if(!$paged){
      $paged = 1;
    }
    // On the first page, don't put the First page link
    if($paged != 1){
      echo "<a href=" . get_pagenum_link(1) . "> First </a>";
    }
    // To the previous page
    previous_posts_link(' « ');
    // We need the sliding effect only if there are more pages than is the sliding range
    if($max_page > $range){
      // When closer to the beginning
      if($paged < $range){
        for($i = 1; $i <= ($range + 1); $i++){
          echo "<a href='" . get_pagenum_link($i) ."'";
          if($i==$paged) echo "class='current'";
          echo ">$i</a>";
        }
      }
      // When closer to the end
      elseif($paged >= ($max_page - ceil(($range/2)))){
        for($i = $max_page - $range; $i <= $max_page; $i++){
          echo "<a href='" . get_pagenum_link($i) ."'";
          if($i==$paged) echo "class='current'";
          echo ">$i</a>";
        }
      }
      // Somewhere in the middle
      elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
        for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){
          echo "<a href='" . get_pagenum_link($i) ."'";
          if($i==$paged) echo "class='current'";
          echo ">$i</a>";
        }
      }
    }
    // Less pages than the range, no sliding effect needed
    else{
      for($i = 1; $i <= $max_page; $i++){
        echo "<a href='" . get_pagenum_link($i) ."'";
        if($i==$paged) echo "class='current'";
        echo ">$i</a>";
      }
    }
    // Next page
    _e(next_posts_link(' » '),'templatic');
    // On the last page, don't put the Last page link
    if($paged != $max_page){
      echo " <a href=" . get_pagenum_link($max_page) . "> Last </a>";
    }
  }
}

function get_pagination($targetpage,$total_pages,$limit=10,$page=0,$extra_url = '')
		{
			/* Setup page vars for display. */
			if ($page == 0) $page = 1;					//if no page var is given, default to 1.
			$prev = $page - 1;							//previous page is page - 1
			$next = $page + 1;							//next page is page + 1
			$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;						//last page minus 1
			
			if(strstr($targetpage,'?'))
			{
				$querystr = "&amp;pagination";
			}else
			{
				$querystr = "?pagination";
			}
			$pagination = "";
			if($lastpage > 1)
			{	
				$pagination .= "<div class=\"pagination\">";
				//previous button
				if ($page > 1) 
					$pagination.= '<a href="'.$targetpage.$querystr.'='.$prev.$extra_url.'">'.PREV_PAGE_TEXT.'</a>';
				else
					$pagination.= "<span class=\"disabled\">".PREV_PAGE_TEXT."</span>";	
				
				//pages	
				if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
				{	
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= '<a href="'.$targetpage.$querystr.'='.$counter.$extra_url.'">'.$counter.'</a>';					
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
				{
					//close to beginning; only hide later pages
					if($page < 1 + ($adjacents * 2))		
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= '<a href="'.$targetpage.$querystr.'='.$counter.$extra_url.'">'.$counter.'</a>';					
						}
						$pagination.= "...";
						$pagination.= '<a href="'.$targetpage.$querystr.'='.$lpm1.$extra_url.'">'.$lpm1.'</a>';
						$pagination.= '<a href="'.$targetpage.$querystr.'='.$lastpage.$extra_url.'">'.$lastpage.'</a>';		
					}
					//in middle; hide some front and some back
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= '<a href="'.$targetpage.$querystr.'=1'.$extra_url.'">1</a>';
						$pagination.= '<a href="'.$targetpage.$querystr.'=2'.$extra_url.'">2</a>';
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= '<a href='.$targetpage.$querystr.'='.$counter.$extra_url.'">'.$counter.'</a>';					
						}
						$pagination.= "...";
						$pagination.= '<a href="'.$targetpage.$querystr.'='.$lpm1.$extra_url.'">'.$lpm1.'</a>';
						$pagination.= '<a href="'.$targetpage.$querystr.'='.$lastpage.$extra_url.'">'.$lastpage.'</a>';		
					}
					//close to end; only hide early pages
					else
					{
						$pagination.= '<a href="'.$targetpage.$querystr.'=1'.$extra_url.'">1</a>';
						$pagination.= '<a href="'.$targetpage.$querystr.'=2'.$extra_url.'">2</a>';
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= '<a href="'.$targetpage.$querystr.'='.$counter.$extra_url.'">'.$counter.'</a>';					
						}
					}
				}
				
				//next button
				if ($page < $counter - 1) 
					$pagination.= '<a href="'.$targetpage.$querystr.'='.$next.$extra_url.'">'.NEXT_PAGE_TEXT.'</a>';
				else
					$pagination.= "<span class=\"disabled\">".NEXT_PAGE_TEXT."</span>";
				$pagination.= "</div>\n";		
			}
			return $pagination;
		}
function hexstr($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
global $wpdb,$table_prefix;
$transection_db_table_name = $table_prefix . "deal_transaction";
if($wpdb->get_var("SHOW TABLES LIKE \"$transection_db_table_name\"") != $transection_db_table_name)
{
	$price_table = 'CREATE TABLE IF NOT EXISTS `'.$transection_db_table_name.'` (
	`trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
	`author_id` bigint(20) NOT NULL,
	`user_id` bigint(20) NOT NULL,
	`post_id` bigint(20) NOT NULL,
	`post_title` varchar(255) NOT NULL,
	`deal_coupon` varchar(255) NOT NULL,
	`deal_type` int(2) NOT NULL,
	`status` int(2) NOT NULL,
	`payment_method` varchar(255) NOT NULL,
	`payable_amt` float(25,2) NOT NULL,
	`payment_date` datetime NOT NULL,
	`paypal_transection_id` varchar(255) NOT NULL,
	`user_name` varchar(255) NOT NULL,
	`pay_email` varchar(255) NOT NULL,
	`billing_name` varchar(255) NOT NULL,
	`billing_add` text NOT NULL,
	`shipping_name` varchar(255) NOT NULL,
	`shipping_add` text NOT NULL,
	PRIMARY KEY (`trans_id`)
	)';
	$wpdb->query($price_table);	
}

/****** Alter table wp_deal_transaction for affiliate module *******/
$field_check = $wpdb->get_var("SHOW COLUMNS FROM $transection_db_table_name LIKE 'aff_uid'");
if(!isset($field_check)) {
	$wpdb->query("ALTER TABLE $transection_db_table_name  ADD `aff_uid` BIGINT(20) NOT NULL AFTER `shipping_add`");
}
$field_check = $wpdb->get_var("SHOW COLUMNS FROM $transection_db_table_name LIKE 'aff_commission'");
if(!isset($field_check)) {
	$wpdb->query("ALTER TABLE $transection_db_table_name  ADD `aff_commission` FLOAT(20,2) NOT NULL AFTER `aff_uid`");
}
$field_check = $wpdb->get_var("SHOW COLUMNS FROM $transection_db_table_name LIKE 'ip_address'");
if(!isset($field_check)) {
	$wpdb->query("ALTER TABLE $transection_db_table_name  ADD `ip_address` VARCHAR(255) NOT NULL AFTER `aff_commission`");
}
/****** Alter table wp_deal_transaction for affiliate module *******/

//////////pay settings start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Merchant Id",'templatic'),
					"fieldname"		=>	"merchantid",
					"value"			=>	"myaccount@paypal.com",
					"description"	=>	__("Example : myaccount@paypal.com",'templatic'),
					);
	$payOpts[] = array(
					"title"			=>	__("Cancel Url",'templatic'),
					"fieldname"		=>	"cancel_return",
					"value"			=>	site_url("/?ptype=cancel_return&pmethod=paypal"),
					"description"	=>	sprintf(__("Example : %s",'templatic'),site_url("/?ptype=cancel_return&pmethod=paypal")),
					);
	$payOpts[] = array(
					"title"			=>	__("Return Url",'templatic'),
					"fieldname"		=>	"returnUrl",
					"value"			=>	site_url("/?ptype=return&pmethod=paypal"),
					"description"	=>	sprintf(__("Example : %s",'templatic'),site_url("/?ptype=return&pmethod=paypal")),
					);
	$payOpts[] = array(
					"title"			=>	__("Notify Url",'templatic'),
					"fieldname"		=>	"notify_url",
					"value"			=>	site_url("/?ptype=notifyurl&pmethod=paypal"),
					"description"	=>	sprintf(__("Example : %s",'templatic'),site_url("/?ptype=notifyurl&pmethod=paypal")),
					);
								
	$paymethodinfo[] = array(
						"name" 		=> __('Paypal','templatic'),
						"key" 		=> 'paypal',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'1',
						"payOpts"	=>	$payOpts,
						);
	//////////pay settings end////////
	
	//////////google checkout start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Merchant Id",'templatic'),
					"fieldname"		=>	"merchantid",
					"value"			=>	"1234567890",
					"description"	=>	__("Example : 1234567890",'templatic')
					);
												
	$paymethodinfo[] = array(
						"name" 		=> __('Google Checkout','templatic'),
						"key" 		=> 'googlechkout',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'2',
						"payOpts"	=>	$payOpts,
						);

//////////google checkout end////////
//////////authorize.net start////////

$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Login ID",'templatic'),
					"fieldname"		=>	"loginid",
					"value"			=>	"yourname@domain.com",
					"description"	=>	__("Example : yourname@domain.com",'templatic')
					);
	$payOpts[] = array(
					"title"			=>	__("Transaction Key",'templatic'),
					"fieldname"		=>	"transkey",
					"value"			=>	"1234567890",
					"description"	=>	__("Example : 1234567890",'templatic'),
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('Authorize.net','templatic'),
						"key" 		=> 'authorizenet',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'3',
						"payOpts"	=>	$payOpts,
						);

//////////authorize.net end////////
//////////worldpay start////////

	$payOpts = array();	
	$payOpts[] = array(
					"title"			=>	__("Instant Id",'templatic'),
					"fieldname"		=>	"instId",
					"value"			=>	"123456",
					"description"	=>	__("Example : 123456",'templatic')
					);
	$payOpts[] = array(
					"title"			=>	__("Account Id",'templatic'),
					"fieldname"		=>	"accId1",
					"value"			=>	"12345",
					"description"	=>	__("Example : 12345",'templatic')
					);
											
	$paymethodinfo[] = array(
						"name" 		=> __('Worldpay','templatic'),
						"key" 		=> 'worldpay',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'4',
						"payOpts"	=>	$payOpts,
						);
//////////worldpay end////////
//////////2co start////////

	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Vendor ID",'templatic'),
					"fieldname"		=>	"vendorid",
					"value"			=>	"1303908",
					"description"	=>	__("Enter Vendor ID Example : 1303908",'templatic')
					);
	$payOpts[] = array(
					"title"			=>	__("Notify Url",'templatic'),
					"fieldname"		=>	"ipnfilepath",
					"value"			=>	site_url("/?ptype=notifyurl&pmethod=2co"),
					"description"	=>	sprintf(__("Example : %s",'templatic'),site_url("/?ptype=notifyurl&pmethod=2co")),
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('2CO (2Checkout)','templatic'),
						"key" 		=> '2co',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'5',
						"payOpts"	=>	$payOpts,
						);
	
								
//////////2co end////////
//////////pre bank transfer start////////

	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Bank Information",'templatic'),
					"fieldname"		=>	"bankinfo",
					"value"			=>	"ICICI Bank",
					"description"	=>	__("Enter the bank name to which you want to transfer payment",'templatic')
					);
	$payOpts[] = array(
					"title"			=>	__("Account ID",'templatic'),
					"fieldname"		=>	"bank_accountid",
					"value"			=>	"AB1234567890",
					"description"	=>	__("Enter your bank Account ID",'templatic'),
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('Pre Bank Transfer','templatic'),
						"key" 		=> 'prebanktransfer',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'6',
						"payOpts"	=>	$payOpts,
						);
											
//////////pre bank transfer end////////
//////////pay cash on devivery start////////
	$payOpts = array();
	$paymethodinfo[] = array(
						"name" 		=> __('Pay Cash On Delivery','templatic'),
						"key" 		=> 'payondelevary',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'7',
						"payOpts"	=>	$payOpts,
						);

//////////pay cash on devivery end////////
///////////////////////////////////////
for($i=0;$i<count($paymethodinfo);$i++)
{
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_".$paymethodinfo[$i]['key']."' order by option_id asc";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if(count($paymentinfo)==0)
	{
		$paymethodArray = array(
						"option_name"	=>	'payment_method_'.$paymethodinfo[$i]['key'],
						"option_value"	=>	serialize($paymethodinfo[$i]),
						);
		$wpdb->insert( $wpdb->options, $paymethodArray );
	}
}

function plugin_is_active($plugin_var){
							$return_var = in_array($plugin_var.'/'.$plugin_var.'.php',apply_filters('active_plugins',get_option('active_plugins')));
							return $return_var;
						}
					
?>