<?php

/**
 * ListingPress Query API
 *
 * The majority of this code is heavily borrowed from Wordpress Query API
 * For more thorough documentation, please see wp-includes/query.php 
 *
 */

function lp_get_query_var($var) {
	global $lp_query;
	return $lp_query->get($var);
}

function lp_set_query_var($var, $value) {
	global $lp_query;
	return $lp_query->set($var, $value);
}

function &query_listings($query) {
	unset($GLOBALS['lp_query']);
	$GLOBALS['lp_query'] =& new LP_Query();
	return $GLOBALS['lp_query']->query($query);
}

function lp_reset_query() {
	unset($GLOBALS['lp_query']);
	$GLOBALS['lp_query'] =& $GLOBALS['lp_the_query'];
	global $lp_query;
	if( !empty($lp_query->listing) ) {
		$GLOBALS['listing'] = $lp_query->listing;
	}
}

function is_lp_address_search() {
	global $lp_query;
	return $lp_query->is_address_search;
}

function is_lp_city_search() {
	global $lp_query;
	return $lp_query->is_city_search;
}

function is_lp_feed_search() {
	global $lp_query;
	return $lp_query->is_feed_search;
}

function is_lp_geocode_search() {
	global $lp_query;
	return $lp_query->is_geocode_search;
}

function is_lp_geopoint_search() {
	global $lp_query;
	return $lp_query->is_geopoint_search;
}

function is_lp_neighborhood_search() {
	global $lp_query;
	return $lp_query->is_neighborhood_search;
}

function is_lp_polypoint_search() {
	global $lp_query;
	return $lp_query->is_polypoint_search;
}

function is_lp_poly_search() {
	global $lp_query;
	return $lp_query->is_poly_search;
}

function is_lp_zip_search() {
	global $lp_query;
	return $lp_query->is_zip_search;
}

function is_lp_single() {
	global $lp_query;
	return $lp_query->is_single_listing;
}

function is_lp_mlsid_search() {
	global $lp_query;
	return $lp_query->is_mlsid_search;
}

function is_lp_mlsids_search() {
	global $lp_query;
	return $lp_query->is_mlsids_search;
}

function is_lp_search() {
	global $lp_query;
	return $lp_query->is_lp_search;
}

function is_lp_media_rss() {
	global $lp_query;
	return $lp_query->is_media_rss;
}

function is_lp_json() {
	global $lp_query;
	return $lp_query->is_json_search;
}

function is_lp_404() {
	global $lp_query;
	return $lp_query->is_404;
}

function have_listings() {
	global $lp_query;
	return $lp_query->have_listings();
}

function in_the_lp_loop() {
	global $lp_query;
	return $lp_query->in_the_loop;
}

function rewind_listings() {
	global $lp_query;
	return $lp_query->rewind_listings();
}

function the_listing() {
	global $lp_query;
	$lp_query->the_listing();
}

function lp_total_pages() {
	global $lp_query;
	return $lp_query->max_num_pages;
}

function lp_json_results() {
	global $lp_query;
	return json_encode( $lp_query->listings );
}

function lp_current_page() {
	global $lp_query;
	return $lp_query->current_page;
}

class LP_Query {
	
