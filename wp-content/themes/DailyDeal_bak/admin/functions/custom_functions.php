<?php
/////////PRODUCT DETAIL PAGE FUNCTIONS START///////////////
function templ_is_show_listing_author()
{
	if(strtolower(get_option('ptthemes_listing_author'))=='yes' || get_option('ptthemes_listing_author')=='')
	{
		return true;	
	}
	return false;
}
function templ_is_show_listing_date()
{
	if(strtolower(get_option('ptthemes_listing_date'))=='yes' || get_option('ptthemes_listing_date')=='')
	{
		return true;	
	}
	return false;
}
function templ_is_show_listing_comment()
{
	if(strtolower(get_option('ptthemes_listing_comment'))=='yes' || get_option('ptthemes_listing_comment')=='')
	{
		return true;	
	}
	return false;
}
function templ_is_show_listing_category()
{
	if(strtolower(get_option('ptthemes_listing_category'))=='yes' || get_option('ptthemes_listing_category')=='')
	{
		return true;	
	}
	return false;
}
function templ_is_show_listing_tags()
{
	if(strtolower(get_option('ptthemes_listing_tags'))=='yes' || get_option('ptthemes_listing_tags')=='')
	{
		return true;	
	}
	return false;
}
function templ_is_show_capcha()
{
	if(strtolower(get_option('ptthemes_capcha'))=='yes' || get_option('ptthemes_capcha')=='')
	{
		return true;	
	}
	return false;
}

/////////PRODUCT DETAIL PAGE FUNCTIONS END///////////////

/////////PRODUCT DETAIL PAGE FUNCTIONS START///////////////
function templ_is_show_post_author()
{
	if(strtolower(get_option('ptthemes_details_author'))=='yes' || get_option('ptthemes_details_author')=='')
	{
		return true;	
	}
	return false;
}

function templ_is_show_post_date()
{
	if(strtolower(get_option('ptthemes_details_date'))=='yes' || get_option('ptthemes_details_date')=='')
	{
		return true;	
	}
	return false;
}

function templ_is_show_post_comment()
{
	if(strtolower(get_option('ptthemes_details_comment'))=='yes' || get_option('ptthemes_details_comment')=='')
	{
		return true;	
	}
	return false;
}

function templ_is_show_post_category()
{
	if(strtolower(get_option('ptthemes_details_category'))=='yes' || get_option('ptthemes_details_category')=='')
	{
		return true;	
	}
	return false;
}

function templ_is_show_post_tags()
{
	if(strtolower(get_option('ptthemes_details_tags'))=='yes' || get_option('ptthemes_details_tags')=='')
	{
		return true;	
	}
	return false;
}
/////////PRODUCT DETAIL PAGE FUNCTIONS END///////////////

