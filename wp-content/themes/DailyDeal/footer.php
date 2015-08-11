  </div>
</div>
<!-- /Container #end -->
<div class="container_below">

<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('single_post_below')){?>
<?php } else {?>  <?php }?></div>    <!--  all in one #end --> 
<?php templ_content_end(); // content end hooks?>
<?php get_template_part( 'footer_bottom' ); // footer bottom. ?>
 <div class="allinone"> 
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer_above')){?>
 <?php } else {?>  <?php }?>    
</div> 
 <?php templ_before_footer(); // content end hooks?>
 
     <div class="footer">
        <div class="footer_in">
        <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer_below_links')){?>
		<?php } else {?>  <?php }?>    
        
	<div id="copyright"> &copy GetDeals.nl | Dagaanbiedingen in Nederland | Webdesign & Marketing door <a href="http://www.qlickonline.nl.com">Qlickonline</a> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="http://www.getdeals.nl/contact-getdeals/">Contact</A></div>
   
        
        </div>
    </div>
</div> 
<?php templ_after_footer(); // content end hooks?>
<?php wp_footer(); ?>
<?php echo (get_option('ga')) ? get_option('ga') : '' ?>
<?php templ_body_end(); // Body end hooks?>
	</body>
</html>