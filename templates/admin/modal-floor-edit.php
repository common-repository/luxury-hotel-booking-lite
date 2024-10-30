<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$floor_id 		=	sanitize_text_field($_POST['param1']);
global $wpdb;
$floor			=	$wpdb->prefix. 'chb_floor';
$query_result	=	$wpdb->get_results("SELECT * FROM `$floor` WHERE `floor_id` = $floor_id", ARRAY_A);
foreach($query_result as $row):
?>
<form method="post" action="<?php echo admin_url();?>admin-post.php" class="floor-edit">
	<input type="hidden" name="action" 		value="chb">
	<input type="hidden" name="task" 		value="edit_floor">
	<input type="hidden" name="nonce" 		value="<?php echo wp_create_nonce('chb-hotel-booking');?>">
	<input type="hidden" name="floor_id" 	value="<?php echo $floor_id;?>"

	<fieldset>
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" placeholder="Room type" name="name" value="<?php echo $row['name'];?>">
			<small class="form-text text-muted">e.g. 1st floor</small>
		</div>
		<div class="form-group">
			<label>Note</label>
			<input type="text" class="form-control" name="note" value="<?php echo $row['note'];?>">
		</div>
		<div class="form-group">
	    	<div style="float:right;">
	      		<button type="submit" class="btn btn-primary btn-sm">Update floor</button>
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
			success             :   response_floor_edit,  
			resetForm           :   true 
		}; 

		// binding the form for ajax submission
		jQuery('.floor-edit').submit(function() { 
			jQuery(this).ajaxSubmit(options); 

			// prevents normal form submission
			return false; 
		}); 
	});

	function validate() {
		return true;
	}
	function response_floor_edit() {
		jQuery('#modal').modal('hide');
		ajax_call('module-floor', 'false', 'false', 'tab5');
		notify('Floor updated!');
	}

</script>