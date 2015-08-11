<?php
// =============================== Connect Widget ======================================
class social_media extends WP_Widget {
	function social_media() {
	//Constructor
		$widget_ops = array('classname' => 'widget Social Media', 'description' => apply_filters('templ_socialmedia_widget_desc_filter','Social Media') );		
		$this->WP_Widget('social_media', apply_filters('templ_socialmedia_widget_title_filter','T &rarr; Social Media'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$twitter = empty($instance['twitter']) ? '' : apply_filters('widget_twitter', $instance['twitter']);
		$facebook = empty($instance['facebook']) ? '' : apply_filters('widget_facebook', $instance['facebook']);
		$digg = empty($instance['digg']) ? '' : apply_filters('widget_digg', $instance['digg']);
		$linkedin = empty($instance['linkedin']) ? '' : apply_filters('widget_linkedin', $instance['linkedin']);
		$myspace = empty($instance['myspace']) ? '' : apply_filters('widget_myspace', $instance['myspace']);
		$rss = empty($instance['rss']) ? '' : apply_filters('widget_rss', $instance['rss']);
		 ?>						

		<div class="widget social_media">
      		<h3> <?php echo $title; ?> </h3>
       
       <ul>
       	<?php if ( $twitter <> "" ) { ?>	
        	<li><a href="<?php echo $twitter; ?>" > <img src="<?php echo TT_WIDGETS_FOLDER_URL;?>widget_images/i_twitter.png" alt=""  /> </a>  </li>
         <?php } ?>
         	<?php if ( $facebook <> "" ) { ?>	
        	<li> <a href="<?php echo $facebook; ?>" > <img src="<?php echo TT_WIDGETS_FOLDER_URL;?>widget_images/i_facebook.png" alt=""  /> </a> </li>
         <?php } ?>
         	<?php if ( $digg <> "" ) { ?>	
        	<li>  <a href="<?php echo $digg; ?>" > <img src="<?php echo TT_WIDGETS_FOLDER_URL;?>widget_images/i_digg.png" alt=""  /> </a> </li>
         <?php } ?>
         	<?php if ( $linkedin <> "" ) { ?>	
        	<li> <a href="<?php echo $linkedin; ?>" > <img src="<?php echo TT_WIDGETS_FOLDER_URL;?>widget_images/i_linkedin.png" alt=""  /> </a>   </li>
         <?php } ?>
         	<?php if ( $myspace <> "" ) { ?>	
        	<li> <a href="<?php echo $myspace; ?>" > <img src="<?php echo TT_WIDGETS_FOLDER_URL;?>widget_images/i_myspace.png" alt=""  /> </a>  </li>
         <?php } ?>
         	<?php if ( $rss <> "" ) { ?>	
        	<li> <a href="<?php echo $rss; ?>" > <img src="<?php echo TT_WIDGETS_FOLDER_URL;?>widget_images/i_rss.png" alt=""  /> </a>  </li>
         <?php } ?>
		</ul>
        
        
        </div> <!-- widget #end -->
            
            
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter'] = ($new_instance['twitter']);
		$instance['facebook'] = ($new_instance['facebook']);
		$instance['digg'] = ($new_instance['digg']);
		$instance['linkedin'] = ($new_instance['linkedin']);
		$instance['myspace'] = ($new_instance['myspace']);
		$instance['rss'] = ($new_instance['rss']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'twitter' => '', 'facebook' => '', 'digg' => '',  'linkedin' => '', 'myspace' => '','rss' => '' ) );		
		$title = strip_tags($instance['title']);
		$twitter = ($instance['twitter']);
		$facebook = ($instance['facebook']);
		$digg = ($instance['digg']);
		$linkedin = ($instance['linkedin']);		
		$myspace = ($instance['myspace']);
		$rss = ($instance['rss']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter Full URL','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo attribute_escape($twitter); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook Full URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo attribute_escape($facebook); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('digg'); ?>"><?php _e('Digg Full URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('digg'); ?>" name="<?php echo $this->get_field_name('digg'); ?>" type="text" value="<?php echo attribute_escape($digg); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin Full URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo attribute_escape($linkedin); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('myspace'); ?>"><?php _e('Myspace Full URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('myspace'); ?>" name="<?php echo $this->get_field_name('myspace'); ?>" type="text" value="<?php echo attribute_escape($myspace); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('Rss Full URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo attribute_escape($rss); ?>" /></label></p>

<?php
	}}
register_widget('social_media');
?>