	var $query;								// Query String
	var $query_vars = array();				// Query Search Variables Set By User
	var $request;							// Holds returned xml string
	var $total_listings;					// Array of total listings returned
	var $listings;							// Array of listings to display
	var $listing_count = 0;					// Amount of listings in the current query
	var $current_listing = -1;				// Index of the current item in the loop
	var $in_the_loop = false;				// Are we in the loop
	var $listing;							// Current listing object
	var $found_listings = 0;				// Amount of listings
	var $current_page;						// Current page
	var $max_num_pages = 0;					// Amount of pages
	var $search_method;						// The current search method
	var $search_url;						// The api search url
	var $is_mlsid_search = false;			// Set if we are performing a mls id search
	var $is_mlsids_search = false;			// Set if we are performing a mls ids search
	var $is_single_listing = false;			// Set if single listing is queried
	var $is_address_search = false;			// Set if we are performing an address search
	var $is_city_search = false;			// Set if we are performing a city search
	var $is_feed_search = false;			// Set if we are performing a feed search
	var $is_geocode_search = false;			// Set if we are performing a geocode search
	var $is_geopoint_search = false;		// Set if we are performing a geopoint search
	var $is_neighborhood_search = false;	// Set if we are performing a neighborhood search
	var $is_polypoint_search = false;		// Set if we are performing a polypoint search
	var $is_poly_search = false;			// Set if we are performing a poly search
	var $is_zip_search = false;				// Set if we are performing a zip search
	var $is_lp_search = false;				// Set is any search is being performed
	var $is_404 = false;					// Set if no listings are found
	var $is_media_rss = false;				// Set if we are performing a media rss search
	var $is_json_search = false;			// Set if we are performing a json search
	
	function init_query_flags() {
		$this->is_single_listing = false;
		$this->is_mlsid_search = false;
		$this->is_mlsids_search = false;
		$this->is_address_search = false;
		$this->is_city_search = false;
		$this->is_feed_search = false;
		$this->is_geocode_search = false;
		$this->is_geopoint_search = false;
		$this->is_neighborhood_search = false;
		$this->is_polypoint_search = false;
		$this->is_poly_search = false;
		$this->is_zip_search = false;
		$this->is_lp_search = false;
		$this->is_404 = false;
		$this->is_media_rss = false;
		$this->is_json_search = false;
	}
	
	function init () {
		unset($this->listings);
		unset($this->query);
		unset($this->search_method);
		unset($this->search_url);
		$this->query_vars = array();
		$this->listing_count = 0;
		$this->current_listing = -1;
		$this->in_the_loop = false;
		$this->init_query_flags();
	}
	
	function fill_query_vars($array) {
		$keys = array('listing', 'mlsid', 'mlsids', 'address', 'city', 'citystate', 'county', 'state', 'zip', 'zipstate', 'distance', 'neighborhood', 'proptype', 'minprice', 'maxprice', 'minsize', 'maxsize', 'beds', 'baths', 'minyear', 'maxyear', 'features', 'amenities', 'lifestyle', 'dom', 'agent', 'office', 'agent_id', 'office_id', 'limit', 'searchable_area_1', 'searchable_area_2', 'searchable_area_3', 'view', 'style', 'minlotsize', 'maxlotsize', 'minfloors', 'maxfloors', 'center_lat', 'center_lon', 'center_point', 'poly_points', 'poly_points_csv', 'feed_id', 'format', 'sort', 'lpage', 'showlistings', 'display');
		
		foreach( $keys as $key ) {
			if( !isset($array[$key]) )
				$array[$key] = '';
		}

		return $array;
	}
	
