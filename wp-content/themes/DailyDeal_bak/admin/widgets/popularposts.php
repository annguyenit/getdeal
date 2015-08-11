<?php
// =============================== Popular Posts Widget ======================================
if(!class_exists('templ_popularposts'))
{
	class templ_popularposts extends WP_Widget {
		function templ_popularposts() {
		//Constructor
			$widget_ops = array('classname' => 'widget popularposts', 'description' => apply_filters('templ_popularpost_widget_desc_filter','Popular Posts Widget') );		
			$this->WP_Widget('templ_popularposts', apply_filters('templ_popularpost_widget_title_filter','T &rarr; Popular Posts'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			?>						
        <div class="widget popular">
       <?php if($title){?> <h3><?php echo $title; ?></h3><?php }?>
        <ul>
        <?php
        global $wpdb;
        $now = gmdate("Y-m-d H:i:s",time());
        $lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
        $popularposts = "SELECT ID, post_title,post_date, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT $number";
        $posts = $wpdb->get_results($popularposts);
        $popular = '';
        if($posts){
            foreach($posts as $post){
                $post_title = stripslashes($post->post_title);
                   $guid = get_permalink($post->ID);
                   
                      $first_post_title=substr($post_title,0,26);
        ?>
        <li> <a href="<?php echo $guid; ?>" title="<?php echo $post_title; ?>"><?php echo $first_post_title; ?></a> <br />
        <span class="date"><?php echo get_the_time(templ_get_date_format(),$post) ?> at <?php echo get_the_time(templ_get_time_format(),$post) ?></span> 
        </li>
        <?php } } ?>
        </ul>
        </div>
				   
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = ($new_instance['number']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );		
			$title = strip_tags($instance['title']);
			$number = ($instance['number']);
		?>
		
        <p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT;?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		
		<p><label for="<?php  echo $this->get_field_id('number'); ?>"><?php echo WID_NO_POST;?> <input class="widefat" id="<?php  echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($number); ?>" /></label></p>
		
		<?php
	}}
	register_widget('templ_popularposts');
}
?>