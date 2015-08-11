<?php
add_action("admin_head", "templ_seo_add_custom_box_css");
function templ_seo_add_custom_box_css()
{
?>
<style type="text/css">
.inside p.row { min-height:25px; }
.inside p.row label  { width: 120px; float:left; margin-right:10px; font-weight:bold; } 
.inside p.row input{ float:left;} 
.inside p.row .page_seo_desc, .inside p.row .page_seo_kw { width:320px !important; height:120px !important; }
.inside p.row .seo_button { margin-left:130px !important; }
</style>
<?php	
}

/* Define the custom box */

// backwards compatible
add_action('admin_init', 'templ_seo_add_custom_box', 1);

/* Do something with the data entered */
add_action('save_post', 'templ_seo_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function templ_seo_add_custom_box() {
    add_meta_box( 'myplugin_sectionid', __( 'SEO Settings','templatic'),'myplugin_inner_custom_box', 'post' );
    add_meta_box( 'myplugin_sectionid', __( 'SEO Settings','templatic'),'myplugin_inner_custom_box', 'page' );
}

/* Prints the box content */
function myplugin_inner_custom_box() {
global $post;
  // The actual fields for data entry
  echo '<p class="row"><label for="templ_seo_page_title">' . __("Page Title",'templatic') . '</label> ';
  echo '<input type="text" id= "templ_seo_page_title" name="templ_seo_page_title" class="page_seo_title" value="'.get_post_meta($post->ID,'templ_seo_page_title',true).'" size="50" /></p>';
  
  echo '<p class="row"><label for="templ_seo_page_desc">' . __("Page Description",'templatic') . '</label> ';
  echo '<textarea id= "templ_seo_page_desc" name="templ_seo_page_desc" class="page_seo_desc">'.get_post_meta($post->ID,'templ_seo_page_desc',true).'</textarea></p>';
  
  echo '<p class="row"><label for="templ_seo_page_kw">' . __("Keywords <br />(comma separated)",'templatic') . '</label> ';
  echo '<textarea id= "templ_seo_page_kw" name="templ_seo_page_kw" class="page_seo_kw">'.get_post_meta($post->ID,'templ_seo_page_kw',true).'</textarea></p>';
  
  echo '<p class="row"><input type="submit" value="'.__('Update','templatic').'" id="publish" class="button-primary seo_button" name="save"></p>';
}

/* When the post is saved, saves our custom data */
function templ_seo_save_postdata( $post_id ) {

  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
  // to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

  // OK, we're authenticated: we need to find and save the data

  update_post_meta($post_id,'templ_seo_page_title',$_POST['templ_seo_page_title']);
  update_post_meta($post_id,'templ_seo_page_desc',$_POST['templ_seo_page_desc']);
  update_post_meta($post_id,'templ_seo_page_kw',$_POST['templ_seo_page_kw']);
  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)

   return $mydata;
}
?>