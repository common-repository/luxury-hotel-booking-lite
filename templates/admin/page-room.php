<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<div style="text-align: right; padding: 5px;">
		<a class="btn btn-info btn-xs" href="http://support.creativeitem.com" target="_blank">Get support</a>
		<a class="btn btn-info btn-xs" href="http://creativeitem.com/demo/hotel_wp/wp-admin/admin.php?page=chb-booking" target="_blank">Full demo</a>
		<a class="btn btn-info btn-xs" href="https://codecanyon.net/item/x/21445221/?ref=creativeitem" target="_blank">upgrade</a>
	</div>
<div class="bs-component">
	<div class="row">
		<div class="col-md-9 col-md-offset-2">
			<ul class="nav nav-tabs">
				<li class="nav-item active" style="float: left;">
					<a class="nav-link active" data-toggle="tab" href="#tab1" onclick="ajax_call('module-room', 'false', 'false', 'tab1')">
						<i class="flaticon-squares-2"></i> Rooms</a>
				</li>
				<li class="nav-item" style="float: left;">
					<a class="nav-link" data-toggle="tab" href="#tab3" onclick="ajax_call('module-amenity', 'false', 'false', 'tab3')">
						<i class="flaticon-tea-cup"></i> Amenities</a>
				</li>
				<li class="nav-item" style="float: left;">
					<a class="nav-link" data-toggle="tab" href="#tab4" onclick="ajax_call('module-room-type', 'false', 'false', 'tab4')">
						<i class="flaticon-signs-1"></i> Room type</a>
				</li>
				<li class="nav-item" style="float: left;">
					<a class="nav-link" data-toggle="tab" href="#tab5" onclick="ajax_call('module-floor', 'false', 'false', 'tab5')">
						<i class="flaticon-layers"></i> Floors</a>
				</li>

			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10 col-md-offset-2">
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade in active" id="tab1">
					loading..
				</div>
				<div class="tab-pane fade" id="tab3">
					loading..
				</div>
				<div class="tab-pane fade" id="tab4">
					loading..
				</div>
				<div class="tab-pane fade" id="tab5">
					loading..
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'modal.php';?>

<script>
	jQuery(document).ready(function(){
		ajax_call('module-room', 'false', 'false', 'tab1');
	})

</script>