<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$room_id	    =	sanitize_text_field($_POST['param1']);
$room_name      =   DataApi::chb_get_room_name($room_id);
$room_type_name =   DataApi::chb_get_room_type_name($room_id);
?>
<center>
    <h4 style="margin-bottom:40px;">Booking status of room - <?php echo $room_name;?> (<?php echo $room_type_name;?>)</h4>
</center>

<div class="calendar"></div>

<script>
jQuery(document).ready(function() {
	var currentYear = new Date().getFullYear();
	jQuery('.calendar').calendar({ 
		enableContextMenu: true,
        enableRangeSelection: true,

        clickDay: function(e) {
        	if(e.events.length > 0) {
        		for(var i in e.events) {
        			//alert(e.events[i].location);
        			ajax_call('module-booking-summary', 'true', 'false', 'modal_body', e.events[i].booking_id);
        		}
        	}
        },

        dataSource: [

        	<?php
        	$bookings	=	DataApi::chb_get_booking_of_room($room_id);
        	foreach($bookings as $row) : //break;
        	?>
            {
                booking_id: '<?php echo $row["booking_id"];?>',
                startDate: new Date(<?php echo date("Y", $row['checkin_timestamp']);?>, <?php echo date("n", strtotime('-1 month', $row['checkin_timestamp']));?>, <?php echo date("j", $row['checkin_timestamp']);?>),
                endDate: new Date(<?php echo date("Y", $row['checkout_timestamp']);?>, <?php echo date("n", strtotime('-1 month', $row['checkin_timestamp']));?>, <?php echo date("j", $row['checkout_timestamp']);?>)
            },

        	<?php
            endforeach;
            ?>
        ]
    });
	
})
</script>