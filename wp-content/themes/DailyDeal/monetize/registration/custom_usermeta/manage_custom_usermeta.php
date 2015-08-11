<?php
//Custom Settings
if(!function_exists('templ_get_user_custom_meta_array')){
function templ_get_user_custom_meta_array()
{
	$pt_metaboxes = array();
	return apply_filters('templ_admin_post_custom_fields_filter',$pt_metaboxes);
}
}

if(!function_exists('ptthemes_meta_box_content')){
function ptthemes_meta_box_content($post, $metabox ) {
    global $post;
	$pt_metaboxes = get_post_custom_fields_templ($metabox['args']['post_types']);
    $output = '';
    if($pt_metaboxes){
   $output .= '<div class="pt_metaboxes_table">'."\n";
   $output .= '<script>var rootfolderpath = "'.get_template_directory_uri().'/images/";</script>'."\n";
   $output .= '<script type="text/javascript" src="'.get_template_directory_uri().'/js/dhtmlgoodies_calendar.js"></script>'."\n";
   $output .= ' <link href="'.get_template_directory_uri().'/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />'."\n";
   $output .='<input type="hidden" name="templatic_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
   foreach ($pt_metaboxes as $pt_id => $pt_metabox) {
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'radio' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea' OR $pt_metabox['type'] == 'upload' OR $pt_metabox['type'] == 'date' OR $pt_metabox['type'] == 'multicheckbox' OR $pt_metabox['type'] == 'texteditor')
            $pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
            if ($pt_metaboxvalue == "" || !isset($pt_metaboxvalue)) {
                $pt_metaboxvalue = $pt_metabox['default'];
            }
            if($pt_metabox['type'] == 'text'){
            
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input size="100" class="pt_input_text" type="'.$pt_metabox['type'].'" value="'.$pt_metaboxvalue.'" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'"/></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }
            
            elseif ($pt_metabox['type'] == 'textarea'){
            			
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }
			
			elseif ($pt_metabox['type'] == 'texteditor'){
            			
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }

            elseif ($pt_metabox['type'] == 'select'){
                            
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><select class="pt_input_select" id="'.$pt_id.'" name="ptthemes_'. $pt_metabox["name"] .'"></p>'."\n";
                $output .= '<option>Select a '.$pt_metabox['label'].'</option>';
                
                $array = $pt_metabox['options'];
                
                if($array){
                    foreach ( $array as $id => $option ) {
                        $selected = '';
                        if($pt_metabox['default'] == $option){$selected = 'selected="selected"';} 
                        if($pt_metaboxvalue == $option){$selected = 'selected="selected"';}
                        $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
                    }
                }
                $output .= '</select><p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
            }
			elseif ($pt_metabox['type'] == 'multicheckbox'){
				
					$output .= "\t".'<div>';
					$output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
					 $array = $pt_metabox['options'];
					if($array){
						foreach ( $array as $id => $option ) {
						   
						    $checked='';
							if($pt_metaboxvalue!=""){
							$fval_arr = explode(',',$pt_metaboxvalue);
							if(in_array($option,$fval_arr)){ $checked='checked="checked"';}
							}else{
							$fval_arr = explode(',',$pt_metabox['default']);
							if(in_array($option,$fval_arr)){$checked = 'checked="checked"';} 
							}
							$output .= "\t\t".'<div class=\"multicheckbox\"><input type="checkbox" '.$checked.' class="pt_input_radio" value="'.$option.'" name="ptthemes_'. $pt_metabox["name"] .'[]" />  ' . $option .'</div>'."\n";
						}
					}
					$output .= ''.$pt_metabox['desc'].'</p>'."\n";
					$output .= "\t".'</div>'."\n";
			}
			 elseif ($pt_metabox['type'] == 'date'){
            			
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input size="40" class="pt_input_text" type="text" value="'.$pt_metaboxvalue.'" name="ptthemes_'.$pt_metabox["name"].'" /><img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.post.ptthemes_'.$pt_metabox["name"].',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" /></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }
			elseif ($pt_metabox['type'] == 'radio'){
					$output .= "\t".'<div>';
					$output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
					 $array = $pt_metabox['options'];
					if($array){
						foreach ( $array as $id => $option ) {
						   
						   $checked='';
						   if($pt_metabox['default'] == $option){$checked = 'checked="checked"';} 
							if(trim($pt_metaboxvalue) == trim($option)){$checked = 'checked="checked"';}
							$output .= "\t\t".'<div class=\"input_radio\"><input type="radio" '.$checked.' class="pt_input_radio" value="'.$pt_metaboxvalue.'" name="ptthemes_'. $pt_metabox["name"] .'" />  ' . $option .'</div>'."\n";
						}
					}
					$output .= ''.$pt_metabox['desc'].'</p>'."\n";
					$output .= "\t".'</div>'."\n";
			}
            elseif ($pt_metabox['type'] == 'checkbox'){
                if($pt_metaboxvalue == '1') { $checked = 'checked="checked"';} else {$checked='';}
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input type="checkbox" '.$checked.' class="pt_input_checkbox"  id="'.$pt_id.'" value="1" name="ptthemes_'. $pt_metabox["name"] .'" /></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
            }
			 elseif ($pt_metabox['type'] == 'upload'){
               $pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
			   
			   if($pt_metaboxvalue!="")
			   $up_class="upload ".$pt_metaboxvalue;
			   else
			   $up_class="upload has-file";
			   
				$output .= '<div class="option option-upload"><div class="section">
      <div class="element">';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= '<input type="text" class="'.$up_class.'"  id="ptthemes_'. $pt_metabox["name"] .'" name="ptthemes_'. $pt_metabox["name"] .'" value="'.$pt_metaboxvalue.'"/> <input id="upload_'.$pt_id.'" class="upload_button" type="button" value="'.__('Upload','templatic').'" rel="'.$pt_id.'" /><div class="screenshot" id="ptthemes_'. $pt_metabox["name"] .'_image">';
				 if ( isset( $pt_metaboxvalue ) && $pt_metaboxvalue != '' ) 
				{ 
					$remove = '<a href="javascript:(void);" class="remove">Remove</a>';
					$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $pt_metaboxvalue );
					if ( $image ) 
					{
						$output .='<img src="'.$pt_metaboxvalue.'" alt="" />'.$remove.'';
					} 
					else 
					{
						$parts = explode( "/", $pt_metaboxvalue );
						for( $i = 0; $i < sizeof($parts); ++$i ) 
						{
							$title = $parts[$i];
						}
					$output .='<div class="no_image"><a href="'.$pt_metaboxvalue.'">'.$title.'</a>'.$remove.'</div>';
					}
				}
				$output .='</div></div>';
                $output .= '<div class="description">'.$pt_metabox['desc'].' </div>';
                $output .= '</div></div></div>'."\n";
            }else
			if($pt_metabox['type'] == 'geo_map'){
				$geo_address = get_post_meta($post->ID,'geo_address',true);
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="geo_address">'.__('Geo Address','templatic').'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input size="100" class="pt_input_text" type="text" value="'.$geo_address.'" name="ptthemes_geo_address" id="geo_address"/></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.__('Please enter address. eg. : 230 Vine Street And locations throughout Old City, Philadelphia, PA 19106','templatic').'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
				
				$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="geo_latitude">'.__('Geo Latitude','templatic').'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input size="100" class="pt_input_text" type="text" value="'.$geo_latitude.'" name="ptthemes_geo_latitude" id="geo_latitude"/></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.__('Enter Geo Latitude. eg. : 38.8225909761771','templatic').'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
				
				$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="geo_longitude">'.__('Geo Longitude','templatic').'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input size="100" class="pt_input_text" type="text" value="'.$geo_longitude.'" name="ptthemes_geo_longitude" id="geo_longitude"/></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.__('Enter Geo Longitude. eg. : 12.65625','templatic').'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
				
				              
            }
        }
	$output .= '</div>'."\n\n";
    }
	echo $output;
}
}

if(!function_exists('ptthemes_metabox_insert')){
function ptthemes_metabox_insert($post_id) {
    global $globals;
	// verify nonce
    if (!wp_verify_nonce($_POST['templatic_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
   $pt_metaboxes = get_post_custom_fields_templ($_POST['post_type']);
   $pID = $_POST['post_ID'];
    $counter = 0;

    
    foreach ($pt_metaboxes as $pt_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea' OR $pt_metabox['type'] == 'radio'  OR $pt_metabox['type'] == 'upload' OR $pt_metabox['type'] == 'date' OR $pt_metabox['type'] == 'multicheckbox' OR $pt_metabox['type'] == 'geo_map' OR $pt_metabox['type'] == 'texteditor') // Normal Type Things...
        {
			
            $var = "ptthemes_".$pt_metabox["name"];
			if($pt_metabox['type'] == 'multicheckbox'){
				
				if(is_array($_POST[$var])){
				$multi_chb = implode(",",$_POST[$var]);
				unset($_POST[$var]);
				$_POST[$var]=$multi_chb;
								   }
			}
			
			if($pt_metabox['type'] == 'geo_map'){
				update_post_meta($pID, 'geo_address', $_POST['ptthemes_geo_address']);
				update_post_meta($pID, 'geo_latitude', $_POST['ptthemes_geo_latitude']);
				update_post_meta($pID, 'geo_longitude', $_POST['ptthemes_geo_longitude']);
				}
			
           // if (isset($_POST[$var])) {            
                if( get_post_meta( $pID, $pt_metabox["name"] ) == "" )
                    add_post_meta($pID, $pt_metabox["name"], $_POST[$var], true );
                elseif($_POST[$var] != get_post_meta($pID, $pt_metabox["name"], true))
                    update_post_meta($pID, $pt_metabox["name"], $_POST[$var]);
                elseif($_POST[$var] == "")
                    delete_post_meta($pID, $pt_metabox["name"], get_post_meta($pID, $pt_metabox["name"], true));
          // }  
        } 
    }
}
}


if(!function_exists('ptthemes_meta_box')){
	function ptthemes_meta_box() {
		$custom_post_types_args = array();  
		$custom_post_types = get_post_types($custom_post_types_args,'objects');   
		foreach ($custom_post_types as $content_type) 
		{
			if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page')
			{
				$post_types=$content_type->name;
//$pt_metaboxes = get_post_custom_fields_templ($post_types);
				if ( function_exists('add_meta_box') && $pt_metaboxes ) {
				//	apply_filters('templ_admin_post_type_custom_filter',add_meta_box('ptthemes-settings',apply_filters('templ_admin_post_custom_fields_title_filter','Custom Settings'),'ptthemes_meta_box_content',$post_types,'normal','high',array( 'post_types' => $post_types)));
				}
			}
		}
	}
}

add_action('admin_menu', 'ptthemes_meta_box');
add_action('save_post', 'ptthemes_metabox_insert');
?>