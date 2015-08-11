<?php get_header(); 
date_default_timezone_set(get_option('timezone_string')); ?>
<div  class="<?php templ_content_css();?>" >
<?php templ_page_title_above(); //page title above action hook?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/timer.js"></script>

  <!--  CONTENT AREA START -->
  <div class="content-title">
    <?php 
	global $wp_query, $post;
	
	$current_term = $wp_query->get_queried_object();	

	if( $current_term->name)
	{
		$ptitle = $current_term->name; 
	 
	} else {
		
		$ptitle = DEAL_TITLE;
	}?>
    <?php echo templ_page_title_filter($ptitle); //page tilte filter?> </div>
		<?php 
	$main_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if(strstr($main_url,'?')) {
		$imgtype = substr($main_url, 0,strrpos($main_url, '&ptype') );
	} else {
		$imgtype = substr($main_url, 0 ,strrpos($main_url, '?ptype') );
	}
	
	$main_url = str_replace($imgtype,'',$main_url);
		
	if(strstr($main_url,'?')) {
	
		$all_deal_querystr = "&amp;ptype=taxonomy_all_deal_tab";
	
		$live_deal_querystr = "&amp;ptype=taxonomy_live_deal_tab";
	
		$expired_deal_querystr = "&amp;ptype=taxonomy_expired_deal_tab";
	
	}else	{
		
			$all_deal_querystr = "?ptype=taxonomy_all_deal_tab";
		
			$live_deal_querystr = "?ptype=taxonomy_live_deal_tab";
		
			$expired_deal_querystr = "?ptype=taxonomy_expired_deal_tab";
		
	}

	?>
  <div id="loop" class="<?php if (get_option('ptttheme_view_opt') == 'Grid View') {  echo 'grid'; }else{ echo 'list clear'; } ?> ">
    <ul class="tabbernav">
		<li class="tabberactive">
			<a href="<?php echo $main_url.$all_deal_querystr ;?>" title="<?php echo ALL_DEAL; ?>"><?php echo ALL_DEAL; ?></a>
		</li>
		<li class="">
			<a href="<?php echo $main_url.$live_deal_querystr ;?>" title="<?php echo LIVE_DEAL; ?>"><?php echo LIVE_DEAL; ?></a>
		</li>
		<li class="">
			<a href="<?php echo $main_url.$expired_deal_querystr ;?>" title="<?php echo EXPIRED_DEAL; ?>"><?php echo EXPIRED_DEAL; ?></a>
		</li>
	</ul>
	<div class="tabbertab">
	<?php include_once('monetize/deal/all_deal.php');?>
	</div>
  </div>

  <!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
