<?php
// =============================== Testimonials  Widget======================================
class templ_testimonials_widget extends WP_Widget {
	function templ_testimonials_widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget testimonials', 'description' => apply_filters('templ_testimonial_widget_desc_filter','Testimonials Widget') );		
		$this->WP_Widget('testimonials_widget',apply_filters('templ_testimonial_widget_title_filter','T &rarr; Testimonials'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$fadin = empty($instance['fadin']) ? '1000' : apply_filters('widget_fadin', $instance['fadin']);
		$fadout = empty($instance['fadout']) ? '5000' : apply_filters('widget_fadout', $instance['fadout']);
		$author1 = empty($instance['author1']) ? '' : apply_filters('widget_author1', $instance['author1']);
		$quotetext1 = empty($instance['quotetext1']) ? '' : apply_filters('widget_quotetext1', $instance['quotetext1']);
		$author2 = empty($instance['author2']) ? '' : apply_filters('widget_author2', $instance['author2']);
		$quotetext2 = empty($instance['quotetext2']) ? '' : apply_filters('widget_quotetext2', $instance['quotetext2']);
		$author3 = empty($instance['author3']) ? '' : apply_filters('widget_author3', $instance['author3']);
		$quotetext3 = empty($instance['quotetext3']) ? '' : apply_filters('widget_quotetext3', $instance['quotetext3']);
		$author4 = empty($instance['author4']) ? '' : apply_filters('widget_author4', $instance['author4']);
		$quotetext4 = empty($instance['quotetext4']) ? '' : apply_filters('widget_quotetext4', $instance['quotetext4']);
		$author5 = empty($instance['author5']) ? '' : apply_filters('widget_author5', $instance['author5']);
		$quotetext5 = empty($instance['quotetext5']) ? '' : apply_filters('widget_quotetext5', $instance['quotetext5']);
		 ?>						
 
<?php if($quotetext1 || $quotetext2 || $quotetext3 || $quotetext4 || $quotetext5){?>

<script type="text/javascript">
var $tc = jQuery.noConflict();
function slideSwitch() {
    var $active = $tc('#testimonials blockquote.active');

    if ( $active.length == 0 ) $active = $('#testimonials blockquote:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : $tc('#testimonials blockquote:first');

    // uncomment the 3 lines below to pull the images in random order
    // var $sibs  = $active.siblings();
    // var rndNum = Math.floor(Math.random() * $sibs.length );
    // var $next  = $( $sibs[ rndNum ] );


    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, <?php echo $fadin;?>, function() {
            $active.removeClass('active last-active');
        });
}
$tc(function() {
    setInterval( "slideSwitch()", <?php echo $fadout;?> );
});

</script>



<?php }?>
	<div class="widget">
		 
  		<?php if($title){?><h3 class="i_testimonials"><?php echo $title; ?> </h3><?php }?>        
         
         <div id="testimonials">
         <?php if ( $quotetext1 <> "" ) { ?>	
         	<blockquote class="active">
                  <p><span></span> <?php echo $quotetext1; ?>  </p>
              <?php if($author1){?> <cite> - <?php echo $author1; ?></cite><?php }?>
            </blockquote>
         <?php } ?>
        
        <?php if ( $quotetext2 <> "" ) { ?>	 
        	<blockquote>
                  <p><span></span> <?php echo $quotetext2; ?>  </p>
              <?php if($author2){?> <cite> - <?php echo $author2; ?></cite><?php }?>
            </blockquote>
         
        <?php } ?>
        
        <?php if ( $quotetext3 <> "" ) { ?>	
         	<blockquote>
                  <p><span></span> <?php echo $quotetext3; ?>  </p>
               <?php if($author3){?><cite> - <?php echo $author3; ?></cite><?php }?>
            </blockquote>
         <?php } ?>
        
        <?php if ( $quotetext4 <> "" ) { ?>	
         	<blockquote>
                  <p><span></span> <?php echo $quotetext4; ?>  </p>
              <?php if($author4){?> <cite> - <?php echo $author4; ?></cite><?php }?>
            </blockquote>
         <?php } ?>
        
        <?php if ( $quotetext5 <> "" ) { ?>	
         	<blockquote>
                  <p><span></span> <?php echo $quotetext5; ?>  </p>
               <?php if($author4){?><cite> - <?php echo $author5; ?></cite><?php }?>
            </blockquote>
      <?php } ?>
        
     </div>
   </div>         
		 
             
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['fadin'] = ($new_instance['fadin']);
		$instance['fadout'] = ($new_instance['fadout']);
		
		$instance['author1'] = ($new_instance['author1']);
		$instance['quotetext1'] = ($new_instance['quotetext1']);
		$instance['author2'] = ($new_instance['author2']);
		$instance['quotetext2'] = ($new_instance['quotetext2']);
		$instance['author3'] = ($new_instance['author3']);
		$instance['quotetext3'] = ($new_instance['quotetext3']);
		$instance['author4'] = ($new_instance['author4']);
		$instance['quotetext4'] = ($new_instance['quotetext4']);
		$instance['author5'] = ($new_instance['author5']);
		$instance['quotetext5'] = ($new_instance['quotetext5']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'author1' => '', 'author2' => '', 'author3' => '',  'author4' => '', 'author5' => '','quotetext1' => '','quotetext2' => '','quotetext3' => '','quotetext4' => '','quotetext5' => '','fadin' => '','fadout' => '' ) );		
		$title = strip_tags($instance['title']);
		$fadin = ($instance['fadin']);
		$fadout = ($instance['fadout']);
		
		$author1 = ($instance['author1']);
		$quotetext1 = ($instance['quotetext1']);
		$author2 = ($instance['author2']);
		$quotetext2 = ($instance['quotetext2']);
		$author3 = ($instance['author3']);
		$quotetext3 = ($instance['quotetext3']);
		$author4 = ($instance['author4']);
		$quotetext4 = ($instance['quotetext4']);
		$author5 = ($instance['author5']);
		$quotetext5 = ($instance['quotetext5']);
?>

<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<p><label for="<?php echo $this->get_field_id('fadin'); ?>"><?php _e('Show Fade In Time Set:','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('fadin'); ?>" name="<?php echo $this->get_field_name('fadin'); ?>" type="text" value="<?php echo attribute_escape($fadin); ?>" /></label></p>
<p><label for="<?php echo $this->get_field_id('fadout'); ?>"><?php _e('Show Fade Out Time Set:','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('fadout'); ?>" name="<?php echo $this->get_field_name('fadout'); ?>" type="text" value="<?php echo attribute_escape($fadout); ?>" /></label></p>
        
<p><label for="<?php echo $this->get_field_id('quotetext1'); ?>"><?php _e('Quote text 1','templatic');?>  : <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('quotetext1'); ?>" name="<?php echo $this->get_field_name('quotetext1'); ?>"><?php echo attribute_escape($quotetext1); ?></textarea></label></p>
<p><label for="<?php echo $this->get_field_id('author1'); ?>"><?php _e('Author name 1','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('author1'); ?>" name="<?php echo $this->get_field_name('author1'); ?>" type="text" value="<?php echo attribute_escape($author1); ?>" /></label></p>

<p><label for="<?php echo $this->get_field_id('quotetext2'); ?>"><?php _e('Quote text 2','templatic');?> : <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('quotetext2'); ?>" name="<?php echo $this->get_field_name('quotetext2'); ?>"><?php echo attribute_escape($quotetext2); ?></textarea></label></p>
<p><label for="<?php echo $this->get_field_id('author2'); ?>"><?php _e('Author name 2','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('author2'); ?>" name="<?php echo $this->get_field_name('author2'); ?>" type="text" value="<?php echo attribute_escape($author2); ?>" /></label></p>

<p><label for="<?php echo $this->get_field_id('quotetext3'); ?>"><?php _e('Quote text 3','templatic');?> : <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('quotetext3'); ?>" name="<?php echo $this->get_field_name('quotetext3'); ?>"><?php echo attribute_escape($quotetext3); ?></textarea></label></p>
<p><label for="<?php echo $this->get_field_id('author3'); ?>"><?php _e('Author name 3','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('author3'); ?>" name="<?php echo $this->get_field_name('author3'); ?>" type="text" value="<?php echo attribute_escape($author3); ?>" /></label></p>

<p><label for="<?php echo $this->get_field_id('quotetext4'); ?>"><?php _e('Quote text 4','templatic');?> : <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('quotetext4'); ?>" name="<?php echo $this->get_field_name('quotetext4'); ?>"><?php echo attribute_escape($quotetext4); ?></textarea></label></p>
<p><label for="<?php echo $this->get_field_id('author4'); ?>"><?php _e('Author name 4','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('author4'); ?>" name="<?php echo $this->get_field_name('author4'); ?>" type="text" value="<?php echo attribute_escape($author4); ?>" /></label></p>

<p><label for="<?php echo $this->get_field_id('quotetext5'); ?>"><?php _e('Quote text 5','templatic');?> : <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('quotetext5'); ?>" name="<?php echo $this->get_field_name('quotetext5'); ?>"><?php echo attribute_escape($quotetext5); ?></textarea></label></p>
<p><label for="<?php echo $this->get_field_id('author5'); ?>"><?php _e('Author name 5','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('author5'); ?>" name="<?php echo $this->get_field_name('author5'); ?>" type="text" value="<?php echo attribute_escape($author5); ?>" /></label></p>
<?php
	}}
register_widget('templ_testimonials_widget');
?>