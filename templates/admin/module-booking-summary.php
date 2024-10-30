<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$booking_id = $_POST['param1'];
$sub_total_room_price	=	0;
$vat_percentage			=	DataApi::chb_get_settings('vat_percentage');
global $wpdb;
$booking			=	$wpdb->prefix. 'chb_booking';
$query_result		=	$wpdb->get_results("SELECT * FROM `$booking` WHERE `booking_id` = $booking_id ", ARRAY_A);

foreach ($query_result as $row):
?>
<center>
    <h4 style="margin-bottom:20px;">Booking summary</h4>
</center>

<div class="row">
	<!-- GUEST PERSONAL DETAIL -->
	<div class="col-md-6">
		<h6><i class="fa fa-id-badge"></i> Booking detail</h6>
		<table class="table table-striped">
			<tr>
				<td>
					Status 
				</td>
				<td>
					<span class="badge badge-info">
						<?php 
						if ($row['status'] == '1')echo 'reservation';
						else if ($row['status'] == '2')echo 'active';
						else if ($row['status'] == '3')echo 'completed';
						?>
					</span>
				</td>
			</tr>
			<tr>
				<td>
					Guest name 
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
	<div class="col-md-6">
		<h6><i class="fa fa-file-text-o"></i> Invoice</h6>
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
					$vat_amount	=	round($sub_total_room_price * $vat_percentage / 100);
					echo DataApi::chb_currency($vat_amount);
					?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Grand total</b>
				</td>
				<td align="left">
					<b>
						<?php 
						$grand_total	=	$sub_total_room_price + $vat_amount;
						echo DataApi::chb_currency($grand_total);
						?>
					</b>
				</td>
			</tr>
		</table>
	</div>
	<div class="col-md-6">
		<h6><i class="fa fa-credit-card"></i> Payment History</h6>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Date</th>
					<th>Price</th>
				</tr>
			</thead>
			<?php
			$total_paid_amount	=	0;
			$payments			=	DataApi::chb_get_booking_payments($booking_id);
			foreach($payments as $row2):
				?>
				<tr>
					<td>
						<?php echo date("d M, Y", $row2['timestamp']);?>
					</td>
					<td>
						<?php 
						echo DataApi::chb_currency($row2['amount']);
						$total_paid_amount	+=	$row2['amount'];
						?>
					</td>
				</tr>
			<?php
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