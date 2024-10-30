<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<form method="post" action="<?php echo admin_url();?>admin-post.php" class="amenity-add">
	<input type="hidden" name="action" 	value="chb">
	<input type="hidden" name="task" 	value="create_amenity">
	<input type="hidden" name="nonce" 	value="<?php echo wp_create_nonce('chb-hotel-booking');?>">

	<fieldset>
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" placeholder="amenity name" name="name" value="" id="name" autofocus>
			<small class="form-text text-muted">e.g. 1st amenity</small>
		</div>
		<div class="form-group">
			<label>Description</label>
			<input type="text" class="form-control" name="description" value="">
		</div>
		<div class="form-group">
	    	<div style="float:right;">
	      		<button type="submit" class="btn btn-primary btn-sm">Create amenity</button>
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
			success             :   response_amenity_add,  
			resetForm           :   true 
		}; 

		// binding the form for ajax submission
		jQuery('.amenity-add').submit(function() { 
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
	function response_amenity_add() {
		jQuery('#modal').modal('hide');
		ajax_call('module-amenity', 'false', 'false', 'tab3');
		notify('amenity added');
	}

</script>