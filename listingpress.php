<?php
/***************************************************************************

Plugin Name:  ListingPress
Plugin URI:   http://www.listingpress.com/
Description:  Easily embed Real Estate Listings into your blog.
Version:      1.0.5
Author:       Jason Benesch
Author URI:   http://www.jasonbenesch.com/

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
	
	Adam Hupp
	http://hupp.org/adam/
	- For his awesome WP-FacebookConnect plugin
	
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

require_once( 'core/lp_registration.php' );
require_once( 'core/lp_settings.php' );
require_once( 'core/lp_activation.php' );

if( lp_is_registered() ) {

	$GLOBALS['lp_access_token'] = lp_access_token();
	$GLOBALS['lp_current_version'] = lp_current_version();
	$GLOBALS['lp_host'] = lp_host();
	$GLOBALS['lp_feed'] = lp_feed();
	$lpvars = get_option('ListingPressQuery');
	
	define( 'LP_ACCESS_TOKEN', lp_access_token() );
	define( 'LP_HOST', lp_host() );
	define( 'LP_FEED_ID', lp_feed() );
	define( 'LP_PER_PAGE', $lpvars['lp_per_page'] );
	define( 'LP_GMAP_API', $lpvars['lp_maps'] );
	define( 'LP_ZILLOW_API', $lpvars['lp_zillow'] );
	define( 'LP_EDU_API', $lpvars['lp_education'] );
	define( 'LP_MENU_BAR', $lpvars['lp_menu_bar'] );

	/* Core Files */
	require_once( 'core/lp_cache.php' );
	require_once( 'core/lp_query.php' );
	require_once( 'core/lp_functions.php' );
	require_once( 'core/lp_lookups.php' );
	require_once( 'core/lp_rewrites.php' );
	require_once( 'core/lp_template.php' );
	
	/* ListingPress User Authentication */
	require_once( 'users/lp_user_auth.php' );
	
	/* Zillow API */
	if( defined('LP_ZILLOW_API') && constant('LP_ZILLOW_API') != '' ) {
		require_once( 'zillow/zws_query.php' );
		require_once( 'zillow/zws_functions.php' );
		//require_once( 'zillow/zws_rewrites.php' );
		//require_once( 'zillow/zws_template.php' );
	}
	
	/* ListingPress Menu Bar */
	if( defined('LP_MENU_BAR') && constant('LP_MENU_BAR') == 'show' ) {
		require_once( 'menu/lp_menu_bar.php' );
	}
	
	/* Facebook Connect API */
	//require_once( 'connect/fbconnect.php' );
	
	/* Education API */
	//require_once( 'education/edu_query.php' );
	//require_once( 'education/edu_functions.php' );
	
	/* ListingPress Shortcode */
	//require_once( 'shortcode/lp_shortcode.php' );
	
	/* ListingPress Sitemap */
	require_once( 'sitemap/lp_sitemap.php' );
	
	/* ListingPress Featured Listing Widget */
	require_once( 'widgets/lp_featured_listings.php' );
	
	/* ListingPress Visualizations */
	//require_once( 'google/lp_visualizations.php' );
	
	/* Google Maps API */
	//if( defined('LP_GMAP_API') && constant('LP_GMAP_API') != '' ) {
		//require_once( 'google/lp_maps.php' );
		//require_once( 'google/lp_custom_hoods.php' );
	//}
	
	if( !is_admin() ) {
		wp_enqueue_script('jquery');
	} 
		
}

?>