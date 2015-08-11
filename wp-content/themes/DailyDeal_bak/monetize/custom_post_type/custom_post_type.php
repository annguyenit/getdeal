<?php
//----------------------------------------------------------------------//
// Initiate the plugin to add custom post type
//----------------------------------------------------------------------//

add_action("init", "custom_posttype_menu_wp_admin");
function custom_posttype_menu_wp_admin()
{
//===============EVENT SECTION START================
$custom_post_type = CUSTOM_POST_TYPE1;
$custom_cat_type = CUSTOM_CATEGORY_TYPE1;
$custom_tag_type = CUSTOM_TAG_TYPE1;

register_post_type(	"$custom_post_type", 
				array(	'label' 			=> CUSTOM_MENU_TITLE,
						'labels' 			=> array(	'name' 					=> 	CUSTOM_MENU_NAME,
														'singular_name' 		=> 	CUSTOM_MENU_SIGULAR_NAME,
														'add_new' 				=>  CUSTOM_MENU_ADD_NEW,
														'add_new_item' 			=>  CUSTOM_MENU_ADD_NEW_ITEM,
														'edit' 					=>  CUSTOM_MENU_EDIT,
														'edit_item' 			=>  CUSTOM_MENU_EDIT_ITEM,
														'new_item' 				=>  CUSTOM_MENU_NEW,
														'view_item'				=>  CUSTOM_MENU_VIEW,
														'search_items' 			=>  CUSTOM_MENU_SEARCH,
														'not_found' 			=>  CUSTOM_MENU_NOT_FOUND,
														'not_found_in_trash' 	=>  CUSTOM_MENU_NOT_FOUND_TRASH	),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
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
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array("$custom_cat_type","$custom_tag_type")
					)
				);

// Register custom taxonomy
register_taxonomy(	"$custom_cat_type", 
				array(	"$custom_post_type"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> CUSTOM_MENU_CAT_LABEL, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_CAT_TITLE,
														'singular_name' 	=>  CUSTOM_MENU_SIGULAR_CAT,
														'search_items' 		=>  CUSTOM_MENU_CAT_SEARCH,
														'popular_items' 	=>  CUSTOM_MENU_CAT_SEARCH,
														'all_items' 		=>  CUSTOM_MENU_CAT_ALL,
														'parent_item' 		=>  CUSTOM_MENU_CAT_PARENT,
														'parent_item_colon' =>  CUSTOM_MENU_CAT_PARENT_COL,
														'edit_item' 		=>  CUSTOM_MENU_CAT_EDIT,
														'update_item'		=>  CUSTOM_MENU_CAT_UPDATE,
														'add_new_item' 		=>  CUSTOM_MENU_CAT_ADDNEW,
														'new_item_name' 	=>  CUSTOM_MENU_CAT_NEW_NAME,	), 
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
register_taxonomy(	"$custom_tag_type", 
				array(	"$custom_post_type"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> CUSTOM_MENU_TAG_LABEL, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_TAG_TITLE,
														'singular_name' 	=>  CUSTOM_MENU_TAG_NAME,
														'search_items' 		=>  CUSTOM_MENU_TAG_SEARCH,
														'popular_items' 	=>  CUSTOM_MENU_TAG_POPULAR,
														'all_items' 		=>  CUSTOM_MENU_TAG_ALL,
														'parent_item' 		=>  CUSTOM_MENU_TAG_PARENT,
														'parent_item_colon' =>  CUSTOM_MENU_TAG_PARENT_COL,
														'edit_item' 		=>  CUSTOM_MENU_TAG_EDIT,
														'update_item'		=>  CUSTOM_MENU_TAG_UPDATE,
														'add_new_item' 		=>  CUSTOM_MENU_TAG_ADD_NEW,
														'new_item_name' 	=>  CUSTOM_MENU_TAG_NEW_ADD,	),  
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
}
//===============EVENT SECTION END================

/////The filter code to get the custom post type in the RSS feed
function myfeed_request($qv) {
	if (isset($qv['feed']))
		$qv['post_type'] = get_post_types();
	return $qv;
}
add_filter('request', 'myfeed_request');

add_filter( 'manage_edit-seller_columns', 'templatic_edit_seller_columns' ) ;

function templatic_edit_seller_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Deal' ),
		'coupon_start_date_time' => __( 'Start time' ),
		'coupon_end_date_time' => __( 'End time' ),
		'deal_sold' => __( 'Deals sold' ),
		'total_item' => __( 'Total items' ),
		'status' => __( 'Status' ),
		'post_category' => __( 'Categories' ),
		'post_tags' => __( 'Tags' )
	);

	return $columns;
}

