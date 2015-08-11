<?php
/*
Plugin Name: Deals Importer
Plugin URI: http://getdeals.nl
Description: Import deals from daisycon.com
Author: GetDeals.nl
Author URI: http://getdeals.nl
Version: 1.0
*/

register_activation_hook(__FILE__, 'mp_deals_importer_activation');
add_action('mp_news_cron', 'do_this_hourly');
register_deactivation_hook(__FILE__, 'mp_deals_importer_deactivation');

function send_report($data)
{
   $headers = 'From: My Name <cron@getdeal.nl>' . "\r\n";
   wp_mail('hmphu.it@gmail.com', 'Cron update deals', $data, $headers);
}

function mp_deals_importer_activation() {
	wp_schedule_event(time(), 'in_one_minute', 'mp_deals_importer_hook');
	update_option('mp-deal-importer-last-run',time());
	update_option('mp-deal-importer-time',21600);
}

function mp_deals_importer_deactivation() {
	wp_clear_scheduled_hook('mp_deals_importer_hook');
}

add_action('mp_deals_importer_hook','mp_deals_importer_do');

function do_not_cache_feeds(&$feed) {
	$feed->enable_cache(false);
}

add_action( 'wp_feed_options', 'do_not_cache_feeds' );

function mp_deals_importer_do_nudeal()
{
	/*
	if(get_option('mp-deal-importer-enable') != 'YES')
		return false;

	if(time() - (int)get_option('mp-deal-importer-last-run') < get_option('mp-deal-importer-time'))
		return;
	*/
	$url = get_option('mp-getdeal-feed-url-nudeal');
	$xml = @simplexml_load_file($url,null,LIBXML_NOCDATA);
	if(!$xml)
		return false;

	global $user_ID;
	$post_type = 'dagaanbiedingen';
	$array_post_id = array();
	$total = 0;
	try
	{
		foreach($xml->item as $post)
		{
			//if($total == 10)
				//break;
			$title_str = trim($post->title);
			$title_str = esc_attr(htmlspecialchars($title_str));
			//$title_str = html_entity_decode($title_str, ENT_COMPAT, 'UTF-8');
			$check = get_page_by_title($title_str , 'ARRAY_A', $post_type);
			if(empty($check)){
				$content  = '[tab:Over deze deal]';
				$content .= html_entity_decode($post->description,ENT_QUOTES,'UTF-8');
				$content .=	'[most_important_info]';
				//$content .=	html_entity_decode($post->accommodation_description,ENT_QUOTES,'UTF-8');
				$content .=	'[/most_important_info]';
				$content .=	'[tab:Meer informatie]';
				//$content .=	 html_entity_decode($post->inclusief,ENT_QUOTES,'UTF-8');
				$content .=	'[tab:END]';
				$new_post = array(
					'post_title' => $post->title,
					'post_content' =>  $content,
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_type' => $post_type,
					'filter' => true
				);
				//remove_filter('content_save_pre', 'wp_filter_post_kses');
				//remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');
				$id = wp_insert_post($new_post);
				//add_filter('content_save_pre', 'wp_filter_post_kses');
				//add_filter('content_filtered_save_pre', 'wp_filter_post_kses');
				if($id)
				{
					list($day, $month, $year, $hour, $minute) = split('[/ :]', $post->start_date . ' ' .$post->start_time);
					$start_timestamp = mktime((int)$hour, (int)$minute,0, (int)$month, (int)$day, (int)$year);
					list($day, $month, $year, $hour, $minute) = split('[/ :]', $post->end_date . ' ' .$post->end_time);
					$end_timestamp = mktime((int)$hour, (int)$minute,0, (int)$month, (int)$day, (int)$year);

					$total++;
					update_post_meta($id, "status",'2');
					update_post_meta($id,"is_show",'1');
					update_post_meta($id, "owner_name", 'Nu Deal');
					update_post_meta($id, "current_price", (float)$post->maximum_price);
					update_post_meta($id, "our_price", (float)$post->minimum_price);
					update_post_meta($id, "coupon_type", 1);
					update_post_meta($id, "coupon_link", (string)$post->link);
					update_post_meta($id, "coupon_start_date_time", $start_timestamp);
					update_post_meta($id, "coupon_end_date_time", $end_timestamp);
					update_post_meta($id, "coupon_end_date_timef", $end_timestamp);
					update_post_meta($id, "file_name", (string)$post->img_medium);
					update_post_meta($id, "is_expired", '0');
					update_post_meta($id, "_yoast_wpseo_title", strip_tags($post->title));
					update_post_meta($id, "_yoast_wpseo_metadesc", strip_tags(html_entity_decode($post->description,ENT_QUOTES,'UTF-8')));
					wp_set_object_terms($id, isset($post->category) ? (array)$post->category : 'Nu Deal','deal-categorie', true);
					/*
					if(function_exists('mp_getdeal_post_on_fb'))
					{
						$p = query_posts("p=$id&post_type=$post_type");
						mp_getdeal_post_on_fb($p,$post->img_small);
					}
					*/
				}
				$array_post_id[] = $id;
			}
		}
	}
	catch(Exception $ex)
	{
		send_report(time().var_dump($ex));
	}
	//send_report('Success NUDeal'.time()."<br/>".var_dump($array_post_id));
}

