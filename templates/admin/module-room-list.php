<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$room_type_id		=	sanitize_text_field($_POST['param1']);
$floor_id 			=	sanitize_text_field($_POST['param2']);
global $wpdb;
$room				=	$wpdb->prefix. 'chb_room';

if ($room_type_id 	== '0' && $floor_id == '0')
	$query_result		=	$wpdb->get_results("SELECT * FROM `$room` ", ARRAY_A);
else if ($room_type_id 	== '0' && $floor_id != '0')
	$query_result		=	$wpdb->get_results("SELECT * FROM `$room` WHERE `floor_id` = $floor_id", ARRAY_A);
else if ($room_type_id 	!= '0' && $floor_id == '0')
	$query_result		=	$wpdb->get_results("SELECT * FROM `$room` WHERE `room_type_id` = $room_type_id", ARRAY_A);
else if ($room_type_id 	!= '0' && $floor_id != '0')
	$query_result		=	$wpdb->get_results("SELECT * FROM `$room` WHERE `room_type_id` = $room_type_id AND `floor_id` = $floor_id", ARRAY_A);

$number_of_rooms	=	count($query_result);
?>

<h5>Total <?php echo $number_of_rooms;?> rooms found.</h5>
<table class="table table-striped table-hover ">
	<thead class="thead-dark">
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Type</th>
			<th>Floor</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$counter = 1;
			foreach($query_result as $row):
		?>
		<tr>
			<td><?php echo $counter++;?></td>
			<td><?php echo $row['name'];?></td>
			<td><?php echo DataApi::get_room_type_name_by_id($row['room_type_id']);?></td>
			<td><?php echo DataApi::get_floor_name_by_id($row['floor_id']);?></td>
			<td>
				<button type="button" class="btn btn-default btn-xs"
					onclick="ajax_call('modal-room-edit', 'true', 'false', 'modal_body', <?php echo $row['room_id'];?>)">
						edit</button>
				<button type="button" class="btn btn-default btn-xs"
					onclick="ajax_call('delete-room', 'false', 'true', 'tab1', <?php echo $row['room_id'];?>, 'module-room')">
						delete</button>
			</td>
		</tr>
		<?php
			endforeach;
		?>
	</tbody>
</table>