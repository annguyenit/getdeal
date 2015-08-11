<?php
// =============================== My Bio ======================================
if(!class_exists('templ_my_bio'))
{
	class templ_my_bio extends WP_Widget {
		function templ_my_bio() {
		//Constructor
			$widget_ops = array('classname' => 'widget my_biography', 'description' => apply_filters('templ_bio_widget_desc_filter','Enter your Biography Information') );		
			$this->WP_Widget('widget_templ_my_bio', apply_filters('templ_bio_widget_title_filter','T &rarr; My Biography'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$photo = empty($instance['photo']) ? '' : apply_filters('widget_photo', $instance['photo']);
			$sort_desc = empty($instance['sort_desc']) ? '' : apply_filters('widget_sort_desc', $instance['sort_desc']);
			$desc = empty($instance['desc']) ? '' : apply_filters('widget_desc', $instance['desc']);
			$more_text = empty($instance['more_text']) ? '' : apply_filters('widget_more_text', $instance['more_text']);
			$more_link = empty($instance['more_link']) ? '' : apply_filters('widget_more_link', $instance['more_link']);
			?>						
		   <div class="widget my_bio clearfix">
		  <?php if($title){?> <h3 class="i_bio"><?php echo $title; ?> </h3><?php }?>
			  <?php if ( $photo <> "" ) { ?>	 
				 <div class="photo"><img src="<?php echo $photo; ?>" alt=""  /></div>  
			<?php } ?>
			 <?php if ( $sort_desc <> "" ) { ?>	
			<p class="highlight"><?php echo $sort_desc; ?> </p>
			<?php } 
			echo $desc; 
			if ( $more_text <> "" ) { ?>
			<a href="<?php echo $more_link; ?> " class="b_readmore fr" ><?php echo $more_text; ?> </a>  
			<?php } ?>
			</div>        
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['photo'] = ($new_instance['photo']);
			$instance['sort_desc'] = ($new_instance['sort_desc']);
			$instance['desc'] = ($new_instance['desc']);
			$instance['more_text'] = ($new_instance['more_text']);
			$instance['more_link'] = ($new_instance['more_link']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'photo' => '', 'sort_desc' => '', 'desc' => '','more_text' => '','more_link' => '') );		
			$title = strip_tags($instance['title']);
			$photo = ($instance['photo']);
			$sort_desc = ($instance['sort_desc']);
			$desc = ($instance['desc']);
			$more_text = ($instance['more_text']);
			$more_link = ($instance['more_link']);
		?>
		<p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		
		<p><label for="<?php  echo $this->get_field_id('photo'); ?>"><?php _e('Author Photo (ex.http://templatic.com/photo.png)','templatic');?> <input class="widefat" id="<?php  echo $this->get_field_id('photo'); ?>" name="<?php echo $this->get_field_name('photo'); ?>" type="text" value="<?php echo attribute_escape($photo); ?>" /></label></p>
		 
		<p><label for="<?php echo $this->get_field_id('sort_desc'); ?>"><?php _e('Short Description','templatic');?> : <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sort_desc'); ?>" name="<?php echo $this->get_field_name('sort_desc'); ?>"><?php echo attribute_escape($sort_desc); ?></textarea></label></p>
		
		<p><label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Description :  (html tag use ex.&lt;p&gt;text &lt;/p&gt;)','templatic');?> <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo attribute_escape($desc); ?></textarea></label></p>
		
		<p><label for="<?php  echo $this->get_field_id('more_text'); ?>"><?php _e('Read More Text','templatic');?> <input class="widefat" id="<?php  echo $this->get_field_id('more_text'); ?>" name="<?php echo $this->get_field_name('more_text'); ?>" type="text" value="<?php echo attribute_escape($more_text); ?>" /></label></p>
        
		<p><label for="<?php  echo $this->get_field_id('more_link'); ?>"><?php _e('Read More Link URL (ex.http://templatic.com/mybio)','templatic');?> <input class="widefat" id="<?php  echo $this->get_field_id('more_link'); ?>" name="<?php echo $this->get_field_name('more_link'); ?>" type="text" value="<?php echo attribute_escape($more_link); ?>" /></label></p>
		<?php
	}}
	register_widget('templ_my_bio');
}
?>