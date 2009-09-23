<?php

function get_zillow_search($add, $city, $state) {
	$args = array(
		'z_method'	=> 'search',
		'address' 	=> $add,
		'city'		=> $city,
		'state'		=> $state
	);
	$search = new LP_Zillow($args);
	return $search->results;
}

function get_zillow_deep_search($add, $city, $state) {
	$args = array(
		'z_method'	=> 'deepsearch',
		'address' 	=> $add,
		'city'		=> $city,
		'state'		=> $state
	);
	$search = new LP_Zillow($args);
	return $search->results;
}

function get_zestimate($zpid) {
	$args = array(
		'z_method'	=> 'zestimate',
		'zpid'		=> $zpid
	);
	$zest = new LP_Zillow($args);
	return $zest->results;
}

function get_zillow_chart($zpid, $unit, $width, $height, $duration) {
	$args = array(
		'z_method'			=> 'chart',
		'zpid'				=> $zpid,
		'z_chart_unit_type'	=> $unit,
		'z_chart_width'		=> $width,
		'z_chart_height'	=> $height,
		'z_chart_duration'	=> $duration
	);
	$chart = new LP_Zillow($args);
	return $chart->results;
}

function get_zillow_comps($zpid, $count) {
	$args = array(
		'z_method'		=> 'comps',
		'zpid'			=> $zpid,
		'z_comp_count'	=> $count
	);
	$comps = new LP_Zillow($args);
	return $comps->results;
}

function get_zillow_deep_comps($zpid, $count) {
	$args = array(
		'z_method'		=> 'deepcomps',
		'zpid'			=> $zpid,
		'z_comp_count'	=> $count
	);
	$comps = new LP_Zillow($args);
	return $comps->results;
}

function get_zillow_children($countystate) {
	$a = explode( ',', $countystate );
	$args['z_method'] = 'children';
	$args['county'] = $a[0];
	$args['state'] = $a[1];
	$args['z_childtype'] = 'city';
	$children = new LP_Zillow($args);
	return $children->results;
}

function get_zillow_demographics($a) {
	$args['z_method'] = 'demographics';
	if( isset($a['neighborhood']) && !empty($a['neighborhood']) ) {
		$args['neighborhood'] = $a['neighborhood'];
		$args['city'] = $a['city'];
	} else if( isset($a['z_region_id']) && !empty($a['z_region_id']) ) {
		$args['z_region_id'] = $a['z_region_id'];
	} else if( isset($a['city']) && !empty($a['city']) ) {
		$args['city'] = $a['city'];
		$args['state'] = $a['state'];
	} 
	$demographics = new LP_Zillow($args);
	return $demographics->results;
}

class LP_Zillow {
	
	var $query;								// Query String
	var $query_vars = array();				// Query Search Variables Set By User
	var $request;							// Holds returned xml string
	var $search_method;						// The current search method
	var $search_url;						// The api search url
	var $host;								// API endpoint
	var $zws_id;							// Zillow API key
	var $is_zillow_search = false;			// Set if we are performing a normal zillow search request
	var $is_zestimate = false;				// Set if we are performing a zestimate request
	var $is_chart = false;					// Set if we are performing a chart request
	var $is_comps = false;					// Set if we are performing a comps request
	var $is_demographics = false;			// Set if we are performing a demographics request
	var $is_region_children = false;		// Set if we are performing a region_children request
	var $is_region_chart = false; 			// Set if we are performing a region_chart request
	var $is_deep_search = false;			// Set if we are performing a deep_search request
	var $is_deep_comps = false;				// Set if we are performing a deep_comp request
	var $is_404 = false;					// Set if we get an error returned
	var $results;
	
	function init_query_flags() {
		$this->is_zillow_search = false;		
		$this->is_zestimate = false;			
		$this->is_chart = false;			
		$this->is_comps = false;				
		$this->is_demographics = false;	
		$this->is_region_children = false;
		$this->is_region_chart = false; 		
		$this->is_deep_search = false;	
		$this->is_deep_comps = false;
		$this->is_404 = false;
	}
	
	function init () {
		global $lpvars;
		unset($this->query);
		unset($this->search_method);
		unset($this->search_url);
		$this->return = array();
		$this->query_vars = array();
		$this->host = 'http://www.zillow.com/webservice/';
		$this->zws_id = $lpvars['lp_zillow'];
		$this->init_query_flags();
	}
	
	function fill_query_vars($array) {
		$keys = array('zpid', 'address', 'city', 'county', 'state', 'zip', 'neighborhood', 'z_method', 'z_chart_unit_type', 'z_chart_width', 'z_chart_height', 'z_chart_duration', 'z_comp_count', 'z_region_id', 'z_childtype', 'z_price', 'z_down', 'z_dollarsdown', 'display');
		foreach( $keys as $key ) {
			if( !isset($array[$key]) )
				$array[$key] = '';
		}
		return $array;
	}
	
