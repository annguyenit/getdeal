<?php
//----------------------------------------------------------------------//
// Initiate the plugin to add custom post type
//----------------------------------------------------------------------//

add_action("init", "custom_posttype__slider_menu_wp_admin");
function custom_posttype__slider_menu_wp_admin()
{
//===============EVENT SECTION START================
$custom_post_type = CUSTOM_POST_TYPE2;
$custom_cat_type = CUSTOM_CATEGORY_TYPE2;
$custom_tag_type = CUSTOM_TAG_TYPE2;

register_post_type(	"$custom_post_type", 
				array(	'label' 			=> CUSTOM_MENU_TITLE2,
						'labels' 			=> array(	'name' 					=> 	CUSTOM_MENU_NAME2,
														'singular_name' 		=> 	CUSTOM_MENU_SIGULAR_NAME2,
														'add_new' 				=>  CUSTOM_MENU_ADD_NEW2,
														'add_new_item' 			=>  CUSTOM_MENU_ADD_NEW_ITEM2,
														'edit' 					=>  CUSTOM_MENU_EDIT2,
														'edit_item' 			=>  CUSTOM_MENU_EDIT_ITEM2,
														'new_item' 				=>  CUSTOM_MENU_NEW2,
														'view_item'				=>  CUSTOM_MENU_VIEW2,
														'search_items' 			=>  CUSTOM_MENU_SEARCH2,
														'not_found' 			=>  CUSTOM_MENU_NOT_FOUND2,
														'not_found_in_trash' 	=>  CUSTOM_MENU_NOT_FOUND_TRASH2	),
						'public' 			=> false,
						'can_export'		=> false,
						'show_ui' 			=> false, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> array("slug" => "$custom_post_type"), // Permalinks
						'query_var' 		=> "$custom_post_type", // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> false ,
						'taxonomies'		=> array("$custom_cat_type","$custom_tag_type")
					)
				);


}
//===============EVENT SECTION END================

/////The filter code to get the custom post type in the RSS feed
function myfeed_request_2($qv) {
	if (isset($qv['feed']))
		$qv['post_type'] = get_post_types();
	return $qv;
}
add_filter('request', 'myfeed_request_2');

?>