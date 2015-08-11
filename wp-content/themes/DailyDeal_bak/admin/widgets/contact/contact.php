<?php
// =============================== Login Widget ======================================
class contact_widget extends WP_Widget {
	function contact_widget() {
	//Constructor
		$widget_ops = array('classname' => 'Contact Us', 'description' => apply_filters('templ_contact_widget_desc_filter','Contact Us Widget') );		
		$this->WP_Widget('widget_contact', apply_filters('templ_contact_widget_title_filter','T &rarr; Contact Us'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
			
    <div class="widget contact_widget" id="contact_widget">
    <?php if($title){?> <h3><?php echo $title; ?> </h3><?php }?>
            
       		<?php
if($_POST && $_POST['contact_widget'])
{
	if($_POST['your-email'])
	{
		$toEmailName = get_option('blogname');
		$toEmail = get_site_emailId();
		
		$subject = $_POST['your-subject'];
		$message = '';
		$message .= '<p>Dear '.$toEmailName.',</p>';
		$message .= '<p>Name : '.$_POST['your-name'].',</p>';
		$message .= '<p>Email : '.$_POST['your-email'].',</p>';
		$message .= '<p>Message : '.nl2br($_POST['your-message']).'</p>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		// Additional headers
		$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
		$headers .= 'From: '.$_POST['your-name'].' <'.$_POST['your-email'].'>' . "\r\n";
		
		// Mail it
		templ_sendEmail($_POST['your-email'],$_POST['your-name'],$toEmail,$toEmailName,$subject,$message);
		if(strstr($_REQUEST['request_url'],'?'))
		{
			$url =  $_REQUEST['request_url'].'&msg=success'	;	
		}else
		{
			$url =  $_REQUEST['request_url'].'?msg=success'	;
		}
		echo "<script type='text/javascript'>location.href='".$url."#contact_widget';</script>";
		
	}else
	{
		if(strstr($_REQUEST['request_url'],'?'))
		{
			$url =  $_REQUEST['request_url'].'&err=empty'	;	
		}else
		{
			$url =  $_REQUEST['request_url'].'?err=empty'	;
		}
		echo "<script type='text/javascript'>location.href='".$url."#contact_widget';</script>";	
	}
}
?>
<?php
if($_REQUEST['msg'] == 'success')
{
?>
	<p class="success_msg"><?php echo apply_filters('templ_contact_widget_successmsg_filter',__('Thank you, your information is sent successfully.','templatic'));?></p>
<?php
}elseif($_REQUEST['err'] == 'empty')
{
?>
	<p class="error_msg"><?php echo apply_filters('templ_contact_widget_errormsg_filter',__('Please fill out all the fields before submitting.','templatic'));?></p>
<?php
}
?>
            
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" id="contact_widget_frm" name="contact_frm" class="wpcf7-form">
    <input type="hidden" name="contact_widget" value="1" />
    <input type="hidden" name="request_url" value="<?php echo $_SERVER['REQUEST_URI'];?>" />

    <div class="form_row "> <label> <?php _e('Name','templatic');?> <span class="indicates">*</span></label>
        <input type="text" name="your-name" id="widget_your-name" value="" class="textfield" size="40" />
        <span id="widget_your_name_Info" class="error"></span>
   </div>
   
    <div class="form_row "><label><?php _e('Email','templatic');?>  <span class="indicates">*</span></label>
        <input type="text" name="your-email" id="widget_your-email" value="" class="textfield" size="40" /> 
        <span id="widget_your_emailInfo"  class="error"></span>
  </div>
          
       <div class="form_row "><label><?php _e('Subject','templatic');?> <span class="indicates">*</span></label>
        <input type="text" name="your-subject" id="widget_your-subject" value="" size="40" class="textfield" />
        <span id="widget_your_subjectInfo"></span>
        </div>     
          
    <div class="form_row"><label><?php _e('Message','templatic');?> <span class="indicates">*</span></label>
     <textarea name="your-message" id="widget_your-message" cols="40" class="textarea textarea2" rows="10"></textarea> 
    <span id="widget_your_messageInfo"  class="error"></span>
    </div>
        <input type="submit" value="<?php _e('Send','templatic');?>" class="b_submit" />  
  </form> 
<script type="text/javascript" src="<?php echo TT_WIDGETS_FOLDER_URL; ?>contact/contact_validation1.js"></script>
</div>
        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('title' => '') );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT;?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
	}}
register_widget('contact_widget');
?>