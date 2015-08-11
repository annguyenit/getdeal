<?php
if(!function_exists('show_address_google_map'))
{
    function show_address_google_map($latitute,$longitute,$address,$width='640',$height='350')
    {
    ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo get_option('pttheme_google_map_api');?>" type="text/javascript"></script>
<script type="text/javascript" src="http://maps.gstatic.com/intl/en_ALL/mapfiles/340c/maps2.api/main.js"></script>
    <script type="text/javascript">
    var map = null;
    var geocoder = null;
    var lat = <?php echo $latitute;?>;
    var lng = <?php echo $longitute;?>;
    function initialize() {
     
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));

        map.setCenter(new GLatLng(lat, lng), 13);
      
        function createMarker(latlng, number) {
          var marker = new GMarker(latlng);
          marker.value = number;
          GEvent.addListener(marker,"click", function() {
            var myHtml =  "<?php echo $address;?>";
            map.openInfoWindowHtml(latlng, myHtml);
          });
          return marker;
        }
    
          var latlng = new GLatLng(lat,lng);
            map.addOverlay(createMarker(latlng, 1));
      }
    }
    window.onload = function () {initialize();}
    window.onunload = function () {GUnload();}
    </script>
    <div class="map" id="map_canvas" style="width:<?php echo $width;?>px; height:<?php echo $height;?>px;margin-left:0px;"></div>
    <?php
    }
}
?>