<?php

function lp_activate() {
	$defaultSettings = array( 
		'reg_code' 		=> '',
		'access_token' 	=> '',
		'last_access' 	=> time(),
		'this_version'	=> '1.0.0',
		'new_version'	=> '1.0.0',
		'host' 			=> 'http://search.obiwebservices.com/listings/search.asmx/',
		'feed' 			=> ''
	);
	update_option('ListingPressSettings',$defaultSettings);	
	
	$defaultQuery = array(
		'lp_per_page' 	=> 10,
		'lp_base' 		=> 'listings',
		'lp_agent' 		=> '',
		'lp_office' 	=> '',
		'lp_maps' 		=> '',
		'lp_zillow' 	=> '',
		'lp_education'	=> '',
	);
	update_option('ListingPressQuery',$defaultQuery);
	
	//$defaultNotices = array();
	//update_option('ListingPressNotices',$defaultNotices);
	
	$defaultForm = array(
		'active' => array(),
		'inactive' => array('address','city','state','zip_code','property_type','sales_price','bedrooms','bathrooms','sqft','lot_size','year_built','floors','features','dom'),
		'options' => array(
			'sqft_min' => '0',
			'sqft_max' => '10000',
			'sqft_inc' => '100',
			'lot_size_min' => '0',
			'lot_size_max' => '10000',
			'lot_size_inc' => '100',
			'sales_price_min' => '0',
			'sales_price_max' => '10000000',
			'sales_price_inc' => '1000',
			'year_built_min' => '1925',
			'year_built_max' => '2009',
			'year_built_inc' => '1',
			'property_types' => array('Single Family'),
			'features' => array('Pool')
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
	//delete_option('ListingPressNotices');
	delete_option('ListingPressForms');
}
register_deactivation_hook( __FILE__, 'lp_deactivate' );

?>
