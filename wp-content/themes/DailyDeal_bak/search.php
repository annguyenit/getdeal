<?php get_header(); ?>
<div id="pages" class="clear" >
<div  class="<?php templ_content_css();?>" >

 <div class="content-title">
           
           <?php ob_start(); // don't remove this code?>
  <?php if($_REQUEST['catdrop']) echo SEARCH_CATEGORY_TITLE; elseif($_REQUEST['todate'] || $_REQUEST['frmdate']) echo SEARCH_DATE_TITLE; elseif($_REQUEST['articleauthor']) echo SEARCH_AUTHOR_TITLE; else echo SEARCH_TITLE;?>
  "<?php the_search_query(); ?>"
  <?php
        $page_title = ob_get_contents(); // don't remove this code
		ob_end_clean(); // don't remove this code
		?>
  <?php echo templ_page_title_filter($page_title); //page tilte filter?> 
  
   
          
          </div>

<?php if ( have_posts() ) : ?>




<?php templ_page_title_above(); //page title above action hook?>

 
<?php get_template_part('loop'); ?>
<?php else : ?>

 
<div class="entry">
  <div class="single clear">
    <div class="post-content">
       		<?php get_search_form(); ?> 
            <p><?php echo SEARCH__RESULT_NOT_FOUND; ?></p>               
     </div>
  </div>
</div>
<?php endif; ?>
<?php get_template_part('pagination'); ?>


<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>