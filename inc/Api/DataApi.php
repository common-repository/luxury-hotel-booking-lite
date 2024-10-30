<?php

/**
 * @package LuxuryHotelBooking
 */

namespace Inc\api;

use \Inc\base\BaseController;
use Stripe\Charge;
use Stripe\Stripe;
defined( 'ABSPATH' ) or die( 'You can not access the file directly' );

class DataApi extends BaseController
{
	// Booking queries
	public static function chb_create_booking_paypal_payment() {
	    $amount             = sanitize_text_field( $_POST['amount'] );
	    $booking_id         = sanitize_text_field( $_POST['booking_id'] );

	    $data['method']     =   'paypal';
	    $data['amount']     =   $amount;    
	    $data['booking_id'] =   $booking_id;    
	    $data['timestamp']  =   strtotime(date("d M, Y"));
	    global $wpdb;
	    $wpdb->insert($wpdb->prefix . 'chb_payment', $data);
	}
	public static function chb_create_booking_stripe_payment() {

	    //require_once('stripe/init.php');
	    // Take values from the submitted form
	    $token              = sanitize_text_field( $_POST['stripe_token'] );
	    $amount             = sanitize_text_field( $_POST['amount'] );
	    $booking_id         = sanitize_text_field( $_POST['booking_id'] );

	    
	    // Get stripe keys from settings
	    
	    
	    // get the stripe settings from database
	    $stripe_settings_json           =   chb_get_settings('stripe');
	    $stripe_settings_array          =   json_decode($stripe_settings_json);
	    $stripe_test_mode               =   $stripe_settings_array[0]->testmode;
	    $stripe_secret_test_key         =   $stripe_settings_array[0]->secret_test_key;
	    $stripe_secret_live_key         =   $stripe_settings_array[0]->secret_live_key;
	    $stripe_currency                =   $stripe_settings_array[0]->currency;

	    if ($stripe_test_mode == 'on')
	        $stripe_secret_key     =   $stripe_secret_test_key;
	    else if ($stripe_test_mode == 'off')
	        $stripe_secret_key     =   $stripe_secret_live_key;

	    $secret_key = $stripe_secret_key;
	    // Set stripe secret key
	    \stripe\Stripe::setApiKey($secret_key);
	    // Create a charge for the paid amount
	    $chargeable_amount  =   $amount * 100;
	    $description        =   'Reservation charge [booking_id_'.$booking_id.']';
	    $currency           =   $stripe_currency;
	    $charge = \stripe\Charge::create(
	        array(
	            'amount'        => $chargeable_amount,
	            'currency'      => $currency,
	            'description'   => $description,
	            'source'        => $token
	        )
	    );
	    //echo $charge;

	    $data['method']     =   'stripe';
	    $data['booking_id'] =   $booking_id;
	    $data['timestamp']  =   strtotime(date("d M, Y"));
	    $data['amount']     =   $amount;
	    global $wpdb;
	    $wpdb->insert($wpdb->prefix . 'chb_payment', $data);
	}

