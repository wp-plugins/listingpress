<?php
/***************************************************************************

Plugin Name:  ListingPress
Plugin URI:   http://www.listingpress.com/
Description:  Easily embed Real Estate Listings into your blog.
Version:      1.0.21
Author:       Jason Benesch
Author URI:   http://www.listingpress.com/about

Copyright (C) 2008-2009 Jason Benesch
	
****************************************************************************

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*****************************************************************************

	Many Thanks To:
	
	Mark James
	http://www.famfamfam.com/lab/icons/silk/
	- For allowing me to use his Silk icon set 1.3
	
	Jonas Einarsson
	http://jonas.einarsson.net/ajaxlogin
	- For parts of his AJAX Login plugin
	
	Mahmoud Al-Qudsi
	http://neosmart.net/dl.php?id=14
	- For parts of the caching
	
	Donncha O Caoimh
	http://ocaoimh.ie/
	- Way too much to mention. 
	

******************************************************************************/

require_once( 'lp_registration.php' );
require_once( 'lp_admin.php' );

if( lp_is_registered() ) {

	$GLOBALS['lp_access_token'] = lp_access_token();
	$GLOBALS['lp_current_version'] = lp_current_version();
	$GLOBALS['lp_host'] = lp_host();
	$GLOBALS['lp_feed'] = lp_feed();
	$lpvars = get_option('ListingPressQuery');
	
	if( !is_admin() ) {
		wp_enqueue_style( 'jquery-custom', plugins_url('listingpress/resources/css/custom-theme/jquery-ui-1.7.2.custom.css'), '', '1.7.2', 'screen' );
		wp_enqueue_style( 'listingpress', plugins_url('listingpress/resources/css/listingpress.css'), '', '1.0', 'screen' );
		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery-1.3.2', plugins_url('listingpress/resources/js/jquery-1.3.2.min.js'), '', '1.3.2' );
		wp_enqueue_script( 'jquery-ui-1.7.2', plugins_url('listingpress/resources/js/jquery-ui-1.7.2.custom.min.js'), '', '1.7.2' );
		wp_enqueue_script( 'swfobject', 'http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js', '', '2.2' );
	}
	
	require_once( 'lp_cache.php' );
	require_once( 'lp_query.php' );
	require_once( 'lp_functions.php' );
	require_once( 'lp_lookups.php' );
	require_once( 'lp_rewrites.php' );
	require_once( 'lp_template.php' );
	//require_once( 'lp_login.php' );
		
}

function lp_activate() {
	$defaultSettings = array( 
		'reg_code' 		=> '',
		'access_token' 	=> '',
		'last_access' 	=> time(),
		'this_version'	=> '1.0.0',
		'new_version'	=> '1.0.0',
		'host' 			=> 'http://search.obwebservices.com/search.asmx/',
		'feed' 			=> ''
	);
	update_option('ListingPressSettings',$defaultSettings);	
	
	$defaultQuery = array(
		'lp_per_page' 	=> 10,
		'lp_base' 		=> 'listings',
		'lp_agent' 		=> '',
		'lp_office' 	=> '',
		'lp_maps' 		=> '',
		'lp_zillow' 	=> ''
	);
	update_option('ListingPressQuery',$defaultQuery);
	
	$defaultNotices = array();
	update_option('ListingPressNotices',$defaultNotices);
	
	$defaultForm = array(
		0 => array(
			0 => array(
				'name' => 'form',
				'id' => 'my-first-form',
				'label' => 'My First Form'
			),
			1 => array(
				'id' => 'do_ajax',
				'name' => 'do_ajax',
				'do' => false,
				'div' => ''
			),
			2 => array(
				'name' => 'search-by',
				'id' => 'search-by',
				'show' 	=> true,
				'label' => 'Search By:'
			),
			3 => array(
				'name' => 'mlsids',
				'id' => 'mlsids',
				'show' 	=> true,
				'label' => 'MLS IDs:'
			),
			4 => array(
				'name' => 'address',
				'id' => 'address',
				'show' => true,
				'label' => 'Street Address:'
			),
			5 => array(
				'name' => 'city',
				'id' => 'city',
				'show' => true,
				'label' => 'City:'
			),
			6 => array(
				'name' => 'state',
				'id' => 'state',
				'show' => true,
				'label' => 'State:'
			),
			7 => array(
				'name' => 'zip',
				'id' => 'zip',
				'show' => true,
				'label' => 'Zip Code:'
			),
			8 => array(
				'name' => 'distance',
				'id' => 'distance',
				'show' => true,
				'label' => 'Search Distance:'
			),
			9 => array(
				'name' => 'proptype',
				'id' => 'proptype',
				'show' => true,
				'label' => 'Property Type:'
			),
			10 => array(
				'name' => 'minprice',
				'id' => 'minprice',
				'show' => true,
				'label' => 'Minimum Price:'
			),
			11 => array(
				'name' => 'maxprice',
				'id' => 'maxprice',
				'show' => true,
				'label' => 'Maximum Price:'	
			),
			12 => array(
				'name' => 'beds',
				'id' => 'beds',
				'show' => true,
				'label' => 'Bedrooms:'	
			),
			13 => array(
				'name' => 'baths',
				'id' => 'baths',
				'show' => true,
				'label' => 'Bathrooms:'	
			),
			14 => array(
				'name' => 'minyear',
				'id' => 'minyear',
				'show' => true,
				'label' => 'Minimum Year Built:'	
			),
			15 => array(
				'name' => 'maxyear',
				'id' => 'maxyear',
				'show' => true,
				'label' => 'Maximum Year Built:'	
			),
			16 => array(
				'name' => 'minsize',
				'id' => 'minsize',
				'show' => true,
				'label' => 'Minimum Size:'	
			),
			17 => array(
				'name' => 'maxsize',
				'id' => 'maxsize',
				'show' => true,
				'label' => 'Maximum Size:'	
			),
			18 => array(
				'name' => 'minlotsize',
				'id' => 'minlotsize',
				'show' => true,
				'label' => 'Minimum Lot Size:'	
			),
			19 => array(
				'name' => 'maxlotsize',
				'id' => 'maxlotsize',
				'show' => true,
				'label' => 'Maximum Lot Size:'	
			),
			20 => array(
				'name' => 'minfloors',
				'id' => 'minfloors',
				'show' => true,
				'label' => 'Minimum Floors:'	
			),
			21 => array(
				'name' => 'maxfloors',
				'id' => 'maxfloors',
				'show' => true,
				'label' => 'Maximum Floors:'	
			),
			22 => array(
				'name' => 'dom',
				'id' => 'dom',
				'show' => true,
				'label' => 'Days On Market:'	
			)
		)
	);
	update_option('ListingPressForms',$defaultForm);
	
	// Add a couple more roles
	add_role( 'lead', 'Leads', array('read' => '1', 'level_0' => '1') );
	add_role( 'client', 'Clients', array('read' => '1', 'level_0' => '1') );
	update_option('default_role', 'lead');
}
register_activation_hook( __FILE__, 'lp_activate' );

function lp_deactivate() {
	if( lp_is_registered() ) {
		lp_flush_cache();
	}
	delete_option('ListingPressSettings');
	delete_option('ListingPressQuery');
	delete_option('ListingPressNotices');
}
register_deactivation_hook( __FILE__, 'lp_deactivate' );



?>
