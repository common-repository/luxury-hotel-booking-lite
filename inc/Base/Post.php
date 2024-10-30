<?php

/**
 * @package LuxuryHotelBooking
 */

namespace Inc\base;

use Inc\api\DataApi;


class Post extends BaseController
{
	
	public function register() {

	    // Wordpress form submission post function
	    add_action('admin_post_chb', array( $this, 'task' ) );
	    add_action('admin_post_nopriv_chb', array( $this, 'task' ) );

	}

	public function task() {

		$nonce 	=	sanitize_text_field($_POST['nonce']);
		$task 	=	sanitize_text_field($_POST['task']);

		$nonce_verify	=	wp_verify_nonce($nonce , 'chb-hotel-booking');


		//Only if nonce values submitted with post calls are verified, those db query functions will be executed
		if ($nonce_verify == true) {

			if ($task		==	'create_booking_publicly') {
				DataApi::chb_create_booking_publicly();
			}
			if ($task		==	'create_booking_stripe_payment') {
				DataApi::chb_create_booking_stripe_payment();
			}
			if ($task		==	'create_booking_paypal_payment') {
				DataApi::chb_create_booking_paypal_payment();
			}

			if ($task		==	'create_booking') {
				DataApi::chb_booking_create();
			}

			if ($task		==	'edit_booking') {
				DataApi::chb_booking_edit();
			}

			if ($task		==	'delete_booking') {
				DataApi::chb_booking_delete();
			}

			if ($task		==	'take_payment') {
				DataApi::chb_take_payment();
			}

			if ($task		== 'create_room') {
				DataApi::chb_room_create();
			}

			if ($task		== 'edit_room') {
				DataApi::chb_room_edit();
			}
			
			if ($task 		== 'delete-room') {
				DataApi::chb_room_delete();
			}

			if ($task		==	'create_pricing') {
				DataApi::chb_pricing_create();
			}

			if ($task		==	'delete_pricing') {
				DataApi::chb_pricing_delete();
			}

			if ($task		== 'create_room_type') {
				DataApi::chb_room_type_create();
			}

			if ($task		== 'edit_room_type') {
				DataApi::chb_room_type_edit();
			}
			
			if ($task 		== 'delete-room-type') {
				DataApi::chb_room_type_delete();
			}

			if ($task		== 'create_floor') {
				DataApi::chb_floor_create();
			}

			if ($task		== 'edit_floor') {
				DataApi::chb_floor_edit();
			}
			
			if ($task 		== 'delete-floor') {
				DataApi::chb_floor_delete();
			}
			
			if ($task		== 'create_amenity') {
				DataApi::chb_amenity_create();
			}

			if ($task		== 'edit_amenity') {
				DataApi::chb_amenity_edit();
			}
			
			if ($task 		== 'delete-amenity') {
				DataApi::chb_amenity_delete();
			}
			
			if ($task		== 'create_service') {
				DataApi::chb_service_create();
			}

			if ($task		== 'edit_service') {
				DataApi::chb_service_edit();
			}
			
			if ($task 		== 'delete-service') {
				DataApi::chb_service_delete();
			}
			
			if ($task 		== 'save_settings') {
				DataApi::chb_save_settings();
			}

		}

	}
}