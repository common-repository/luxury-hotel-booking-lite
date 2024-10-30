<?php 

/**
 * @package  LuxuryHotelBooking
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{

	public function booking()
	{
		return require_once( "$this->plugin_path/templates/admin/page-booking.php" );
	}

	public function availability()
	{
		return require_once( "$this->plugin_path/templates/admin/page-availability.php" );
	}

	public function rooms()
	{
		return require_once( "$this->plugin_path/templates/admin/page-room.php" );
	}

	public function settings()
	{
		return require_once( "$this->plugin_path/templates/admin/page-settings.php" );
	}

	public function help()
	{
		return require_once( "$this->plugin_path/templates/admin/page-help.php" );
	}
}