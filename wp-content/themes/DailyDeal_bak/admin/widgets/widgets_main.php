<?php
include_once(TT_WIDGET_FOLDER_PATH.'widgets_sidebar.php'); // all register sidebar widget
$widget_array = array();
$widget_array['ads'] = 'ads.php';
$widget_array['featured_video'] = 'featured_video.php';
$widget_array['flickr'] = 'flickr.php';
$widget_array['google_map'] = 'google_map.php';
$widget_array['latest_posts'] = 'latest_posts.php';
$widget_array['my_bio'] = 'my_bio.php';
$widget_array['popularposts'] = 'popularposts.php';
$widget_array['testimonials'] = 'testimonials.php';
$widget_array['twitter'] = 'twitter.php';
$widget_array['login'] = 'login.php';
$widget_array['contact'] = 'contact/contact.php';
$widget_array['social_media'] = 'social_media.php';
$widget_array['subscribe'] = 'subscribe.php';
$widget_array['anything_slider'] = 'anything_slider/anything_slider.php';
$widget_array = apply_filters('templ_widgets_listing_filter',$widget_array);
if($widget_array)
{
	foreach($widget_array as $key=>$val)
	{
		if($val)
		{
			$filename = $val;
			if(file_exists(TT_WIDGET_FOLDER_PATH.$filename))
			{
				include_once(TT_WIDGET_FOLDER_PATH.$filename);
			}
		}
	}
}
?>