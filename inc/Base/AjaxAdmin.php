<?php

/**
 * @package LuxuryHotelBooking
 */

namespace Inc\base;

use Inc\api\DataApi;

defined( 'ABSPATH' ) or die( 'Access not allowed!' );

class AjaxAdmin extends BaseController
{
	protected $page_to_load;

	// Method for registering ajax submit hook to the plugin
	public function register() {
		add_action( 'wp_ajax_chb_task' , array( $this, 'post' ) );
	}

	// Method for sanitizing all the received parameters and assign it to the public variables declared in this class
	public function post() {

		$this->page_to_load      = sanitize_text_field($_POST['task_name']);
        require ( $this->plugin_path . "templates/admin/$this->page_to_load.php" );
        die();

	}
}