<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>

<form method="post" action="<?php echo admin_url();?>admin-post.php" class="booking-add">
	<input type="hidden" name="action" 	value="chb">
	<input type="hidden" name="task" 	value="create_booking">
	<input type="hidden" name="nonce" 	value="<?php echo wp_create_nonce('chb-hotel-booking');?>">

	<div class="row">
		<div class="col-md-6">

			<!-- GUEST PERSONAL DETAIL INFORMATION -->
			<fieldset>
				<legend>Booking detail</legend>
				<div class="form-group">
					<label>Booking status</label>
					<select class="form-control" name="status">
						<option value="1">Reservation</option>
						<option value="2">Active</option>
						<option value="3">Completed</option>
					</select>
				</div>
				<div class="form-group">
					<label>Guest name</label>
					<input type="text" class="form-control" name="name" value="" id="name">
				</div>
				<div class="form-group">
					<label>Address</label>
					<input type="text" class="form-control" name="address" value="">
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="text" class="form-control" name="email" value="">
				</div>
				<div class="form-group">
					<label>Phone</label>
					<input type="text" class="form-control" name="phone" value="">
				</div>
				<div class="form-group">
					<label>Total guests</label>
					<input type="text" class="form-control" name="total_guest" value="">
				</div>
			</fieldset>
		</div>
		<div class="col-md-6">

			<!-- ROOM ALLOCATION INFORMATION -->
			<fieldset>
				<legend>Room allocation</legend>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group" >
							<label>Checkin date</label>
							<input type="text"  class="form-control datepicker" name="checkin_timestamp" id="checkin_timestamp"
								readonly style="cursor:pointer;" value="<?php echo date('d M, Y');?>" onblur="load_available_room_list()">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group" >
							<label>Checkout date</label>
							<input type="text"  class="form-control datepicker" name="checkout_timestamp" id="checkout_timestamp"
								readonly style="cursor:pointer;" value="<?php echo date('d M, Y' , strtotime(' +1 day'));?>" onblur="load_available_room_list()">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group" >
							<label>Available rooms</label>
							<span id="available_room_list">
								
							</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<button type="button" class="btn btn-success btn-sm" onclick="add_room()" 
								style="margin:20px 0px;width:100%">
								+ Add room</button>
						</div>
					</div>
				</div>

			</fieldset>

			<table class="table table-striped" id="rooms">
				<thead>
					<tr>
						<th>Room</th>
						<th>Date</th>
						<th>Price</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<fieldset>
				<div class="form-group">
					<div style="float:right;">
						<button type="submit" class="btn btn-primary btn-sm">Create booking</button>
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	
</form>


<script type="text/javascript">
    // Ajax form plugin calls at each modal loading,
	jQuery(document).ready(function() { 

		// Configuration for ajax form submission
		var options = { 
			beforeSubmit        :   validate,  
			success             :   response_booking_add,  
			resetForm           :   true 
		}; 

		// Binding the form for ajax submission
		jQuery('.booking-add').submit(function() { 
			jQuery(this).ajaxSubmit(options); 

			// prevents normal form submission
			return false; 
		}); 
		
		
		// Make the datepicker input fields
		jQuery("#checkout_timestamp").datepicker(
		{
			dateFormat: 'dd M, yy', 
		});

		jQuery("#checkin_timestamp").datepicker(
		{ 
			dateFormat: 'dd M, yy', 
			onSelect : function() {
				var date2 = jQuery('#checkin_timestamp').datepicker('getDate');
				date2.setDate(date2.getDate() + 1);
		        jQuery('#checkout_timestamp').datepicker('option', 'minDate', date2);
			} 
		});

		// Load the available room list within timestamp range
		load_available_room_list();
		
	});

	function load_available_room_list() {
		var checkin_timestamp	=	jQuery("#checkin_timestamp").val();
		var checkout_timestamp	=	jQuery("#checkout_timestamp").val();
		ajax_call('modal-booking-manage-room-list', 'false', 'false', 'available_room_list', checkin_timestamp, checkout_timestamp);
	}
	function validate() {
		if (jQuery('#name').val() == '') {
			notify_warning('Name must be filled up!');
			jQuery('#name').focus();
			return false;
		}
		return true;
	}
	function response_booking_add() {
		jQuery('#modal').modal('hide');
		ajax_call('module-booking-list', 'false', 'false', 'booking_list_holder');
		notify('booking added');
	}

	function add_room() {
		var room_id	=	jQuery("#room_id").val();
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' );?>';
		jQuery.post(
			ajaxurl,
			{
				'action'		: 'chb_task',
				'task_name'		: 'modal-booking-add-room-list',
				'room_id'		: room_id,
				'checkin_date'	: jQuery("#checkin_timestamp").val(),
				'checkout_date'	: jQuery("#checkout_timestamp").val(),
			},
			function (response) {
				jQuery('#rooms tbody').append(response);
				jQuery( ".btn_delete_room" ).click(function(event) {
					jQuery(this).parent().parent().remove();
				});
			}
		);
		

		
	}

</script>