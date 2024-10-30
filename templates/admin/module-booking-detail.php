<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$booking_id = $_POST['param1'];
$sub_total_room_price	=	0;
$sub_total_service_price=	0;

$vat_percentage			=	DataApi::chb_get_settings('vat_percentage');
global $wpdb;
$booking			=	$wpdb->prefix. 'chb_booking';
$query_result		=	$wpdb->get_results("SELECT * FROM `$booking` WHERE `booking_id` = $booking_id ", ARRAY_A);

foreach ($query_result as $row):
?>

<div class="row">
	<div class="col-md-6" style="text-align:left;">
		<h5>Status : <span class="badge badge-info">
			<?php 
			if ($row['status'] == '1')echo 'reservation';
			else if ($row['status'] == '2')echo 'active';
			else if ($row['status'] == '3')echo 'completed';
			?>
		</span></h5>
	</div>
	<div class="col-md-6" style="text-align:right;">
		<button type="button" onclick="ajax_call('modal-booking-edit', 'true', 'false', 'modal_body', <?php echo $booking_id;?>)"
			class="btn btn-xs btn-default" >
			<i class="fa fa-pencil"></i> edit
		</button>
		<button type="button" class="btn btn-default btn-xs"
			onclick="ajax_call('modal-booking-delete', 'true', 'false', 'modal_body', <?php echo $booking_id;?>)">
			<i class="fa fa-trash"></i>
		</button>
	</div>
</div>

<div class="row">
	<!-- GUEST PERSONAL DETAIL -->
	<div class="col-md-6">
		<h6><i class="fa fa-id-badge"></i> Guest detail</h6>
		<table class="table table-striped">
			<tr>
				<td>
					Name 
				</td>
				<td>
					<?php echo $row['name'];?>
				</td>
			</tr>
			<tr>
				<td>
					Email
				</td>
				<td>
					<?php echo $row['email'];?>
				</td>
			</tr>
			<tr>
				<td>
					Address
				</td>
				<td>
					<?php echo $row['address'];?>
				</td>
			</tr>
			<tr>
				<td>
					Phone
				</td>
				<td>
					<?php echo $row['phone'];?>
				</td>
			</tr>
			<tr>
				<td>
					Total guest
				</td>
				<td>
					<?php echo $row['total_guest'];?>
				</td>
			</tr>
		</table>
	</div>

	<!-- ROOM ALLOCATION DETAIL -->
	<div class="col-md-6">
		<h6><i class="fa fa-hotel"></i> Room allocation</h6>
		<table class="table table-striped">
			<tbody>
				<?php 
				$allocated_rooms	=	DataApi::chb_get_booking_allocated_rooms($booking_id);
				foreach ($allocated_rooms as $row2):
				?>
				<tr>
					<td>
						<i class="fa fa-dot"></i>
						<?php echo DataApi::chb_get_room_name($row2['room_id']);?>
					</td>
					<td>
						<span class="small_text">
							<?php echo date('d M, Y', $row2['checkin_timestamp']);?> - 
							<?php echo date('d M, Y', $row2['checkout_timestamp']);?>
						</span>
					</td>
					<td>
						<?php 
						echo DataApi::chb_currency($row2['price']);
						$sub_total_room_price	+=	$row2['price'];
						?>
					</td>
				</tr>
				<?php
				endforeach;
				?>
			</tbody>
		</table>
	</div>
</div>
<hr>

<div class="row">

	<!-- payment summary -->
	<div class="col-md-6">
		<h6><i class="fa fa-credit-card"></i> Invoice</h6>
		<table class="table table-striped">
			<tr>
				<td>
					Room Pricing
				</td>
				<td align="left">
					<?php echo DataApi::chb_currency($sub_total_room_price);?>
				</td>
			</tr>
			<tr>
				<td>
					Vat (<?php echo $vat_percentage;?>%)
				</td>
				<td align="left">
					<?php
					$sub_total 	=	$sub_total_room_price + $sub_total_service_price;
					$vat_amount	=	round($sub_total * $vat_percentage / 100);
					echo DataApi::chb_currency($vat_amount);
					?>
				</td>
			</tr>
			<tr>
				<td>
					Total payable
				</td>
				<td align="left">
					<b>
						<?php 
						$grand_total	=	$sub_total + $vat_amount;
						echo DataApi::chb_currency($grand_total);
						?>
					</b>
				</td>
			</tr>
			<?php
			$total_paid_amount	=	0;
			$payments			=	DataApi::chb_get_booking_payments($booking_id);
			foreach($payments as $row2):
				$total_paid_amount	+=	$row2['amount'];
			endforeach;
			?>
			<tr>
				<td>
					<b>Paid</b>
				</td>
				<td>
					<b><?php echo DataApi::chb_currency($total_paid_amount);?></b>
				</td>
			</tr>
			<tr>
				<td>
					<b>Due</b>
				</td>
				<td>
					<b><?php echo DataApi::chb_currency($grand_total - $total_paid_amount);?></b>
				</td>
			</tr>
		</table>
	</div>
	
</div>


<?php
endforeach;
?>
<style>
.small_text {
	font-size:10px; color:#999;
}
</style>