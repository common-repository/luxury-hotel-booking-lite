<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$booking_id 	=	sanitize_text_field($_POST['param1']);

global $wpdb;
$booking			=	$wpdb->prefix. 'chb_booking';
$query_result		=	$wpdb->get_results("SELECT * FROM `$booking` WHERE `booking_id` = $booking_id ", ARRAY_A);

foreach ($query_result as $row):
?>

<form method="post" action="<?php echo admin_url();?>admin-post.php" class="booking-delete">
	<input type="hidden" name="action" 		value="chb">
	<input type="hidden" name="task" 		value="delete_booking">
	<input type="hidden" name="nonce" 		value="<?php echo wp_create_nonce('chb-hotel-booking');?>">
	<input type="hidden" name="booking_id" 	value="<?php echo $booking_id;?>"

	<div class="row">
		<div class="col-md-12">

			<!-- GUEST PERSONAL DETAIL INFORMATION -->
			<fieldset>
				<legend>Are you sure to delete this booking?</legend>
				<div class="form-group">
					<label>Deleted data won't be reversible.</label>
					
				</div>
				<div class="form-group">
					<div style="float:right;">
						<button type="submit" class="btn btn-danger btn-sm">Delete booking</button>
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
			success             :   response_booking_delete,  
			resetForm           :   true 
		}; 

		// Binding the form for ajax submission
		jQuery('.booking-delete').submit(function() { 
			jQuery(this).ajaxSubmit(options); 

			// prevents normal form submission
			return false; 
		}); 
		
		
		
	});

	function validate() {
		return true;
	}

	// Loads the updated booking in the list
	function response_booking_delete() {
		jQuery('#modal').modal('hide');
		notify('booking deleted');
		jQuery("#row_<?php echo $booking_id;?>").remove();
		ajax_call('module-booking-detail-placeholder', 'false', 'false', 'booking_detail');
	}


</script>

<?php
endforeach;
?>