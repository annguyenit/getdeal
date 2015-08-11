<?php 
if(!function_exists('get_location_map_javascripts'))
{
	function get_location_map_javascripts($geo_latitude = '',$geo_longitude = '',$address = '')
	{
	?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo get_option('pttheme_google_map_api');?>" type="text/javascript"></script>
<script type="text/javascript">
/* <![CDATA[ */
window.onload = function () {main_function();}
window.onunload = function () {GUnload();}
var map;
var latlng;
var geocoder;
var address;

<?php 
if(stripslashes($geo_latitude) && stripslashes($geo_longitude))
{
?>
var CITY_MAP_CENTER_LAT = '<?php echo $geo_latitude;?>';
var CITY_MAP_CENTER_LNG = '<?php echo $geo_longitude;?>';
<?php
}else
{
?>
var CITY_MAP_CENTER_LAT = '<?php echo get_option('ptthemes_latitute');?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_option('ptthemes_longitute');?>';
var CITY_MAP_ZOOMING_FACT=<?php echo get_option('ptthemes_scaling_factor');?>;
<?php }?>

if(CITY_MAP_CENTER_LAT=='')
{
	var CITY_MAP_CENTER_LAT = 34;	
}
if(CITY_MAP_CENTER_LNG=='')
{
	var CITY_MAP_CENTER_LNG = 0;	
}
if(CITY_MAP_CENTER_LAT!='' && CITY_MAP_CENTER_LNG!='' && CITY_MAP_ZOOMING_FACT!='')
{
	var CITY_MAP_ZOOMING_FACT = 13;
}else if(CITY_MAP_ZOOMING_FACT!='')
{
	var CITY_MAP_ZOOMING_FACT = 3;	
}
function initialize() {
  map = new GMap2(document.getElementById("map_canvas"));
 //map.setCenter(new GLatLng(0,34), 3);
  map.setCenter(new GLatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG), CITY_MAP_ZOOMING_FACT);
  map.addControl(new GLargeMapControl);
  
  
    GEvent.addListener(map, "click", getAddress);
  	geocoder = new GClientGeocoder();
    var marker = new GMarker(new GLatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG), {draggable: true});

    GEvent.addListener(marker, "dragstart", function() {
      map.closeInfoWindow();
    });
	
	GEvent.addListener(marker, "dragend", function() {

	var lat = marker.getLatLng().lat();
	var lng = marker.getLatLng().lng();

  /*  
     if(eval(marker.A)){
	 var lat = marker.A.Nd;
	 }
	 if(eval(marker.A)){
	 var lng = marker.A.Ga;
	 }
	 if(eval(marker.B)){
	 var lat = marker.B.Nd;
	 }
	 if(eval(marker.B)){
	 var lng = marker.B.Ga;
	 }
	if(eval(marker.C)){
	 var lat = marker.C.Nd;
	 }
	 if(eval(marker.C)){
	 var lng = marker.C.Ga;
	 }
	 if(eval(marker.D)){
	 var lat = marker.D.Nd;
	 }
	 if(eval(marker.D)){
	 var lng = marker.D.Ga;
	 }
	 if(eval(marker.Ca)){
	 var lat = marker.Ca.Md;
	 }
	 if(eval(marker.Ca)){
	 var lng = marker.Ca.Ha;
	 }
*/
      marker.openInfoWindowHtml('<b><?php _e('Latitude:');?></b>' + lat + '<br><b><?php _e('Longitude:');?></b>' + lng);
	  document.getElementById('geo_latitude').value=lat;
      document.getElementById('geo_longitude').value=lng;
    });
    map.addOverlay(marker);
	
}

function dumpProps(obj, parent) {
   // Go through all the properties of the passed-in object
   for (var i in obj) {
      // if a parent (2nd parameter) was passed in, then use that to
      // build the message. Message includes i (the object's property name)
      // then the object's property value on a new line
      if (parent) { var msg = parent + "." + i + "\n" + obj[i]; } else { var msg = i + "\n" + obj[i]; }
      // Display the message. If the user clicks "OK", then continue. If they
      // click "CANCEL" then quit this level of recursion
      if (!confirm(msg)) { return; }
      // If this property (i) is an object, then recursively process the object
      if (typeof obj[i] == "object") {
         if (parent) { dumpProps(obj[i], parent + "." + i); } else { dumpProps(obj[i], i); }
      }
   }
}

function getAddress(overlay, latlng) {
  if (latlng != null) {
    address = latlng;
    geocoder.getLocations(latlng, showAddress);
  }
}

function showAddress(response) {
  map.clearOverlays();
  if (!response || response.Status.code != 200) {
    alert("<?php _e('Status Code:');?>" + response.Status.code);
  } else {
    place = response.Placemark[0];
    point = new GLatLng(place.Point.coordinates[1],
                        place.Point.coordinates[0]);
    marker = new GMarker(point, {draggable: true});
    map.addOverlay(marker);
    marker.openInfoWindowHtml(
    '<b><?php _e('Lat-Long:');?></b>' + place.Point.coordinates[1] + "," + place.Point.coordinates[0] + '<br>' +
    '<b><?php _e('Address:');?></b>' + place.address
    );
	document.getElementById('geo_latitude').value = place.Point.coordinates[1];
	document.getElementById('geo_longitude').value = place.Point.coordinates[0];

	GEvent.addListener(marker, "dragstart", function() {
	  map.closeInfoWindow();
	});
	
	
	GEvent.addListener(marker, "dragend", function() {
		var lat = marker.getLatLng().lat();
	  var lng = marker.getLatLng().lng();

	  marker.openInfoWindowHtml('<b><?php _e('Latitude:');?></b>' + lat + '<br><b><?php _e('Longitude:');?></b>' + lng + '<br>');
	  document.getElementById('geo_latitude').value=lat;
	  document.getElementById('geo_longitude').value=lng;
	 
	});   
  }
}
function findAddress(address) {
  if (geocoder) {
    geocoder.getLatLng(
      address,
      function(point) {
        if (!point) {
          alert(address + "<?php _e('not found');?>");
        } else {
          map.setCenter(point, 13);
         geocoder.getLocations(point, showAddress);
        }
      }
    );
	return marker;

  }
}
/* ]]> */
</script>
	<?php
	}
}
get_location_map_javascripts($geo_latitude,$geo_longitude,$shipping_address);
?>
<script type="text/javascript">
window.onload = function () {initialize();}
window.onunload = function () {GUnload();}
</script>
<input type="button" class="b_addressmap" value="<?php _e('Set Address on Map');?>" onclick="findAddress(document.getElementById('shhiping_address').value);" />
<div id="map_canvas" style=" height:300px; margin-right:40px; position:relative; width:420px;"  class="form_row clearfix">
</div>