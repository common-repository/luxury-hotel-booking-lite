<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>

<style type="text/css">
	.preview_thumb {
		border:1px solid #ccc; width: 100%; margin:0px 0px 15px;
	}
	.nav.fixed{
        position: fixed;
        position: fixed;
        top: 32px;
        right: 15px;
        z-index: 10000;
        padding: 10px;
        width:905px;
        background-color: rgba(255, 235, 59, 0.91) !important;
    }
</style>
<div class="row" style="margin:20px 0px;">
	<div class="col-md-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					Help & Support
				</h3>
			</div>
			<div class="panel-body" style="text-align: center; padding: 150px 10px;">
					<i class="fa fa-life-ring" style="font-size: 50px; color: #607D8B;"></i>
				<h5 style="line-height: 1.9; color: cadetblue;">Get premium quality free support via zendesk from Creativeitem developer team.</h5>
				<hr>
				<a class="btn btn-info btn-sm" href="http://support.creativeitem.com" target="_blank">
					<i class=""></i>
					Contact us
				</a>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					More features
				</h3>
			</div>
			<div class="panel-body">
				<div class="row nav" style="background-color: white;">
					<div class="col-md-10">
						<h5>Upgrade to the premium version of Luxury and unlock all features.</h5>
					</div>
					
					<div class="col-md-2">
						<a class="btn btn-danger btn-sm" href="https://codecanyon.net/item/x/21445221/?ref=Creativeitem" target="_blank">
						<i class=""></i>
						Upgrade now
						</a>
					</div>
				</div>

				<hr>

				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/additional_service.png')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/additional_service.png" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Additional Services</h4>
						<hr>
						<h6>
							Hotel extra services with booking can be managed. For example, breakfast, car parking, airport pickup etc.. There are multiple types of additional services. It can be multiplied with per guest, per night or a fixed price attached with each booking. 
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/payment_manager.png')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/payment_manager.png" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Payment Invoice</h4>
						<hr>
						<h6>
							Every booking has a payment history of the guests. They are preserved properly and showed as invoice and can be printed to the guests. 
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/custom_pricing.png')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/custom_pricing.png" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Custom Room Pricing</h4>
						<hr>
						<h6>
							There is a base price for each room type. Over that, hotel manager can setup different pricing for a room on a schedule basis. For example, a room price can be changed from base price for 6 months, and only saturdays. It can be reset later on.
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/paypal_payment.png')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/paypal_payment.png" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Paypal payment</h4>
						<hr>
						<h6>
							Guest can make payment of booking from the frontend website using their paypal account.
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/stripe_payment.png')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/stripe_payment.png" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Stripe payment</h4>
						<hr>
						<h6>
							Guest can make payment of booking from the frontend website using their stripe account. 
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/cash_payment.jpg')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/cash_payment.jpg" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Cash payment management</h4>
						<hr>
						<h6>
							Guest can make cash payment arriving the hotel, and manager can put entry of cash amount taken against a booking payment. 
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/multilanguage.jpg')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/multilanguage.jpg" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Multilanguage, WPML compatibility</h4>
						<hr>
						<h6>
							This plugin can be translated into different languages. A language template file will be given with the plugin which can be edited by poeditor and easily translated.
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/payment_report.png')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/payment_report.png" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Payment Report</h4>
						<hr>
						<h6>
							There is a payment report generation module. Which can be very helpful for tracking booking payments and other statistical data.
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="#" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/booking_form_shortcode.png')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/booking_form_shortcode.png" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Guest booking form shortcode</h4>
						<hr>
						<h6>
							Guest booking form can be setup in a page using shortcode
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->
				
				<!-- Upgrade feature starts -->
				<div class="row">
					<div class="col-md-3">
						<a href="" onclick="show_preview('<?php echo $this->plugin_url;?>assets/upgrade/airbnb_ical.png')">
							<img src="<?php echo $this->plugin_url;?>assets/upgrade/airbnb_ical.png" class="preview_thumb">
						</a>
					</div>
					<div class="col-md-9">
						<h4>Airbnb sync with ical</h4>
						<hr>
						<h6>
							If your hotel rooms are also attached with airbnb, for prohibitting the overbooking, there will be a syncing calendar. So when your room is booked in airbnb, it will also be shown as unavailable on that same day in your luxury hotel booking premium plugin.
						</h6>
					</div>
				</div>
				<!-- Upgrade feature ends -->

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function show_preview(image_url) {
		event.preventDefault();
		jQuery('#modal').modal('show');
		jQuery('#modal_body').html('<img src="' + image_url + '" style="width:100%;" />');
		return false;
	}
</script>

<div id="modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Preview</h4>
			</div>
			<div class="modal-body" id="modal_body" style="padding: 0px;">
				
			</div>
		</div>
	</div>
</div>

<script>
	

	jQuery(document).ready(function(){

            var navHeight = jQuery('.nav').offset().top;
            jQuery(window).bind('scroll', function() {
                console.log(navHeight);
                console.log(jQuery(window).scrollTop());
                if (jQuery(window).scrollTop() > navHeight-32) {
                    jQuery('.nav').addClass('fixed');
                }
                else {
                    jQuery('.nav').removeClass('fixed');
                }
            });
        });

</script>