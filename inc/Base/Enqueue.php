<?php 
/**
 * @package  LuxuryHotelBooking
 */
namespace Inc\Base;

use Inc\Base\BaseController;

/**
* 
*/
class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue($hook) {

		// Hooking up the js & css files to current plugin pages only
		$current_page = get_current_screen()->base;

		if ( $hook == $current_page ){

			// Javascript files enqued
	        wp_enqueue_script( 'bootstrap',			$this->plugin_url . 'assets/bootstrap.min.js', 					array( 'jquery' ) );
	        wp_enqueue_script( 'icheck',        	$this->plugin_url . 'assets/icheck/icheck.js', 					array( 'jquery' ) );
	        wp_enqueue_script( 'ajax-form',     	$this->plugin_url . 'assets/jquery.form.js', 					array( 'jquery' ) );
	        wp_enqueue_script( 'block-ui',      	$this->plugin_url . 'assets/blockui.js', 						array( 'jquery' ) );
	        wp_enqueue_script( 'notification',		$this->plugin_url . 'assets/jquery.toaster.js', 				array( 'jquery' ) );
	        wp_enqueue_script( 'custom-js',			$this->plugin_url . 'assets/custom.js', 						array( 'jquery' ) );
	        wp_enqueue_script( 'moment',			$this->plugin_url . 'assets/daterangepicker/moment.min.js', 	array( 'jquery' ) );
	        wp_enqueue_script( 'daterange-picker',	$this->plugin_url . 'assets/daterangepicker/daterangepicker.js',array( 'jquery' ) );
			wp_enqueue_script( 'year-calendar', 	$this->plugin_url . 'assets/year-calendar/bootstrap-year-calendar.js' , array( 'jquery' ) );
	        wp_enqueue_script( 'jquery-ui-datepicker' );
	        wp_enqueue_script( 'jquery-ui-accordion' );
	        wp_enqueue_script( 'jquery-ui-tabs' );
	        wp_enqueue_media();
	        
	        // Css files enqued
	        wp_enqueue_style( 'bootstrap',      $this->plugin_url . 'assets/bootstrap.css' );
	        wp_enqueue_style( 'icheck-square',  $this->plugin_url . 'assets/icheck/square/blue.css' );
	        wp_enqueue_style( 'icheck-line',    $this->plugin_url . 'assets/icheck/line/blue.css' );
	        wp_enqueue_style( 'fontawesome',    $this->plugin_url . 'assets/fontawesome/font-awesome.min.css' );
	        wp_enqueue_style( 'flaticon',       $this->plugin_url . 'assets/flaticon.css' );
	        wp_enqueue_style( 'datepicker',     $this->plugin_url . 'assets/jquery-ui/jquery-ui.css' );
	        wp_enqueue_style( 'daterange-picker',$this->plugin_url . 'assets/daterangepicker/daterangepicker.css' );
	        wp_enqueue_style( 'custom',         $this->plugin_url . 'assets/custom.min.css' );
	        wp_enqueue_style( 'year-calendar',  $this->plugin_url . 'assets/year-calendar/bootstrap-year-calendar.css' );
	        wp_enqueue_style( 'custom-css',     $this->plugin_url . 'assets/custom.css' );

	    }
	}
}