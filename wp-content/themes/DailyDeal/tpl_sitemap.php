<?php
/*
Template Name: Page - Sitemap
*/
?>
<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<!--  CONTENT AREA START -->

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="entry">
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
    <div class="post-meta">
      <h1><?php the_title(); ?></h1>
     </div>
    <div class="post-content">
    
    <?php the_content(); ?>
    
       
      <div class="arclist">
		<div class="arclist_head">
 			<h4><?php echo POST_TEXT;?></h4>
		</div>
        <ul class="sitemap_list">
          <?php $archive_query = new WP_Query('showposts=60');
            while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <?php the_title(); ?>
            </a> <span class="arclist_comment">
            <?php comments_number(__('0 comment','templatic'), __('1 comment','templatic'),__('% comments','templatic')); ?>
            </span></li>
          <?php endwhile; ?>
        </ul>
		<div class="arclist_head">
			<h4><?php echo PAGES_TEXT;?></h4>
		</div>
        <ul class="sitemap_list"><?php wp_list_pages('title_li='); ?></ul>
      </div>
      <!--/arclist -->
      <div class="arclist">
		<div class="arclist_head">
 			<h4><?php echo ARCHIVE_TEXT;?></h4>
		</div>
        <ul class="sitemap_list"><?php wp_get_archives('type=monthly'); ?></ul>
        
        <div class="arclist_head">
           <h4><?php echo CATEGORY_TEXT;?></h4>
		</div>
        <ul class="sitemap_list"><?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?></ul>
        <div class="arclist_head">
 			<h4><?php echo META_TEXT;?></h4>
		</div>
        <ul class="sitemap_list">
          <li><a href="<?php bloginfo('rdf_url'); ?>" title="RDF/RSS 1.0 feed">
          <?php echo RDF_TEXT;?> <?php _e('1.0 feed','templatic')?></a></li>
          <li><a href="<?php bloginfo('rss_url'); ?>" title="RSS 0.92 feed"><?php _e('RSS','templatic')?> <?php _e('0.92 feed','templatic')?></a></li>
          <li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS 2.0 feed"><?php _e('RSS','templatic')?><?php _e('2.0 feed','templatic')?></a></li>
          <li><a href="<?php bloginfo('atom_url'); ?>" title="Atom feed"><?php _e('Atom feed','templatic')?></a></li>
        </ul>
      </div>
        
    </div>
   
  </div>
</div>
<?php endwhile; ?>
<?php endif; ?>
<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>