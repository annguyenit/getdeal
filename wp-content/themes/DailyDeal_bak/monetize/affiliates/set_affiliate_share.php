<?php
global $current_user;
get_currentuserinfo();
$user_id = $current_user->ID;

if($cartTotalAmt>0 && $_COOKIE['affiliate-settings'] != '')
{
	$aff_info_array = explode('|',$_COOKIE['affiliate-settings']);
	$aid = $aff_info_array[0];
	$lkey = $aff_info_array[1];
	setcookie('affiliate-settings', '', time(), SITECOOKIEPATH,COOKIE_DOMAIN );
}
?>