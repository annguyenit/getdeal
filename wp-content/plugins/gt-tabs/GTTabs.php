<?php
/*
Plugin Name: GT Tabs
Plugin URI: http://www.CustomDesignSite.net/gt-tabs/
Description: GT Tabs allows you to easily split your post/page content into Tabs that will be shown to your visitors
Author: Billy Bryant
Version: 3.1
Author URI: http://www.CustomDesignSite.net/

    GTTabs is released under the GNU General Public License (GPL)
    http://www.gnu.org/licenses/gpl.txt

    
*/

//////////////////////////////////////////////////////////

function GTTabs_init(){
	if(!get_option("GTTabs")){

		# Load default options
		$options["active_font"] = "#000000";
		$options["active_bg"] = "#fff";
		$options["inactive_font"] = "#666";
		$options["inactive_bg"] = "#f3f3f3";
		$options["over_font"] = "#666";
		$options["over_bg"] = "#fff";
		$options["line"] = "#ccc";
		$options["align"] = "left";
		$options["width"] = "auto";
		$options["height"] = "auto";
		$options["layout"] = "horizontal";
		$options["spacing"] = "20px";
		$options["font-size"] = "11px";
		$options["list_link"] = "hideshow";
		$options["single_link"] = "hideshow";
		$options["show_perma"] = "never";
		$options["TOC"] = "0";
		$options["cookies"] = "1";
		update_option("GTTabs", $options);
	}

}


///////////////////// PLUGIN PATH ////////////////////////////
// required for Windows & XAMPP
$myabspath = str_replace("\\","/",ABSPATH);  
define('WINABSPATH', $myabspath);
// Pre-2.6 compatibility
if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', WINABSPATH . 'wp-content' );
	
define('GTTabs_FOLDER', plugin_basename( dirname(__FILE__)) );
define('GTTabs_ABSPATH', WP_CONTENT_DIR.'/plugins/'.plugin_basename( dirname(__FILE__)).'/' );
define('GTTabs_URLPATH', WP_CONTENT_URL.'/plugins/'.plugin_basename( dirname(__FILE__)).'/' );

//////////////////////////////////////////////////////////////


function GTTabs_filter($a){
	
	$b = "[tab:";
	$c = 0;
	
	#Search for tabs inside the post
	if(is_int(strpos($a, $b, $c))){
		
		$options = get_option("GTTabs");
		global $user_ID;	
		
		# What kind of link should be used?
		if(is_single() || is_page()){
			$linktype = $options["single_link"];
		}else{
			$linktype = $options["list_link"];
		}
		
		$vai = true;
		$results_i = array();
		$results_f = array();
		$results_t = array();
		$post = get_the_ID();

		 #find the begining, the end and the title of the tabs
		 while ($vai)  {	
			$r = strpos($a, $b, $c);
			if (is_int($r)){
				array_push($results_i, $r);
				$c=$r+1;
				$f = strpos($a, "]", $c);
				if($f){
					array_push($results_f, $f);
					array_push($results_t, substr($a, $r+5, $f-($r+5)));
				}	
			}else $vai = false;		
		};

		#If there is text before the first tab, print it
		If ($results_i[0] > 0) $op .= substr($a, 0, $results_i[0]);
		
		#Print the list of tabs only when we are not in RSS feed
		if(!is_feed()){
			
			#Print the tabs links
			$op .= "<ul id='GTTabs_ul_$post' class='GTTabs' style='display:none'>\n";
			
			for ($x=0; $x<sizeof($results_t); $x++){
				if($results_t[$x]!="END"){
					$op .= "<li id='GTTabs_li_".$x."_$post' ";
					if ($x==0) $op .= "class='GTTabs_curr'";		
					#$link = ($linktype=="permalink") ? get_GTTabs_permalink($x) : "javascript:GTTabs_show($x,$post)";		
					$link = ($linktype=="permalink") ? "href='" . get_GTTabs_permalink($x) ."'" : " class='GTTabsLinks'";		
					$op .= "><a  id=\"" . $post . "_$x\" onMouseOver=\"GTTabsShowLinks('".$results_t[$x]."'); return true;\"  onMouseOut=\"GTTabsShowLinks();\" $link>".$results_t[$x]."</a></li>\n";
				}		
			}
			$op .= "</ul>\n\n";
		}

		#print tabs content
		for ($x=0; $x<sizeof($results_t); $x++){
			
			#if tab title is END, just print the rest of the post
			if ($results_t[$x]=="END") {
				
				## Prints the table of contents
				if(!is_feed() && $options["TOC"]=="rightAfter") $op.=GTTabs_printTOC($results_t,$post,$linktype,$options["TOC_title"]);
				
				$op .= substr($a, $results_f[$x]+1);
				break;	
			}
			
			$op .= "<div class='GTTabs_divs";
			if ($x==0) $op .= " GTTabs_curr_div";
			$op .= "' id='GTTabs_".$x."_$post'>\n";
			
			#This is the hidden title that only shows up on RSS feed or somewhere outside the context like a print page
			$op .= "<span class='GTTabs_titles'><b>".$results_t[$x]."</b></span>";
			
			$ini = $results_f[$x]+1;
			if (sizeof($results_t)-$x==1){
				$op .= substr($a, $results_f[$x]+1);
			}else{
				$op .= substr($a, $results_f[$x]+1, $results_i[$x+1]-$results_f[$x]-1);
			}
			
			#Display permalink?
			if($options["show_perma"]!="never" && (($options["show_perma"]=="all") || ($options["show_perma"]=="registered" && $user_ID)   ) ){
				$op .= "<span class='postmetadata'>Permalink to this post: " . get_GTTabs_permalink($x) . "</span>";
			}
			
			#Print the navigation
			if(!is_feed() && $options["TOC"]=="navigation"){
				$linkprev = 0;
				$linknext = 0;
				if($x>0)
					#$linkprev = ($linktype=="permalink") ? get_GTTabs_permalink($x-1) : "#GTTabs_ul_$post' onClick='GTTabs_show(".($x-1).",$post)";		
					$linkprev = "#GTTabs_ul_$post' onClick='GTTabs_show(".($x-1).",$post)";		
				if ($x< (sizeof($results_t)-1)){
					if ($results_t[$x+1]!="END")
						#$linknext = ($linktype=="permalink") ? get_GTTabs_permalink($x+1) : "#GTTabs_ul_$post' onClick='GTTabs_show(".($x+1).",$post)";
						$linknext = "#GTTabs_ul_$post' onClick='GTTabs_show(".($x+1).",$post)";
				}
				if($linkprev || $linknext){	
					$op .= "<div class='GTTabsNavigation' style='display:none'>";
					if ($linkprev)
						$op .= "<span class='GTTabs_nav_prev'><a href='$linkprev'>&lt;&lt; ".$results_t[$x-1]."</a></span>";
					if ($linknext)
						$op .= "<span class='GTTabs_nav_next'><a href='$linknext'>".$results_t[$x+1]." &gt;&gt;</a></span>";
					$op .= "</div>";
				}
			}
			$op .= "</div>\n\n";
		}
		
		## Prints the table of contents
		if(!is_feed() && $options["TOC"]=="END") $op.=GTTabs_printTOC($results_t,$post,$linktype,$options["TOC_title"]);
		
		
		
		#handle permalinks and cookies
		if ($_GET["GTTabs"]!=""){
			$op .= "<script type='text/javascript'>jQuery(document).ready(function() { GTTabs_show(".$_GET["GTTabs"].",$post); });</script>";	
		}else{		
			if ($options["cookies"]) $op .= "<script type='text/javascript'>jQuery(document).ready(function() { if(GTTabs_getCookie('GTTabs_$post')) GTTabs_show(GTTabs_getCookie('GTTabs_$post'),$post); });</script>";
		}
		
		#return
		return $op;
	}else{
		return $a;	
	}

}