function mp_deals_importer_do_dealdonkey()
{
	/*
	if(get_option('mp-deal-importer-enable') != 'YES')
		return false;

	if(time() - (int)get_option('mp-deal-importer-last-run') < get_option('mp-deal-importer-time'))
		return;
	*/
	$url = get_option('mp-getdeal-feed-url-dealdonkey');
	$xml = @simplexml_load_file($url,null,LIBXML_NOCDATA);

	if(!$xml)
		return false;

	global $user_ID;
	$post_type = 'dagaanbiedingen';
	$array_post_id = array();
	$total = 0;
	try
	{
		foreach($xml->item as $post)
		{
			//if($total == 10)
				//break;
			$title_str = trim($post->title);
			$title_str = esc_attr(htmlspecialchars($title_str));
			$check = get_page_by_title( $title_str , 'ARRAY_A', $post_type);
			if(empty($check)){
				$content  = '[tab:Over deze deal]';
				$content .= html_entity_decode($post->description,ENT_QUOTES,'UTF-8');
				$content .=	'[most_important_info]';
				//$content .=	html_entity_decode($post->accommodation_description,ENT_QUOTES,'UTF-8');
				$content .=	'[/most_important_info]';
				$content .=	'[tab:Meer informatie]';
				//$content .=	 html_entity_decode($post->inclusief,ENT_QUOTES,'UTF-8');
				$content .=	'[tab:END]';
				$new_post = array(
					'post_title' => $post->title,
					'post_content' =>  $content,
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_type' => $post_type,
					'filter' => true
				);
				//remove_filter('content_save_pre', 'wp_filter_post_kses');
				//remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');
				$id = wp_insert_post($new_post);
				//add_filter('content_save_pre', 'wp_filter_post_kses');
				//add_filter('content_filtered_save_pre', 'wp_filter_post_kses');
				if($id)
				{
					$total++;
					update_post_meta($id, "status",'2');
					update_post_meta($id,"is_show",'1');
					update_post_meta($id, "owner_name", 'Dealdonkey');
					update_post_meta($id, "current_price", (float)$post->maximum_price);
					update_post_meta($id, "our_price", (float)$post->minimum_price);
					update_post_meta($id, "coupon_type", 1);
					update_post_meta($id, "coupon_link", (string)$post->link);
					update_post_meta($id, "coupon_start_date_time", strtotime(date('Y-m-d 00:00:00')));
					update_post_meta($id, "coupon_end_date_time", strtotime((string)$post->time_end));
					update_post_meta($id, "coupon_end_date_timef", strtotime((string)$post->time_end));
					update_post_meta($id, "file_name", (string)$post->img_small);
					update_post_meta($id, "is_expired", '0');
					update_post_meta($id, "_yoast_wpseo_title", strip_tags($post->title));
					update_post_meta($id, "_yoast_wpseo_metadesc", strip_tags(html_entity_decode($post->description,ENT_QUOTES,'UTF-8')));
					wp_set_object_terms($id, isset($post->category) ? (array)$post->category : 'Verassingen','deal-categorie', true);
					/*
					if(function_exists('mp_getdeal_post_on_fb'))
					{
						$p = query_posts("p=$id&post_type=$post_type");
						mp_getdeal_post_on_fb($p,$post->img_small);
					}
					*/
				}
				$array_post_id[] = $id;
			}
		}
	}
	catch(Exception $ex)
	{
		send_report(time().var_dump($ex));
	}
	//send_report('Success Dealdonkey'.time()."<br/>".var_dump($array_post_id));
	//update_option('mp-deal-importer-last-run',time());
}