	function parse_query($query) {
		if( !empty($query) || !isset($this->query) ) {
			$this->init();
			if( is_array($query) )
				$this->query_vars = $query;
			else
				parse_str($query, $this->query_vars);
			$this->query = $query;
		}
		$this->query_vars = $this->fill_query_vars($this->query_vars);
		$qv = &$this->query_vars;
		
		if( $qv['display'] == 'mediarss' ) {
			$this->is_lp_search = true;
			$this->is_media_rss = true;
		} 
		else if( $qv['display'] == 'json' ) {
			$this->is_lp_search = true;
			$this->is_json_search = true;
		}

		if( !empty($qv['listing']) ) {
			$this->is_single_listing = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingDetailXML';
		}
		else if( !empty($qv['mlsid']) ) {
			$this->is_mlsid_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsFeedSearchByMlsIdsXML';
		}
		else if( !empty($qv['mlsids']) ) {
			$this->is_mlsids_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsFeedSearchByMlsIdsXML';
		}
		else if( !empty($qv['address']) && !empty($qv['city']) && !empty($qv['state']) && !empty($qv['zip']) ) {
			$this->is_address_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsAddressSearchXML';
		}
		else if( !empty($qv['city']) && !empty($qv['state']) ) {
			$this->is_city_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsCitySearchXML';
		}
		else if( !empty($qv['citystate']) ) {
			$this->is_city_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsCitySearchXML';
		}
		else if( !empty($qv['feed_id']) || !empty($qv['agent_id']) || !empty($qv['office_id']) ) {
			$this->is_feed_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsFeedSearchXML';
		}
		else if( !empty($qv['center_lat']) && !empty($qv['center_lon']) ) {
			$this->is_geocode_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsGeoCodeSearchXML';
		}
		else if( !empty($qv['center_point']) ) {
			$this->is_geopoint_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsGeoPointSearchXML';
		}
		else if( !empty($qv['neighborhood']) ) {
			$this->is_neighborhood_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsHoodIdSearchXML';
		}
		else if( !empty($qv['poly_points']) ) {
			$this->is_polypoint_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsPolyPointSearchXML';
		}
		else if( !empty($qv['poly_points_csv']) ) {
			$this->is_poly_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsPolySearchXML';
		}
		else if( !empty($qv['zip']) ) {
			$this->is_zip_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsZipSearchXML';
		}
		else if( !empty($qv['zipstate']) ) {
			$this->is_zip_search = true;
			$this->is_lp_search = true;
			$this->search_method = 'GetListingsZipSearchXML';
		}
		else if( '404' == $qv['error'] ) {
			$this->set_404();
		}
		else {
			$this->set_404();
		}
		
	}
	
	function set_404() {
		$this->init_query_flags();
		$this->is_404 = true;
	}
	
	function get($query_var) {
		if( isset($this->query_vars[$query_var]) ) {
			return $this->query_vars[$query_var];
		}
		return '';
	}
	
	function set($query_var, $value) {
		$this->query_vars[$query_var] = $value;
	}
	
	function build_and_encode( $array ) {
		foreach( $array as $k => $v ) {
			$encoded .= '&' . $k . '=' . urlencode( $v ); 
		}
		return $encoded;
	}
	
	function start_parsing_el($ph, $el, $atts) {
		if( !empty($atts) )
			$this->total_listings[] = $atts;
	}
	
	function end_parsing_el($ph, $el) {
		
	}
	
	function parse_xmlString($str) {
		$ph = xml_parser_create();
		xml_set_element_handler($ph, array(&$this,'start_parsing_el'), array(&$this,'end_parsing_el'));
		xml_parse($ph, $str);
		xml_parser_free($ph);
	}
	
	function parse_xmlFile($file) {
		$dir = lp_cache_dir();
		$cache_file =  $dir . $file;
		$ph = xml_parser_create();
		xml_set_element_handler($ph, array(&$this,'start_parsing_el'), array(&$this,'end_parsing_el') );
		$fp = fopen($cache_file, "r");
		while( $line = fread($fp, 4096) ) {
    		xml_parse($ph, $line, feof($fp));
    	}
		xml_parser_free($ph);
	}
	