add_action( 'manage_seller_posts_custom_column', 'templatic_manage_seller_columns', 10, 2 );

function templatic_manage_seller_columns( $column, $post_id ) {
	echo '<link href="'.get_template_directory_uri().'/monetize/admin.css" rel="stylesheet" type="text/css" />';
	global $post;

	switch( $column ) {

		/* If displaying the 'status' column. */
		case 'status' :

			/* Get the post meta. */
			$status = fetch_status(get_post_meta( $post_id, 'status', true ),get_post_meta( $post_id, 'is_expired', true ));

			/* If no status is found, output a default message. */
			 _e($status,'templatic');

			break;

		/* If displaying the 'coupon_start_date_time' column. */
		case 'coupon_start_date_time' :

			/* Get the coupon_start_date_time for the post. */
			$coupon_start_date_time = get_post_meta( $post_id, 'coupon_start_date_time', true );

			/* If coupon_start_date_time were found. */
			if ( $coupon_start_date_time != '' ) {
				echo date('Y-m-d H:i:s',$coupon_start_date_time);
			}

			/* If no coupon_start_date_time were found, output a default message. */
			else {
				_e( 'Unknown' );
			}

			break;
		case 'coupon_end_date_time' :

			/* Get the coupon_end_date_time for the post. */
			$coupon_end_date_time = get_post_meta( $post_id, 'coupon_end_date_time', true );

			/* If coupon_end_date_time were found. */
			if ( !empty( $coupon_end_date_time ) ) {
				echo date('Y-m-d H:i:s',$coupon_end_date_time);
			}

			/* If no coupon_end_date_time were found, output a default message. */
			else {
				_e( 'Continue deal' );
			}

			break;
		case 'deal_sold' :

			/* Get the deal_sold for the post. */
			$deal_sold = deal_transaction($post_id);

			/* If deal_sold were found. */
			if ( !empty( $deal_sold ) ) {
				echo $deal_sold;
			}

			/* If no deal_sold were found, output a default message. */
			else {
				_e( '0' );
			}

			break;
		case 'post_category' :
			/* Get the post_category for the post. */
			
			if(templ_is_show_post_category()){
				$category = get_the_taxonomies($post);
				$category_display = str_replace(CUSTOM_MENU_CAT_TITLE.':','',$category['seller_category']);
				$category_display = str_replace(' and ',', ',$category_display);
				echo $category_display = str_replace(',,',', ',$category_display);
			}else {
				_e( 'Uncategorized' );
			}

			break;
			
		case 'post_tags' :
			/* Get the post_tags for the post. */
				$tags = get_the_taxonomies($post);
				$tags_display = str_replace(CUSTOM_MENU_TAG_TITLE.':','',$tags['seller_tags']);
				$tags_display = str_replace(' and ',', ',$tags_display);
				echo $tags_display = str_replace(',,',', ',$tags_display);
			break;

		case 'total_item' :

			/* Get the total_item for the post. */
			$total_item = get_post_meta( $post_id, 'no_of_coupon', true );

			/* If terms were found. */
			if ( !empty( $total_item ) ) {
				echo $total_item;
			}

			/* If no terms were found, output a default message. */
			else {
				_e( '0' );
			}

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
add_filter( 'manage_edit-seller_sortable_columns', 'templatic_seller_sortable_columns' );

function templatic_seller_sortable_columns( $columns ) {
	$columns['coupon_start_date_time'] = 'coupon_start_date_time';
	$columns['coupon_end_date_time'] = 'coupon_end_date_time';
	$columns['deal_sold'] = 'deal_sold';
	$columns['total_item'] = 'total_item';
	$columns['status'] = 'status';
	$columns['post_category'] = 'Categories';
	return $columns;
}
?>