	function parse_query($query) {
		if( !empty($query) || !isset($this->query) ) {
			$this->init();
			if( is_array($query) ) {
				$this->query_vars = $query;
			} else {
				parse_str($query, $this->query_vars);
			}
			$this->query = $query;
		}
		$this->query_vars = $this->fill_query_vars($this->query_vars);
		$qv = &$this->query_vars;
		
		if( !empty($qv['z_method']) ) {
			switch($qv['z_method']) {
				case 'search':
					$this->search_method = 'GetSearchResults';
					$this->is_zillow_search = true;
				break;
				case 'deepsearch':
					$this->search_method = 'GetDeepSearchResults';
					$this->is_deep_search = true;
				break;
				case 'zestimate':
					$this->search_method = 'GetZestimate';
					$this->is_zestimate = true;
				break;
				case 'chart':
					$this->search_method = 'GetChart';
					$this->is_chart = true;
				break;
				case 'comps':
					$this->search_method = 'GetComps';
					$this->is_comps = true;
				break;
				case 'deepcomps':
					$this->search_method = 'GetDeepComps';
					$this->is_deep_comps = true;
				break;
				case 'demographics':
					$this->search_method = 'GetDemographics';
					$this->is_demographics = true;
				break;
				case 'children':
					$this->search_method = 'GetRegionChildren';
					$this->is_region_children = true;
				break;
				case 'regionchart':
					$this->search_method = 'GetRegionChart';
					$this->is_region_chart = true;
				break;
				default:
					$this->is_404 = true;
				break;
			}
		} 	
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
		
	function &get_results() {

		$q = &$this->query_vars;
		$q = $this->fill_query_vars($q);
		$url = array();
		
		if( $this->is_zillow_search ) {			
			$url['address'] 			= $q['address'];
			$url['citystatezip'] 		= ( !empty( $q['zip'] ) ) ? $q['zip'] : $q['city'] . ',' . $q['state'];
		} 
		else if( $this->is_deep_search ) {
			$url['address'] 			= $q['address'];
			$url['citystatezip'] 		= ( !empty( $q['zip'] ) ) ? $q['zip'] : $q['city'] . ',' . $q['state'];
		}
		else if( $this->is_zestimate ) {
			$url['zpid'] 				= $q['zpid'];
		} 
		else if( $this->is_chart ) {
			$url['zpid'] 				= $q['zpid'];
			$url['unit-type'] 			= $q['z_chart_unit_type'];
			$url['width'] 				= $q['z_chart_width'];
			$url['height'] 				= $q['z_chart_height'];
			$url['chartDuration'] 		= $q['z_chart_duration'];
		}
		else if( $this->is_comps ) {
			$url['zpid'] 				= $q['zpid'];
			$url['count'] 				= $q['z_comp_count'];
		}
		else if( $this->is_deep_comps ) {
			$url['zpid'] 				= $q['zpid'];
			$url['count'] 				= $q['z_comp_count'];
		}
		else if( $this->is_demographics ) {
			$url['regionid'] 			= $q['z_region_id'];
			$url['state'] 				= $q['state'];
			$url['city'] 				= $q['city'];
			$url['neighborhood']	 	= $q['neighborhood'];
		}
		else if( $this->is_region_children ) {
			$url['rid'] 				= $q['z_region_id'];
			$url['country'] 			= 'USA';
			$url['state'] 				= $q['state'];
			$url['county'] 				= $q['county'];
			$url['city'] 				= $q['city'];
			$url['childtype'] 			= $q['z_childtype'];
		}
		else if( $this->is_region_chart ) {
			$url['city'] 				= $q['city'];
			$url['state']		 		= $q['state'];
			$url['neighborhood'] 		= $q['neighborhood'];
			$url['zip'] 				= $q['zip'];
			$url['unit-type'] 			= $q['z_chart_unit_type'];
			$url['width'] 				= $q['z_chart_width'];
			$url['height'] 				= $q['z_chart_height'];
			$url['chartDuration'] 		= $q['z_chart_duration'];
		}
		else {
			// 404 - houston, we have a problem.
		}

		$api_query_string = $this->build_and_encode( $url );
		$this->search_url = $this->host . $this->search_method . '.htm?zws-id=' . urlencode( $this->zws_id ) . $api_query_string;
		$http = new WP_Http();
		$xml = $http->request($this->search_url);
		$xmlString = $xml['body'];
		$this->results = new SimpleXMLElement($xmlString);
		return true;

	}
	
	function &query($query) {
		$this->parse_query($query);
		return $this->get_results();
	}
	
	function LP_Zillow($query = '') {
		if( !empty($query) ) {
			$this->query($query);
		}
	}
}

?>