/////////FOOTER FUNCTIONS START///////////////
function templ_is_footer_widgets_2colright()
{
	if(get_option('ptthemes_bottom_options')=='Two Column - Right(one third)')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_2colleft()
{
	if(get_option('ptthemes_bottom_options')=='Two Column - Left(one third)')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_eqlcol()
{
	if(get_option('ptthemes_bottom_options')=='Equal Column')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_3col()
{
	if(get_option('ptthemes_bottom_options')=='Three Column')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_4col()
{
	if(get_option('ptthemes_bottom_options')=='Four Column')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_fullwidth()
{
	if(get_option('ptthemes_bottom_options')=='Full Width')
	{
		return true;	
	}
	return false;
}

///////////////OTHER FLAG SETTINGS START////////////////////
function templ_is_ajax_pagination()
{
	if (get_option('ptthemes_pagination') == 'AJAX-fetching posts')
	{
		return true;	
	}
	return false;
}
function templ_is_third_party_seo()
{
	if(strtolower(get_option('ptthemes_use_third_party_data'))=='yes')
	{
		return true;	
	}
	return false;		
}
function templ_is_top_home_link()
{
	if(strtolower(get_option('ptthemes_top_home_links'))=='yes' || get_option('ptthemes_top_home_links')=='' )
	{
		return true;
	}
	return false;
}
function templ_is_top_pages_nav()
{
	if(get_option('ptthemes_top_pages_nav')!="" && !strstr(get_option('ptthemes_top_pages_nav'),'none'))
	{
		return true;
	}
	return false;
}
function templ_is_top_category_nav()
{
	if(get_option('ptthemes_category_top_nav')!="" && !strstr(get_option('ptthemes_category_top_nav'),'none'))
	{
		return true;
	}
	return false;
}
function templ_is_facebook_button()
{
	if(strtolower(get_option('ptthemes_facebook_button'))=='yes')
	{
		return true;	
	}
	return false;
}
function templ_is_tweet_button()
{
	if(strtolower(get_option('ptthemes_tweet_button'))=='yes')
	{
		return true;	
	}
	return false;
}
function templ_is_show_blog_title()
{
	if(strtolower(get_option('ptthemes_show_blog_title'))=='yes')
	{
		return true;	
	}
	return false;
}
function templ_is_php_mail()
{
	if(get_option('ptthemes_notification_type')=='PHP Mail')
	{
		return true;	
	}
	return false;
}
function templ_is_auto_install()
{
	if(strtolower(get_option('ptthemes_auto_install'))=='yes')
	{
		return true;	
	}
	return false;
}
///////////////OTHER FLAG SETTINGS END////////////////////


/************************************
//FUNCTION NAME : templ_sendEmail
//ARGUMENTS : from email ID,From email Name, To email ID, To email name, Mail Subject, Mail Content, Mail Header.
//RETURNS : Send Mail to the email address.
***************************************/
function templ_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
{
	$fromEmail = apply_filters('templ_send_from_emailid', $fromEmail);
	$fromEmailName = apply_filters('templ_send_from_emailname', $fromEmailName);
	$toEmail = apply_filters('templ_send_to_emailid', $toEmail);
	$toEmailName = apply_filters('templ_send_to_emailname', $toEmailName);
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
	$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
	$subject = apply_filters('templ_send_email_subject', $subject);
	$message = apply_filters('templ_send_email_content', $message);
	$headers = apply_filters('templ_send_email_headers', $headers);
	
	// Mail it
	if(templ_is_php_mail())
	{
		@mail($toEmail, $subject, $message, $headers);	
	}else
	{
		wp_mail($toEmail, $subject, $message, $headers);	
	}	
}
/************************************
//FUNCTION NAME : templ_getTinyUrl
//ARGUMENTS :source url
//RETURNS : Tiny URL created
***************************************/
function templ_getTinyUrl($url) {
    //$tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
	$tinyurl = $url;
    return $tinyurl;
}


/************************************
//FUNCTION NAME : templ_get_date_format
//ARGUMENTS :None
//RETURNS : date format as per set from design settings
***************************************/
function templ_get_date_format()
{
	return templ_date_format();
}

function templ_date_format()
{
	$date_format = get_option('ptthemes_date_format');
	if(!$date_format){$date_format = 'yyyy-mm-dd';}
	return apply_filters('templ_date_formate_filter',$date_format);
}
/************************************
//FUNCTION NAME : templ_get_time_format
//ARGUMENTS :None
//RETURNS : time format as per set from design settings
***************************************/
function templ_get_time_format()
{
	return templ_time_format();
}

function templ_time_format()
{
	$time_format = get_option('ptthemes_time_format');
	if(!$time_format){ $time_format = get_option('time_format');}
	if($time_format==''){$time_format = 'g:s a';}
	return apply_filters('templ_time_formate_filter',$time_format);
}

/************************************
//FUNCTION NAME : templ_get_formated_date
//ARGUMENTS :Input date in 'Y-m-d' format (eg:- 2011-01-31)
//RETURNS : formated date as per set from design settings
***************************************/
function templ_get_formated_date($date)
{
	return templ_date_formated($date);	
}

function templ_date_formated($date)
{
	$date_format = templ_get_date_format();
	if($date)
	{
		return apply_filters('templ_get_formated_date_filter',date($date_format,strtotime($date)));	
	}
}

/************************************
//FUNCTION NAME : templ_get_site_contact_email
//ARGUMENTS :NONE
//RETURNS : site email set from design settings or admin email
***************************************/
function templ_get_site_contact_email()
{
	return templ_site_contact_email();
}

function templ_site_contact_email()
{
	$site_email = get_option('pttheme_contact_email');
	if($site_email=='')
	{
		$site_email = get_option('admin_email');	
	}
	return apply_filters('templ_get_site_contact_email_filter',$site_email);
}

/************************************
//FUNCTION NAME : templ_set_breadcrumbs_navigation
//ARGUMENTS :arg1=custom seperator, arg2=cutom breadcrumbs content
//RETURNS : breadcrums for each pages
***************************************/
function templ_set_breadcrumbs_navigation($arg1='',$arg2='')
{
	do_action('templ_set_breadcrumbs_navigation');
	if (strtolower(get_option( 'ptthemes_breadcrumbs'))=='yes') { ?>

    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in">
		<?php 
		ob_start();

		if($_GET['ptype'] == 'affiliate'){
			if($_REQUEST['type']=='reg'){
				yoast_breadcrumb('',' &raquo; '.AFFILIATE_REG_BREADCUM);
			} else {
				yoast_breadcrumb('',' &raquo;'.AFFILIATE_LOGIN_BREADCUM);
			}
		} else {
			yoast_breadcrumb(''.$arg1,''.$arg2);
		}

		$breadcrumb = ob_get_contents();
		ob_end_clean();
		echo apply_filters('templ_breadcrumbs_navigation_filter',$breadcrumb);
		?></div>
    </div>
    <?php }
}

/************************************
//FUNCTION NAME : templ_get_excerpt
//ARGUMENTS :string content, number of characters limit
//RETURNS : string with limit of number of characters
***************************************/
function templ_get_excerpt($string, $limit='',$post_id='') {
	global $post;
	if(!$post_id)
	{
		$post_id=$post->ID;
	}
	$read_more = stripslashes(get_option('ptthemes_content_excerpt_readmore'));
	if($read_more)
	{
		$read_more = ' <a href="'.get_permalink($post_id).'" title="" class="read_more">'.$read_more.'</a>';
	}else
	{
		$read_more = ' <a href="'.get_permalink($post_id).'" title="" class="read_more">'.__('read more','templatic').'</a>';
	}
	$read_more = apply_filters('templ_get_excerpt_readmore_filter',$read_more);
	if($limit)
	{
		$words = explode(" ",$string);
		if ( count($words) >= $limit)
		return apply_filters('templ_get_excerpt_filter',implode(" ",array_splice($words,0,$limit)).$read_more);
		else
		return apply_filters('templ_get_excerpt_filter',$string.$read_more);
		
	}else
	{
		return apply_filters('templ_get_excerpt_filter',$string.$read_more);
	}
}

/************************************
//FUNCTION NAME : templ_listing_content
//ARGUMENTS :NONE
//RETURNS : display content or excerpt or sub part of it.
***************************************/
function templ_listing_content()
{
	if (apply_filters('templ_get_listing_content_filter', true))
	{
		if(get_option('ptthemes_postcontent_full')=='Full Content')
		{
			the_content();		
		}else
		{
			$limit = get_option('ptthemes_content_excerpt_count');
			echo templ_get_excerpt(get_the_excerpt(), $limit);
		}
	}
}
add_action('templ_get_listing_content','templ_listing_content');


/************************************
//FUNCTION NAME : templ_seo_meta_content
//ARGUMENTS : None
//RETURNS : Meta Content, Description and Noindex settings for SEO
***************************************/
function templ_seo_meta_content()
{
	if (is_home() || is_front_page()) 
	{
		$description = stripslashes(get_option('ptthemes_home_desc_seo'));
		$keywords = stripslashes(get_option('ptthemes_home_keyword_seo'));
	}elseif (is_single() || is_page())
	{
		global $post;
		$description = get_post_meta($post->ID,'templ_seo_page_desc',true);
		$keywords = get_post_meta($post->ID,'templ_seo_page_kw',true);
	}
	
	if(is_archive() && strtolower(get_option( 'ptthemes_archives_noindex' ))=='yes')
	{
		echo '<meta name="robots" content="noindex" />';
	}elseif(is_tag() && strtolower(get_option( 'ptthemes_tag_archives_noindex' ))=='yes')
	{
		echo '<meta name="robots"  content="noindex" />';
	}elseif(is_archive() && strtolower(get_option('ptthemes_category_noindex'))=='yes')
	{
		echo '<meta name="robots"  content="noindex" />';
	}
	if($description){ echo '<meta content="'.$description.'" name="description" />';}
	if($keywords){ echo '<meta content="'.$keywords.'" name="keywords" />';}
	
}
add_action('templ_seo_meta','templ_seo_meta_content');

/************************************
//FUNCTION NAME : templ_seo_title
//ARGUMENTS : None
//RETURNS : SEO page title
***************************************/
function templ_seo_title() {
	if(templ_is_third_party_seo()){
	}else
	{
		global $page, $paged;
		$sep = " | "; # delimiter
		$newtitle = get_bloginfo('name'); # default title
	
		# Single & Page ##################################
		if (is_single() || is_page())
		{
			global $post;
			$newtitle = get_post_meta($post->ID,'templ_seo_page_title',true);
			if($newtitle=='')
			{
				$newtitle = single_post_title("", false);
			}
		}
	
		# Category ######################################
		if (is_category())
			$newtitle = single_cat_title("", false);
	
		# Tag ###########################################
		if (is_tag())
		 $newtitle = single_tag_title("", false);
	
		# Search result ################################
		if (is_search())
		 $newtitle = __("Search Result ",'templatic') . $s;
	
		# Taxonomy #######################################
		if (is_tax()) {
			$curr_tax = get_taxonomy(get_query_var('taxonomy'));
			$curr_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); # current term data
			# if it's term
			if (!empty($curr_term)) {
				$newtitle = $curr_tax->label . $sep . $curr_term->name;
			} else {
				$newtitle = $curr_tax->label;
			}
		}
	
		if ( is_author() ) {
			$newtitle = __('Author Archives','templatic');
		}
		# Page number
		if ($paged >= 2 || $page >= 2)
				$newtitle .= $sep . sprintf('Page %s', max($paged, $page));
	
		# Home & Front Page ########################################
		if (is_home() || is_front_page()) {
			if(get_option('ptthemes_home_title_seo')){
				$newtitle = stripslashes(get_option('ptthemes_home_title_seo'));
			}else
			{
				$newtitle = get_bloginfo('name') . $sep . stripslashes(get_bloginfo('description'));
			}
		} else {
			$newtitle .=  $sep . get_bloginfo('name');
		}
		$pos = strpos($_SERVER['REQUEST_URI'], "feed");
		if($pos != '' || $pos != 0)
		{
			$newtitle = '';
		}
		return $newtitle;
	}
}
add_filter('wp_title', 'templ_seo_title');

/************************************
//FUNCTION NAME : templ_main_header_navigation_content
//ARGUMENTS : None
//RETURNS : Get Header Main Menu Action Hook
***************************************/
function templ_main_header_navigation_content()
{
	if(strtolower(get_option('ptthemes_main_pages_nav_enable'))!='deactivate'){?>
        <div class="main_nav">
        <div class="main_nav_in clearfix">
         <?php apply_filters('templ_main_header_nav_above_filter','');?>
        <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary' ));?>
        <?php if (function_exists('dynamic_sidebar') ){dynamic_sidebar('Main Navigation');} ?>
        <?php apply_filters('templ_main_header_nav_below_filter','');?>
        </div></div>
    <?php
	}
}
add_action('templ_get_main_header_navigation','templ_main_header_navigation_content');


/************************************
//FUNCTION NAME : templ_top_header_navigation_content
//ARGUMENTS : None
//RETURNS : Get Header Top Menu Action Hook
***************************************/
function templ_top_header_navigation_content()
{
	if(strtolower(get_option('ptthemes_top_pages_nav_enable'))!='deactivate'){?>
        <div class="top_navigation">
        <div class="top_navigation_in clearfix">
        <?php apply_filters('templ_top_header_nav_above_filter','');?>
        <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ));?>
        <?php if (function_exists('dynamic_sidebar') ){ dynamic_sidebar('top_navigation');}?>
        <?php apply_filters('templ_top_header_nav_below_filter','');?>
        </div></div>
    <?php
	}
}
add_action('templ_get_top_header_navigation','templ_top_header_navigation_content');


/************************************
//FUNCTION NAME : templ_show_facebook_button_action
//ARGUMENTS : None
//RETURNS : Facebook Button Detail page - Action Hook
***************************************/
function templ_show_facebook_button_action()
{
	if(templ_is_facebook_button())
	{
		if (apply_filters('templ_facebook_button_script', true))
		{
			global $post;
		?>
      <div class="flike"> <iframe src="https://www.facebook.com/plugins/like.php?app_id=231052570273376&amp;href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
        <?php	
		}
	}
}add_action('templ_show_facebook_button','templ_show_facebook_button_action');


/************************************
//FUNCTION NAME : templ_show_twitter_button_action
//ARGUMENTS : None
//RETURNS : Twitter Button Detail page - Action Hook
***************************************/
function templ_show_twitter_button_action()
{
	if(templ_is_tweet_button())
	{
		if (apply_filters('templ_tweet_button_script', true))
		{
		?>
        <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal"><?php _e('Tweet','templatic');?></a>
		<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
        <?php	
		}
	}
}
add_action('templ_show_twitter_button','templ_show_twitter_button_action');


/************************************
//FUNCTION NAME : templ_add_site_logo
//ARGUMENTS : None
//RETURNS : Text as site logo with description
***************************************/
function templ_add_site_logo()
{
	if (templ_is_show_blog_title()) 
	{ 
		if ( is_home()){
			echo apply_filters('templ_blog_title_text','<div class="site-title"><h1><a href="'.get_option('home').'/">'.get_bloginfo( 'name', 'display' ).'</a></h1> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}else{
			echo apply_filters('templ_blog_title_text','<div class="site-title"><a href="'.get_option('home').'/">'.get_bloginfo( 'name', 'display' ).'</a> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}
	}else
	{
		echo templ_get_site_logo();
	}	
}
add_action('templ_site_logo','templ_add_site_logo'); //site logo action + filters

/************************************
//FUNCTION NAME : templ_get_site_logo
//ARGUMENTS : None
//RETURNS : Site Header logo with Hyper link
***************************************/
function templ_get_site_logo() {
	if(get_option('ptthemes_logo_url'))
	{
		$logo_url = get_option('ptthemes_logo_url');	
	}else
	{
		$logo_url = get_bloginfo('template_directory').'/images/logo.png';
	}
    if($logo_url)
	{		
		$return_str = '<a href="'.get_option('home').'/">';
		$return_str .= '<img src="'.apply_filters('templ_logo',$logo_url).'" alt="" />';
		$return_str .= '</a>';
		if ( is_home()){
			$return_str .=apply_filters('templ_blog_title_text','<div class="site-title none"><h1><a href="'.get_option('home').'/">'.get_bloginfo( 'name', 'display' ).'</a></h1> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}else{
			$return_str .=apply_filters('templ_blog_title_text','<div class="site-title none" ><a href="'.get_option('home').'/">'.get_bloginfo( 'name', 'display' ).'</a>
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}	
	}
    return apply_filters( 'templ_get_site_logo', $return_str );
}


/************************************
//FUNCTION NAME : templ_home_page_slider
//ARGUMENTS : None
//RETURNS : Widgets of Slider Above,Home Slider and Slider Below for home page
***************************************/
function templ_home_page_slider()
{
	do_action('templ_slider_above');
	if (apply_filters('templ_home_page_slider_filter', true))
	{
		if (function_exists('dynamic_sidebar')){ dynamic_sidebar('home_slider'); }
	}
	do_action('templ_slider_below');
}

/************************************
//FUNCTION NAME : get_currency_sym
//ARGUMENTS : None
//RETURNS : Currency symbol for the system
***************************************/
if(!function_exists('get_currency_sym'))
{
	function get_currency_sym()
	{
		if(get_option('ptttheme_currency_symbol'))
		{
			return get_option('ptttheme_currency_symbol');	
		}else{
	
			return '$';
			}
	}
}

/************************************
//FUNCTION NAME : get_currency_code
//ARGUMENTS : None
//RETURNS : Currency code for the system
***************************************/
if(!function_exists('get_currency_code'))
{
	function get_currency_code()
	{
		if(get_option('ptthemes_default_currency'))
		{
			return get_option('ptthemes_default_currency');	
		} else {
			return 'USD';
		}
	}
}

function bdw_get_images_with_info($iPostID,$img_size='thumb') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
	   }
	  return $return_arr;
	}
}

function is_wp_admin()
{
	if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
	{
		return true;
	}
	return false;
}

if(!function_exists('wp_pagenavi'))
{
	function wp_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {
	
		global $request, $posts_per_page, $wpdb, $paged, $totalpost_count, $posts_per_page_homepage;
		if($posts_per_page_homepage)
		{
			$posts_per_page = $posts_per_page_homepage;
		}
		if(empty($prelabel)) {
			$prelabel  = '<strong>&laquo;</strong>';
		}
		if(empty($nxtlabel)) {
			$nxtlabel = '<strong>&raquo;</strong>';
		}
		$half_pages_to_show = round($pages_to_show/2);
		if (!is_single()) {
			if(is_tag()) {
				preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
			} elseif (!is_category()) {
				preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);	
			} else {
				preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
			}
			$fromwhere = $matches[1];
			$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
			
		}
		if($totalpost_count)
		{
			$numposts = $totalpost_count;
		}
		$max_page = ceil($numposts /$posts_per_page);
			if(empty($paged)) {
				$paged = 1;
			}
			if($max_page > 1 || $always_show) {
				echo "$before <div class='Navi'>";
				if ($paged >= ($pages_to_show-1)) {
					echo '<a href="'.str_replace('&','&amp;',str_replace('&','&amp;',get_pagenum_link())).'">&laquo; First</a>';
				}
				previous_posts_link($prelabel);
				for($i = $paged - $half_pages_to_show; $i  <= $paged + $half_pages_to_show; $i++) {
					if ($i >= 1 && $i <= $max_page) {
						if($i == $paged) {
							echo "<strong class='on'>$i</strong>";
						} else {
							echo ' <a href="'.str_replace('&','&amp;',get_pagenum_link($i)).'">'.$i.'</a> ';
						}
					}
				}
				next_posts_link($nxtlabel, $max_page);
				if (($paged+$half_pages_to_show) < ($max_page)) {
					echo '<a href="'.str_replace('&','&amp;',get_pagenum_link($max_page)).'">Last &raquo;</a>';
				}
				echo "</div> $after";
			}
	}
}

add_action("admin_head", "templ_add_admin_custom_css");
function templ_add_admin_custom_css()
{?>
 <link rel="stylesheet" type="text/css" media="all" href="<?php echo TT_ADMIN_FOLDER_URL; ?>admin_style.css" />
<?php
}
?>