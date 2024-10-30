<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$checkin_date		=	sanitize_text_field($_POST['param1']);
$checkout_date		=	sanitize_text_field($_POST['param2']);

$checkin_timestamp	=	strtotime($checkin_date);
$checkout_timestamp	=	strtotime($checkout_date);

//echo $checkin_timestamp.'-'.$checkout_timestamp;
?>

<select class="form-control" name="room_id" id="room_id">
	<?php

		// Listing all the rooms from database
		global $wpdb;
		$room				=	$wpdb->prefix. 'chb_room';
		$query_result		=	$wpdb->get_results("SELECT * FROM `$room` ORDER BY `room_type_id` ASC ", ARRAY_A);
		foreach($query_result as $row):

			// Flag variable for checking if a room is available for booking
			$exclude_flag	=	false;

			// If a room is already in booking status within the asked checkin & checkout timestamp
			// Checking within the room booking history of a single room
			$booking_room	=	$wpdb->prefix. 'chb_booking_room';
			$room_id 		=	$row['room_id'];
			$query_result2	=	$wpdb->get_results("SELECT * FROM  `$booking_room` WHERE `room_id` = $room_id", ARRAY_A);
			foreach( $query_result2 as $row2):

				if ($checkin_timestamp >= $row2['checkin_timestamp'] && $checkin_timestamp <= $row2['checkout_timestamp'])
				{
					$exclude_flag	=	true;
					break;
				}
				if ($checkout_timestamp >= $row2['checkin_timestamp'] && $checkout_timestamp <= $row2['checkout_timestamp'])
				{
					$exclude_flag	=	true;
					break;
				}
				if ($checkin_timestamp <= $row2['checkin_timestamp'] && $checkout_timestamp >= $row2['checkout_timestamp'])
				{
					$exclude_flag	=	true;
					break;
				}
			
			endforeach;

			// Exclude this room from available list
			if ($exclude_flag == true)
				continue;
			?>
				<option value="<?php echo $row['room_id'];?>">
					<?php echo $row['name'];?> - <?php echo DataApi::chb_get_room_type_name($row['room_id']);?></option>
			<?php 
		endforeach;
	?>
</select>



