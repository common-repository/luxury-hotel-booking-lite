<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<form method="post" action="<?php echo admin_url();?>admin-post.php" class="room-add">
	<input type="hidden" name="action" 	value="chb">
	<input type="hidden" name="task" 	value="create_room">
	<input type="hidden" name="nonce" 	value="<?php echo wp_create_nonce('chb-hotel-booking');?>">

	<fieldset>
		<div class="form-group">
			<label>Room type</label>
			<select class="form-control" name="room_type_id">
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
		</div>
		<div class="form-group">
			<label>Floor</label>
			<select class="form-control" name="floor_id">
				<?php
					global $wpdb;
					$floor		=	$wpdb->prefix. 'chb_floor';
					$query_result	=	$wpdb->get_results("SELECT * FROM `$floor`", ARRAY_A);
					foreach($query_result as $row):
				?>
					<option value="<?php echo $row['floor_id'];?>">
						<?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="form-group">
			<label>Room Name</label>
			<input type="text" class="form-control" placeholder="Room name" name="name" value="" id="name" autofocus>
			<small class="form-text text-muted">e.g. 308, 102</small>
		</div>
		<div class="form-group">
	    	<div style="float:right;">
	      		<button type="submit" class="btn btn-primary btn-sm">Create room</button>
	      		<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
	    	</div>
	    </div>
	</fieldset>
</form>


<script type="text/javascript">
    // ajax form plugin calls at each modal loading,
	jQuery(document).ready(function() { 

		// configuration for ajax form submission
		var options = { 
			beforeSubmit        :   validate,  
			success             :   response_room_add,  
			resetForm           :   true 
		}; 

		// binding the form for ajax submission
		jQuery('.room-add').submit(function() { 
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
	function response_room_add() {
		jQuery('#modal').modal('hide');
		ajax_call('module-room', 'false', 'false', 'tab1');
		notify('Room added');
	}

</script>