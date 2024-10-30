<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$room_id 	=	sanitize_text_field($_POST['param1']);
global $wpdb;
$room			=	$wpdb->prefix. 'chb_room';
$query_result	=	$wpdb->get_results("SELECT * FROM `$room` WHERE `room_id` = $room_id", ARRAY_A);
foreach($query_result as $row):
?>
<form method="post" action="<?php echo admin_url();?>admin-post.php" class="room-edit">
	<input type="hidden" name="action" 	value="chb">
	<input type="hidden" name="task" 	value="edit_room">
	<input type="hidden" name="nonce" 	value="<?php echo wp_create_nonce('chb-hotel-booking');?>">
	<input type="hidden" name="room_id" value="<?php echo $room_id;?>"

	<fieldset>
		<div class="form-group">
			<label>Room type</label>
			<select class="form-control" name="room_type_id">
				<?php
					global $wpdb;
					$room_type		=	$wpdb->prefix. 'chb_room_type';
					$query_result2	=	$wpdb->get_results("SELECT * FROM `$room_type`", ARRAY_A);
					foreach($query_result2 as $row2):
				?>
					<option value="<?php echo $row2['room_type_id'];?>" <?php if ($row['room_type_id'] == $row2['room_type_id']) echo 'selected';?>>
						<?php echo $row2['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="form-group">
			<label>Floor</label>
			<select class="form-control" name="floor_id">
				<?php
					global $wpdb;
					$floor		=	$wpdb->prefix. 'chb_floor';
					$query_result2	=	$wpdb->get_results("SELECT * FROM `$floor`", ARRAY_A);
					foreach($query_result2 as $row2):
				?>
					<option value="<?php echo $row2['floor_id'];?>" <?php if ($row['floor_id'] == $row2['floor_id']) echo 'selected';?>>
						<?php echo $row2['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="form-group">
			<label>Room Name</label>
			<input type="text" class="form-control" placeholder="Room name" name="name" value="<?php echo $row['name'];?>" id="name" >
			<small class="form-text text-muted">e.g. 308, 102</small>
		</div>
		<div class="form-group">
	    	<div style="float:right;">
	      		<button type="submit" class="btn btn-primary btn-sm">Update room</button>
	      		<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
	    	</div>
	    </div>
	</fieldset>
</form>
<?php
endforeach;
?>


<script type="text/javascript">
    // ajax form plugin calls at each modal loading,
	jQuery(document).ready(function() { 

		// configuration for ajax form submission
		var options = { 
			beforeSubmit        :   validate,  
			success             :   response_room_edit,  
			resetForm           :   true 
		}; 

		// binding the form for ajax submission
		jQuery('.room-edit').submit(function() { 
			jQuery(this).ajaxSubmit(options); 

			// prevents normal form submission
			return false; 
		}); 
	});

	function validate() {
		if (jQuery('#name').val() == '') {
			notify_warning('Name must be filled up!');
			jQuery('#name').focus();
			return false;
		}
		return true;
	}
	function response_room_edit() {
		jQuery('#modal').modal('hide');
		ajax_call('module-room', 'false', 'false', 'tab1');
		notify('Room updated');
	}

</script>