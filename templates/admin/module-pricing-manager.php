<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$room_type_id	=	sanitize_text_field($_POST['param1']);
$current_year	=	sanitize_text_field($_POST['param2']);
$room_type_price=	DataApi::chb_get_room_type_price($room_type_id);
$room_type_name =   DataApi::chb_get_name_by_room_type_id($room_type_id);
?>

<hr>
<center>
	<h4>Price manager</h4>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">

			<table class="table table-striped">
				<tbody>
					<tr>
						<td align="right">Room type</td>
						<td><?php echo $room_type_name;?></td>
					</tr>
					<tr>
						<td align="right">Base price</td>
						<td><?php echo DataApi::chb_currency($room_type_price);?></td>
					</tr>
					<tr>
						<td align="right">Year</td>
						<td><?php echo $current_year;?></td>
					</tr>
					<tr>
						<td align="right">
							<button class="btn btn-default btn-xs" 
								onclick="ajax_call('modal-pricing-create', 'true', 'false', 'modal_body', <?php echo $room_type_id;?>, <?php echo $current_year;?>)">
								<i class="fa fa-plus-circle"></i> Create custom price</button>
						</td>
						<td>
							<button class="btn btn-default btn-xs"
								onclick="ajax_call('modal-pricing-delete', 'true', 'false', 'modal_body', <?php echo $room_type_id;?>, <?php echo $current_year;?>)">
								<i class="fa fa-trash-o"></i> Reset custom price</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</center>
<hr>

<table class="table table-bordered" style="cursor:default;">
	<thead>
	<tr>
		<td>Month/Date</td>
		<?php
		for ($i = 1; $i<=31; $i++) :
			?>
			<td style="font-family:poppins;">
				<?php echo $i;?>
			</td>
			<?php
		endfor;
		?>
	</tr>
	</thead>
	<tbody>
		<?php
			// Listing all month of a year
			for ($m=1; $m<=12; $m++) :
	    	$month = date('F', mktime(0,0,0,$m, 1, $current_year));
		?>
			<tr>
				<td style="font-family:poppins; vertical-align:middle;"><?php echo $month;?></td>
				<?php
				// Show the date if it is actually a valid one
				for ($i = 1; $i<=31; $i++):
					if ( checkdate($m, $i, $current_year) == false)
						continue;

						// Define the room price. If special prcing is available or not
						global $wpdb;
						$table 		=   $wpdb->prefix . 'chb_pricing';
    					$query		=   "SELECT * FROM $table WHERE `room_type_id` = $room_type_id AND `day` = $i AND `month` = $m AND `year` = $current_year";
    					$wpdb->get_results($query);
    					//$wpdb->get_results("SELECT * FROM $table WHERE `day` = $i AND `month` = $m AND `year` = $current_year");
    					if( $wpdb->num_rows == 0)
    					{
    						$room_price 	=	$room_type_price;
    					}
    					else 
    					{
    						$custom_pricing =	$wpdb->get_row($query);
    						$room_price 	=	$custom_pricing->price;
    					}
    					$full_date	=	$i . " " . $month .", " . $current_year;
    					$day_name	=	date('D', strtotime($full_date));
					?>
					<td title="<?php echo $full_date . '('. $day_name .')';?>" 
						class="<?php if ($room_price == $room_type_price) echo 'regular';else echo 'special';?>">
						
						<div class="price_amount">
							<?php echo $room_price;?>
						</div>
						
    					<div class="day_name">
    						<?php echo $day_name;?>
    					</div>
					</td>
				<?php
				endfor;
				?>
			</tr>
		<?php 
		endfor;
		?>
	</tbody>
</table>
<style>
.regular {
	background-color: #fff;
	padding: 0px !important;
}
.special {
	/*background-color: #eee;*/
	padding: 0px !important;
}
.special .price_amount {
	color:#eb4d3d;
}
.special .day_name {
	background-color: #eb4d3d;
	color:#fff;
}
.day_name {
	background-color: #eee;
	color: #aaa;
	font-size: 10px;
	font-weight: 100;
	text-align: center;
}
.price_amount {
	padding:5px 5px;
	text-align: center;
	color: #9e9e9e;
}
</style>

