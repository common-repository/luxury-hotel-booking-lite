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
                <!-- LIST OF ROOM TYPES -->
                <select name="room_type_id" id="room_type_id" onchange="load_rooms()" class="form-control">
                        <option value="0">All room type</option>
                    <?php
                    $room_types =   DataApi::chb_get_room_type();
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
                Select a room
            </td>
            <td>

                <!-- LIST OF ALL ROOM TYPES -->
                <select name="room_id" id="room_type_0" class="rooms form-control" onchange="load_rooms()"
                    style="width:150px;">
                    <?php
                    $rooms =   DataApi::chb_get_rooms();
                    foreach ($rooms as $row) :
                        ?>
                        <option value="<?php echo $row['room_id'];?>">
                            <?php echo $row['name'];?>
                        </option>
                    <?php
                    endforeach;
                    ?>
                </select>


                <!-- LIST OF SELECTED TYPE'S ROOMS -->
                <?php
                foreach ($room_types as $row):
                    ?>
                    <select name="room_id" id="room_type_<?php echo $row['room_type_id'];?>" 
                        style="display:none; width:150px;" class="rooms form-control" onchange="load_rooms()">
                        <?php
                        $rooms =   DataApi::chb_get_room_by_type($row['room_type_id']);
                        foreach ($rooms as $row2) :
                            ?>
                            <option value="<?php echo $row2['room_id'];?>">
                                <?php echo $row2['name'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                    <?php 
                endforeach;
                ?>
            </td>
        </tr>
    </table>
</center>
<hr>