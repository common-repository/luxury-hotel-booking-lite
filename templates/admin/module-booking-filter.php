<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<div class="row">
	<h4><i class="fa fa-calendar-check-o"></i> Booking list</h4>
	<hr style="margin: 10px;">
	<!-- Filter toggling button -->
	<div class="col-md-12" style="text-align:right;">
		<button id="filter" type="button" class="btn btn-xs btn-default">
			<i class="fa fa-sliders"></i> filter</button>
		<button type="button" class="btn btn-default btn-xs" onclick="ajax_call('modal-booking-add', 'true', 'false', 'modal_body')">
			<i class="fa fa-plus"></i>
			create booking
		</button>
	</div>
</div>

<!-- FILTERING OPTIONS -->
<div id="filter_options" style="clear: both; background-color: rgb(249, 249, 249); padding: 15px; margin: 20px 0px; display: none;">
	
		<div class="row" style="margin-bottom:10px;">
			<div class="col-md-4">
				Booking status : 
			</div>

			<div class="col-md-8">
				<input type="radio" name="status" class="icheck" id="status-active" value="2" checked="">
				<label for="status-active" class="status_selector">Active</label>

				<input type="radio" name="status" class="icheck" id="status-reservation" value="1">
				<label for="status-reservation" class="status_selector">Reservation</label>

				<input type="radio" name="status" class="icheck" id="status-completed" value="3">
				<label for="status-completed" class="status_selector">Completed</label>
			</div>
		</div>
		<div class="row" style="margin-bottom:10px;" id="daterange">
			<div class="col-md-4">
				Date range : 
			</div>

			<div class="col-md-8">
				<div id="reportrange" 
					style="background: #fff; cursor: pointer; padding: 7px 15px; border: 1px solid #ccc;">
					<i class="fa fa-calendar"></i>&nbsp;
					<span></span> <b class="caret"></b>
				</div>
				<input type="hidden" id="filter_timestamp_from">
				<input type="hidden" id="filter_timestamp_to">
			</div>
		</div>
		<div class="row" style="margin-bottom:10px;" id="guestdetail">
			<div class="col-md-4">
				Guest name/phone : 
			</div>

			<div class="col-md-8">
				<input type="text" class="form-control" placeholder="Name or phone number" id="guest" />
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-8 col-md-offset-4">
				<button type="submit" class="btn btn-default btn-xs" style="width: 100%;"
					onclick="do_filter('true')">Filter booking</button>
			</div>
		</div>
</div>

<script>





jQuery(document).ready(function(){

	// Show / hide the filtering options
	jQuery( "#filter" ).click(function() {
		jQuery( "#filter_options" ).slideToggle( "fast");
	});

	// Making daterangepicker
	var start = moment();
    var end = moment();

    function cb(start, end) {
        jQuery('#reportrange span').html(start.format('D MMM, YYYY') + ' - ' + end.format('D MMM, YYYY'));
        jQuery('#filter_timestamp_from').val(start.format('D MMM, YYYY'));
        jQuery('#filter_timestamp_to').val(end.format('D MMM, YYYY'));
    }

	// Making date range picker
    jQuery('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Tomorrow': [moment().subtract(-1, 'days'), moment().subtract(-1, 'days')],
            'Next 7 Days': [moment(), moment().subtract(-6, 'days')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Next Month': [moment().subtract(-1, 'month').startOf('month'), moment().subtract(-1, 'month').endOf('month')],
            'Next 6 Months': [moment().subtract(-1, 'month').startOf('month'), moment().subtract(-6, 'month').endOf('month')],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        }
    }, cb);

    cb(start, end);

    // Customize icheck
	jQuery('.icheck').iCheck({
	    checkboxClass: 'icheckbox_square-blue',
	    radioClass: 'iradio_square-blue',
	    increaseArea: '20%' // optional
	});
	jQuery('#status-active').on('ifChecked', function(event){
		//jQuery("#guestdetail").slideUp(200);
		jQuery("#daterange").slideUp(200);
	});
	jQuery('#status-reservation').on('ifChecked', function(event){
		//jQuery("#guestdetail").slideDown(200);
		jQuery("#daterange").slideDown(200);
	});
	jQuery('#status-completed').on('ifChecked', function(event){
		//jQuery("#guestdetail").slideDown(200);
		jQuery("#daterange").slideDown(200);
	});
	
	// By default, active bookings are selected
	// so, daterange won't be shown
	//jQuery("#guestdetail").slideUp(200);
	jQuery("#daterange").slideUp(200);


	// Load the list of active booking, by default
	do_filter();
})



// Manual ajax call due to ux for toggling the filter section after completing booking list loading.
function do_filter( toggle = 'false') {
	var ajaxurl 				= 	'<?php echo admin_url( 'admin-ajax.php' );?>';
	var status 					=	jQuery("input[name='status']:checked").val();
	var filter_timestamp_from 	=	jQuery("#filter_timestamp_from").val();
	var filter_timestamp_to 	=	jQuery("#filter_timestamp_to").val();
	var guest 					=	jQuery("#guest").val();

	jQuery.post(
		ajaxurl,
		{
			'action'	: 'chb_task',
			'task_name'	: 'module-booking-list',
			'param1'	: status,
			'param2'	: filter_timestamp_from,
			'param3'	: filter_timestamp_to,
			'param4'	: guest,
		},
		function (response) {
			jQuery('#booking_list_holder').html(response);
			if (toggle == 'true')
				jQuery( "#filter_options" ).slideToggle( "fast");
		}
	);
	
}


</script>