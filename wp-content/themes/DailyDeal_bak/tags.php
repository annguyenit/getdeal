<?php 
get_header();
?>

<div  class="<?php templ_content_css();?>" >
<!--  CONTENT AREA START -->

    <?php templ_page_title_above(); //page title above action hook?>
    
    <div class="content-title">
      <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
      <?php /* If this is a category archive */ if (is_category()) { ?>
      <?php $ptitle=sprintf(__('%s','templatic'), single_cat_title('', false)); ?>
      <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
      <?php $ptitle=sprintf(__('Posts tagged &quot;%s&quot;','templatic'), single_tag_title('', false) ); ?>
      <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
      <?php $ptitle=sprintf(__('Daily archive %s','templatic'), get_the_time(templ_get_date_format())); ?>
      <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
      <?php $ptitle=sprintf(__('Monthly archive %s','templatic'), get_the_time('F, Y')); ?>
      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
      <?php $ptitle=sprintf(__('Yearly archive %s','templatic'), get_the_time('Y')); ?>
      <?php /* If this is an author archive */ } elseif (is_author()) { ?>
      <?php $ptitle= __('Author Archive','templatic'); ?>
      <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
        <?php $ptitle=__('Blog Archives','templatic'); ?>
		 <?php /* If this is a seller archive */ } elseif (isset($_GET['paged']) && !empty($_GET['seller'])) { ?>
        <?php $ptitle=__('Seller Archives','templatic'); ?>
        <?php } ?>
      <?php echo templ_page_title_filter($ptitle); //page tilte filter?> 
     
      
      </div>
    <?php templ_page_title_below(); //page title below action hook?>
    
    
    
    
    <?php get_template_part('loop'); ?>
    <?php get_template_part('pagination'); ?>

<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
