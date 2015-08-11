<?php get_header(); ?>

<?php if ( get_option('ptthemes_breadcrumbs' )) {  ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><?php yoast_breadcrumb('','404 error!');  ?></div>
    </div>
<?php } ?>
<div class="content content_full">
<!--  CONTENT AREA START -->

<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('page_content_above'); }?>

<div class="content-title"> <?php echo templ_page_title_filter(__("Oh, Oh. Deze pagina kunnen we helaas niet vinden.",'templatic')); //page tilte filter?> </div>
<div class="entry">
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
    <div class="post-content page_404_set">
      <p>
        <?php echo PAGE_ERROR_MSG;?>
      </p>
      
      			
                
                <div class="error_404">
                	<div class="head_error"> 404 Error! </div>
                   <p> <?php echo DETAIL_ERROR_MSG; ?></p>
               
             
                 </div>   
				 <div class="two_thirds  left ">
                		
                        <div class="search">
				<form method="get" id="searchform2" action="<?php bloginfo('url'); ?>">
					<fieldset>
						<input name="s" type="text" onfocus="if(this.value=='<?php echo SEARCH_TEXT;?>') this.value='';" onblur="if(this.value=='') this.value='<?php echo SEARCH_TEXT; ?>';" value="<?php echo SEARCH_TEXT; ?>" />
						<button type="submit"></button>
					</fieldset>
				</form>
			</div>
            </div> 
               <div class="spacer_404"></div>
               <div class="one_third_column left">
                
                	 
                    <h3><?php echo PAGES_TEXT;?></h3>
                    <ul>
                      <?php wp_list_pages('title_li='); ?>
                    </ul>
                </div> 
                <div class="one_third_column left">
                 
           <h3><?php _e('Posts','templatic');?></h3>
        <ul>
          <?php $archive_query = new WP_Query('showposts=60');
            while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <?php the_title(); ?>
            </a> <span class="arclist_comment">
            <?php comments_number(__('0 comment','templatic'), __('1 comment','templatic'),__('% comments','templatic')); ?>
            </span></li>
          <?php endwhile; ?>
        </ul>
	</div> 
                
                
            <div class="one_third_column_last right">
					<h3><?php echo CATEGORY_TEXT;?></h3>
                        <ul>
                          <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
                        </ul>
                <h3><?php echo ARCHIVE_TEXT;?></h3>
            <ul>
                  <?php wp_get_archives('type=monthly'); ?>
            </ul>
        </div>
    </div>
  </div>
</div>
<!--  CONTENT AREA END -->
</div>
<?php get_footer(); ?>