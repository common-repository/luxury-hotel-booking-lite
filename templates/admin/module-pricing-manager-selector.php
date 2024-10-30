<?php

use \Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

?>
<center>
	<table>
        <tr>
            <td style="padding:0px 10px;">
                Select room type
            </td>
            <td>
            	<select name="room_type_id" id="room_type" onchange="load_pricing()" class="form-control">
					<?php
					$room_types	=	DataApi::chb_get_room_type();
					foreach ($room_types as $row) :
						?>
						<option value="<?php echo $row['room_type_id'];?>">
							<?php echo $row['name'];?>
						</option>
					<?php
					endforeach;
					?>
				</select>
			</td>
            <td style="padding:0px 10px;">
                Year
            </td>
            <td>
            	<select name="year" id="year" onchange="load_pricing()" class="form-control">
					<?php
					for ($i = 2017; $i <= 2020; $i++) :
						?>
						<option value="<?php echo $i;?>" <?php if (date("Y") == $i) echo 'selected';?>>
							<?php echo $i;?></option>
						<?php
					endfor;
					?>
				</select>
			</td>
        </tr>
    </table>

</center>