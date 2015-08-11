<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<!--  CONTENT AREA START -->

<?php
global $current_user;
if(isset($_GET['author_name'])) :
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;
?>
<?php templ_page_title_above(); //page title above action hook?>
<div class="content-title"> 
<h4><?php echo "Past Deal"; //page tilte filter 
?> </h4>
</div>
<?php templ_page_title_below(); //page title below action hook?>
<?php global $transection_db_table_name, $wpdb;?>




<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>