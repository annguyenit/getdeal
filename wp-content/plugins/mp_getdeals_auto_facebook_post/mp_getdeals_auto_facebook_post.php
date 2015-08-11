<?php
/*
Plugin Name: Facebook Deals Poster
Plugin URI: http://www.getdeal.nl
Description: This plugin automatically publishes deals on Facebook account.
Author: GetDeals
Version: 1.0
Author URI: http://www.getdeals.nl
Copyright 2013 GetDeals
*/
require_once(plugin_dir_path( __FILE__ ).'inc/facebook.php');

$facebook = new Facebook(array(
  'appId'  => get_option('mp-getdeal-fb-app-key'),
  'secret' => get_option('mp-getdeal-fb-app-secret'),
));

//Hoook
//add_action('new_to_publish', 'mp_getdeal_post_on_fb');
//add_action('draft_to_publish', 'mp_getdeal_post_on_fb');
//add_action('pending_to_publish', 'mp_getdeal_post_on_fb');

register_activation_hook(__FILE__, 'mp_fb_poster_activation');
register_deactivation_hook(__FILE__, 'mp_fb_poster_deactivation'); 

function mp_fb_deal_send_report($data)
{
   $headers = 'From: Facebook Auto Post <cron@getdeal.nl>' . "\r\n";
   wp_mail('hmphu.it@gmail.com', 'Facebook Post Success', $data, $headers);
}

function mp_fb_poster_activation() {
	wp_schedule_event(time(), 'in_one_minute', 'mp_fb_poster_hook');
	update_option('mp-deal-poster-last-run',time());
	update_option('mp-fb-deal-poster-time',7200);
	$max_id = mp_get_next_id(0);
	update_option('mp-fb-deal-poster-last-id',$max_id);
}

function mp_fb_poster_deactivation() {
	wp_clear_scheduled_hook('mp_fb_poster_hook');
}

add_action('mp_fb_poster_hook','mp_fb_poster_do');

function mp_fb_poster_hook(){
	if(time() - (int)get_option('mp-deal-poster-last-run') < get_option('mp-fb-deal-poster-time',7200))
		return;
		
	$last_id = get_option('mp-fb-deal-poster-last-id');	
	$next_id = mp_get_next_id($last_id);
	
	if(!$next_id  || $next_id == $last_id)
		return false;
		
	$post = get_post($next_id);
	
	if(!empty($post))
	{
		mp_getdeal_post_on_fb($post);
	}
	update_option('mp-deal-poster-last-run',time());
	mp_fb_deal_send_report((int)$next_id . ' at ' . time());
}

function mp_get_next_id($last_id = 0,$post_type = 'dagaanbiedingen')
{
	global $wpdb;
	$next_id = 0;
	if((int)$last_id <= 0)
	{
		$next_id = $wpdb->get_var( "SELECT MAX(ID) FROM $wpdb->posts WHERE post_type = '" . $post_type . "'" );
	}
	else
	{
		$next_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE ID > " . (int)$last_id ." AND post_type = '" . $post_type . "' LIMIT 1" );
	}	
	return (int)$next_id ;
}

//Function for posting on facebook
function mp_getdeal_post_on_fb($post,$picUrl = null){
	if(get_option('mp-enable-fb-deal-poster') == 'YES')
	{			
		global $facebook;		
		$user_id = get_option('mp-getdeal-userid');
		$user_token = get_option('mp-getdeal-access-token');
		if(!$facebook || !$user_id  || !$user_token)
			return false;
		$facebook->setAccessToken($user_token);
		
		$deal = array(
					'access_token' => $user_token,
					'message' => $post->post_title,
					'link' => get_permalink($post->ID),
					'caption' => $post->post_title,
					'description' => get_bloginfo ('description')
				);
		if($picUrl != null)
		{
			$deal['picture'] = $picUrl;
		}
		else if(get_post_meta($post->ID,'file_name',true) != "")
		{
			$deal['picture'] = templ_thumbimage_filter(get_post_meta($post->ID,'file_name',true),165,180);
		}        
		else
		{
			$deal['picture'] = get_template_directory_uri()."/images/de-beste-deals.png"; 
        }
		$facebook->api('/' . $user_id . '/feed', 'POST', $deal);
		
		if(get_option('mp-getdeal-fanpage-id') != '' && get_option('mp-getdeal-page-access-token') != '')
		{
			$fanpage = get_option('mp-getdeal-fanpage-id');
			$deal['access_token'] = get_option('mp-getdeal-page-access-token');
			$kq = $facebook->api('/' . $fanpage . '/feed', 'POST', $deal);
		}
		update_option('mp-fb-deal-poster-last-id',$post->ID);
	}
}

if(!function_exists('mp_deals_importer_time'))
{
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
}

function mp_insert_image_src_rel_in_head() {
	global $post;
	if ( !is_singular())
		return;
	if(get_post_meta($post->ID,'file_name',true) == "")
	{ 
		$default_image=get_template_directory_uri()."/images/de-beste-deals.png";
		echo '<meta property="og:image" content="' . $default_image . '"/>';
	}
	else{
		$thumbnail_src = templ_thumbimage_filter(get_post_meta($post->ID,'file_name',true),165,180);
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src) . '"/>';
	}
}


add_action( 'wp_head', 'mp_insert_image_src_rel_in_head', 5 );

//Options Page
include_once('option.php');
?>