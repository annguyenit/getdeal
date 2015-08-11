<?php
/*
Template Name: Page - Author
*/
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<!-- Content  2 column - Right Sidebar  -->
<div class="content right">
  <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('page_content_above'); }?>
  <div class="entry">
  
  <div class="post-meta">
      <?php templ_page_title_above(); //page title above action hook?>
      <?php echo templ_page_title_filter(get_the_title()); //page tilte filter?>
      <?php templ_page_title_below(); //page title below action hook?>
    </div>
  
    <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
      <div class="post-content">
       
       		<div class="author_detail clearfix">
              
              <h3 class="page_head"> Andrew  </h3>

              		 
             <img class="author_photo" id="user_photo" src="<?php bloginfo('template_directory'); ?>/images/photo1.jpg" width="150" height="150"  />         
                     <div class="author_biodata">
                     
                     	 <p><a href="http://www.californiamoves.com">Visit Website</a>	|  <a href="http://www.twitter.com/andrew">Twitter </a> | <a href="#"> Edit Profile</a>  </p>
                     
                          <p class="agent_links clearfix"> 
						 
                          <p> Properties Listed : <b> 1</b> <br />
                         Phone : 6545222778  |  <a href="#" >Email This Agent</a></p>

                         <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam </p>
                     </div>              
              </div> <!-- agent_details_main #end  -->
            
            
            
            <h3> My Listing </h3>
            
            <ul class="addlist">
  <li class="clearfix"> 
        <div  class="listing_img"> 
        
              
        
        <a href="#"> <img src="<?php bloginfo('template_directory'); ?>/images/list1.png" alt="" title="" /> </a>
        </div>
      <div class="listing_content">
        <h3 class="clearfix"><a href="http://192.168.1.111/project/wordpress/realestate/2011/04/12/3658-wilderness-ln/"> 3658 Wilderness Ln </a>    </h3>
     
        <p>Price : <strong>$230</strong>  <br /> Address : 1103 S Ocean Blvd, nepal, MA, USA - 254871  </p>
        
        <div class="listing_info">
          <p>  Area : <strong>658 (Sq.Ft.)</strong>  </p>
          <p>  Bedrooms :  <strong>4</strong> </p>
          <p> Bathrooms :  <strong>3</strong> </p>
          <p> Grage :  <strong>3</strong> </p>
          <p> Total Views :  <strong>200</strong> </p>
      	  <p>  MLS #: <strong>CA4662774</strong>  </p>
          <p>  Property ID:  <strong>296</strong> </p>
          <p> Posted on :  <strong>April 12, 2011</strong> </p>
        </div>
        
         <div class="rating"> 
         <span>Rating : </span>
        <img src="<?php bloginfo('template_directory'); ?>/images/rating_on.png" alt=""  /> 
        <img src="<?php bloginfo('template_directory'); ?>/images/rating_on.png" alt=""  /> 
        <img src="<?php bloginfo('template_directory'); ?>/images/rating_on.png" alt=""  /> 
        <img src="<?php bloginfo('template_directory'); ?>/images/rating_off.png" alt=""  />
        <img src="<?php bloginfo('template_directory'); ?>/images/rating_off.png" alt=""  />
        </div>
        
        <p class="clearfix" >  <a href="#">Ping Point</a> | <a href="#">Favorited  <b>(remove)</b></a> |   <a href="#" class="edit">Edit</a> | <a href="#" class="delete">Delete</a> (expires in 24  days)   </p>
      </div>
   
  </li>
  
  <li class="clearfix"> 
        <div  class="listing_img"> 
        <div class="list_featured"></div> 
        <a href="#"> <img src="<?php bloginfo('template_directory'); ?>/images/list1.png" alt="" title="" /> </a>
        </div>
      <div class="listing_content">
        <h3 class="clearfix"><a href="http://192.168.1.111/project/wordpress/realestate/2011/04/12/3658-wilderness-ln/"> 3658 Wilderness Ln </a>   </h3>
         <p>Price : <strong>$230</strong>  <br /> Address : 1103 S Ocean Blvd, nepal, MA, USA - 254871  </p>
         
        <div class="listing_info">
          <p>  Area : <strong>658 (Sq.Ft.)</strong>  </p>
          <p>  Bedrooms :  <strong>4</strong> </p>
          <p> Bathrooms :  <strong>3</strong> </p>
          <p> Grage :  <strong>3</strong> </p>
          <p> Total Views :  <strong>200</strong> </p>
      	  <p>  MLS #: <strong>CA4662774</strong>  </p>
          <p>  Property ID:  <strong>296</strong> </p>
          <p> Posted on :  <strong>April 12, 2011</strong> </p>
        </div>
        
        <p >  <a href="#">Favorited  <b>(remove)</b></a> |   <a href="#" class="edit">Edit</a> | <a href="#" class="delete">Delete</a> (expires in 24  days)  </p>
      </div>
   </li>
   
   <li class="clearfix"> 
        <div  class="listing_img"> 
        <div class="list_featured"></div> 
        <a href="#"> <img src="<?php bloginfo('template_directory'); ?>/images/list1.png" alt="" title="" /> </a>
        </div>
      <div class="listing_content">
        <h3 class="clearfix"><a href="http://192.168.1.111/project/wordpress/realestate/2011/04/12/3658-wilderness-ln/"> 3658 Wilderness Ln </a>   </h3>
         <p>Price : <strong>$230</strong>  <br /> Address : 1103 S Ocean Blvd, nepal, MA, USA - 254871  </p>
         
        <div class="listing_info">
          <p>  Area : <strong>658 (Sq.Ft.)</strong>  </p>
          <p>  Bedrooms :  <strong>4</strong> </p>
          <p> Bathrooms :  <strong>3</strong> </p>
          <p> Grage :  <strong>3</strong> </p>
          <p> Total Views :  <strong>200</strong> </p>
      	  <p>  MLS #: <strong>CA4662774</strong>  </p>
          <p>  Property ID:  <strong>296</strong> </p>
          <p> Posted on :  <strong>April 12, 2011</strong> </p>
        </div>
        
        <p >  <a href="#">Favorited  <b>(remove)</b></a> |   <a href="#" class="edit">Edit</a> | <a href="#" class="delete">Delete</a> (expires in 24  days)  </p>
      </div>
   </li>
  
  
</ul>
	       
      </div>
    </div>
  </div>
</div>
<!-- /Content -->
<?php endwhile; ?>
<?php endif; ?>
<div class="sidebar left" >
  <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('sidebar1');}?>
</div>
<!-- sidebar #end -->
<!--Page 2 column - Right Sidebar #end  -->
<?php get_footer(); ?>
