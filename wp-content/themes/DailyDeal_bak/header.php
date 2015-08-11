<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" >
    <title><?php wp_title ( '|', true,'right' ); ?></title>
	<?php do_action('templ_head_meta');?>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" >
    <link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
    <?php do_action('templ_head_css');?>
	<link type='text/css' href='<?php bloginfo('template_directory'); ?>/library/css/basic.css' rel='stylesheet' media='screen' />
	<link type="text/css" href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" media="all" />
	<?php if (!is_home() || $_REQUEST['page']!='' ) { ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery-1.2.6.min.js" ></script>
	<?php }?>
	
	<?php
	if (function_exists (gConstantcontact)){ ?>
		<script type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/constant-contact/gExtra/gConstantcontact.js"></script>
		<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_option('siteurl'); ?>/wp-content/plugins/constant-contact/style.css" />
	
    <?php }
    wp_enqueue_script('jquery');
    wp_enqueue_script('cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', 'jquery', false);
    
    if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', 'jquery', false);
    wp_enqueue_script('script', get_template_directory_uri() . 'library/js/tabber.js', 'jquery', false); 

    remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
    //remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
    remove_action( 'wp_head', 'index_rel_link' ); // index link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
	 wp_head();
	
	if ( is_home() || is_single()){
	?>   

	<link type="text/css" href="<?php bloginfo('template_directory'); ?>/library/css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
<?php
} ?>

</head>
<body <?php body_class(); ?>>
<?php templ_body_start(); // Body Start hooks?>
<?php  templ_get_top_header_navigation_above() 
?>

<?php
if ( is_home() && $_REQUEST['ptype']=='' )  // Home page code
{
 ?>
 <div class="wrapper" >
    <div class="header clear <?php echo $header_class;?>">
       <div class="header_in" >
        <div class="logo">
        <?php  templ_site_logo(); ?>
        </div>
      <div class="header_right">	
		<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('header_above')){?>
		 <?php } else {?>  <?php }?>
          <?php if(strtolower(get_option('pttthemes_submit_deal_link'))!='disable'){ ?>
				 <ul class="submitdeal">
					<li class="bgn"><a href="<?php echo site_url();?>/?ptype=dealform"><?php echo SUBMIT_DEAL_TEXT; ?></a></li> 
				 </ul>
			<?php
			} ?>	  
			<?php if(!is_user_logged_in()){
				echo '<div class="mp_social_connect_form">';
				do_action('social_connect_form');
				echo '</div>';
			}?> 
			
        <?php  templ_get_top_header_navigation() ?> 
				
      </div>
        </div> <!-- header #end -->
    </div> <!-- header #end -->
   
    <?php templ_home_page_slider(); //home header slider ?>

 <div  class=" <?php echo $inner_class;?>" > 
    <!-- Container -->
    <div id="container" class="clear">
 <?php   
}else 
{
 ?>
 <div class="wrapper">
    <div class="header clear header_inner">
       <div class="header_in" >
        <div class="logo">
        <?php
        templ_site_logo();
        ?>
        </div>
      <div class="header_right">	
		<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('header_above')){?>
		 <?php } else {?>  <?php }?>	  
 		 <?php if(strtolower(get_option('pttthemes_submit_deal_link'))!='disable'){ ?>
				 <ul class="submitdeal">
					<li class="bgn"><a href="<?php echo site_url();?>/?ptype=dealform"><?php echo SUBMIT_DEAL_TEXT;?></a></li> 
				 </ul>
			<?php
			} ?>	
            <?php  templ_get_top_header_navigation() ?> 	
      </div>
        </div> <!-- header #end -->
    </div> <!-- header #end -->

    <?php templ_home_page_slider(); //home header slider ?>

 <div  class="inner" > 
    <!-- Container -->
    <div id="container" class="clear">
   <?php 
		if($_GET['ptype'] != 'dealform' && $_GET['ptype'] != 'deals' && $_GET['ptype'] != 'profile' && $_GET['ptype'] != 'login' && $_GET['ptype'] != 'taxonomy_all_deal_tab' && $_GET['ptype'] != 'taxonomy_live_deal_tab' && $_GET['ptype'] != 'taxonomy_expired_deal_tab' && $_GET['ptype'] != 'buydeal'){
			templ_set_breadcrumbs_navigation();
		}
}
?>