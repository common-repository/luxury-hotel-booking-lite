<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<form method="post" action="<?php echo admin_url();?>admin-post.php" class="room-type-add">
	<input type="hidden" name="action" 	value="chb">
	<input type="hidden" name="task" 	value="create_room_type">
	<input type="hidden" name="nonce" 	value="<?php echo wp_create_nonce('chb-hotel-booking');?>">

	<div class="row">
		<div class="col-md-6">
			<fieldset>
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" placeholder="Room type" name="name" value="" id="name" autofocus>
					<small class="form-text text-muted">e.g. deluxe</small>
				</div>
				<div class="form-group">
					<label>Guest Capacity</label>
					<select class="form-control" name="capacity">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</div>
				<div class="form-group">
					<label for="exampleSelect1">Amenities</label>
					<select class="form-control" name="amenities[]" multiple style="height:100px !important;">
						<?php 
						$amenities 	=	DataApi::chb_get_amenities();
						foreach ($amenities as $row):
							?>
							<option value="<?php echo $row['amenity_id'];?>">
								<?php echo $row['name'];?>
							</option>
							<?php
						endforeach;
						?>
					</select>
					<small class="form-text text-muted">Hold ctrl(on windows) or cmd(on mac) and select multiple</small>
				</div>
				<div class="form-group">
					<label>Price</label>
					<input type="text" class="form-control" placeholder="Basic price" name="price" value="">
					<small class="form-text text-muted">e.g. $50</small>
				</div>
			</fieldset>
		</div>
		<div class="col-md-6" style="text-align:right;">
			<fieldset>
				<div class="form-group">
                    <label>Featured image</label>
                    <br>
                    <img src="" id="room_image" 
                        style="height:200px; min-width:100px; border:1px solid #ccc; padding 2px;">
                </div>
                <input type="hidden" name="image_url" value="" id="image_url" >
                <button class="btn btn-default btn-xs" onclick="open_media_uploader()" type="button">Select image</button>
			</fieldset>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
				<div class="form-group">
			    	<div style="float:right;">
			      		<button type="submit" class="btn btn-primary btn-sm">Create room type</button>
			      		<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
			    	</div>
			    </div>
		</div>
	</div>
</form>


<script type="text/javascript">
    // ajax form plugin calls at each modal loading,
	jQuery(document).ready(function() { 

		// configuration for ajax form submission
		var options = { 
			beforeSubmit        :   validate,  
			success             :   response_room_type_add,  
			resetForm           :   true 
		}; 

		// binding the form for ajax submission
		jQuery('.room-type-add').submit(function() { 
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
	function response_room_type_add() {
		jQuery('#modal').modal('hide');
		ajax_call('module-room-type', 'false', 'false', 'tab4');
		notify('Room type added');
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