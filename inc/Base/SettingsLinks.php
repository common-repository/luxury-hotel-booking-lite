<?php
/**
 * @package  LuxuryHotelBooking
 */
namespace Inc\Base;

use Inc\Base\BaseController;

class SettingsLinks extends BaseController
{
	public function register() 
	{
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
	}

	public function settings_link( $links ) 
	{
		$support_link	= '<a href="http://support.creativeitem.com" target="_blank">Support</a>';
		array_push( $links, $support_link );
		$pro_link	= '<a href="https://codecanyon.net/item/x/21445221/?ref=creativeitem" target="_blank">Pro version</a>';
		array_push( $links, $pro_link );
		return $links;
	}
}