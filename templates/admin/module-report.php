<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

$start_date		=	$_POST['param1'];
$end_date		=	$_POST['param2'];
$start_timestamp=	strtotime($start_date);
$end_timestamp	=	strtotime($end_date);
?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<table class="table table-striped">
			<thead>
				<tr>
    				<th>
						Date
					</th>
					<th>
						Amount
					</th>
					<th>
						Detail
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$total_amount	=	0;
				global $wpdb;
				$table			=	$wpdb->prefix. 'chb_payment';
				$query_result	=	$wpdb->get_results("SELECT * FROM `$table` WHERE `timestamp` >= $start_timestamp AND `timestamp` <= $end_timestamp", ARRAY_A);
				foreach ($query_result as $row):
				?>
				<tr>
					<td>
						<?php echo date("d M, Y", $row['timestamp']); ?>
					</td>
					<td>
						<?php echo DataApi::chb_currency($row['amount']); $total_amount	+=	$row['amount'];?>
					</td>
					<td>
						<button class="btn btn-xs btn-default" 
							onclick="ajax_call('module-booking-summary', 'true', 'false', 'modal_body', <?php echo $row['booking_id'];?>)">
							booking detail
						</button>
					</td>
				</tr>
				<?php
				endforeach;
				?>
			</tbody>
		</table>
		<hr>
		<h5>Total : <?php echo DataApi::chb_currency($total_amount);?></h5>
	</div>
</div>