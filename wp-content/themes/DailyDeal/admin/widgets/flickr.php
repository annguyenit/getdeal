<?php
// =============================== Flickr widget ======================================
if(!class_exists('templ_flickr'))
{
	class templ_flickr extends WP_Widget {
		function templ_flickr() {
		//Constructor
			$widget_ops = array('classname' => 'widget flickr_photos ', 'description' => apply_filters('templ_flickr_widget_desc_filter','Enter your Flickr ID and you can see Flickr Photos') );
			$this->WP_Widget('widget_flickrwidget', apply_filters('templ_flickr_widget_title_filter','T &rarr; Flickr Photos'), $widget_ops);
		}
	
		function widget($args, $instance) {
			// prints the widget
			extract($args, EXTR_SKIP);
			echo $before_widget;
 			global $width;
			global $height;
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
			$number = empty($instance['number']) ? '6' : apply_filters('widget_number', $instance['number']);
			$height = empty($instance['height']) ? '70' : apply_filters('widget_height', $instance['height']);
			$width = empty($instance['width']) ? '70' : apply_filters('widget_width', $instance['width']);
	?>
   <script type="text/javascript"><!--
 function addcss(css){
    var head = document.getElementsByTagName('head')[0];
    var styleElement = document.createElement('style');
    styleElement.setAttribute('type', 'text/css');
    if (styleElement.styleSheet) {   // IE
        styleElement.styleSheet.cssText = css;
    } else {                // the world
        styleElement.appendChild(document.createTextNode(css));
    }
    head.appendChild(styleElement);
 }
addcss('.flickr_badge_image img { <?php if($width){ echo 'width:'.$width.'px;';}?> <?php if($height){ echo 'height:'.$height.'px;';}?>}');
//--></script>

 <!--<style type="text/css">
	.flickr_badge_image img { <?php if($width){ echo 'width:'.$width.'px;';}?> <?php if($height){ echo 'height:'.$height.'px;';}?>}
    </style> -->
	
	<div class="flickr">
	<?php if($title){?><h3 ><?php echo $title;?></h3><?php }?>
     <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
	</div>
    </div>
    
      	
	<?php
		}
	
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['id'] = strip_tags($new_instance['id']);
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['height'] = strip_tags($new_instance['height']);
			$instance['width'] = strip_tags($new_instance['width']);
			return $instance;	
		}
	
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array('title' => __('Flickr','templatic'),  'id' => '', 'number' => '6', 'height' => '70', 'width' => '70') );
			$title = strip_tags($instance['title']);
			$id = strip_tags($instance['id']);
			$number = strip_tags($instance['number']);
			$height = strip_tags($instance['height']);
			$width = strip_tags($instance['width']);
	?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT;?> (<?php _e('eg. : Flickr','templatic');?>):
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com">idGettr</a>)','templatic');?>:
		<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo attribute_escape($id); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('number'); ?>"><?php echo WID_NO_POST; ?>
		<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($number); ?>" />
	  </label>
	</p>
     <p>
	  <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Photo Width','templatic');?>:
		<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" />
	  </label>
	</p>
    <p>
	  <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Photo Height','templatic');?>:
		<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo attribute_escape($height); ?>" />
	  </label>
	</p>
	<?php
		}
	}
	register_widget('templ_flickr');
}
?>