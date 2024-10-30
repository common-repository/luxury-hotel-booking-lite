<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$room_id 			=	sanitize_text_field($_POST['room_id']);
$checkin_date		=	sanitize_text_field($_POST['checkin_date']);
$checkout_date		=	sanitize_text_field($_POST['checkout_date']);

$checkin_timestamp	=	strtotime($checkin_date);
$checkout_timestamp	=	strtotime($checkout_date);

$room_name			=	DataApi::chb_get_room_name($room_id);

$price				=	DataApi::chb_get_room_price($room_id, $checkin_timestamp, $checkout_timestamp);
?>
<tr>
	<td>
		<?php echo $room_name;?>
		<input type="hidden" name="rooms[]" value="<?php echo $room_id;?>">
	</td>
	<td>
		<?php echo $checkin_date;?> - <?php echo $checkout_date;?>
		<input type="hidden" name="checkin_timestamps[]" value="<?php echo $checkin_timestamp;?>">
		<input type="hidden" name="checkout_timestamps[]" value="<?php echo $checkout_timestamp;?>">
	</td>
	<td>
		<?php echo $price;?>
		<input type="hidden" name="prices[]" value="<?php echo $price;?>">
	</td>
	<td>
		<i class="fa fa-times btn_delete_room" style="cursor:pointer; color:#9e9e9e;"></i>
	</td>
</tr>