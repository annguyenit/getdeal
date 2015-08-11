<?php get_header();?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tabber.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/timer.js"></script>
<script type="text/javascript">
function viewtransaction(cuid,did)
{
	location.href= "?author="+cuid+"&transid="+did;
}
function showtransdetail(details_id)
{ 
	if(document.getElementById('transaction_'+details_id).style.display=='none')	{
		document.getElementById('transaction_'+details_id).style.display='';
	}else	{
		document.getElementById('transaction_'+details_id).style.display='none';	
	}
}

	function a()
	{
		return false;
	}

	function buydeal(oid,did)
	{
	location.href= "?ptype="+oid+"&did="+did;
	}
	
	function delete_deal(dealid)
	{    
	  if (dealid=="")
	  {
	  document.getElementById("deletedeal").innerHTML="";
	  return;
	  }
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("deletedeal").innerHTML=xmlhttp.responseText;
		
		}
	  }
	    url = "<?php echo get_template_directory_uri(); ?>/monetize/deal/ajax_delete_deal.php?delete_id="+dealid+"&myid="+dealid
	 	xmlhttp.open("GET",url,true);
	  	xmlhttp.send();
	}

</script>
<script type="text/javascript">document.write('<style type="text/css">.tabber { display: none; }<\/style>');</script>
<?php
global $current_user;
global $wpdb,$deal_db_table_name;	
$postmeta_db_table_name = $wpdb->prefix . "postmeta";
$post_db_table_name = $wpdb->prefix . "posts";
$transaction_table = $wpdb->prefix."deal_transaction";
if(isset($_GET['author_name'])) :
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;
$user_db_table_name = get_user_table();
$destination_path = site_url().'/wp-content/uploads/';

if($curauth->ID == $current_user->ID) {
	$title_name = WELCOME_TEXT." ".$curauth->display_name;
	$user_displayname = $curauth->display_name ;
	$dashboard_display = '<a href="'.get_author_posts_url($current_user->ID).'" class="back_link" >'.BACK_TO_DASHBOARD.'</a>';
} elseif($curauth->ID != $current_user->ID ){
	$title_name	 = $curauth->display_name.DEAL_S;
	$user_displayname = $curauth->display_name;
} else {
	// donothing
} 

if ( get_option('ptthemes_breadcrumbs' )) {  
$sep_array = get_option('yoast_breadcrumbs');
$sep = $sep_array['sep'];
?>

<div class="breadcrumb clearfix">
  <div class="breadcrumb_in"><a href="<?php echo site_url(); ?>"><?php echo HOME;?></a> <?php echo $sep; ?> <?php echo $user_displayname; ?></div>
</div>
<?php } ?>
<!-- Content  2 column - left Sidebar  -->
<div  class="<?php templ_content_css();?>" >
  <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('page_content_above')){ } else {  }?>
  <div class="content-title">
    <h1><?php echo $title_name ; ?> </h1>
  </div>
  <!-- BOF Author Detail -->
  <?php if(!isset($_REQUEST['transid'])) { ?>
  <div class="details_main">
    <div class="detail_photo">
     <?php echo get_avatar($curauth->ID, 125 );?>
    </div>
    <div class="detail_content">
      <h3><?php echo $user_displayname;	?></h3>
      <p class="detail_links">
        <?php if(get_user_meta($curauth->ID,'user_website',true) != "" ) {?>
        <a href="<?php echo get_user_meta($curauth->ID,'user_website',true);?>" target="_blank"><?php echo VISIT_WEBSITE;?></a>
        <?php } ?>
        <?php if(get_user_meta($curauth->ID,'user_twitter',true) != "" ) {?>
        <a href="<?php echo get_user_meta($curauth->ID,'user_twitter',true);?>" target="_blank"><?php echo TWITTER;?></a>
        <?php } ?>
        <?php if(get_user_meta($curauth->ID,'user_facebook',true) != "" ) {?>
        <a href="<?php echo get_user_meta($curauth->ID,'user_facebook',true);?>" target="_blank"><?php echo FACEBOOK;?></a>
        <?php } ?>
      </p>
      <ul class="user_detail">
        <?php if($curauth->ID == $current_user->ID) {?>
        <li><span><?php echo DEAL_PURCHASE;?> : </span><?php echo deal_salecount_post($curauth->ID);?></li>
        <?php }?>
        <li><span><?php echo DEAL_PROVIDED;?> : </span><?php echo deal_count_post($curauth->ID);?></li>
        <li><?php echo get_user_meta($curauth->ID,'user_about',true);?></li>
      </ul>
    </div>
  </div>
  <?php } ?>
  <!-- EOF Author Detail -->
  <?php 
$UID=$curauth->ID;
	$email_id = $curauth->user_email;
	$username  = $curauth->user_login;
	$targetpage = get_author_posts_url($curauth->ID);
	$total_deals = mysql_query("select p.* from $post_db_table_name p where post_author = '".$curauth->ID."' and p.post_type = '".CUSTOM_POST_TYPE1."' and p.post_status = 'publish' ");
	$total_pages = mysql_num_rows($total_deals);
	$recordsperpage = 5;
	$pagination = $_REQUEST['pagination'];
	if($pagination == '') {
		$pagination = 1;
	}
	$strtlimit = ($pagination-1)*$recordsperpage;
	$endlimit = $strtlimit+$recordsperpage;
	$dealcnt_sql = $wpdb->get_results("select p.* from $post_db_table_name p where post_author = '".$curauth->ID."' and p.post_type = '".CUSTOM_POST_TYPE1."' and p.post_status = 'publish' limit $strtlimit,$recordsperpage ");
if($curauth->ID == $current_user->ID && !isset($_REQUEST['transid'])) {
//----------------------------------------------------		
?>
 <?php  //AFFILIATE START
		if($General->is_active_affiliate())
		{
			global $current_user;
			get_currentuserinfo();
			$user_id = $current_user->ID;
			$user_role = get_usermeta($user_id,'wp_capabilities');
			if(!$user_role['affiliate'])
			{
			?>
				<h6><b><?php _e(WANT_TO_BECOME_AFF_TEXT);?> <?php $themeUI->get_affiliate_link($css='fr');?></b> </h6>
				<?php
			} 
			
		} //AFFILIATE END
		?>
  <div id="deletedeal"></div>
  <div class="tabber">
    <div class="tabbertab">
      <?php include_once('monetize/author_detail/deal_provided.php');?>
    </div>
    <div class="tabbertab">
      <?php include_once('monetize/author_detail/deal_purchased.php');?>
    </div> 
	<?php if($General->is_active_affiliate())
			{ ?>
	<div class="tabbertab">
      <?php @include_once(TEMPLATEPATH . '/monetize/affiliates/affiliates_links.php');		
				 ?>
    </div>
	<?php } ?>
  </div>
  <?php  } 
 // Transaction Detail BOF
if(isset($_REQUEST['transid']) ||($_REQUEST['transid']) != "" && $curauth->ID == $current_user->ID) {
	include_once('monetize/author_detail/transaction_detail.php');
}   // Transaction Detail EOF
/* Author Detail BOF */
if($curauth->ID != $current_user->ID && !isset($_REQUEST['transid'])) {
	include_once('monetize/author_detail/author_detail.php');
} 
/* Author Detail EOF */
if (function_exists('dynamic_sidebar') && dynamic_sidebar('page_content_below')){ } else { }?>
</div>
<!-- /Content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
