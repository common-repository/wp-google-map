<?php
global $wpdb;
if ( ! defined( 'ABSPATH' ) ) exit;
if(isset($_REQUEST['action'])){
    if($_REQUEST['action']=="wgm_get_map_op"){
         $address = sanitize_text_field($_REQUEST['addr']);
        $prepAddr = str_replace(' ','+',$address);
        
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDA6UCUhe6eVvvGKWZ_jX9ywdemoQgFRf8');
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
        $ar_return = array("latitude"=>$latitude,"longitude"=>$longitude);
        echo json_encode($ar_return);
    }
    /*********************
    Delete Map Address
    ***********************/
    if($_REQUEST['action']=='wgm_delete_addr'){
        $db = $wpdb->prefix."address";
        $id = intval($_REQUEST['id']);
        $query = $wpdb->query("delete from $db where id='$id'");
        if($query){
            echo 1;
        }else{
            echo 0;
        }
    }
}
?>