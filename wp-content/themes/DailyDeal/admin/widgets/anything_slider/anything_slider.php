<?php
// =============================== Any thing Slider  - Widget  ======================================
include_once(TT_WIDGET_FOLDER_PATH.'anything_slider/custom_post_type_slider/custom_post_type_slider_lang.php');
include_once(TT_WIDGET_FOLDER_PATH.'anything_slider/custom_post_type_slider/custom_post_type_slider.php');
if(!class_exists('templ_anything_slider')){
class templ_anything_slider extends WP_Widget {
	function templ_anything_slider() {
		$widget_ops = array('classname' => 'widget anything_slider','description' =>  apply_filters('templ_anything_slider_widget_desc_filter','Any thing Slider Widget'));
		$this->WP_Widget('anything_slider', apply_filters('templ_anything_slider_widget_title_filter','T &rarr; Any thing Slider'), $widget_ops);
	}
 
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$sliderposttype = empty($instance['sliderposttype']) ? '' : apply_filters('widget_sliderposttype', $instance['sliderposttype']);
		$numberpost = empty($instance['numberpost']) ? '' : apply_filters('widget_numberpost', $instance['numberpost']);
		$delay = empty($instance['delay']) ? '3000' : apply_filters('widget_delay', $instance['delay']);
		$animationTime = empty($instance['animationTime']) ? '600' : apply_filters('widget_animationTime', $instance['animationTime']);
		$height = empty($instance['height']) ? '388' : apply_filters('widget_height', $instance['height']);
		
 ?>

<script type="text/javascript" src="<?php echo TT_WIDGET_JS_FOLDER_URL; ?>jquery_slider2.js"></script>
<script src="<?php echo TT_WIDGET_JS_FOLDER_URL; ?>jquery_slider2plus.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
 var $anytsl = jQuery;
function formatText(index, panel) {
  return index + "";
}
$anytsl(function () {

    $anytsl('.tslider3').anythingSlider({
        easing: "easeInOutExpo",        // Anything other than "linear" or "swing" requires the easing plugin
        autoPlay: true,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not.
        delay: <?php if (($delay) <> "" ) { echo (($delay)); } else { echo '3000'; } ?>,                    // How long between slide transitions in AutoPlay mode
        startStopped:false,            // If autoPlay is on, this can force it to start stopped
        animationTime: <?php if (($animationTime) <> "" ) { echo (($animationTime)); } else { echo '600'; } ?>,             // How long the slide transition takes
        hashTags: true,                 // Should links change the hashtag in the URL?
        buildNavigation: true,          // If true, builds and list of anchor links to link to each slide
        pauseOnHover: true,             // If true, and autoPlay is enabled, the show will pause on hover
        startText: "Go",             // Start text
        stopText: "Stop",               // Stop text
        navigationFormatter: formatText       // Details at the top of the file on this use (advanced use)
    });
    
    $anytsl("#slide-jump").click(function(){
        $anytsl('.tslider3').anythingSlider(6);
    });
    
});
</script> 

          <div id="any_slider">
                 <div class="tslider3 ">
             <div class="wrapper clearfix" style="height:<?php if (($height) <> "" ) { echo (($height)); } else { echo '388'; } ?>px !important;">
                <ul> 
<?php 
$pquery .= "&post_type=".CUSTOM_POST_TYPE2;
global $post;

$today_special = apply_filters('templ_anything_slider_widget_postsobj_filter',get_posts('numberposts='.$numberpost.$pquery.''));
foreach($today_special as $post) :
if($post){
setup_postdata($post);
?>
<li>
<?php
$custom_design = apply_filters('templ_anything_slider_widget_content_filter',$post);
if(is_object($custom_design))
{
	echo templ_anything_slider_class_fun($post);
}else
{
	echo $custom_design;	
}
?>
</li>
<?php }?>
<?php endforeach; ?>
			</ul>
		</div>
      </div>
 </div>
<?php
		echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['sliderposttype'] = strip_tags($new_instance['sliderposttype']);
		$instance['numberpost'] = strip_tags($new_instance['numberpost']);
		$instance['delay'] = strip_tags($new_instance['delay']);
		$instance['animationTime'] = strip_tags($new_instance['animationTime']);
		$instance['height'] = strip_tags($new_instance['height']);
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'sliderposttype' => '','numberpost' => '', 'category' => '', 'post_number' => '','delay' => '','animationTime' => '','height' => '' ) );
		$sliderposttype = strip_tags($instance['sliderposttype']);
		$numberpost = strip_tags($instance['numberpost']);
		$delay = strip_tags($instance['delay']);
		$animationTime = strip_tags($instance['animationTime']);
		$height = strip_tags($instance['height']);
		
?>


<p>
  <label for="<?php echo $this->get_field_id('numberpost'); ?>"><?php echo WID_NO_POST; ?>
  <input class="widefat" id="<?php echo $this->get_field_id('numberpost'); ?>" name="<?php echo $this->get_field_name('numberpost'); ?>" type="text" value="<?php echo attribute_escape($numberpost); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('delay'); ?>"><?php echo WID_SLIDER_TIME; ?>
  <input class="widefat" id="<?php echo $this->get_field_id('delay'); ?>" name="<?php echo $this->get_field_name('delay'); ?>" type="text" value="<?php echo attribute_escape($delay); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('animationTime'); ?>"><?php echo WID_SLIDER_ANIMATION_TIME; ?>
  <input class="widefat" id="<?php echo $this->get_field_id('animationTime'); ?>" name="<?php echo $this->get_field_name('animationTime'); ?>" type="text" value="<?php echo attribute_escape($animationTime); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('height'); ?>"><?php echo WID_SLIDER_SIZE_OPT; ?>
  <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo attribute_escape($height); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('templ_anything_slider');
}

function templ_anything_slider_class_fun($post)
{
	ob_start(); // don't remove this code
/////////////////////////////////////////////////////
	if(get_the_post_thumbnail( $post->ID, array())){
	?>
	<a class="post_img" href="<?php echo get_permalink($post->ID);?>"><?php echo  get_the_post_thumbnail( $post->ID, array(220,220),array('class'	=> "",));?></a>
	<?php
    }else if($post_images = bdw_get_images($post->ID,'large')){ 
	global $thumb_url;

		$crop_image = vt_resize( '', $post_images[0], 220, 220, $crop = true );
		$imgurl = $crop_image['url'];
    ?>
	<a class="post_img" href="<?php echo get_permalink($post->ID); ?>"><img src="<?php echo $imgurl; ?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>" /></a>
 
	<?php } ?>
    <div class="tslider3_content">
    <h3> <a class="widget-title" href="<?php echo get_permalink($post->ID);?>"><?php echo get_the_title($post->ID);?></a></h3>
    <p><?php echo bm_better_excerpt(605, ' ... ');?></p>
    <p><a href="<?php echo get_permalink($post->ID);?>" class="more"><?php _e('Read More','templatic')?></a></p>
   </div>
<?php
/////////////////////////////////////////////////////
	$return = ob_get_contents(); // don't remove this code
	ob_end_clean(); // don't remove this code
	return  $return;
}
?>