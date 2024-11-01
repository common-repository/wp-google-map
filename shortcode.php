 <?php
 if ( ! defined( 'ABSPATH' ) ) exit;
 $db = $wpdb->prefix."address";
 
 $id_map =$attr['id'];
 $height = str_replace('px','',$attr['height']);
 
 $get_r = $wpdb->get_row("select * from $db where id='$id_map'",ARRAY_A);

 if(count($get_r)>0){
 $latitude      = $get_r['latitude'];
 $longitude     = $get_r['longitude'];
 $address       = $get_r['address'];
 ?>
 <style>
      #map {
        height: <?php echo $height; ?>px;
      }
    </style>
    <div id="map"></div>
    
    <script>

      function initMap() {
        var myLatLng = {lat:<?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: '<?php echo esc_html($address) ?>'
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBieCXD_X2tbov2Tj_PA_KVSshPCqRcVEU&callback=initMap">
    </script>
<?php
}
?>