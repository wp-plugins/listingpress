<?php

function lp_query_vars( $query_vars ) {
	$myvars = array( 'listing', 'mlsid', 'mlsids', 'address', 'city', 'citystate', 'county', 'state', 'zip', 'zipstate', 'proptype', 'minprice', 'maxprice', 'minsize', 'maxsize', 'beds', 'baths', 'minyear', 'maxyear', 'agent', 'office', 'minlotsize', 'maxlotsize', 'minfloors', 'maxfloors', 'sort', 'limit', 'distance', 'center_lat', 'center_lon', 'center_point', 'neighborhood', 'poly_points', 'poly_points_csv', 'searchable_area_1', 'searchable_area_2', 'searchable_area_3', 'view', 'style', 'features', 'amenities', 'lifestyle', 'dom', 'feed_id', 'agent_id', 'office_id', 'format', 'display', 'showlistings', 'lpage' );
	$query_vars = array_merge( $query_vars, $myvars );
	return $query_vars;
}
add_filter( 'query_vars', 'lp_query_vars' );

function lp_flush_rewrite_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
add_action( 'init', 'lp_flush_rewrite_rules' );
	
function lp_add_rewrite_rules( $wp_rewrite ) {	
	$wp_rewrite->add_rewrite_tag( "%listing%", "([0-9]{0,7})", "listing=" );
	$wp_rewrite->add_rewrite_tag( "%mlsid%", "([0-9]{9})", "mlsid=" );
	$wp_rewrite->add_rewrite_tag( "%mlsids%", "([0-9]{9}.+)", "mlsids=" );
	$wp_rewrite->add_rewrite_tag( "%address%", "(.+?)", "address=" );
	$wp_rewrite->add_rewrite_tag( "%city%", "(.+?)", "city=" );
	$wp_rewrite->add_rewrite_tag( "%state%", "([A-Za-z]{2})", "state=" );
	$wp_rewrite->add_rewrite_tag( "%zip%", "([0-9]{5})", "zip=" );
	$wp_rewrite->add_rewrite_tag( "%agent%", "(.+?)", "agent=" );
	$wp_rewrite->add_rewrite_tag( "%office%", "(.+?)", "office=" );

	$urls = array(
		'%state%/%city%/%address%/listing/%listing%',
		'%city%/%state%/Real-Estate',
		'%city%/%state%/real-estate',
		'mylistings/%agent%',
		'office/%office%',
		'listing/%mlsid%',
		'listings/%mlsid%',
		'listings/%mlsids%'
	);
	foreach( $urls as $url ) {
		$rule = $wp_rewrite->generate_rewrite_rules($url, EP_NONE, false, false, false, false, false);
		$wp_rewrite->rules = array_merge( $rule, $wp_rewrite->rules );
	}
	return $wp_rewrite;
}
add_action( 'generate_rewrite_rules', 'lp_add_rewrite_rules' );
	

		
?>