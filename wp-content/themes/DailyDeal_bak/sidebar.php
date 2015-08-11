<?php
/**
 * The Sidebar containing the Sidebar 1 and Sidebar 2 widget areas.
 */
?>
<?php templ_before_sidebar(); // before sidebar hooks?>

<?php

if(templ_is_layout('3_col_fix'))  ////Sidebar 3 column fixed
{
	templ_sidebar1('sidebar sidebar_3col_l left');
	templ_sidebar2('sidebar sidebar_3col_r right');	
}else
if(templ_is_layout('3_col_left'))  ////Sidebar 3 column left
{
?>
	<div class="sidebar sidebar_3col_merge_l left">
<?php
	templ_sidebar_2col_merge();
	templ_sidebar1('sidebar_3col_l_m left');
	templ_sidebar2('sidebar_3col_r_m right');
?>
	</div>
<?php
}else
if(templ_is_layout('3_col_right'))  ////Sidebar 3 column right
{
?>
	<div class="sidebar sidebar_3col_merge_r right">
<?php
	templ_sidebar_2col_merge();
	templ_sidebar1('sidebar_3col_l_m left');
	templ_sidebar2('sidebar_3col_r_m right');
?>
	</div>
<?php
}else
if(templ_is_layout('full_width'))  ////Sidebar Full width page
{
	
}else
if(templ_is_layout('2_col_right'))  ////Sidebar 2 column right
{
	templ_sidebar1('sidebar right');
}
else  ////Sidebar 2 column left as default setting
{
	templ_sidebar1('sidebar left');
}
?>
<?php templ_after_sidebar(); // after sidebar hooks?>