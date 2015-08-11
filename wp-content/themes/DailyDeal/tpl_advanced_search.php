<?php
/*
Template Name: Page - Advanced Search
*/
?>
<?php
add_action('wp_head','templ_header_tpl_advsearch');
function templ_header_tpl_advsearch()
{
	?>
	<script type="text/javascript">var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
    <?php
}
?>
<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
	<div class="content_top"></div>
	<div class="content_bg">
<!--  CONTENT AREA START -->

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="entry">
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
    <div class="post-meta">
      <h1><?php the_title(); ?></h1>
     </div>
    <div class="post-content">
      <?php endwhile; ?>
      <?php endif; ?>
      
        <div class="post-content">
    	 <?php the_content(); ?>
    </div>
      
      
      <div id="advancedsearch">
        <h4> <?php echo SEARCH_WEBSITE; ?></h4>
        <form method="get"  action="<?php bloginfo('url'); ?>" name="searchform" onsubmit="return sformcheck();">
          <div class="advanced_left">
            <p>
             <label><?php echo SEARCH;?></label> 
             <input class="adv_input" name="s" id="adv_s" type="text" onfocus="if(this.value=='') this.value='';" onblur="if(this.value=='') this.value='<?php echo SEARCH;?>';" value="<?php _e('','templatic');?>" />
            </p>
            <p>
              <label><?php echo DATE_TEXT;?></label>
                <input name="todate" type="text" class="textfield" />
                <img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" class="adv_calendar" onclick="displayCalendar(document.searchform.todate,'yyyy-mm-dd',this)"  />
                
                
               <?php echo '<span>'.TO.'</span>';?> 
                <input name="frmdate" type="text" class="textfield"  />
                <img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar"  class="adv_calendar" onclick="displayCalendar(document.searchform.frmdate,'yyyy-mm-dd',this)"  />
            </p>
            <p>
              <label>
                <?php echo AUTHOR_TEXT;?> </label>
                <input name="articleauthor" type="text" class="textfield"  />
                <span class="adv_author">
                <?php echo EXACT_AUTHOR_TEXT;?>
                </span>
                <input name="exactyes" type="checkbox" value="1" class="checkbox" />
             
            </p>
          </div>
          <input type="submit" value="Submit" class="adv_submit" />
        </form>
      </div>
    </div>
  </div>
</div>


</div> <!-- content bg #end -->
    <div class="content_bottom"></div>
</div> <!-- content end -->

<script type="text/javascript" >
function sformcheck()
{
if(document.getElementById('adv_s').value=="")
{
	alert('<?php echo SEARCH_ALERT_MSG;?>');
	document.getElementById('adv_s').focus();
	return false;
}
if(document.getElementById('adv_s').value=='<?php echo SEARCH;?>')
{
document.getElementById('adv_s').value = ' ';
}
return true;
}
</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>