function get_GTTabs_permalink($tab){
	$link = get_permalink();
	$signal = (substr_count($link,"?")) ? "&" : "?";
	return $link . $signal . "GTTabs=$tab" ;
}


function GTTabs_printTOC($results_t,$post,$linktype,$title=""){
	
	if ($title) $op .= "<br><b>$title</b>";
	$op .= "<ul class='GTTabs_TOC'>\n";
			
	for ($x=0; $x<sizeof($results_t); $x++){
		if($results_t[$x]!="END"){
			$op .= "<li id='GTTabs_li_".$x."_$post' ";
			//if ($x==0) $op .= "class='GTTabs_curr'";		
			#$link = ($linktype=="permalink") ? get_GTTabs_permalink($x) : "#GTTabs_ul_$post' onClick='GTTabs_show($x,$post)";		
			$link = ($linktype=="permalink") ? get_GTTabs_permalink($x) : "#GTTabs_ul_$post' class='GTTabsLinks'";		
			$op .= "><a id=\"" . $post . "_$x\" onMouseOver=\"GTTabsShowLinks('".$results_t[$x]."'); return true;\"  onMouseOut=\"GTTabsShowLinks();\" href='$link'>".$results_t[$x]."</a></li>\n";
		}		
	}
	$op .= "</ul>\n\n";
	return $op;

}


function GTTabs_addCSS(){
	$GTTabs_options=get_option("GTTabs");
	?>
	<style type="text/css">
	    <?php require_once("style.php"); ?>
	</style>
	<?php
}

function GTTabs_addJS() {
       wp_enqueue_script('jquery'); 
       wp_enqueue_script('GTTabs', GTTabs_URLPATH . 'GTTabs.js'); 
}


function GTTabs_admin_addCSS(){
	$GTTabs_options=get_option("GTTabs");
	?>
	<style type="text/css">
	<?php require_once("style_admin.php"); ?>
	</style>
	<?php

}

function GTTabs_admin_addJS() {
       wp_enqueue_script('GTTabsColorpicker', GTTabs_URLPATH . '301a.js'); 
}

function GTTabs_admin() {
	if (function_exists('add_options_page')) {
		add_options_page('GT Tabs Setup', 'GT Tabs Setup', 8, basename(__FILE__), 'GTTabs_admin_page');
	}
}

function GTTabs_admin_page() {
	
	require_once("GTTabs_admin.php");

}

register_activation_hook( __FILE__, 'GTTabs_init' );

add_filter('the_content', 'GTTabs_filter');

add_action('wp_head','GTTabs_addCSS');
add_action('admin_head','GTTabs_admin_addCSS');

add_action('wp_print_scripts','GTTabs_addJS');
add_action('admin_print_scripts','GTTabs_admin_addJS');

add_action('admin_menu','GTTabs_admin');
?>
