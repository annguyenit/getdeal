<?php
	session_start();
ob_start();
if (!class_exists('themeui')) {
	class themeui {
		// Class initialization
		function themeui() {
		}
		
		function get_myaccount_link()
		{?>
		<a href="<?php echo site_url('/?ptype=account'); ?>"><?php echo MY_ACCOUNT_TEXT;?></a>
        <?php
		}
		
		function get_logout_link($css='')
		{?>
		<a href="<?php global $General; echo $General->get_url_login(site_url('/?ptype=login&amp;action=logout')); ?>" class="<?php echo $css;?>"><?php echo LOGOUT_TEXT; ?></a>
        <?php
		}
		
		function get_login_link($css='')
		{?>
		<a href="<?php global $General; echo $General->get_url_login(site_url('/?ptype=login')); ?>" class="<?php echo $css;?>"><?php _e(LOGIN_TEXT);?></a>
        <?php
		}
		
		function get_registration_link($css='')
		{?>
		<a href="<?php global $General; echo $General->get_url_login(site_url('/?ptype=login')); ?>" class="<?php echo $css;?>"><?php echo REGISTER_TEXT;?></a>
        <?php
		}
		
		function get_checkout_link($css='')
		{?>
		<a  href="<?php echo site_url('/?ptype=cart'); ?>" class="<?php echo $css;?>"><?php echo CHECKOUT_TEXT;?> &raquo;</a>
        <?php
		}
		function get_affiliate_link($css='')
		{?>
		<a href="<?php echo site_url('/?ptype=setasaff');?>" class="<?php echo $css;?>"><?php _e('Click here','templatic');?> &raquo;</a>
        <?php
		}
		
		function get_shoppingcart_info_header()
		{
			global $Cart,$General,$themeUI;
			$itemsInCartCount = $Cart->cartCount();
			$cartAmount = $Cart->getCartAmt();
			if($General->is_storetype_shoppingcart() || $General->is_storetype_digital())
            {
            ?>
            <div class="header_cart">
                 <?php _e('You have');?> <a href="<?php echo site_url('/?ptype=cart'); ?>"><strong> <span id="cart_information_span"><?php echo $itemsInCartCount . "(".$General->get_currency_symbol()."$cartAmount)";?></span></strong></a> <?php _e(SHOPPING_CART_CONTENT_TEXT);?>   | <span class="checkout"> <?php $themeUI->get_checkout_link();?> </span>                 
            </div> <!-- cart #end -->
			<?php
            }
		}
		
		function get_welcome_user_text()
		{
			global $General;
			$userInfo = $General->getLoginUserInfo();
			_e(WELCOME_TEXT);?> <strong><?php echo $userInfo['user_nicename'];?></strong>,
        <?php
		}
		
		function get_welcome_guest_text()
		{
			_e(HELLO_GUEST_TEXT);
			echo ',';
		}
		
		function is_on_guest_checkout()
		{
			 global $General;
			 $chekcout_method = $General->get_checkout_method();
			 if($chekcout_method == 'single'  && $General->is_storetype_shoppingcart())
			 {
				return true; 
			 }else
			 {
				return false; 
			 }	
		}
		
		function get_product_att1_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['sizetitle']){ _e($data['sizetitle']);}else{ _e(SIZE_TEXT);}	
			}else
			{
				if($data['sizetitle']){ return __($data['sizetitle']);}else{ return __(SIZE_TEXT);}	
			}
		}
		
		function get_product_att2_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['colortitle']){ _e($data['colortitle']);}else{ _e(COLOR_TEXT);}
			}else
			{
				if($data['colortitle']){ return __($data['colortitle']);}else{ return __(COLOR_TEXT);}
			}
		}
		function get_product_att3_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['att3title']){ _e($data['att3title']);}else{ _e('Attribute3');}
			}else
			{
				if($data['att3title']){ return __($data['att3title']);}else{  return __('Attribute3');}
			}
		}
		function get_product_att4_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['att4title']){ _e($data['att4title']);}else{ _e('Attribute4');}
			}else
			{
				if($data['att4title']){ return __($data['att4title']);}else{  return __('Attribute4');}
			}
		}
		function get_product_att5_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['att5title']){ _e($data['att5title']);}else{ _e('Attribute5');}
			}else
			{
				if($data['att5title']){ return __($data['att5title']);}else{ return __('Attribute5');}	
			}
		}
		function get_product_att6_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['att6title']){ _e($data['att6title']);}else{ _e('Attribute6');}
			}else
			{
				if($data['att6title']){ return __($data['att6title']);}else{ return __('Attribute6');}	
			}
		}
		function get_product_att7_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['att7title']){ _e($data['att7title']);}else{ _e('Attribute7');}
			}else
			{
				if($data['att7title']){ return __($data['att7title']);}else{ return __('Attribute7');}	
			}
		}
		function get_product_att8_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['att8title']){ _e($data['att8title']);}else{ _e('Attribute8');}
			}else
			{
				if($data['att8title']){ return __($data['att8title']);}else{ return __('Attribute8');}	
			}
		}
		function get_product_att9_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['att9title']){ _e($data['att9title']);}else{ _e('Attribute9');}
			}else
			{
				if($data['att9title']){ return __($data['att9title']);}else{ return __('Attribute9');}	
			}
		}
		function get_product_att10_title($data,$show='1')
		{
			if($show==1)
			{
				if($data['att10title']){ _e($data['att10title']);}else{ _e('Attribute10');}
			}else
			{
				if($data['att10title']){ return __($data['att10title']);}else{ return __('Attribute10');}	
			}
		}
		
	}
	// Start this plugin once all other plugins are fully loaded
}
if(!$themeUI)
{
	$themeUI = new themeui();
}
?>