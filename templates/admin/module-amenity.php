<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<div class="row" style="margin-top:30px;">
	<div class="col-lg-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Manage Amenity</h3>
			</div>
			<div class="panel-body">
								
				<button type="button" class="btn btn-success btn-sm" onclick="ajax_call('modal-amenity-add', 'true', 'false', 'modal_body')	"
					style="float: right; margin-bottom:15px;">
					+ Add new amenity</button>
				
				<!-- Room type listing -->
				<table class="table table-striped table-hover ">
					<thead class="thead-dark">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Description</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$counter = 1;
							global $wpdb;
							$amenity			=	$wpdb->prefix. 'chb_amenity';
							$query_result	=	$wpdb->get_results("SELECT * FROM `$amenity`", ARRAY_A);
							foreach($query_result as $row):
						?>
						<tr>
							<td><?php echo $counter++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['description'];?></td>
							<td>
								<button type="button" class="btn btn-default btn-xs"
									onclick="ajax_call('modal-amenity-edit', 'true', 'false', 'modal_body', <?php echo $row['amenity_id'];?>)">
										edit</button>
								<button type="button" class="btn btn-default btn-xs"
									onclick="ajax_call('delete-amenity', 'false', 'true', 'tab3', <?php echo $row['amenity_id'];?>, 'module-amenity')">
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