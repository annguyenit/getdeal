.GTTabs_divs{
	padding: 8px;
	border: 1px solid #d9d9d9;
	border-top: 0 !important;
	width: 96%;
	box-shadow:0px 0px 10px #D1D1D1	
}


.GTTabs_titles{
	display:none;	
}

ul.GTTabs
	{
	<?php if ($GTTabs_options["layout"]=="vertical") echo "float: left;"; ?>
	width: <?php if ($GTTabs_options["layout"]=="horizontal") echo $GTTabs_options["width"]; else echo "auto"; ?>;
	height: <?php echo $GTTabs_options["height"]; ?>;
	margin: <?php if ($GTTabs_options["layout"]=="horizontal") echo "0px 0px 1em"; else echo "0px 1em 1em 0px"; ?> !important;
	padding: <?php if ($GTTabs_options["layout"]=="horizontal") echo "0.2em 1em 0.2em ".$GTTabs_options["spacing"]; else echo "1em 0px ".$GTTabs_options["spacing"]." 0.2em"; ?> !important;		
	font-size: <?php echo $GTTabs_options["font-size"]; ?>;
	list-style-type: none !important;
	line-height:normal;
	text-align: <?php if ($GTTabs_options["layout"]=="horizontal") echo $GTTabs_options["align"]; else echo "right"; ?>;
	display: block !important;
	background: none;
	margin-bottom: 0px !important;
	}

ul.GTTabs li
	{	
	<?php if ($GTTabs_options["layout"]=="horizontal") echo "display: inline !important;"; ?>
	font-size: <?php echo $GTTabs_options["font-size"]; ?>;
	line-height:normal;
	background: none;
	padding: 0px;
	margin:1em 0px 0px 0px;
	box-shadow:0px 0px 10px #D1D1D1	
	}
  
ul.GTTabs li:before{
content: none;	
}  
  	
ul.GTTabs li a
	{
	text-decoration: none;
	background: <?php echo $GTTabs_options["inactive_bg"]; ?>;
	border: 1px solid <?php echo $GTTabs_options["line"]; ?>  !important;	
	padding: 0.5em 3.4em !important;
	color: <?php echo $GTTabs_options["inactive_font"]; ?> !important;
	outline:none;	
	cursor: pointer;
	
	}
	
ul.GTTabs li.GTTabs_curr a{
	border-<?php if ($GTTabs_options["layout"]=="horizontal") echo "bottom:"; else echo "right:"; ?>: 1px solid <?php echo $GTTabs_options["active_bg"] ?> !important;
	background: <?php echo $GTTabs_options["active_bg"]; ?>;
	color: <?php echo $GTTabs_options["active_font"]; ?> !important;
	text-decoration: none;	
	border-bottom: 0px !important;
	}

ul.GTTabs li a:hover
	{
	color: <?php echo $GTTabs_options["over_font"]; ?> !important;
	background: <?php echo $GTTabs_options["over_bg"]; ?>;
	text-decoration: none;
	
	}

.GTTabsNavigation{
	display: block !important;
	overflow:hidden;
}

.GTTabs_nav_next{
	float:right;
}

.GTTabs_nav_prev{
	float:left;
}
