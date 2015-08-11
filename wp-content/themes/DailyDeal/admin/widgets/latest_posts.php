<?php
// ===============================  Latest Posts - widget ======================================
if(!class_exists('templ_latest_posts_with_images')){
	class templ_latest_posts_with_images extends WP_Widget {
	
		function templ_latest_posts_with_images() {
		//Constructor
		global $thumb_url;
			$widget_ops = array('classname' => 'widget special', 'description' => apply_filters('templ_latestpostwimg_widget_desc_filter','Post with image & date') );
			$this->WP_Widget('latest_posts_with_images',apply_filters('templ_latestpostwimg_widget_title_filter','T &rarr; Post with image & date'), $widget_ops);
		}
	 
		function widget($args, $instance) {
		// prints the widget
	
			extract($args, EXTR_SKIP);
	 
			echo $before_widget;
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
			$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			$post_type = empty($instance['post_type']) ? 'post' : apply_filters('widget_post_type', $instance['post_type']);
			 ?>
			
		 <?php if($title){?> <h3 class="i_publication"><?php echo $title; ?> </h3> <?php }?>
					<ul class="latest_posts"> 
			 <?php 
					global $post;
					if($category)
					{
						$arg = "&category=$category";	
					}
					$arg = "&post_type=$post_type";
					$today_special = get_posts('numberposts='.$number.$arg);
					foreach($today_special as $post) :
					setup_postdata($post);
					 ?>
			<?php $post_images = bdw_get_images($post->ID); ?>	
			<li>
         
        
         <?php 
            if(get_the_post_thumbnail( $post->ID)){?>
             <a  class="post_img"  href="<?php the_permalink(); ?>">
             <?php echo get_the_post_thumbnail( $post->ID, array(50,50),array('class'	=> "",));?>
             </a>
            <?php }elseif($post_images = bdw_get_images($post->ID)){ ?>
             <a  class="post_img" href="<?php the_permalink(); ?>">
             <img  src="<?php echo templ_thumbimage_filter(get_post_meta($post->ID,'file_name',true),50,50,1);?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" width="50" height="50"  /> </a>
            <?php
            }?>
					
            <h4> <a class="widget-title" href="<?php the_permalink(); ?>">
                  <?php the_title(); ?>
                  </a> <br />  <span class="post_author">by <?php the_author_posts_link(); ?> at <?php echo $post->post_date; ?>  / <?php comments_popup_link(__('No Comments','templatic'), __('1 Comment','templatic'), __('% Comments','templatic'), '', __('Comments Closed','templatic')); ?> </span></h4> 
                  
                  <p> <?php echo bm_better_excerpt(175, ''); ?> <a href="<?php the_permalink(); ?>"> <?php _e('more...','templatic');?> </a></p> 
        </li>
	<?php endforeach; ?>
				</ul>
		
	<?php
			echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['post_type'] = strip_tags($new_instance['post_type']);
			return $instance;
		}
	 
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
			$title = strip_tags($instance['title']);
			$category = strip_tags($instance['category']);
			$number = strip_tags($instance['number']);
			$post_type = strip_tags($instance['post_type']);
	?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
	
	<p>
	  <label for="<?php echo $this->get_field_id('number'); ?>"><?php echo WID_NO_POST; ?>
	  <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($number); ?>" />
	  </label>
	</p>
    <p>
<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php echo POST_TYPE_TEXT; ?>
<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
<?php
$custom_post_types_args = array();  
$custom_post_types = get_post_types($custom_post_types_args,'objects');   
foreach ($custom_post_types as $content_type) {
if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page'){
?>
<option value="<?php _e($content_type->name);?>" <?php if(attribute_escape($post_type)==$content_type->name){ echo 'selected="selected"';}?>><?php _e($content_type->label);?></option>
<?php }}?>
</select>
</label>
</p>
	<p>
	  <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo CATEGORY_ID_MSG;?>
	  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
	  </label>
	</p>
	<?php
		}
	}
	register_widget('templ_latest_posts_with_images');
}
?>