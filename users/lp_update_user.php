<?php

require_once( dirname( dirname( dirname( dirname( dirname(__FILE__) ) ) ) ) . '/wp-load.php' );

function lp_update_user_meta($array) {
	
	check_ajax_referer('listingpress_update_user-submit');
	extract($array, EXTR_PREFIX_SAME, "lp");

	$listings = get_usermeta($user_id,'lp_saved_listings');

	if( is_array($listings) ) {
		$listings[$listing_id] = $mls_id;
	} else {
		$listings = array( $listing_id => $mls_id );
	}

	update_usermeta($user_id,'lp_saved_listings',$listings);
	echo json_encode( array( 'listing_id' => $listing_id, 'mls_id' => $mls_id ) ); 

}
lp_update_user_meta($_POST);

?>