	public static function chb_create_booking_publicly() {
	    $data['status']         =   '1'; // booking type = reservation
	    $data['name']           =   sanitize_text_field($_POST['name']);
	    $data['email']          =   sanitize_text_field($_POST['email']);
	    $data['address']        =   sanitize_text_field($_POST['address']);
	    $data['phone']          =   sanitize_text_field($_POST['phone']);
	    $data['total_guest']    =   sanitize_text_field($_POST['total_guest']);
	    global $wpdb;
	    $wpdb->insert($wpdb->prefix . 'chb_booking', $data);
	    $booking_id             =   $wpdb->insert_id;

	    // Saving the rooms for a single booking
	    $room_types             =   sanitize_text_field($_POST['room_types']);
	    $room_quantities        =   sanitize_text_field($_POST['room_quantities']);
	    $checkin_timestamps     =   sanitize_text_field($_POST['checkin_timestamps']);
	    $checkout_timestamps    =   sanitize_text_field($_POST['checkout_timestamps']);
	    $prices                 =   sanitize_text_field($_POST['prices']);
	    $number_of_entries      =   sizeof($room_types);
	    for ($i = 0; $i< $number_of_entries; $i++) {

	        // for each room type, run the number of rooms requested by guest
	        $room_type_id       =   $room_types[$i];
	        $number_of_rooms    =   $room_quantities[$i];
	        $room_counter       =   1;
	        $room               =   $wpdb->prefix. 'chb_room';
	        $query_result       =   $wpdb->get_results("SELECT * FROM `$room` WHERE `room_type_id` = $room_type_id ", ARRAY_A);
	        foreach($query_result as $row1) {

	            // Flag variable for checking if a room is available for booking
	            $exclude_flag   =   false;

	            // If a room is already in booking status within the asked checkin & checkout timestamp
	            // Checking within the room booking history of a single room
	            $booking_room   =   $wpdb->prefix. 'chb_booking_room';
	            $room_id        =   $row1['room_id'];
	            $query_result2  =   $wpdb->get_results("SELECT * FROM  `$booking_room` WHERE `room_id` = $room_id", ARRAY_A);
	            foreach( $query_result2 as $row2):

	                if ($checkin_timestamps[$i] >= $row2['checkin_timestamp'] && $checkin_timestamps[$i] <= $row2['checkout_timestamp'])
	                {
	                    $exclude_flag   =   true;
	                    break;
	                }
	                if ($checkout_timestamps[$i] >= $row2['checkin_timestamp'] && $checkout_timestamps[$i] <= $row2['checkout_timestamp'])
	                {
	                    $exclude_flag   =   true;
	                    break;
	                }
	                if ($checkin_timestamps[$i] <= $row2['checkin_timestamp'] && $checkout_timestamps[$i] >= $row2['checkout_timestamp'])
	                {
	                    $exclude_flag   =   true;
	                    break;
	                }
	            
	            endforeach;

	            // Exclude this room, as it is not available
	            if ($exclude_flag == true) {
	                continue;
	            }
	            else {
	                
	                // insert in the booking_room table
	                $data2['room_id']               =   $room_id;
	                $data2['checkin_timestamp']     =   $checkin_timestamps[$i];
	                $data2['checkout_timestamp']    =   $checkout_timestamps[$i];
	                $data2['price']                 =   $prices[$i]/$room_quantities[$i];
	                $data2['booking_id']            =   $booking_id;
	                $wpdb->insert($wpdb->prefix . 'chb_booking_room', $data2);

	                // check if the room number exceeds the guest's requests room number of a single room type
	                $room_counter++;
	                if ($room_counter > $number_of_rooms) {
	                    break;
	                }
	            }

	        }
	        
	    }

	    // Saving the services for a single booking
	    $service_ids            =   sanitize_text_field( $_POST['service_ids'] );
	    $types                  =   sanitize_text_field( $_POST['types'] );
	    $guest_numbers          =   sanitize_text_field( $_POST['guest_numbers'] );
	    $night_numbers          =   sanitize_text_field( $_POST['night_numbers'] );
	    $service_prices         =   sanitize_text_field( $_POST['service_prices'] );
	    $number_of_entries      =   sizeof($service_ids);

	    for ($i = 0; $i< $number_of_entries; $i++) {
	        $data3['booking_id']    =   $booking_id;
	        $data3['service_id']    =   $service_ids[$i];
	        $data3['type']          =   $types[$i];
	        $data3['guest_number']  =   $guest_numbers[$i];
	        $data3['night_number']  =   $night_numbers[$i];
	        $data3['price']         =   $service_prices[$i];

	        $wpdb->insert($wpdb->prefix . 'chb_booking_service', $data3);
	    }


	    echo $booking_id;
	}

