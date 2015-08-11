<!-- bottom section start -->
	<?php if(templ_is_footer_widgets_2colright())
		{?>
           <div class="bottom">
           		 <div class="bottom_in clear">
           	 
           	 <div class="max_width left">
            	 <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
            </div> <!-- three_column #end -->
      
             <div class="min_width right">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
            </div> <!-- three_column #end -->
            </div> <!-- bottom in #end -->
          </div> <!-- bottom #end -->
        <?php
 		}else if(templ_is_footer_widgets_2colleft())
		{?>
   		<div class="bottom">
           <div class="bottom_in clear">
        	<div class="min_width left">
            	 <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
            </div> <!-- three_column #end -->
            
    	 <div class="max_width right">
            	 <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
            </div> <!-- three_column #end -->
          </div> <!-- bottom in #end -->
          </div> <!-- bottom #end -->
 		<?php 
		}
		else if(templ_is_footer_widgets_eqlcol())
		{?> 
         <div class="bottom">
              <div class="bottom_in clear">
         		<div class="equal_column left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
                </div> <!-- three_column #end -->
                  
                <div class="equal_column right">
                    <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
                </div> <!-- three_column #end -->
             </div> <!-- bottom in #end -->
          </div> <!-- bottom #end -->
        <?php 			
		}else if(templ_is_footer_widgets_3col())
		{?> 
        <div class="bottom">
            <div class="bottom_in">
             	<div class="three_column left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
                </div> <!-- three_column #end -->
                 
                <div class="three_column spacer_3col left">
                    <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
                </div> <!-- three_column #end -->
                
                <div class="three_column right">
                    <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer3'); }?>
                </div> <!-- three_column #end -->
         	 </div> <!-- bottom in #end -->
          </div> <!-- bottom #end -->    
		<?php
  		}else if(templ_is_footer_widgets_4col())
		{?> 
    	 <div class="bottom">
           <div class="bottom_in clear">
             		<div class="foruth_column left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
            </div> <!-- three_column #end -->
            
            
            <div class="foruth_column spacer_4col left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
            </div> <!-- three_column #end -->
            
            <div class="foruth_column spacer_4col left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer3'); }?>
            </div> <!-- three_column #end -->
            
             <div class="foruth_column right">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer4'); }?>
            </div> <!-- three_column #end -->
         	  </div> <!-- bottom in #end -->
          </div> <!-- bottom #end -->
        <?php	
 		}else if(templ_is_footer_widgets_fullwidth())
		{?> 
        <div class="bottom">
           <div class="bottom_in clear">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
         	 </div> <!-- bottom in #end -->
          </div> <!-- bottom #end -->
        <?php }?>
 <!-- bottom section #end  -->