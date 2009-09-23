<?php

/**
 * ListingPress Lookup API
 *
 */

function lp_lookup_agents_by_feed() {
	global $lp_lookups;
	return $lp_lookups->agents_by_feed();
}

function lp_lookup_feeds() {
	global $lp_lookups;
	return $lp_lookups->feeds();
}

function lp_lookup_cities() {
	global $lp_lookups;
	return $lp_lookups->cities();
}

function lp_lookup_zips() {
	global $lp_lookups;
	return $lp_lookups->zips();
}

function lp_lookup_cities_by_county($county, $state) {
	global $lp_lookups;
	return $lp_lookups->cities_by_county($county, $state);
}

function lp_lookup_cities_by_state($state) {
	global $lp_lookups;
	return $lp_lookups->cities_by_state($state);
}

function lp_lookup_counties_by_state($state) {
	global $lp_lookups;
	return $lp_lookups->counties_by_state($state);
}

function lp_lookup_zips_by_state($state) {
	global $lp_lookups;
	return $lp_lookups->zips_by_state($state);
}

function lp_lookup_neighborhoods() {
	global $lp_lookups;
	return $lp_lookups->neighborhoods();
}

function lp_lookup_neighborhood_by_market($market) {
	global $lp_lookups;
	return $lp_lookups->neighborhoods_by_market($market);
}

function lp_lookup_neighborhoods_by_state($state) {
	global $lp_lookups;
	return $lp_lookups->neighborhoods_by_state($state);
}

function lp_lookup_property_types() {
	global $lp_lookups;
	return $lp_lookups->property_types();
}

function lp_lookup_searchable_areas($areaID) {
	global $lp_lookups;
	return $lp_lookups->searchable_areas($areaID);
}

function lp_lookup_searchable_areas_descriptions() {
	global $lp_lookups;
	return $lp_lookups->searchable_areas_descriptions();
}

function lp_lookup_searchable_styles() {
	global $lp_lookups;
	return $lp_lookups->searchable_styles();
}

function lp_lookup_searchable_views() {
	global $lp_lookups;
	return $lp_lookups->searchable_views();
}

function lp_lookup_searchable_features() {
	global $lp_lookups;
	return $lp_lookups->searchable_features();
}

function lp_lookup_rules() {
	global $lp_lookups;
	return $lp_lookups->rules();
}

class LP_Lookups {
	
	var $host;
	var $access;
	var $feed;
	var $results;
	
	function agents_by_feed() {
		$url = $this->host . 'LookupAgentsByFeed?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&FeedID=' . urlencode( $this->feed );
		$this->process($url);
		return $this->results;
	}
	
	function feeds() {
		$url = $this->host . 'LookupAllFeedsXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] );
		$this->process($url);
		return $this->results;
	}
	
	function cities() {
		$url = $this->host . 'LookupCurrentCitiesByFeed?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&FeedID=' . urlencode( $this->feed );
		$this->process($url);
		echo $url;
		return $this->results;
	}
	
	function zips() {
		$url = $this->host . 'LookupCurrentZipsByFeed?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&FeedID=' . urlencode( $this->feed );
		$this->process($url);
		return $this->results;
	}
	
	function cities_by_county($county, $state) {
		$url = $this->host . 'LookupCityByCountyXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&State=' . urlencode( $state ) . '&County=' . urlencode( $county );
		$this->process($url);
		return $this->results;
	}
	
	function cities_by_state($state) {
		$url = $this->host . 'LookupCityByStateXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&State=' . urlencode( $state );
		$this->process($url);
		return $this->results;
	}
	
	function counties_by_state($state) {
		$url = $this->host . 'LookupCountyByStateXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&State=' . urlencode( $state );
		$this->process($url);
		return $this->results;
	}
	
	function zips_by_state($state) {
		$url = $this->host . 'LookupZipsByStateXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&State=' . urlencode( $state );
		$this->process($url);
		return $this->results;
	}
	
	function neighborhoods() {
		$url = $this->host . 'LookupHoodAllXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] );
		$this->process($url);
		return $this->results;
	}
	
	function neighborhoods_by_market($market) {
		$url = $this->host . 'LookupHoodMarketXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&Market=' . urlencode( $market );
		$this->process($url);
		return $this->results;
	}
	
	function neighborhoods_by_state($state) {
		$url = $this->host . 'LookupHoodStateXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&State=' . urlencode( $state );
		$this->process($url);
		return $this->results;
	}
	
	function property_types() {
		$url = $this->host . 'LookupPropertyTypesXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] );
		$this->process($url);
		return $this->results;
	}
	
	function searchable_areas($areaID) {
		$url = $this->host . 'LookupCurrentSearchableAreaByFeed?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&FeedID=' . urlencode( $this->feed ) . '&AreaID=' . urlencode( $areaID );
		$this->process($url);
		return $this->results;
	}
	
	function searchable_areas_descriptions() {
		$url = $this->host . 'LookupCurrentSearchableAreasDescriptionsByFeed?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&FeedID=' . urlencode( $this->feed );
		$this->process($url);
		return $this->results;
	}
	
	function searchable_styles() {
		$url = $this->host . 'LookupCurrentSearchableStylesByFeed?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&FeedID=' . urlencode( $this->feed );
		$this->process($url);
		return $this->results;
	}
	
	function searchable_views() {
		$url = $this->host . 'LookupCurrentSearchableViewsByFeed?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&FeedID=' . urlencode( $this->feed );
		$this->process($url);
		return $this->results;
	}
	
	function searchable_features() {
		$url = $this->host . 'LookupSearchableFeaturesXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] );
		$this->process($url);
		return $this->results;
	}
	
	function rules() {
		$url = $this->host . 'LookupRecordRulesXML?AccessToken=' . urlencode( $this->access ) . '&TrackingToken=' . urlencode( $_SERVER['HTTP_HOST'] );
		$this->process($url);
		return $this->results;
	}
	
	function process($url) {
		unset( $this->results );
		$fileName = md5( $url ) . '.xml';
		if( !lp_cache($fileName) ) {
			$http = new WP_Http();
			$xml = $http->request($url);
			$xmlString = $xml['body'];
			$this->parse_xmlString($xmlString);
			lp_cache_write($fileName, $xmlString);
		} else {
			$this->parse_xmlFile($fileName);
		}	
	}
	
	function start_parsing_el($ph, $el, $atts) {
		if( !empty($atts) )
			$this->results[] = $atts;
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
		
	function LP_Lookups() {
		return $this->__construct();
	}
	
	function __construct() {
		global $lp_host, $lp_access_token, $lp_feed;
		$this->host = $lp_host;
		$this->access = $lp_access_token;
		$this->feed = $lp_feed;
		register_shutdown_function( array(&$this, "__destruct") );
	}
	
	function __destruct() {
		return true;
	}
}

$lp_lookups =& new LP_Lookups();

?>