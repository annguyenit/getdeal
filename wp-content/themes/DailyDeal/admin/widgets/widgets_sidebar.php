<?php
// Register widgetized areas
if ( function_exists('register_sidebar') ) {
	$sidebar_widget_arr = array();
	
///-----------------------------------------------------------------
	  //  TOP NAVIGATION SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['top_navigation'] =array(1,array('name' => __('Top Navigation','templatic'),'id' => 'top_navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

///-----------------------------------------------------------------
	  //  MAIN NAVIGATION SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['main_navigation'] =array(1,array('name' => __('Main Navigation','templatic'),'id' => 'main_navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

///-----------------------------------------------------------------
	  //  HEADER SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['header_logo_right_side'] =array(1,array('name' => __('Header Logo Right Side','templatic'),'id' => 'header_logo_right_side','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

///-----------------------------------------------------------------
	  //  SLIDER SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['home_slider'] =array(1,array('name' => __('Home Slider','templatic'),'id' => 'home_slider','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
		
///-----------------------------------------------------------------
	  //  SINGLE POST SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['single_post_below'] =array(1,array('name' => __('Single Post Below Content','templatic'),'id' => 'single_post_below','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));


///-----------------------------------------------------------------
	  //  SIDEBAR SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['sidebar1'] =array(1,array('name' => __('Sidebar 1','templatic'),'id' => 'sidebar1','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	
	$sidebar_widget_arr['sidebar2'] =array(1,array('name' => __('Sidebar 2','templatic'),'id' => 'sidebar2','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

	$sidebar_widget_arr['sidebar_2col_merge'] =array(1,array('name' => __('Sidebar 2col Merge','templatic'),'id' => 'sidebar_2col_merge','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

///-----------------------------------------------------------------
	  //  FOOTER SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['footer1'] =array('1',array('name' => __('First Footer Widget Area','templatic'), 'id' => 'footer1', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	
	$sidebar_widget_arr['footer2'] =array('1',array('name' => __('Second Footer Widget Area','templatic'), 'id' => 'footer2', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	
	$sidebar_widget_arr['footer3'] =array('1',array('name' => __('Third Footer Widget Area','templatic'), 'id' => 'footer3', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	
	$sidebar_widget_arr['footer4'] =array('1',array('name' => __('Fourth Footer Widget Area','templatic'), 'id' => 'footer4', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	


	$sidebar_widget_arr = apply_filters('templ_sidebar_widget_box_filter',$sidebar_widget_arr); //Sidebar widget area manage filer
	foreach($sidebar_widget_arr as $key=>$val)
	{
		if($val){
		register_sidebars($val[0],$val[1]);
		}
	}

}
?>