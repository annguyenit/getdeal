<?php global $transection_db_table_name, $wpdb;?>

<?php if ( have_posts() ) :   $destination_path = site_url().'/wp-content/uploads/'; 
global $mode;
?>

    <div id="loop" class="<?php if (get_option('ptttheme_view_opt') == 'Grid View') {  echo 'grid'; }else{ echo 'list clear'; } ?> ">

    <?php 
	$pcount=0; 
	while ( have_posts() ) : the_post(); 
	$pcount++;
	?>

        <div <?php post_class('post clear blog_post'); ?> id="post_<?php the_ID(); ?>">

					<div class="product_left">
					<?php if($post->post_type == CUSTOM_POST_TYPE1){
							if(get_post_meta($post->ID,'file_name',true) != "") { ?>
								<img src="<?php echo templ_thumbimage_filter(get_post_meta($post->ID,'file_name',true),165,180);?>" width="165" height="180" alt="" />
					<?php } else{ ?>
								<img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="165" height="180" alt="" />
					<?php } } else {
							display_deal_image($post->ID,'165','180') ;
					}?></div>

                <div class="product_right with_img">
						<?php
						$our_price= get_post_meta($post->ID,'our_price',true);
						$current_price= get_post_meta($post->ID,'current_price',true);
						$sellsql = "select count(*) from $transection_db_table_name where post_id=".$post->ID." and status=1";
						$sellsqlinfo = $wpdb->get_var($sellsql);
						$totdiff = $current_price - $our_price;
						$percent = $totdiff * 100;
						if($percent>0)
						{
							$percentsave = $percent/$current_price;
						}
						?>
					<?php if(get_option('ptthemes_listing_date')=='yes' || get_option('ptthemes_listing_date')==''){?>
                    <!--<span class="title_yellow"><?php //the_time(__('F jS, Y','templatic')) ?>  </span>-->
                     <?php } ?>
                     
                     
                     
                     <?php if(get_option('ptthemes_listing_author')=='yes' || get_option('ptthemes_listing_author')==''){?> 
                   	 <?php } ?>                    
                    
                    
                    
                    <?php if ( has_post_format( 'chat' )){?>
				<h3><a href="<?php the_permalink() ?>">
				  <?php the_title(); ?>
				  </a></h3>
				 <?php }elseif(has_post_format( 'gallery' )){?>
				  <h3><a href="<?php the_permalink() ?>">
				  <?php the_title(); ?>
				  </a></h3>
				 <?php }elseif(has_post_format( 'image' )){?>
				   <h3><a href="<?php the_permalink() ?>">
				  <?php the_title(); ?>
				  </a></h3>
				 <?php }elseif(has_post_format( 'link' )){?>
				   <h3><a href="<?php the_permalink() ?>">
				  <?php the_title(); ?>
				  </a></h3>
				 <?php }elseif(has_post_format( 'video' )){?>
				   <h3><a href="<?php the_permalink() ?>">
				  <?php the_title(); ?>
				  </a></h3>
				 <?php }elseif(has_post_format( 'audio' )){?>
				   <h3><a href="<?php the_permalink() ?>">
				  <?php the_title(); ?>
				  </a></h3>
				   <?php }else{?>
				   <h3><a href="<?php the_permalink() ?>">
				  <?php the_title(); ?>
				  </a></h3>
				   <?php }?> 
                     
                      <?php if(templ_is_show_post_category()){
						  if(the_taxonomies()) {?>
					  <div class="post_cats clearfix"> 
                       <?php the_taxonomies(array('before'=>'<span class="categories">','sep'=>'</span><span class="tags">','after'=>'</span>')); ?> 
                       </div>
                     <?php } } ?>
                                                  
                    <p class="content_text"><?php templ_get_listing_content()?> </p>
                     
                </div>
            
        </div>
        
        <?php 
		$page_layout = templ_get_page_layout();
		if($page_layout=='full_width'){
					if($pcount==3){
					$pcount=0; 
					?>
                 		<div class="hr clearfix"></div>
                <?php } 
				}
				else if ($pcount==2 || $mode == 'grid' || $mode == ''){
					$pcount=0; 
					?>
                <div class="hr clear"></div>
                <?php }?>

    <?php endwhile; ?>
    
    	</div>

<?php endif; ?>
