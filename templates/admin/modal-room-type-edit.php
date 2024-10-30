<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$room_type_id = sanitize_text_field($_POST['param1']);
global $wpdb;
$room_type		=	$wpdb->prefix. 'chb_room_type';
$query_result	=	$wpdb->get_results("SELECT * FROM `$room_type` WHERE `room_type_id` = $room_type_id", ARRAY_A);
foreach($query_result as $row):
?>
<form method="post" action="<?php echo admin_url();?>admin-post.php" class="room-type-edit">
	<input type="hidden" name="action" 		value="chb">
	<input type="hidden" name="task" 		value="edit_room_type">
	<input type="hidden" name="nonce" 		value="<?php echo wp_create_nonce('chb-hotel-booking');?>">
	<input type="hidden" name="room_type_id" value="<?php echo $room_type_id;?>">

	<div class="row">
		<div class="col-md-6">
			<fieldset>
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" placeholder="Room type" name="name" value="<?php echo $row['name'];?>">
					<small class="form-text text-muted">e.g. deluxe</small>
				</div>
				<div class="form-group">
					<label>Guest Capacity</label>
					<select class="form-control" name="capacity">
						<option value="1" <?php if($row['capacity'] == 1)echo 'selected';?>>1</option>
						<option value="2" <?php if($row['capacity'] == 2)echo 'selected';?>>2</option>
						<option value="3" <?php if($row['capacity'] == 3)echo 'selected';?>>3</option>
						<option value="4" <?php if($row['capacity'] == 4)echo 'selected';?>>4</option>
					</select>
				</div>
				<div class="form-group">
					<label for="exampleSelect1">Amenities</label>
					<select class="form-control" name="amenities[]" multiple style="height:100px !important;">
						<?php 
						$amenities 	=	DataApi::chb_get_amenities();
						foreach ($amenities as $row2):
							$room_amenities_json	=	$row['amenities'];
							$room_amenities_array	=	json_decode($room_amenities_json);
							?>
							<option <?php if (in_array($row2['amenity_id'], $room_amenities_array))echo 'selected'; ?>
								value="<?php echo $row2['amenity_id'];?>">
								<?php echo $row2['name'];?>
							</option>
							<?php
						endforeach;
						?>
					</select>
					<small class="form-text text-muted">Hold ctrl(on windows) or cmd(on mac) and select multiple</small>
				</div>
				<div class="form-group">
					<label>Price</label>
					<input type="text" class="form-control" placeholder="Basic price" name="price" value="<?php echo $row['price'];?>">
					<small class="form-text text-muted">e.g. $50</small>
				</div>
			</fieldset>
		</div>
		<div class="col-md-6" style="text-align:right;">
			<fieldset>
				<div class="form-group">
                    <label>Featured image</label>
                    <br>
                    <img src="<?php echo $row['image_url'];?>" id="room_image" 
                        style="height:200px; min-width:100px; border:1px solid #ccc; padding 2px;">
                </div>
                <input type="hidden" name="image_url" value="<?php echo $row['image_url'];?>" id="image_url" >
                <button class="btn btn-default btn-xs" onclick="open_media_uploader()" type="button">Select image</button>
			</fieldset>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
				<div class="form-group">
			    	<div style="float:right;">
			      		<button type="submit" class="btn btn-primary btn-sm">Update room type</button>
			      		<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
			    	</div>
			    </div>
		</div>
	</div>
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
			success             :   response_room_type_edit,  
			resetForm           :   true 
		}; 

		// binding the form for ajax submission
		jQuery('.room-type-edit').submit(function() { 
			jQuery(this).ajaxSubmit(options); 

			// prevents normal form submission
			return false; 
		}); 
	});

	function validate() {
		return true;
	}
	function response_room_type_edit() {
		jQuery('#modal').modal('hide');
		ajax_call('module-room-type', 'false', 'false', 'tab4');
		notify('Room type updated!');
	}

	// WP MEDIA UPLOADER FOR IMAGE UPLOADING
    var media_uploader = null;
    function open_media_uploader()
    {
        media_uploader = wp.media({
            frame:    "post", 
            state:    "insert", 
            multiple: false
        });

        media_uploader.on("insert", function(){
            var json = media_uploader.state().get("selection").first().toJSON();

            var image_url = json.url;
            var image_caption = json.caption;
            var image_title = json.title;

            jQuery("#image_url").val(image_url);
            jQuery("#room_image").attr("src", image_url);
        });

        media_uploader.open();
    }

</script>