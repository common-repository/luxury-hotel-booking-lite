<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$amenity_id 		=	sanitize_text_field($_POST['param1']);
global $wpdb;
$amenity			=	$wpdb->prefix. 'chb_amenity';
$query_result	=	$wpdb->get_results("SELECT * FROM `$amenity` WHERE `amenity_id` = $amenity_id", ARRAY_A);
foreach($query_result as $row):
?>
<form method="post" action="<?php echo admin_url();?>admin-post.php" class="amenity-edit">
	<input type="hidden" name="action" 		value="chb">
	<input type="hidden" name="task" 		value="edit_amenity">
	<input type="hidden" name="nonce" 		value="<?php echo wp_create_nonce('chb-hotel-booking');?>">
	<input type="hidden" name="amenity_id" 	value="<?php echo $amenity_id;?>"

	<fieldset>
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" placeholder="Room type" name="name" value="<?php echo $row['name'];?>">
			<small class="form-text text-muted">e.g. 1st amenity</small>
		</div>
		<div class="form-group">
			<label>Description</label>
			<input type="text" class="form-control" name="description" value="<?php echo $row['description'];?>">
		</div>
		<div class="form-group">
	    	<div style="float:right;">
	      		<button type="submit" class="btn btn-primary btn-sm">Update amenity</button>
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
			success             :   response_amenity_edit,  
			resetForm           :   true 
		}; 

		// binding the form for ajax submission
		jQuery('.amenity-edit').submit(function() { 
			jQuery(this).ajaxSubmit(options); 

			// prevents normal form submission
			return false; 
		}); 
	});

	function validate() {
		return true;
	}
	function response_amenity_edit() {
		jQuery('#modal').modal('hide');
		ajax_call('module-amenity', 'false', 'false', 'tab3');
		notify('amenity updated!');
	}

</script>