	function &get_listings() {
		global $lp_host, $lp_access_token, $lp_feed;
		$q = &$this->query_vars;
		$q = $this->fill_query_vars($q);
		$url = array();
		
		if( $this->is_single_listing ) {			
			$url['PropertyID'] = $q['listing'];
		} 
		else if( $this->is_mlsid_search ) {
			$url['FeedID'] = ( !empty($q['feed_id']) ) ? $q['feed_id'] : $lp_feed;
			$url['MlsIDs'] = $q['mlsid'];
		}
		else if( $this->is_mlsids_search ) {
			$url['FeedID'] = ( !empty($q['feed_id']) ) ? $q['feed_id'] : $lp_feed;
			$url['MlsIDs'] = $q['mlsids'];
		} 
		else {
			
			if( $this->is_address_search ) {
				$url['StreetAddress'] = $q['address'];
				$url['City'] = $q['city']; 	
				$url['State'] = $q['state'];
				$url['Zip'] = $q['zip'];
				$url['SearchDistance'] = ( isset($q['distance']) && !empty($q['distance']) ) ? $q['distance'] : '5';
			}
			else if( $this->is_city_search ) {
				$url['CityState'] = ( !empty( $q['citystate'] ) ) ? $q['citystate'] : $q['city'] . ',' . $q['state'];
			}
			else if( $this->is_geocode_search ) {
				$url['CenterLat'] = $q['center_lat'];
				$url['CenterLon'] = $q['center_lon'];
				$url['SearchDistance'] = ( isset($q['distance']) && !empty($q['distance']) ) ? $q['distance'] : '0';
			}
			else if( $this->is_geopoint_search ) {
				$url['CenterPoint'] = $q['center_point']; 	
				$url['SearchDistance'] = ( isset($q['distance']) && !empty($q['distance']) ) ? $q['distance'] : '0';
			}
			else if( $this->is_neighborhood_search ) {
				$url['HoodID'] = $q['neighborhood'];
			}
			else if( $this->is_polypoint_search ) {
				$url['PolyPoints'] = $q['poly_points']; 	
				$url['SearchDistance'] = ( isset($q['distance']) && !empty($q['distance']) ) ? $q['distance'] : '0';
			}
			else if( $this->is_poly_search ) {
				$url['PolyPointsCSV'] = $q['poly_points_csv']; 
			}
			else if( $this->is_zip_search ) {
				$url['ZipState'] = ( !empty( $q['zipstate'] ) ) ? $q['zipstate'] : $q['zip'] . ',' . $q['state'];
			}

			//Standard to every search
			$url['PropertyType'] 		= ( !empty($q['proptype']) ) ? $q['proptype'] : '';
			$url['MinPrice'] 			= ( isset($q['minprice']) && !empty($q['minprice']) ) ? $q['minprice'] : '0';
			$url['MaxPrice'] 			= ( isset($q['maxprice']) && !empty($q['maxprice']) ) ? $q['maxprice'] : '0';
			$url['MinSize'] 			= ( isset($q['minsize']) && !empty($q['minsize']) ) ? $q['minsize'] : '0';
			$url['MaxSize'] 			= ( isset($q['maxsize']) && !empty($q['maxsize']) ) ? $q['maxsize'] : '0'; 
			$url['Bedrooms']			= ( isset($q['beds']) && !empty($q['beds']) ) ? $q['beds'] : '0';
			$url['Bathrooms'] 			= ( isset($q['baths']) && !empty($q['baths']) ) ? $q['baths'] : '0';
			$url['MinYearBuilt'] 		= ( isset($q['minyear']) && !empty($q['minyear']) ) ? $q['minyear'] : '0';
			$url['MaxYearBuilt'] 		= ( isset($q['maxyear']) && !empty($q['maxyear']) ) ? $q['maxyear'] : '0';
			$url['SearchableArea1'] 	= ( !empty($q['searchable_area_1']) ) ? $q['searchable_area_1'] : '';
			$url['SearchableArea2'] 	= ( !empty($q['searchable_area_2']) ) ? $q['searchable_area_2'] : '';
			$url['SearchableArea3'] 	= ( !empty($q['searchable_area_3']) ) ? $q['searchable_area_3'] : '';
			$url['View'] 				= ( !empty($q['view']) ) ? $q['view'] : '';
			$url['Style'] 				= ( !empty($q['style']) ) ? $q['style'] : '';
			$url['MinLotSize'] 			= ( isset($q['minlotsize']) && !empty($q['minlotsize']) ) ? $q['minlotsize'] : '0';
			$url['MaxLotSize'] 			= ( isset($q['maxlotsize']) && !empty($q['maxlotsize']) ) ? $q['maxlotsize'] : '0';
			$url['MinFloors'] 			= ( isset($q['minfloors']) && !empty($q['minfloors']) ) ? $q['minfloors'] : '0';
			$url['MaxFloors'] 			= ( isset($q['maxfloors']) && !empty($q['maxfloors']) ) ? $q['maxfloors'] : '0';
			$url['FeatureProfile'] 		= ( !empty($q['features']) ) ? $q['features'] : '';
			$url['AmenitiesProfile'] 	= ( !empty($q['amenities']) ) ? $q['amenities'] : '';
			$url['LifestyleProfile'] 	= ( !empty($q['lifestyle']) ) ? $q['lifestyle'] : '';
			$url['DOM'] 				= ( !empty($q['dom']) ) ? $q['dom'] : '';
			$url['FeedID'] 				= ( !empty($q['feed_id']) ) ? $q['feed_id'] : $lp_feed;
			$url['AgentID'] 			= ( !empty($q['agent_id']) ) ? $q['agent_id'] : '';
			$url['OfficeID']		 	= ( !empty($q['office_id']) ) ? $q['office_id'] : '';
			$url['AgentName'] 			= ( !empty($q['agent_name']) ) ? $q['agent_name'] : '';
			$url['OfficeName'] 			= ( !empty($q['office_name']) ) ? $q['office_name'] : '';
			$url['SpecialFormat'] 		= ( !empty($q['format']) ) ? $q['format'] : '';
			$url['RecordLimit'] 		= ( isset($q['limit']) && !empty($q['limit']) ) ? $q['limit'] : '1500';
			$url['Sort'] 				= ( !empty($q['sort']) ) ? $q['sort'] : 'SALE_PRICE DESC';
			
		}
		
		$api_query_string = $this->build_and_encode( $url );
		$this->search_url = $lp_host . $this->search_method . '?AccessToken=' . urlencode( $lp_access_token ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . $api_query_string;
		
		$fileName = md5( $this->search_url ) . '.xml';
		if( !lp_cache($fileName) ) {
			$http = new WP_Http();
			$xml = $http->request($this->search_url);
			$xmlString = $xml['body'];
			$this->parse_xmlString($xmlString);
			lp_cache_write($fileName, $xmlString);
		} else {
			$this->parse_xmlFile($fileName);
		}
	
		$this->current_page = absint( $q['lpage'] );
		if( empty($this->current_page) ) {
			$this->current_page = 1;
		}
		
		if( isset($q['showlistings']) && !empty($q['showlistings']) ) {
			$per_page = absint( $q['showlistings'] );
		} else {
			$q = get_option('ListingPressQuery');
			$per_page = ( !empty( $q['lp_per_page'] ) ) ? $q['lp_per_page'] : 10;
		}
 
		$start = ($this->current_page - 1) * $per_page;
		$finish = $start + $per_page;
		$this->found_listings = count( $this->total_listings );
		$finish = ($finish > $this->found_listings) ? $this->found_listings : $finish;
		for( $i = $start; $i < $finish; $i++ ) {
			$this->listings[] = $this->total_listings[$i];
		}
		
		$this->listing_count = count( $this->listings );
		$this->max_num_pages = ceil($this->found_listings / $per_page);
		
		if ($this->listing_count > 0) {
			$this->listing = $this->listings[0];
		}
		
		return $this->listings;
	}
	
	function next_listing() {
		$this->current_listing++;
		$this->listing = $this->listings[$this->current_listing];
		return $this->listing;
	}
	
	function the_listing() {
		global $listing;
		$this->in_the_loop = true;
		$listing = $this->next_listing();
	}
	
	function have_listings() {
		if( $this->current_listing + 1 < $this->listing_count ) {
			return true;
		} else if( $this->current_listing + 1 == $this->listing_count && $this->listing_count > 0 ) {
			$this->rewind_listings();
		}
		$this->in_the_loop = false;
		return false;
	}
	
	function rewind_listings() {
		$this->current_listing = -1;
		if( $this->lsiting_count > 0 ) {
			$this->listing = $this->listings[0];
		}
	}
	
	function &query($query) {
		$this->parse_query($query);
		if( !$this->is_404 )
			return $this->get_listings();
	}
	
	function LP_Query($query = '') {
		if( !empty($query) ) {
			$this->query($query);
		}
	}	
}

$lp_the_query =& new LP_Query();
$lp_query     =& $lp_the_query;


?>