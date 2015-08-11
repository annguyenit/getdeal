<?php ob_start();?>
<?php if(get_option('ptthemes_fonts')){?>
body, input, textarea, select { 
font-family:<?php echo get_option('ptthemes_fonts');?>
 }<?php }?>
<?php if(get_option('ptthemes_body_background_color')){?>
 body { background: <?php echo get_option('ptthemes_body_background_color');?> !important; }
<?php }?>
<?php if(get_option('ptthemes_body_background_image')){?>
 body { background:<?php if(get_option('ptthemes_body_background_color')){ echo get_option('ptthemes_body_background_color');?> <?php }?> <?php if(get_option('ptthemes_body_background_image')){?>url(<?php echo get_option('ptthemes_body_background_image');?>)<?php }?> <?php if(get_option('ptthemes_body_bg_postions')){ echo get_option('ptthemes_body_bg_postions');}?> !important; }
<?php }?>
<?php if(get_option('ptthemes_link_color_normal')){?>
a { color:<?php echo get_option('ptthemes_link_color_normal');?> !important;  }
<?php }?>
<?php if(get_option('ptthemes_link_color_hover')){?>
a:hover { color:<?php echo get_option('ptthemes_link_color_hover');?> !important;   }
<?php }?>
<?php if(get_option('ptthemes_main_title_color')){?>
h1, h2, h3, h4, h5, h6 { color:<?php echo get_option('ptthemes_main_title_color');?> !important; }
<?php }?>
<?php
$data = ob_get_contents();
ob_clean();

if($data)
{
?>
<style type="text/css"> <?php echo $data;?> </style>
<?php }?>
