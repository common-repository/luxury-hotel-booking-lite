<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<div class="row" style="margin:20px;">

    <div style="text-align: right; padding: 5px;">
        <a class="btn btn-info btn-xs" href="http://support.creativeitem.com" target="_blank">Get support</a>
        <a class="btn btn-info btn-xs" href="http://creativeitem.com/demo/hotel_wp/wp-admin/admin.php?page=chb-booking" target="_blank">Full demo</a>
        <a class="btn btn-info btn-xs" href="https://codecanyon.net/item/x/21445221/?ref=creativeitem" target="_blank">upgrade</a>
    </div>
    
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Room Availability & Status</h3>
        </div>
        <div class="panel-body">
            <?php
            // checking if any room type and room exists or not
            global $wpdb;
            $chb_room               =   $wpdb->prefix . 'chb_room';
            $chb_room_type          =   $wpdb->prefix . 'chb_room_type';
            $wpdb->get_results("SELECT * FROM $chb_room_type");
            $room_type_number   =   $wpdb->num_rows;
            $wpdb->get_results("SELECT * FROM $chb_room");
            $room_number   =   $wpdb->num_rows;

            if ($room_type_number > 0 && $room_number > 0) {
                include 'module-room-availability-selector.php';
            }
            else {
                echo '<center><h5><i class="fa fa-info-circle"></i> Create room types, and rooms to watch availability</h5>';
                echo '<br>';
                echo '<a class="btn btn-info btn-xs" href="'.admin_url().'admin.php?page=chb-room"><i class="fa fa-plus"></i> Create rooms</a></center>';
            }
            ?>
            <div id="show_calendar"></div>

        </div>
    </div>
</div>

<?php include 'modal.php';?>

<script>
jQuery(document).ready(function() {
    <?php
    if ($room_type_number > 0 && $room_number > 0) {
        ?>
            load_rooms();
        <?php
    }?>
})

function load_rooms() {
    jQuery(".rooms").css("display", "none");
    var room_type_id    =   jQuery("#room_type_id").val();

    jQuery("#room_type_" + room_type_id).css("display", "block");
    var room_id         =   jQuery("#room_type_" + room_type_id).val();
    ajax_call('module-room-availability', 'false', 'false', 'show_calendar', room_id);
    //alert(room_id);
}
</script>
