<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<div class="row" style="margin-top:30px;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Active Booking List</h3>
		</div>
		<div class="panel-body">
			
			<div class="row">
				<div class="col-md-5">
					<button type="button" class="btn btn-success btn-sm" onclick="ajax_call('modal-booking-add', 'true', 'false', 'modal_body')	"
						style=" margin-bottom:15px;">
						+ Add new booking</button>
					<div id="reportrange"
						 style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%">
						<i class="fa fa-calendar"></i>&nbsp;
						<span></span> <b class="caret"></b>
					</div>
					<table class="table table-striped table-hover ">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Name</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$counter			=	1;
								global $wpdb;
								$room				=	$wpdb->prefix. 'chb_room';
								$query_result		=	$wpdb->get_results("SELECT * FROM `$room` ", ARRAY_A);
								foreach($query_result as $row):
							?>
							<tr style="cursor: pointer;" class="" id="row_<?php echo $row['room_id'];?>" 
								onClick="load_booking('<?php echo $row['room_id'];?>')">
								<td><?php echo $counter;?></td>
								<td><?php echo $row['name'];?></td>
							</tr>
							<?php
								$counter++;
								endforeach;
							?>
						</tbody>
					</table>
				</div>
				<div class="col-md-7">
					<h4>Booking detail</h4>
					<ul class="nav nav-tabs">
						<li class="nav-item active" style="float: left;">
							<a class="nav-link active" data-toggle="tab" href="#tab1" onclick="ajax_call('module-room', 'false', 'false', 'tab1')">
								<i class="flaticon-squares-2"></i> Rooms allocated</a>
						</li>
						<li class="nav-item" style="float: left;">
							<a class="nav-link" data-toggle="tab" href="#tab2" onclick="ajax_call('module-room-type', 'false', 'false', 'tab2')">
								<i class="flaticon-signs-1"></i> Guest info</a>
						</li>
						<li class="nav-item" style="float: left;">
							<a class="nav-link" data-toggle="tab" href="#tab3" onclick="ajax_call('module-floor', 'false', 'false', 'tab3')">
								<i class="flaticon-layers"></i> Payment detail</a>
						</li>
					</ul>
				</div>
			</div>

		</div>
	</div>
</div>


<script>
	function load_booking(booking_id) {
		jQuery(".info").removeClass("info");
		jQuery("#row_" + booking_id).addClass("info");
	}
	
	// Making daterangepicker
	jQuery(document).ready(function(){
		var start = moment();
        var end = moment();
 
        function cb(start, end) {
            jQuery('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
 
        jQuery('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
 
        cb(start, end);
	})
</script>