	public static function chb_booking_create() {
	    $data['status']         =   sanitize_text_field($_POST['status']);
		$data['name']			=	sanitize_text_field($_POST['name']);
	 	$data['email']			=	sanitize_text_field($_POST['email']);
	 	$data['address']		=	sanitize_text_field($_POST['address']);
	 	$data['phone']			=	sanitize_text_field($_POST['phone']);
	 	$data['total_guest']	=	sanitize_text_field($_POST['total_guest']);

	 	global $wpdb;
	 	$wpdb->insert($wpdb->prefix . 'chb_booking', $data);
	    $new_booking_id         =   $wpdb->insert_id;

	 	// Saving the selected rooms for a single booking
	 	$data2['booking_id']	=	$new_booking_id;

	 	$rooms 					=	sanitize_text_field( $_POST['rooms'] );
	 	$checkin_timestamps		=	sanitize_text_field( $_POST['checkin_timestamps'] );
	 	$checkout_timestamps	=	sanitize_text_field( $_POST['checkout_timestamps'] );
	 	$prices					=	sanitize_text_field( $_POST['prices'] );

	 	$number_of_entries		=	sizeof($rooms);
	    for ($i = 0; $i < $number_of_entries; $i++) {
	    	$data2['room_id']				=	$rooms[$i];
	    	$data2['checkin_timestamp']		=	$checkin_timestamps[$i];
	    	$data2['checkout_timestamp']	=	$checkout_timestamps[$i];
	    	$data2['price']					=	$prices[$i];
	    	$wpdb->insert($wpdb->prefix . 'chb_booking_room', $data2);
	    }
	}

	public static function chb_booking_edit() {

	    // Update booking basic info
	    $booking_id             =   sanitize_text_field($_POST['booking_id']);
	    $data['status']         =   sanitize_text_field($_POST['status']);
	    $data['name']           =   sanitize_text_field($_POST['name']);
	    $data['email']          =   sanitize_text_field($_POST['email']);
	    $data['address']        =   sanitize_text_field($_POST['address']);
	    $data['phone']          =   sanitize_text_field($_POST['phone']);
	    $data['total_guest']    =   sanitize_text_field($_POST['total_guest']);

	    global $wpdb;
	    $wpdb->update($wpdb->prefix . 'chb_booking', $data, array('booking_id' => $booking_id));

	    // Update the rooms under this booking.
	    // First delete the old ones and then re-insert the new ones
	    global $wpdb;
	    $wpdb->delete($wpdb->prefix . 'chb_booking_room', array('booking_id' => $booking_id));

	    // Now re-insert the updated booking rooms
	    $data2['booking_id']    =   $booking_id;
	    $rooms                  =   sanitize_text_field( $_POST['rooms'] );
	    $checkin_timestamps     =   sanitize_text_field( $_POST['checkin_timestamps'] );
	    $checkout_timestamps    =   sanitize_text_field( $_POST['checkout_timestamps'] );
	    $prices                 =   sanitize_text_field( $_POST['prices'] );
	    $number_of_entries      =   sizeof($rooms);
	    for ($i = 0; $i < $number_of_entries; $i++) {
	        $data2['room_id']               =   $rooms[$i];
	        $data2['checkin_timestamp']     =   $checkin_timestamps[$i];
	        $data2['checkout_timestamp']    =   $checkout_timestamps[$i];
	        $data2['price']                 =   $prices[$i];
	        $wpdb->insert($wpdb->prefix . 'chb_booking_room', $data2);
	    }

	    
	}

	public static function chb_booking_delete() {    
	    global $wpdb;
	    $booking_id             =   sanitize_text_field($_POST['booking_id']);

	    // delete the booking information
	    $wpdb->delete($wpdb->prefix . 'chb_booking', array('booking_id' => $booking_id));

	    // deleting the rooms allocated with the booking_id
	    $wpdb->delete($wpdb->prefix . 'chb_booking_room', array('booking_id' => $booking_id));
	}

	public static function chb_take_payment() {

	    // create payment under a single booking
	    $data['booking_id']     =   sanitize_text_field($_POST['booking_id']);
	    $data['timestamp']      =   strtotime(sanitize_text_field($_POST['date']));
	    $data['amount']         =   sanitize_text_field($_POST['amount']);

	    global $wpdb;
	    $wpdb->insert($wpdb->prefix . 'chb_payment', $data);
	}

