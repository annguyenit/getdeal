<?php
$_SESSION['count'] = 0;
// =============================== Location Map Widget ======================================
if(!class_exists('templ_locationmap'))
{
	class templ_locationmap extends WP_Widget {
		function templ_locationmap() {
		//Constructor
			$widget_ops = array('classname' => 'widget location_map', 'description' => apply_filters('templ_googlemap_widget_desc_filter','Enter your location OR latitude and longitude to show address on map'));		
			$this->WP_Widget('widget_location_map', apply_filters('templ_googlemap_widget_title_filter','T &rarr; Google Map Location'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$address_latitude = empty($instance['address_latitude']) ? '0' : apply_filters('widget_address_latitude', $instance['address_latitude']);
			$address_longitude = empty($instance['address_longitude']) ? '34' : apply_filters('widget_address_longitude', $instance['address_longitude']);
			$address = empty($instance['address']) ? '' : apply_filters('widget_address', $instance['address']);
			$map_type = empty($instance['map_type']) ? 'ROADMAP' : apply_filters('widget_map_type', $instance['map_type']);
			$map_width = empty($instance['map_width']) ? '200' : apply_filters('widget_map_width', $instance['map_width']);
			$map_height = empty($instance['map_height']) ? '200' : apply_filters('widget_map_height', $instance['map_height']);
			$scale = empty($instance['scale']) ? '10' : apply_filters('widget_scale', $instance['scale']);
			
			$address = str_replace('++','+',str_replace(' ','+',str_replace(',','+',$address)));
			?>						
	<div class="widget google_map">
	<?php if($title){?><h3><?php echo $title; ?> </h3><?php }?>
	<?php 
	$geo_latitude=$address_latitude;
	$geo_longitude=$address_longitude;
	if($geo_latitude && $geo_longitude && ($_SESSION['count'] == 0)){?>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
	/* <![CDATA[ */
	  var infowindow, map;
	  function initialize() {
		var mapDiv = document.getElementById('map-canvas');
		map = new google.maps.Map(mapDiv, {
		  center: new google.maps.LatLng(<?php echo $address_latitude;?>, <?php echo $address_longitude;?>),
		  zoom: <?php echo $scale;?>,
		 <?php if($map_type=='ROADMAP' || $map_type=='SATELLITE'|| $map_type=='TERRAIN'){?>
		 mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>,
		 <?php }else{?>
		 mapTypeId: google.maps.MapTypeId.ROADMAP,
		 <?php }?>
		});
	  
		var content = '<span style="font-size:12px;"><?php echo $address;?></span>';
		infowindow = new google.maps.InfoWindow({
		  content: content
		});  
		google.maps.event.addListenerOnce(map, 'idle', addMarkers);
	  }
	  
	  function addMarkers() {
		var bounds = map.getBounds();
		var southWest = bounds.getSouthWest();
		var northEast = bounds.getNorthEast();
		var lngSpan = northEast.lng() - southWest.lng();
		var latSpan = northEast.lat() - southWest.lat();
		var latLng = new google.maps.LatLng(<?php echo $address_latitude;?>, <?php echo $address_longitude;?>);
		var marker = new google.maps.Marker({
		position: latLng,
		map: map
		});	
		google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map, this);
		});
		
	  } 
	  google.maps.event.addDomListener(window, 'load', initialize);
	  /* ]]> */
	</script>
	<div id="map-canvas" style="width: <?php echo $map_width;?>px; height: <?php echo $map_height;?>px"></div>
	
	<?php }else{ 
	
	?>
	<iframe width="<?php echo $map_width;?>" height="<?php echo $map_height;?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="
	http://maps.google.co.za/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $address;?>&amp;output=embed"></iframe>
	<div class="search_location">
	<a class="large_map b_getdirection" target="_blank" href="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $address;?>&amp;sll=<?php echo $geo_latitude;?>,<?php echo $geo_longitude;?>&amp;ie=UTF8&amp;hq=&ll=<?php echo $geo_latitude;?>,<?php echo $geo_longitude;?>&amp;spn=0.368483,0.891953&amp;z=11&iwloc=A"><?php _e('View Large Map','templatic');?></a>
	</div>
	<?php }?>
    <?php if($address){?>
    <span class="get_direction"><a href="http://maps.google.com/maps?f=d&amp;dirflg=d&amp;saddr=<?php echo $address;?>" target="_blank"><?php echo apply_filters('templ_googlemap_widget_get_direction_filter',__('Get Direction on Map &raquo;','templatic'));?></a></span>
    <?php }?>
	</div>
		<?php
			if($args['id'] == 'contact_googlemap')
			{
				$_SESSION['count']= 1;
			}
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = ($new_instance['title']);
			$instance['address'] = strip_tags($new_instance['address']);
			$instance['address_latitude'] = strip_tags($new_instance['address_latitude']);
			$instance['address_longitude'] = strip_tags($new_instance['address_longitude']);
			$instance['map_width'] = strip_tags($new_instance['map_width']);
			$instance['map_height'] = strip_tags($new_instance['map_height']);
			$instance['map_type'] = strip_tags($new_instance['map_type']);
			$instance['scale'] = strip_tags($new_instance['scale']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );		
			$title = ($instance['title']);
			$address = strip_tags($instance['address']);
			$address_latitude = strip_tags($instance['address_latitude']);
			$address_longitude = strip_tags($instance['address_longitude']);
			$map_width = strip_tags($instance['map_width']);
			$map_height = strip_tags($instance['map_height']);
			$map_type = strip_tags($instance['map_type']);
			$scale = strip_tags($instance['scale']);
			
	?>
	<p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
	
	<p><label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address <small>(eg: 230 Vine Street And locations throughout Old City, Philadelphia, PA 19106)</small>','templatic');?> : 
	<input type="text" class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>"  value="<?php echo attribute_escape($address); ?>"></label></p>
	
	<p><label for="<?php  echo $this->get_field_id('address_latitude'); ?>"><?php _e('Address Latitude <small>(eg: 39.955823048131286)</small>','templatic');?> : <input class="widefat" id="<?php  echo $this->get_field_id('address_latitude'); ?>" name="<?php echo $this->get_field_name('address_latitude'); ?>" type="text" value="<?php echo attribute_escape($address_latitude); ?>" /></label></p>
	
	<p><label for="<?php  echo $this->get_field_id('address_longitude'); ?>"><?php _e('Address Longitude <small>(eg: -75.14408111572266)</small>','templatic');?> : 
	<input class="widefat" id="<?php  echo $this->get_field_id('address_longitude'); ?>" name="<?php echo $this->get_field_name('address_longitude'); ?>" type="text" value="<?php echo attribute_escape($address_longitude); ?>" /></label></p> 
	
	<p><label for="<?php echo $this->get_field_id('map_width'); ?>"><?php _e('Map Width in pixcels <small>(eg: 200)</small>','templatic');?> : 
	<input type="text" class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('map_width'); ?>" name="<?php echo $this->get_field_name('map_width'); ?>" value="<?php echo attribute_escape($map_width); ?>"></label></p>
	
	<p><label for="<?php echo $this->get_field_id('map_height'); ?>"><?php _e('Map Height in pixcels <small>(eg: 200)</small>','templatic');?> : <input type="text" class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('map_height'); ?>" name="<?php echo $this->get_field_name('map_height'); ?>" value="<?php echo attribute_escape($map_height); ?>"></label></p>
	
	
	<p>
	<label for="<?php echo $this->get_field_id('scale'); ?>"><?php _e('Map Zooming Factor','templatic');?> : 
	<select id="<?php echo $this->get_field_id('scale'); ?>" name="<?php echo $this->get_field_name('scale'); ?>">
	<?php
	for($i=3;$i<20;$i++)
	{
	?>
	<option value="<?php echo $i;?>" <?php if(attribute_escape($scale)==$i){echo 'selected="selected"';}?> ><?php echo $i;;?></option>
	<?php	
	}
	?>
	</select>
	</label></p>
	
	<p>
	<label for="<?php echo $this->get_field_id('map_type'); ?>"><?php _e('Select Map Type','templatic');?> : 
	<select id="<?php echo $this->get_field_id('map_type'); ?>" name="<?php echo $this->get_field_name('map_type'); ?>">
	<option value="ROADMAP" <?php if(attribute_escape($map_type)=='ROADMAP'){echo 'selected="selected"';}?> ><?php _e('Road Map','templatic');?></option>
	<option value="SATELLITE" <?php if(attribute_escape($map_type)=='SATELLITE'){echo 'selected="selected"';}?>><?php _e('Satellite Map','templatic');?></option>
	<option value="TERRAIN" <?php if(attribute_escape($map_type)=='TERRAIN'){echo 'selected="selected"';}?>><?php _e('Terrain Map','templatic');?></option>
	</select>
	</label>
	</p>
	<?php
	}}
	register_widget('templ_locationmap');
}
?>