<?php

function lp_query_vars( $query_vars ) {
	$myvars = array( 'listing', 'mlsid', 'mlsids', 'address', 'city', 'citystate', 'county', 'state', 'zip', 'zipstate', 'proptype', 'minprice', 'maxprice', 'minsize', 'maxsize', 'beds', 'baths', 'minyear', 'maxyear', 'agent', 'office', 'minlotsize', 'maxlotsize', 'minfloors', 'maxfloors', 'sort', 'limit', 'distance', 'center_lat', 'center_lon', 'center_point', 'neighborhood', 'poly_points', 'poly_points_csv', 'searchable_area_1', 'searchable_area_2', 'searchable_area_3', 'view', 'style', 'features', 'amenities', 'lifestyle', 'dom', 'feed_id', 'agent_id', 'office_id', 'format', 'display', 'showlistings' );
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
	$wp_rewrite->add_rewrite_tag( "%listing%", "([0-9]{7})", "listing=" );
	$wp_rewrite->add_rewrite_tag( "%mlsid%", "([0-9]{9})", "mlsid=" );
	$wp_rewrite->add_rewrite_tag( "%mlsids%", "([0-9]{9}.+)", "mlsids=" );
	$wp_rewrite->add_rewrite_tag( "%address%", "(.+?)", "address=" );
	$wp_rewrite->add_rewrite_tag( "%city%", "(.+?)", "city=" );
	$wp_rewrite->add_rewrite_tag( "%state%", "([A-Za-z]{2})", "state=" );
	$wp_rewrite->add_rewrite_tag( "%zip%", "([0-9]{5})", "zip=" );
	$wp_rewrite->add_rewrite_tag( "%proptype%", "(.+?)", "proptype=" );
	$wp_rewrite->add_rewrite_tag( "%minprice%", "([0-9]{0,7})", "minprice=" );
	$wp_rewrite->add_rewrite_tag( "%maxprice%", "([0-9]{0,7})", "maxprice=" );
	$wp_rewrite->add_rewrite_tag( "%minsize%", "([0-9]{0,5})", "minsize=" );
	$wp_rewrite->add_rewrite_tag( "%maxsize%", "([0-9]{0,5})", "maxsize=" );
	$wp_rewrite->add_rewrite_tag( "%beds%", "([0-9]{0,2})", "beds=" );
	$wp_rewrite->add_rewrite_tag( "%baths%", "([0-9]{0,2})", "baths=" );
	$wp_rewrite->add_rewrite_tag( "%minyear%", "([0-9]{4})", "minyear=" );
	$wp_rewrite->add_rewrite_tag( "%maxyear%", "([0-9]{4})", "maxyear=" );
	$wp_rewrite->add_rewrite_tag( "%agent%", "(.+?)", "agent=" );
	$wp_rewrite->add_rewrite_tag( "%office%", "(.+?)", "office=" );
	$wp_rewrite->add_rewrite_tag( "%minlotsize%", "([0-9]{0,5})", "minlotsize=" );
	$wp_rewrite->add_rewrite_tag( "%maxlotsize%", "([0-9]{0,5})", "maxlotsize=" );
	$wp_rewrite->add_rewrite_tag( "%minfloors%", "([0-9]{0,2})", "minfloors=" );
	$wp_rewrite->add_rewrite_tag( "%maxfloors%", "([0-9]{0,2})", "maxfloors=" );
	$wp_rewrite->add_rewrite_tag( "%sort%", "(.+?)", "sort=" );
	$wp_rewrite->add_rewrite_tag( "%limit%", "([0-9]{0,4})", "limit=" );

	$urls = array(
		'listing/%listing%',
		'mylistings/%agent%',
		'office/%office%',
		'listing/%mlsid%',
		'listings/%mlsid%',
		'listings/%mlsids%',
		'listings/%zip%',
		'listings/%zip%/proptype/%proptype%',
		'listings/%zip%/price/%minprice%/%maxprice%',
		'listings/%zip%/price/%minprice%/%maxprice%/sort/%sort%',
		'listings/%zip%/size/%minsize%/%maxsize%',
		'listings/%zip%/lotsize/%minlotsize%/%maxlotsize%',
		'listings/%zip%/yearbuilt/%minyear%/%maxyear%',
		'listings/%zip%/beds/%beds%/baths/%baths%',
		'listings/%city%/%state%',
		'listings/%city%/%state%/proptype/%proptype%',
		'listings/%city%/%state%/price/%minprice%/%maxprice%',
		'listings/%city%/%state%/price/%minprice%/%maxprice%/sort/%sort%',
		'listings/%city%/%state%/size/%minsize%/%maxsize%',
		'listings/%city%/%state%/lotsize/%minlotsize%/%maxlotsize%',
		'listings/%city%/%state%/yearbuilt/%minyear%/%maxyear%',
		'listings/%city%/%state%/beds/%beds%/baths/%baths%',
		'listings/%address%/%city%/%state%/%zip%',
		'listings/%address%/%city%/%state%/%zip%/proptype/%proptype%',
		'listings/%address%/%city%/%state%/%zip%/price/%minprice%/%maxprice%',
		'listings/%address%/%city%/%state%/%zip%/price/%minprice%/%maxprice%/%sort%',
		'listings/%address%/%city%/%state%/%zip%/size/%minsize%/%maxsize%',
		'listings/%address%/%city%/%state%/%zip%/lotsize/%minlotsize%/%maxlotsize%',
		'listings/%address%/%city%/%state%/%zip%/yearbuilt/%minyear%/%maxyear%',
		'listings/%address%/%city%/%state%/%zip%/beds/%beds%/baths/%baths%'
	);
	foreach( $urls as $url ) {
		$rule = $wp_rewrite->generate_rewrite_rules($url, EP_NONE, true, false, false, false, false);
		$wp_rewrite->rules = array_merge( $rule, $wp_rewrite->rules );
	}
	return $wp_rewrite;
}
add_action( 'generate_rewrite_rules', 'lp_add_rewrite_rules' );
	

		
?>