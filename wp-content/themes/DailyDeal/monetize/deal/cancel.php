<?php get_header(); ?>
<?php $title = DEAL_PAY_CANCELATION_TITLE;
$pid=explode("|",hexstr($_REQUEST['pid']));

$filecontent = stripslashes(get_option('post_payment_cancel_msg_content'));
if($filecontent==""){
	$filecontent = DEAL_CANCEL_TEXT;
}
$post_link=get_permalink($_REQUEST['pid']);
$store_name = get_option('blogname');
$search_array = array('[#order_amt#]','[#bank_name#]','[#account_number#]','[#orderId#]','[#site_name#]','[#submited_information_link#]');
$replace_array = array($paid_amount,$bankInfo,$accountinfo,$order_id,$store_name,$post_link);
$filecontent = str_replace($search_array,$replace_array,$filecontent);?>

<?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
<div class="breadcrumb clearfix">
    <div class="breadcrumb_in"><?php yoast_breadcrumb('',' / '.$title);  ?></div>
</div>
<?php } ?>
 
<h1 class="singleh1"><?php echo $title;?></h1>   


<div class="content left">
        <div class="post-content">

<?php echo $filecontent ; ?> 

		</div>
 </div> <!-- /Content -->
                            
<div class="sidebar right" >
   
  <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Article Listing Sidebar Right')){?> <?php } else {?>  <?php }?>
   
</div>  <!-- sidebar #end -->




<?php get_footer(); ?>