<?php
// =============================== Advertisement ======================================
if(!class_exists('templ_ads')){
	class templ_ads extends WP_Widget {
		function templ_ads() {
		//Constructor
			$widget_ops = array('classname' => 'widget advertisement', 'description' => apply_filters('templ_ads_widget_desc_filter','Advertisement Banner, google ads, video embed code, etc...') );		
			$this->WP_Widget('widget_ads',apply_filters('templ_ads_widget_title_filter','T &rarr; Advertisement'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$ads = empty($instance['ads']) ? '' : apply_filters('widget_ads', $instance['ads']);
			?>						
		   <div class="widget advt_widget">
				<?php if ( $title <> "" ) { ?><h3><?php echo $title; ?> </h3> <?php } ?>
				<?php echo $ads; ?> 
			</div>        
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['ads'] = ($new_instance['ads']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'ads' => '') );		
			$title = strip_tags($instance['title']);
			$ads = ($instance['ads']);
	?>
	<p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT;?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>     
	<p><label for="<?php echo $this->get_field_id('ads'); ?>"><?php _e('Advertisement (ex.&lt;a href="#"&gt;&lt;img src="http://templatic.com/banner.png" /&gt;&lt;/a&gt; and google ads code here )','templatic');?>: <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('ads'); ?>" name="<?php echo $this->get_field_name('ads'); ?>"><?php echo attribute_escape($ads); ?></textarea></label></p>
	<?php
	}}
	register_widget('templ_ads');
}
?>