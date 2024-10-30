<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<div class="row" style="margin:20px;">

    <div style="text-align: right; padding: 5px;">
        <a class="btn btn-info btn-xs" href="http://support.creativeitem.com" target="_blank">Get support</a>
        <a class="btn btn-info btn-xs" href="http://creativeitem.com/demo/hotel_wp/wp-admin/admin.php?page=chb-booking" target="_blank">Full demo</a>
        <a class="btn btn-info btn-xs" href="https://codecanyon.net/item/x/21445221/?ref=creativeitem" target="_blank">upgrade</a>
    </div>
    
    <div class="panel panel-primary">
      <div class="panel-heading">
            <h3 class="panel-title">Hotel Settings</h3>
        </div>
        <div class="panel-body">
			<form method="post" action="<?php echo admin_url();?>admin-post.php" class="settings">
                <input type="hidden" name="action"  value="chb">
                <input type="hidden" name="task"    value="save_settings">
                <input type="hidden" name="nonce"   value="<?php echo wp_create_nonce('chb-hotel-booking');?>">

                <div class="row">
                    <div class="col-md-6">

                        <!-- GENERAL HOTEL SETTINGS -->
                        <fieldset>
                            <legend><i class="fa fa-wrench"></i> General settings</legend>
                            <hr>
                            <div class="form-group" style="text-align:center;">
                                <img src="<?php echo DataApi::chb_get_settings('logo_url');?>" id="logo_image" 
                                    style="height:100px; min-width:100px; border:1px solid #ccc; padding 2px; margin:10px;">
                                <br>
                                <input type="hidden" name="logo_url" value="<?php echo DataApi::chb_get_settings('logo_url');?>" id="logo_url" >
                                <button class="btn btn-default btn-xs" onclick="open_media_uploader()" type="button">Select logo</button>
                            </div>
                            
                            <div class="form-group">
                                <label>Hotel name</label>
                                <input type="text" class="form-control" name="hotel_name" id="hotel_name"
                                    value="<?php echo DataApi::chb_get_settings('hotel_name');?>">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" 
                                    value="<?php echo DataApi::chb_get_settings('address');?>">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" 
                                    value="<?php echo DataApi::chb_get_settings('phone');?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" 
                                    value="<?php echo DataApi::chb_get_settings('email');?>">
                            </div>
                            <div class="form-group">
                                <label>Currency</label>
                                <select class="form-control" name="country_id">
                                    <?php
                                    $saved_country_id   =   DataApi::chb_get_settings('country_id');
                                    $countries  =   DataApi::chb_get_countries();
                                    foreach ($countries as $row):
                                        if ($row['currency_symbol'] == '')continue;
                                        ?>
                                        <option value="<?php echo $row['country_id'];?>"
                                            <?php if($saved_country_id == $row['country_id']) echo 'selected';?>>
                                            <?php echo $row['currency_name'] . ' , '.$row['currency_symbol'];?>
                                        </option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <?php
                            $saved_currency_location   =   DataApi::chb_get_settings('currency_location');
                            ?>
                            <div class="form-group">
                                <label>Currency position</label>
                                <select class="form-control" name="currency_location">
                                    <option value="right" <?php if($saved_currency_location == 'right') echo 'selected';?>>
                                        Right</option>
                                    <option value="left" <?php if($saved_currency_location == 'left') echo 'selected';?>>
                                        Left</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Vat Percentage</label>
                                <input type="text" class="form-control" name="vat_percentage" 
                                    value="<?php echo DataApi::chb_get_settings('vat_percentage');?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-sm btn-primary" value="Update settings">
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'modal.php';?>

<script>

	jQuery(document).ready(function(){
        // Configuration for ajax form submission
        var options = { 
            beforeSubmit        :   validate,  
            success             :   response_settings_saved,  
            resetForm           :   false 
        }; 

        // Binding the form for ajax submission
        jQuery('.settings').submit(function() { 
            jQuery(this).ajaxSubmit(options); 

            // prevents normal form submission
            return false; 
        }); 
        

	})
    function validate() {
        if (jQuery('#hotel_name').val() == '') {
            notify_warning('Hotel name must be filled up!');
            jQuery('#name').focus();
            return false;
        }
        return true;
    }
    function response_settings_saved() {
        notify('settings updated');
    }

    // WP MEDIA UPLOADER FOR LOGO UPLOADING

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

            jQuery("#logo_url").val(image_url);
            jQuery("#logo_image").attr("src", image_url);
        });

        media_uploader.open();
    }

</script>