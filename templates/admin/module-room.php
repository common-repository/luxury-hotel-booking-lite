<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<div class="row" style="margin-top:30px;">
	<div class="col-lg-10">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Manage room</h3>
			</div>
			<div class="panel-body">
								
				<button type="button" class="btn btn-success btn-sm" onclick="ajax_call('modal-room-add', 'true', 'false', 'modal_body')	"
					style="float: right; margin-bottom:15px;">
					+ Add new room</button>
				<div class="form-group">
					<label style="float: left; margin:13px;">Filter : </label>
					<select class="form-control" id="room_type" onChange="reload_room_list()"
						style="width:250px;float: left; margin: 10px;">
						<option value="0">Room type - all</option>
						<?php
							global $wpdb;
							$room_type		=	$wpdb->prefix. 'chb_room_type';
							$query_result	=	$wpdb->get_results("SELECT * FROM `$room_type`", ARRAY_A);
							foreach($query_result as $row):
						?>
							<option value="<?php echo $row['room_type_id'];?>">
								<?php echo $row['name'];?></option>
						<?php endforeach;?>
					</select>
					<select class="form-control" id="floor" onChange="reload_room_list()"
						style="width:250px;float: left; margin: 10px;">
						<option value="0">Floor - all</option>
						<?php
							$floor			=	$wpdb->prefix. 'chb_floor';
							$query_result	=	$wpdb->get_results("SELECT * FROM `$floor`", ARRAY_A);
							foreach($query_result as $row):
						?>
							<option value="<?php echo $row['floor_id'];?>">
								<?php echo $row['name'];?></option>
						<?php endforeach;?>
					</select>
				</div>
				<hr style="clear: both;">
				<!-- Room type listing -->
				<div id="room-list">
					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function reload_room_list() {
		room_type_id	=	jQuery("#room_type").val();
		floor_id		=	jQuery("#floor").val();
		ajax_call('module-room-list', 'false', 'false', 'room-list', room_type_id, floor_id);
	}
	
	jQuery(document).ready(function() {
		ajax_call('module-room-list', 'false', 'false', 'room-list', '0', '0');
	});
</script>