function mp_deals_importer_do()
{
	if(get_option('mp-deal-importer-enable') != 'YES')
		return false;


	if(time() - (int)get_option('mp-deal-importer-last-run') < get_option('mp-deal-importer-time'))
		return;

	$url = get_option('mp-getdeal-feed-url');
	$xml = @simplexml_load_file($url,null,LIBXML_NOCDATA);
	if(!$xml)
		return false;

	global $user_ID;
	$post_type = 'dagaanbiedingen';
	$array_post_id = array();
	$total = 0;
	try
	{
		foreach($xml->item as $post)
		{
			//if($total == 10)
				//break;
			$title_str = trim($post->title);
			$title_str = esc_attr(htmlspecialchars($title_str));
			$check = get_page_by_title( $title_str , 'ARRAY_A', $post_type);
			if(empty($check)){
				$content  = '[tab:Over deze deal]';
				$content .= html_entity_decode($post->description,ENT_QUOTES,'UTF-8');
				$content .=	'[most_important_info]';
				$content .=	html_entity_decode($post->accommodation_description,ENT_QUOTES,'UTF-8');
				$content .=	'[/most_important_info]';
				$content .=	'[tab:Meer informatie]';
				$content .=	 html_entity_decode($post->inclusief,ENT_QUOTES,'UTF-8');
				$content .=	'[tab:END]';
				$new_post = array(
					'post_title' => $post->title,
					'post_content' =>  $content,
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_type' => $post_type,
					'filter' => true
				);
				//remove_filter('content_save_pre', 'wp_filter_post_kses');
				//remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');
				$id = wp_insert_post($new_post);
				//add_filter('content_save_pre', 'wp_filter_post_kses');
				//add_filter('content_filtered_save_pre', 'wp_filter_post_kses');
				if($id)
				{
					$total++;
					update_post_meta($id, "status",'2');
					update_post_meta($id,"is_show",'1');
					update_post_meta($id, "owner_name", 'Boekvandaag.nl');
					update_post_meta($id, "current_price", (float)$post->maximum_price);
					update_post_meta($id, "our_price", (float)$post->minimum_price);
					update_post_meta($id, "coupon_type", 1);
					update_post_meta($id, "coupon_link", (string)$post->link);
					update_post_meta($id, "coupon_start_date_time", strtotime((string)$post->offer_valid_from_date));
					update_post_meta($id, "coupon_end_date_time", strtotime((string)$post->offer_valid_to_date));
					update_post_meta($id, "coupon_end_date_timef", strtotime((string)$post->offer_valid_to_date));
					update_post_meta($id, "file_name", (string)$post->img_medium);
					update_post_meta($id, "is_expired", '0');
					update_post_meta($id, "_yoast_wpseo_title", strip_tags($post->title));
					update_post_meta($id, "_yoast_wpseo_metadesc", strip_tags(html_entity_decode($post->description,ENT_QUOTES,'UTF-8')));
					wp_set_object_terms($id, (array)$post->category,'deal-categorie', true);
					/*
					if(function_exists('mp_getdeal_post_on_fb'))
					{
						$p = query_posts("p=$id&post_type=$post_type");
						mp_getdeal_post_on_fb($p,$post->img_medium);
					}
					*/
				}
				$array_post_id[] = $id;
			}
		}
	}
	catch(Exception $ex)
	{
		send_report(time().var_dump($ex));
	}
	//send_report('Success '.time()."<br/>".var_dump($array_post_id));
	mp_deals_importer_do_dealdonkey();
	mp_deals_importer_do_nudeal();
	update_option('mp-deal-importer-last-run',time());
}

add_filter('cron_schedules', 'mp_deals_importer_time');

function mp_deals_importer_time(){
	return array(
		'in_one_minute' => array(
			'interval' => 60,
			'display' => 'In every Mintue'
		),
		'in_per_15_minutes' => array(
			'interval' => 60 * 15,
			'display' => 'In every 15 Mintues'
		),
		'in_per_30_minutes' => array(
			'interval' => 60 * 30,
			'display' => 'In every 30 Mintues'
		),
		'one_hourly' => array(
			'interval' => 60 * 60 * 1,
			'display' => 'Once in One Hours'
		),
		'two_hourly' => array(
			'interval' => 60 * 60 * 2,
			'display' => 'Once in Two Hours'
		),
		'three_hourly' => array(
			'interval' => 60 * 60 * 3,
			'display' => 'Once in Three Hours'
		)
	);
}
include_once('option.php');
?>