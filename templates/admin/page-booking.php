<?php

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
			<h3 class="panel-title"><?php _e('Booking', 'luxury-hotel-booking-system');?> Dashboard</h3>
		</div>
		<div class="panel-body">
			
			<div class="row">
				<div class="col-md-6">
					<?php include 'module-booking-filter.php';?>
					<div id="booking_list_holder">
						<?php include 'module-booking-list.php';?>
					</div>
				</div>
				
				<div class="col-md-6 ">
					<h4><i class="fa fa-calendar"></i> Booking detail</h4>
					<hr style="margin: 10px;">
					<div id="booking_detail">
						<?php include 'module-booking-detail-placeholder.php';?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php include 'modal.php';?>
<script>
</script>