	public static function chb_get_booking_payments($booking_id) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_payment';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `booking_id` = $booking_id", ARRAY_A);
	    return $query_result;
	}

	public static function chb_get_booking_allocated_rooms($booking_id) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_booking_room';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `booking_id` = $booking_id", ARRAY_A);
	    return $query_result;
	}

	public static function chb_get_booking_attached_services($booking_id) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_booking_service';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `booking_id` = $booking_id", ARRAY_A);
	    return $query_result;
	}

	public static function chb_get_booking_of_room($room_id) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_booking_room';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id", ARRAY_A);
	    return $query_result;
	}

	public static function chb_get_room_price($room_id, $checkin_timestamp, $checkout_timestamp) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_room';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        $room_type_id = $row['room_type_id'];
	    }


	    // finding the custom price from price table
	    //$checkin_timestamp  =   strtotime('+1 day', $checkin_timestamp);
	    //$str='';
	    $total_price = 0;
	    for($timestamp  =   $checkin_timestamp; $timestamp < $checkout_timestamp;) {
	        $day                =   date("j",$timestamp);
	        $month              =   date("n",$timestamp);
	        $year               =   date("Y",$timestamp);
	        $table              =   $wpdb->prefix . 'chb_pricing';
	        $numrows            =   $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE `day` = $day AND `month` = $month AND `year` = $year AND `room_type_id` = $room_type_id");
	        if ($numrows == 0) {
	            $table          =   $wpdb->prefix . 'chb_room_type';
	            $price          =   $wpdb->get_var($wpdb->prepare("SELECT price FROM $table WHERE room_type_id = %d", $room_type_id));
	            $total_price    +=  $price;
	        }
	        else {
	            $table          =   $wpdb->prefix . 'chb_pricing';
	            $price          =   $wpdb->get_var($wpdb->prepare("SELECT price FROM $table WHERE `day` = %d AND `month` = %d AND `year` = %d AND `room_type_id` = %d", array($day,$month,$year,$room_type_id) ));
	            $total_price    +=  $price;
	        }
	        
	        //$str .= $day.'-'.$month.'-'.$year.'-'.$numrows.'-'.$price.'<br>';
	        $timestamp = strtotime('+1 day', $timestamp);
	    }
	    
	    //return $str;
	    return $total_price;

	    // if custom price is not found, then rooms default base price is returned
	    /////////
		
	    

		$table         			=	$wpdb->prefix . 'chb_room_type';
	    $query_result   		=	$wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['price'];
	    }    
	 }

	 public static function chb_get_room_name($room_id) {
	 	global $wpdb;
	    $table         			=	$wpdb->prefix . 'chb_room';
	    $query_result   		=	$wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['name'];
	    }
	}

	public static function chb_get_room_type() {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_room_type';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
	    return $query_result;
	}

	public static function chb_get_name_by_room_type_id($room_type_id) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_room_type';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['name'];
	    } 
	}

	public static function chb_get_room_type_name($room_id) {
		global $wpdb;
	    $table         			=	$wpdb->prefix . 'chb_room';
	    $query_result   		=	$wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        $room_type_id = $row['room_type_id'];
	    }

		$table         			=	$wpdb->prefix . 'chb_room_type';
	    $query_result   		=	$wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['name'];
	    } 
	}


	// Room queries
	public static function chb_room_create() {
		$data['name']			=	sanitize_text_field($_POST['name']);
	 	$data['room_type_id']	=	sanitize_text_field($_POST['room_type_id']);
	 	$data['floor_id']		=	sanitize_text_field($_POST['floor_id']);
	 	global $wpdb;
	 	$wpdb->insert($wpdb->prefix . 'chb_room', $data);
	}

	public static function chb_room_edit() {
		$room_id				=	sanitize_text_field($_POST['room_id']);
		$data['name']			=	sanitize_text_field($_POST['name']);
	 	$data['room_type_id']	=	sanitize_text_field($_POST['room_type_id']);
	 	$data['floor_id']		=	sanitize_text_field($_POST['floor_id']);
		
		global $wpdb;
		$wpdb->update($wpdb->prefix . 'chb_room', $data, array('room_id' => $room_id));
	}

	public static function chb_room_delete() {	
		$room_id = sanitize_text_field($_POST['delete_id']);
		global $wpdb;
		$wpdb->delete($wpdb->prefix . 'chb_room', array('room_id' => $room_id));
	}

	// Room type queries

	public static function chb_get_room_types() {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_room_type';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
	    return $query_result;
	}

	public static function chb_room_type_create() {
		$data['name']			=	sanitize_text_field($_POST['name']);
	 	$data['capacity']		=	sanitize_text_field($_POST['capacity']);
	 	$data['price']			=	sanitize_text_field($_POST['price']);
	    $data['image_url']      =   sanitize_text_field($_POST['image_url']);

	    // encoding the amenities arrays into json format
	    $amenity_array          =   array();
	    $amenities              =   sanitize_text_field( $_POST['amenities'] );
	    foreach ($amenities as $row) {
	        array_push($amenity_array, $row);
	    }
	    $amenity_json           =   json_encode($amenity_array);
	    $data['amenities']      =   $amenity_json;

	 	global $wpdb;
	 	$wpdb->insert($wpdb->prefix . 'chb_room_type', $data);
	 }

	public static function chb_room_type_edit() {
		$room_type_id			=	sanitize_text_field($_POST['room_type_id']);
		$data['name']			=	sanitize_text_field($_POST['name']);
	 	$data['capacity']		=	sanitize_text_field($_POST['capacity']);
	    $data['price']          =   sanitize_text_field($_POST['price']);
	    $data['image_url']      =   sanitize_text_field($_POST['image_url']);

	    // encoding the amenities arrays into json format
	    $amenity_array          =   array();
	    $amenities              =   sanitize_text_field( $_POST['amenities'] );
	    foreach ($amenities as $row) {
	        array_push($amenity_array, $row);
	    }
	    $amenity_json           =   json_encode($amenity_array);
	    $data['amenities']      =   $amenity_json;
		
		global $wpdb;
		$wpdb->update($wpdb->prefix . 'chb_room_type', $data, array('room_type_id' => $room_type_id));
	}

	public static function chb_room_type_delete() {	
		$room_type_id = sanitize_text_field($_POST['delete_id']);
		global $wpdb;
		$wpdb->delete($wpdb->prefix . 'chb_room_type', array('room_type_id' => $room_type_id));
	}

	public static function get_room_type_name_by_id($room_type_id = '') {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_room_type';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['name'];
	    }
	}

	public static function chb_get_room_type_price($room_type_id) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_room_type';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['price'];
	    }
	}

	public static function chb_get_room_by_type($room_type_id) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_room';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id", ARRAY_A);
	    return $query_result;
	}

	public static function chb_get_rooms() {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_room';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
	    return $query_result;
	}


	// Floor queries
	public static function chb_floor_create() {
		$data['name']			=	sanitize_text_field($_POST['name']);
	 	$data['note']			=	sanitize_text_field($_POST['note']);
	 	global $wpdb;
	 	$wpdb->insert($wpdb->prefix . 'chb_floor', $data);
	}

	public static function chb_floor_edit() {
		$floor_id				=	sanitize_text_field($_POST['floor_id']);
		$data['name']			=	sanitize_text_field($_POST['name']);
	 	$data['note']			=	sanitize_text_field($_POST['note']);
		
		global $wpdb;
		$wpdb->update($wpdb->prefix . 'chb_floor', $data, array('floor_id' => $floor_id));
	}

	public static function chb_floor_delete() {	
		$floor_id = sanitize_text_field($_POST['delete_id']);
		global $wpdb;
		$wpdb->delete($wpdb->prefix . 'chb_floor', array('floor_id' => $floor_id));
	}

	public static function get_floor_name_by_id($floor_id = '') {
	    global $wpdb;
	    $table         			=	$wpdb->prefix . 'chb_floor';
	    $query_result   		=	$wpdb->get_results("SELECT * FROM $table WHERE `floor_id` = $floor_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['name'];
	    }
	}

	// Amenity queries
	public static function chb_get_amenities() {
	    global $wpdb;
	    $amenity                =   $wpdb->prefix. 'chb_amenity';
	    $query_result           =   $wpdb->get_results("SELECT * FROM `$amenity`", ARRAY_A);
	    return $query_result;
	}
	public static function get_amenity_name_by_id($amenity_id = '') {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_amenity';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `amenity_id` = $amenity_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['name'];
	    }
	}
	public static function chb_amenity_create() {
	    $data['name']           =   sanitize_text_field($_POST['name']);
	    $data['description']    =   sanitize_text_field($_POST['description']);
	    global $wpdb;
	    $wpdb->insert($wpdb->prefix . 'chb_amenity', $data);
	}

	public static function chb_amenity_edit() {
	    $amenity_id             =   sanitize_text_field($_POST['amenity_id']);
	    $data['name']           =   sanitize_text_field($_POST['name']);
	    $data['description']    =   sanitize_text_field($_POST['description']);
	    
	    global $wpdb;
	    $wpdb->update($wpdb->prefix . 'chb_amenity', $data, array('amenity_id' => $amenity_id));
	}

	public static function chb_amenity_delete() { 
	    $amenity_id = sanitize_text_field($_POST['delete_id']);
	    global $wpdb;
	    $wpdb->delete($wpdb->prefix . 'chb_amenity', array('amenity_id' => $amenity_id));
	}

	// Service queries

	public static function chb_get_services() {
	    global $wpdb;
	    $service                =   $wpdb->prefix. 'chb_service';
	    $query_result           =   $wpdb->get_results("SELECT * FROM `$service`", ARRAY_A);
	    return $query_result;
	}

	public static function chb_get_service_name($service_id) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_service';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `service_id` = $service_id", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['name'];
	    } 
	}

	// Settings queries
	public static function chb_save_settings() {
	    global $wpdb;

	    $data['description']    =   sanitize_text_field($_POST['hotel_name']);
	    $wpdb->update($wpdb->prefix . 'chb_settings', $data, array('type' => 'hotel_name'));

	    $data['description']    =   sanitize_text_field($_POST['address']);
	    $wpdb->update($wpdb->prefix . 'chb_settings', $data, array('type' => 'address'));

	    $data['description']    =   sanitize_text_field($_POST['phone']);
	    $wpdb->update($wpdb->prefix . 'chb_settings', $data, array('type' => 'phone'));

	    $data['description']    =   sanitize_text_field($_POST['email']);
	    $wpdb->update($wpdb->prefix . 'chb_settings', $data, array('type' => 'email'));

	    $data['description']    =   sanitize_text_field($_POST['country_id']);
	    $wpdb->update($wpdb->prefix . 'chb_settings', $data, array('type' => 'country_id'));

	    $data['description']    =   sanitize_text_field($_POST['currency_location']);
	    $wpdb->update($wpdb->prefix . 'chb_settings', $data, array('type' => 'currency_location'));

	    $data['description']    =   sanitize_text_field($_POST['vat_percentage']);
	    $wpdb->update($wpdb->prefix . 'chb_settings', $data, array('type' => 'vat_percentage'));

	    $data['description']    =   sanitize_text_field($_POST['logo_url']);
	    $wpdb->update($wpdb->prefix . 'chb_settings', $data, array('type' => 'logo_url'));

	}
	public static function chb_get_settings($type) {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_settings';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `type` = '$type'", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['description'];
	    }
	}

	public static function chb_currency($amount) {
	    global $wpdb;
	    $plugin_country_id      =   self::chb_get_settings('country_id');
	    $currency_location      =   self::chb_get_settings('currency_location');
	    $table                  =   $wpdb->prefix . 'chb_country';
	    $currency_symbol        =   $wpdb->get_var($wpdb->prepare("SELECT currency_symbol FROM $table WHERE country_id = %d",$plugin_country_id)); 

	    if ($currency_location == 'left') {
	        $currency_string    =   $currency_symbol . $amount;
	    }else if ($currency_location == 'right') {
	        $currency_string    =   $amount . $currency_symbol;
	    }

	    return $currency_string;
	}

	public static function chb_get_currency_symbol() {
	    global $wpdb;
	    $plugin_country_id      =   self::chb_get_settings('country_id');
	    $table                  =   $wpdb->prefix . 'chb_country';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table WHERE `country_id` = '$plugin_country_id'", ARRAY_A);
	    foreach ($query_result as $row) {
	        return $row['currency_symbol'];
	    }
	}

	public static function chb_get_countries() {
	    global $wpdb;
	    $table                  =   $wpdb->prefix . 'chb_country';
	    $query_result           =   $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
	    return $query_result;
	}
}