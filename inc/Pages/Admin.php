<?php 
/**
 * @package  LuxuryHotelBooking
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* 
*/
class Admin extends BaseController
{
	public $settings;

	public $callbacks;

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setPages();

		$this->setSubpages();

		//$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
		$this->settings->addPages( $this->pages )->addSubPages( $this->subpages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' 	=> 'Luxury Hotel Booking System', 
				'menu_title' 	=> 'Luxury Lite', 
				'capability' 	=> 'manage_options', 
				'menu_slug' 	=> 'luxury_booking', 
				'callback' 		=> array( $this->callbacks, 'booking' ), 
				'icon_url' 		=> 'dashicons-palmtree', 
				'position' 		=> 10
			)
		);
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' 	=> 'luxury_booking', 
				'page_title' 	=> 'Luxury Hotel Booking System', 
				'menu_title' 	=> 'Booking', 
				'capability' 	=> 'manage_options', 
				'menu_slug' 	=> 'luxury_booking', 
				'callback' 		=> array( $this->callbacks, 'booking' )
			),
			array(
				'parent_slug' 	=> 'luxury_booking', 
				'page_title' 	=> 'Room Availability', 
				'menu_title' 	=> 'Availability', 
				'capability' 	=> 'manage_options', 
				'menu_slug' 	=> 'luxury_availabiity', 
				'callback' 		=> array( $this->callbacks, 'availability' )
			),
			array(
				'parent_slug' 	=> 'luxury_booking', 
				'page_title' 	=> 'Room Management', 
				'menu_title' 	=> 'Rooms', 
				'capability' 	=> 'manage_options', 
				'menu_slug' 	=> 'luxury_rooms', 
				'callback' 		=> array( $this->callbacks, 'rooms' )
			),
			array(
				'parent_slug' 	=> 'luxury_booking', 
				'page_title' 	=> 'Hotel Settings', 
				'menu_title' 	=> 'Settings', 
				'capability' 	=> 'manage_options', 
				'menu_slug' 	=> 'luxury_settings', 
				'callback' 		=> array( $this->callbacks, 'settings' )
			),
			array(
				'parent_slug' 	=> 'luxury_booking', 
				'page_title' 	=> 'Get support - Creativeitem', 
				'menu_title' 	=> 'Help', 
				'capability' 	=> 'manage_options', 
				'menu_slug' 	=> 'luxury_help', 
				'callback' 		=> array( $this->callbacks, 'help' )
			),
		);
	}
}