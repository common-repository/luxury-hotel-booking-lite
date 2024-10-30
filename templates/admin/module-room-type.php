<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<div class="row" style="margin-top:30px;">
	<div class="col-lg-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Manage Room Type</h3>
			</div>
			<div class="panel-body">
								
				<button type="button" class="btn btn-success btn-sm" onclick="ajax_call('modal-room-type-add', 'true', 'false', 'modal_body')	"
					style="float: right; margin-bottom:15px;">
					+ Add new room type</button>
				
				<!-- Room type listing -->
				<table class="table table-striped table-hover ">
					<thead class="thead-dark">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Capacity</th>
							<th>Price</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							global $wpdb;
							$room_type		=	$wpdb->prefix. 'chb_room_type';
							$query_result	=	$wpdb->get_results("SELECT * FROM `$room_type`", ARRAY_A);
							foreach($query_result as $row):
						?>
						<tr>
							<td>
								<img src="<?php echo $row['image_url'];?>" style="height:40px;">
							</td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['capacity'];?></td>
							<td><?php echo DataApi::chb_currency($row['price']);?></td>
							<td>
								<button type="button" class="btn btn-default btn-xs"
									onclick="ajax_call('modal-room-type-edit', 'true', 'false', 'modal_body', <?php echo $row['room_type_id'];?>)">
										edit</button>
								<button type="button" class="btn btn-default btn-xs"
									onclick="ajax_call('delete-room-type', 'false', 'true', 'tab4', <?php echo $row['room_type_id'];?>, 'module-room-type')">
										delete</button>
							</td>
						</tr>
						<?php
							endforeach;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>



