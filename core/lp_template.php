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

?>