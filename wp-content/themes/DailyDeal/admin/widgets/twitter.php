<?php
// ============== Twitter widget ======================================
if(!class_exists('templ_twitter'))
{
	class templ_twitter extends WP_Widget {
		function templ_twitter() {
		//Constructor
			$widget_ops = array('classname' => 'twitter', 'description' => apply_filters('templ_twitter_widget_desc_filter',__('Enter your Twitter login ID and it will show latest tweet at your site. One time use per page.','templatic')) );
			$this->WP_Widget('widget_twidget', apply_filters('templ_twitter_widget_title_filter',__('T &rarr; Twitter Feed','templatic')), $widget_ops);
		}
	
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			echo $before_widget;
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$account = empty($instance['account']) ? '' : apply_filters('widget_account', $instance['account']);
			$show = empty($instance['show']) ? '3' : apply_filters('widget_show', $instance['show']);
			$follow = empty($instance['follow']) ? '#' : apply_filters('widget_follow', $instance['follow']);
			$follow_text = empty($instance['follow_text']) ? '' : apply_filters('widget_follow_text', $instance['follow_text']);
			?>
			<?php if($title){?><div id="twitter"> <h3 class="i_twitter"><?php echo $title;?></h3><?php }?>
            <ul id="twitter_update_list"><li></li></ul>
           <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
            <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $account;?>.json?callback=twitterCallback2&amp;count=<?php echo $show;?>"></script>
            
            <?php if($follow_text){?>
            <a href="http://www.twitter.com/<?php echo $account;?>/" title="<?php echo $follow;?>" class="b_twitter fr" target="_blank"><?php echo $follow_text;?> </a>
            <?php }?></div></div>
		<?php
		}
	
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['account'] = strip_tags($new_instance['account']);
			$instance['follow'] = strip_tags($new_instance['follow']);
			$instance['show'] = strip_tags($new_instance['show']);
			$instance['follow_text'] = strip_tags($new_instance['follow_text']);
			return $instance;
	
		}
	
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array('account'=>'', 'title'=>__('Live Tweet','templatic'), 'show'=>'3' ) );
			$title = strip_tags($instance['title']);
			$show = strip_tags($instance['show']);
			$follow = strip_tags($instance['follow']);
			$account = strip_tags($instance['account']);
			$follow_text = strip_tags($instance['follow_text']);
	?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php  _e('Title','templatic')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
          </label>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('account'); ?>"><?php  _e('Twitter Account ID','templatic')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('account'); ?>" name="<?php echo $this->get_field_name('account'); ?>" type="text" value="<?php echo attribute_escape($account); ?>" />
          </label>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('show'); ?>"><?php  _e('Show Twitter Posts','templatic')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('show'); ?>" name="<?php echo $this->get_field_name('show'); ?>" type="text" value="<?php echo attribute_escape($show); ?>" />
          </label>
        </p>	
        <p>
          <label for="<?php echo $this->get_field_id('follow_text'); ?>"><?php  _e('Twitter Button Text','templatic')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('follow_text'); ?>" name="<?php echo $this->get_field_name('follow_text'); ?>" type="text" value="<?php echo attribute_escape($follow_text); ?>" />
          </label>
        </p>
        <p><?php _e('You should user this widget <b>once on the page</b>. As it will not display tweet for more than one ID.');?></p>
	<?php
		}
	
	}
	register_widget('templ_twitter');
}
?>