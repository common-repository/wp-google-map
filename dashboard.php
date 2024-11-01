<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;
$db = $wpdb->prefix."address";
if(isset($_REQUEST['keys']) && $_REQUEST['keys']=='save'){
    
    $title = sanitize_text_field($_REQUEST['title']);
    $address = sanitize_text_field($_REQUEST['address']);
    $latitude = $_REQUEST['latitude'];
    $longitude = $_REQUEST['longitude'];
   $q_run =  $wpdb->query( $wpdb->prepare( 
	"
		INSERT INTO $db
		( title,address,latitude,longitude)
		VALUES (%s, %s, %s, %s)
	", 
       $title,$address,$latitude,$longitude
) );
    if($q_run){
        echo "<div class='updated'><p>Map Address Addedd Successfully.</p></div>";
    }else{
        
        echo "<div class='error'><p>An error occurred please try again.</p></div>";
    }
}
?>
<div style="width: 98%; height: auto; float: left;">
<img src="<?php echo plugins_url('images/google-Map.png',__FILE__); ?>" />
<style>
.mm_row{
    width: 100%;
}
.hide_row{
    display: none;
}
</style>
<h1>Add Address</h1>
<form method="post">
<table width="50%" cellspacing="5px">
    <tr>
        <td><b>Title</b></td>
        <td><input type="text" name="title" class="mm_row" /></td>
    </tr>
    <tr>
        <td><b>Address</b></td>
        <td><input type="text" name="address" class="mm_row" />
        <span><b>Example:</b> Street #, Colony, City, Country</span></td>
    </tr>
    <tr class="hide_row">
        <td><b>Latitude</b></td>
        <td><input type="text" name="latitude" class="mm_row" /></td>
    </tr>
     <tr class="hide_row">
        <td><b>Longitude</b></td>
        <td><input type="text" name="longitude" class="mm_row" /></td>
    </tr>
    <tr>
        <td><input type="submit" value="Save" class="button-primary" style="display: none;" id="save" />
        <input type="button" value="Gen Lat & Long" onclick="get_map()" class="button-primary" id="get_p"  />
        <input type="hidden" name="keys" value="save" id="save"  />
        </td>
    </tr>
</table>
</form>
<br />
<table class="wp-list-table widefat fixed striped pages">
	<thead>
	<tr>
        <td width="100px">ID#</td>
        <td>Map Title</td>
        <td>Shortocode</td>
        <td>Actions</td>
    </tr>
	</thead>
<?php
$get_maps = $wpdb->get_results("select * from $db order by id desc",ARRAY_A);
if(count($get_maps)>0){
    $i=1;
    foreach($get_maps as $map){
        echo "<tr id='map_r_$map[id]'>";
        ?>
            <td><?php echo $i; ?></td>
            <td><?php echo esc_html($map['title']); ?></td>
            <td><input type='text' readonly='' value="[google_map ID='<?php echo $map['id'];?>' Height='400']" size='26' /></td>
            <td><a href="#"  title="Delete" onclick="del_map_google(<?php echo $map['id']; ?>)">Delete</a></td>
            <?php
        echo "</tr>";
        $i++;
    }
}else{
    echo "<tr><th colspan='4'><p style='text-align: center;'><b>No Map Created yet</b></p></th></tr>";
}
?>
</table>
</div>
<script>
function del_map_google(id){
    var v = window.confirm('Are you sure to delete this map address?');
    if(v){
        jQuery.post("<?php echo admin_url(); ?>admin-ajax.php?action=wgm_delete_addr","id="+id,function(data){
            if(data==1){
                alert("Map Address Deleted Successfully.");
                jQuery('#map_r_'+id).remove();
            }else{
                alert("An error occured please try again.");
            }
        });
    }
    return false;
}
function get_map(){
    var addr = jQuery("input[name='address']").val();
    jQuery.post("<?php echo admin_url(); ?>admin-ajax.php?action=wgm_get_map_op","addr="+addr,function(data){
        var obj =  JSON.parse(data);
            jQuery.each(obj,function(k,v){
                if(k=="latitude"){
                    jQuery("input[name='latitude']").val(v);
                }else if(k=="longitude"){
                    jQuery("input[name='longitude']").val(v);
                }
            });
            jQuery('.hide_row').show();
            jQuery('#get_p').hide();
            jQuery('#save').show();
    });
}
</script>


   
