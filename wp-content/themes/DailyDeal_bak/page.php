<?php
global $Cart, $General;

///affiliate setting start//
if($_GET['ptype'] == 'account')
{
	include_once(TEMPLATEPATH . '/monetize/affiliates/check_affiliate.php');
	exit;
}else
if($_GET['ptype'] == 'affiliate') //affiliate page start
{
	include(TEMPLATEPATH . '/monetize/affiliates/affiliate_page.php');
	exit;
}else  //affiliate page end
if($_GET['ptype'] == 'setasaff')
{
	global $current_user;
	get_currentuserinfo();
	$user_id = $current_user->ID;
	$current_user->wp_capabilities['affiliate'] = 1;
	update_usermeta($user_id, 'wp_capabilities', $current_user->wp_capabilities);
	wp_redirect(site_url( "/?ptype=myaccount" ));
	exit;
///affiliate setting end//
}
?>

<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<!--  CONTENT AREA START -->

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>

<div class="entry">
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
    <div class="post-meta">
      <?php //templ_page_title_above(); //page title above action hook?>
      <?php echo templ_page_title_filter(get_the_title()); //page tilte filter?>
      <?php //templ_page_title_below(); //page title below action hook?>
    </div>
    <div class="post-content">
      <?php the_content(); ?>
    </div>
   </div>
</div>
<?php endwhile; ?>
<?php endif; ?>


<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>