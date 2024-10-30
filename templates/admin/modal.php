<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<script>
    function ajax_call(task_name, is_modal, is_delete, response_holder, param1, param2, param3) {

        // LOADING THE AJAX MODAL
        jQuery( '#' + response_holder ).block( { message: null, overlayCSS: { backgroundColor: '#f3f4f5' } });
		if (is_modal == 'true') {
			jQuery('#modal_body').html('');
			jQuery('#modal').modal('show');
		}
		if (is_delete == 'true') {
			jQuery('#modal_delete').modal('show');
			jQuery('#delete_id').val(param1);
			jQuery('#task').val(task_name);
			bind_delete_form_with_ajax(task_name);
			response_holder_div = response_holder;
			refresh_div			= param2;
		}
		
		if (is_delete == 'false') {
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' );?>';
			jQuery.post(
				ajaxurl,
				{
					'action': 'chb_task',
					'task_name': task_name,
					'param1': param1,
					'param2': param2,
					'param3': param3,
				},
				function (response) {
					jQuery('#'+response_holder).html(response);
				}
			);
		}
		
    }
	
	// Binding the deletion form with deletion short modal
	var response_holder_div = '';
	var refresh_div			= '';
	function bind_delete_form_with_ajax(task_name, response_holder) {
		var options = {  
			success             :   show_response_delete,  
			resetForm           :   true 
		}; 
		// binding the form for ajax submission
		jQuery('.delete').submit(function() { 
			jQuery(this).ajaxSubmit(options); 

			// prevents normal form submission
			return false; 
		}); 
	}
	function show_response_delete() {
		jQuery('#modal_delete').modal('hide');
		ajax_call(refresh_div, 'false', 'false', response_holder_div);
		notify('Data deleted!');
	}
	
	
	
	
	
</script>


<!-- Regular Modal -->
<div id="modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Hotel booking system</h4>
			</div>
			<div class="modal-body" id="modal_body" >
				
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>


<!-- Delete Modal -->
<div id="modal_delete" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="border-bottom:0px;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Confirm deletion?</h4>
			</div>
			<div class="modal-footer">
				<form method="post" action="<?php echo admin_url();?>admin-post.php" class="delete">
					<input type="hidden" name="action" 		value="chb">
					<input type="hidden" name="task" 		value="" 	id="task">
					<input type="hidden" name="delete_id" 	value=""	id="delete_id">
					<input type="hidden" name="nonce" 		value="<?php echo wp_create_nonce('chb-hotel-booking');?>">

					<button type="submit" class="btn btn-danger btn-sm">Delete</button>
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>

