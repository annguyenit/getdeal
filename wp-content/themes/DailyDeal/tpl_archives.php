<?php
/*
Template Name: Page - Archives
*/
?>
<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<!--  CONTENT AREA START -->

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php $post_images = bdw_get_images($post->ID,'large'); ?>

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
      
      
      <?php
         $years = $wpdb->get_results("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) as year
		FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post'   ORDER BY post_date DESC");
	if($years)
		{
			foreach($years as $years_obj)
			{
				$year = $years_obj->year;	
				$month = $years_obj->month;
				?>
                <?php query_posts("showposts=1000&year=$year&monthnum=$month"); ?>
           
         	<div class="arclist">  
                  <div class="arclist_head">
                   <h3><?php echo $year; ?>  </h3>
                   <h4> <?php echo  date('F', mktime(0,0,0,$month,1)); ?>  </h4>
           		 </div>
                 
           <ul >
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        
          <li>  <a href="<?php the_permalink() ?>">
            <?php the_title(); ?>
            </a> <br />
            
            <span class="arclist_date">  <?php echo BY;?>  
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="Posts by <?php the_author(); ?>"><?php the_author(); ?></a>
            <?php echo ON;?>
             <?php the_time(__('M j, Y')) ?> // <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments'), '', __('Comments Closed')); ?>
            </span>
           
           
            </li> 
          <?php endwhile; endif; ?> </ul></div>
                <?php
			}
		}
		 ?>
         
         
    </div>
  </div>
</div>



<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>