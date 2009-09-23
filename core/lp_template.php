<?php

function lp_template() {
	global $wp;
	query_listings($wp->query_string);
	
	if( is_lp_json() ) {
		echo lp_json_results(); 
		exit;
	}
	/*	
	else if( is_lp_media_rss() && file_exists( dirname(__FILE__) . "/includes/mediarss.php" ) ) {
		include( dirname(__FILE__) . "/includes/mediarss.php" );
		exit;
	}
	*/	
	else if( is_lp_single() && file_exists(TEMPLATEPATH . "/listing.php") ) {
		include(TEMPLATEPATH . "/listing.php");
		exit;
	}
	else if( is_lp_search() && file_exists(TEMPLATEPATH . "/listings.php") ) {
		include(TEMPLATEPATH . "/listings.php");
		exit;
	}
}
add_action( 'template_redirect', 'lp_template' );


function listingpress_search_form_inc() {
	if( file_exists( WP_PLUGIN_DIR . '/listingpress/resources/html/artemis_search_form.php' ) )
		include( WP_PLUGIN_DIR . '/listingpress/resources/html/artemis_search_form.php' );
}
add_action('listingpress_search_form','listingpress_search_form_inc');

function listingpress_search_inc() {
	if( file_exists( WP_PLUGIN_DIR . '/listingpress/resources/html/artemis_search.php' ) )
		include( WP_PLUGIN_DIR . '/listingpress/resources/html/artemis_search.php' );
}
add_action('listingpress_search','listingpress_search_inc');

function listingpress_single_inc() {
	if( file_exists( WP_PLUGIN_DIR . '/listingpress/resources/html/artemis_single.php' ) )
		include( WP_PLUGIN_DIR . '/listingpress/resources/html/artemis_single.php' );
}
add_action('listingpress_single','listingpress_single_inc');


?>