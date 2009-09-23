<?php

/*
 * Zillow GetSearchResults API
 * http://www.zillow.com/howto/api/GetSearchResults.htm
 * @params addres, city, state
 * @returns array of details
 */
function zillow_search($add, $city, $state) {
	$search = get_zillow_search($add, $city, $state);
	$update = 'last-updated';
	$return = array();
	if( $search->message->code != 0 ) {
		echo $search->message->text;
	} else {
		$return = array(
			'zpid' 			=> $search->response->results->result->zpid,
			'homedetails' 	=> '<a href="'.$search->response->results->result->links->homedetails.'" title="Zillow Home Details" target="_blank">Zillow Home Details</a>',
			'graphsanddata' => '<a href="'.$search->response->results->result->links->graphsanddata.'" title="Zillow Graphs And Data" target="_blank">Zillow Graphs And Data</a>',
			'mapthishome' 	=> '<a href="'.$search->response->results->result->links->mapthishome.'" title="Zillow Map This Home" target="_blank">Zillow Map This Home</a>',
			'myestimator' 	=> '<a href="'.$search->response->results->result->links->myestimator.'" title="Zillow Estimator" target="_blank">Zillow Estimator</a>',
			'myzestimator' 	=> '<a href="'.$search->response->results->result->links->myzestimator.'" title="Zillow Zestimator" target="_blank">Zillow Zestimator</a>',
			'comparables' 	=> '<a href="'.$search->response->results->result->links->comparables.'" title="Zillow Comparaables" target="_blank">Zillow Comparaables</a>',
			'street' 		=> $search->response->results->result->address->street,
			'zip' 			=> $search->response->results->result->address->zipcode,
			'city' 			=> $search->response->results->result->address->city,
			'state' 		=> $search->response->results->result->address->state,
			'lat' 			=> $search->response->results->result->address->latitude,
			'lng' 			=> $search->response->results->result->address->longitude,
			'zestimate' 	=> '$' . str_replace('.00', '', number_format($search->response->results->result->zestimate->amount, 2) ),
			'updated' 		=> $search->response->results->result->zestimate->$update,
			'change' 		=> '$' . str_replace('.00', '', number_format($search->response->results->result->zestimate->valueChange, 2) ),
			'low' 			=> '$' . str_replace('.00', '', number_format($search->response->results->result->zestimate->valuationRange->low, 2) ),
			'high' 			=> '$' . str_replace('.00', '', number_format($search->response->results->result->zestimate->valuationRange->high, 2) ),
			'percentile' 	=> $search->response->results->result->zestimate->percentile
		);
		return $return;
	}
}

/*
 * Zillow GetDeepSearchResults API
 * http://www.zillow.com/howto/api/GetDeepSearchResults.htm
 * @params addres, city, state
 * @returns array of details
 */
function zillow_deep_search($add, $city, $state) {
	$search = get_zillow_deep_search($add, $city, $state);
	$update = 'last-updated';
	$return = array();
	if( $search->message->code != 0 ) {
		echo $search->message->text;
	} else {
		$return = array(
			'zpid' 			=> $search->response->results->result->zpid,
			'homedetails' 	=> '<a href="'.$search->response->results->result->links->homedetails.'" title="Zillow Home Details" target="_blank">Zillow Home Details</a>',
			'graphsanddata' => '<a href="'.$search->response->results->result->links->graphsanddata.'" title="Zillow Graphs And Data" target="_blank">Zillow Graphs And Data</a>',
			'mapthishome' 	=> '<a href="'.$search->response->results->result->links->mapthishome.'" title="Zillow Map This Home" target="_blank">Zillow Map This Home</a>',
			'myestimator' 	=> '<a href="'.$search->response->results->result->links->myestimator.'" title="Zillow Estimator" target="_blank">Zillow Estimator</a>',
			'myzestimator' 	=> '<a href="'.$search->response->results->result->links->myzestimator.'" title="Zillow Zestimator" target="_blank">Zillow Zestimator</a>',
			'comparables' 	=> '<a href="'.$search->response->results->result->links->comparables.'" title="Zillow Comparables" target="_blank">Zillow Comparables</a>',
			'street' 		=> $search->response->results->result->address->street,
			'zip' 			=> $search->response->results->result->address->zipcode,
			'city' 			=> $search->response->results->result->address->city,
			'state' 		=> $search->response->results->result->address->state,
			'lat' 			=> $search->response->results->result->address->latitude,
			'lng' 			=> $search->response->results->result->address->longitude,
			'useCode'		=> $search->response->results->result->useCode,
			'yearAssessed'	=> $search->response->results->result->taxAssessmentYear,
			'taxAssessment'	=> '$' . str_replace('.00', '', number_format($search->response->results->result->taxAssessment, 2) ),
			'yearBuilt'		=> $search->response->results->result->yearBuilt,
			'lotSizesqft'	=> $search->response->results->result->lotSizeSqFt,
			'finishedsqft'	=> $search->response->results->result->finishedSqFt,
			'bathrooms'		=> $search->response->results->result->bathrooms,
			'bedrooms'		=> $search->response->results->result->bedrooms,
			'zestimate' 	=> '$' . str_replace('.00', '', number_format($search->response->results->result->zestimate->amount, 2) ),
			'updated' 		=> $search->response->results->result->zestimate->$update,
			'change' 		=> '$' . str_replace('.00', '', number_format($search->response->results->result->zestimate->valueChange, 2) ),
			'low' 			=> '$' . str_replace('.00', '', number_format($search->response->results->result->zestimate->valuationRange->low, 2) ),
			'high' 			=> '$' . str_replace('.00', '', number_format($search->response->results->result->zestimate->valuationRange->high, 2) ),
			'percentile' 	=> $search->response->results->result->zestimate->percentile
		);
		return $return;
	}
}

/*
 * Zillow GetZestimate API
 * http://www.zillow.com/howto/api/GetZestimate.htm
 * @params Zillow Property ID
 * @returns array of details
 */
function zestimate($zpid) {
	$zest = get_zestimate($zpid);
	$update = 'last-updated';
	$return = array();
	if( $zest->message->code != 0 ) {
		echo $zest->message->text;
	} else {
		$return = array(
			'zpid' 			=> $zest->response->zpid,
			'homedetails' 	=> '<a href="'.$zest->response->links->homedetails.'" title="Zillow Home Details" target="_blank">Zillow Home Details</a>',
			'graphsanddata' => '<a href="'.$zest->response->links->graphsanddata.'" title="Zillow Graphs And Data" target="_blank">Zillow Graphs And Data</a>',
			'mapthishome' 	=> '<a href="'.$zest->response->links->mapthishome.'" title="Zillow Map This Home" target="_blank">Zillow Map This Home</a>',
			'myestimator' 	=> '<a href="'.$zest->response->links->myestimator.'" title="Zillow Estimator" target="_blank">Zillow Estimator</a>',
			'myzestimator' 	=> '<a href="'.$zest->response->links->myzestimator.'" title="Zillow Zestimator" target="_blank">Zillow Zestimator</a>',
			'comparables' 	=> '<a href="'.$zest->response->links->comparables.'" title="Zillow Comparables" target="_blank">Zillow Comparables</a>',
			'street' 		=> $zest->response->address->street,
			'zip' 			=> $zest->response->address->zipcode,
			'city' 			=> $zest->response->address->city,
			'state' 		=> $zest->response->address->state,
			'lat' 			=> $zest->response->address->latitude,
			'lng' 			=> $zest->response->address->longitude,
			'zestimate' 	=> '$' . str_replace('.00', '', number_format($zest->response->zestimate->amount, 2) ),
			'updated' 		=> $zest->response->zestimate->$update,
			'change' 		=> '$' . str_replace('.00', '', number_format($zest->response->zestimate->valueChange, 2) ),
			'low' 			=> '$' . str_replace('.00', '', number_format($zest->response->zestimate->valuationRange->low, 2) ),
			'high' 			=> '$' . str_replace('.00', '', number_format($zest->response->zestimate->valuationRange->high, 2) ),
			'percentile' 	=> $zest->response->zestimate->percentile
		);
		return $return;
	}
}

/*
 * Zillow GetChart API
 * http://www.zillow.com/howto/api/GetChart.htm
 * @params Zillow property id, unit-type, width and height of chart, and chart duration
 * @returns array of details
 * width -> between 200 and 600
 * height -> between 100 and 300
 * unit -> dollar|percent -> required
 * duration -> 1year|5years|10years -> optional defaults to 1year
 */
function zillow_chart($zpid, $unit, $width, $height, $duration) {
	$chart = get_zillow_chart($zpid, $unit, $width, $height, $duration);
	$return = array();
	if( $chart->message->code != 0 ) {
		echo $chart->message->text;
	} else {
		$return = array(
			'chart'			=> $chart->response->url,
			'graphsanddata' => '<a href="'.$chart->response->graphsanddata.'" title="Zillow Graphs And Data" target="_blank">Zillow Graphs And Data</a>'
		);
		return $return;
	}
}

/*
 * Zillow GetComps API
 * http://www.zillow.com/howto/api/GetComps.htm
 * @params Zillow property id, count
 * @returns array recent comparable sales
 */
function zillow_comps($zpid, $count) {
	$comps = get_zillow_comps($zpid, $count);
	$update = 'last-updated';
	$return = array();
	if( $comps->message->code != 0 ) {
		echo $comps->message->text;
	} else {
		$return = array(
			'zpid' 			=> $comps->response->properties->principal->zpid,
			'homedetails' 	=> '<a href="'.$comps->response->properties->principal->links->homedetails.'" title="Zillow Home Details" target="_blank">Zillow Home Details</a>',
			'graphsanddata' => '<a href="'.$comps->response->properties->principal->links->graphsanddata.'" title="Zillow Graphs And Data" target="_blank">Zillow Graphs And Data</a>',
			'mapthishome' 	=> '<a href="'.$comps->response->properties->principal->links->mapthishome.'" title="Zillow Map This Home" target="_blank">Zillow Map This Home</a>',
			'myestimator' 	=> '<a href="'.$comps->response->properties->principal->links->myestimator.'" title="Zillow Estimator" target="_blank">Zillow Estimator</a>',
			'myzestimator' 	=> '<a href="'.$comps->response->properties->principal->links->myzestimator.'" title="Zillow Zestimator" target="_blank">Zillow Zestimator</a>',
			'comparables' 	=> '<a href="'.$comps->response->properties->principal->links->comparables.'" title="Zillow Comparables" target="_blank">Zillow Comparables</a>',
			'street' 		=> $comps->response->properties->principal->address->street,
			'zip' 			=> $comps->response->properties->principal->address->zipcode,
			'city' 			=> $comps->response->properties->principal->address->city,
			'state' 		=> $comps->response->properties->principal->address->state,
			'lat' 			=> $comps->response->properties->principal->address->latitude,
			'lng' 			=> $comps->response->properties->principal->address->longitude,
			'zestimate' 	=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->zestimate->amount, 2) ),
			'updated' 		=> $comps->response->properties->principal->zestimate->$update,
			'change' 		=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->zestimate->valueChange, 2) ),
			'low' 			=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->zestimate->valuationRange->low, 2) ),
			'high' 			=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->zestimate->valuationRange->high, 2) ),
			'percentile' 	=> $comps->response->properties->principal->zestimate->percentile,
			'comps'			=> array()
		);
		for( $i = 0; $i < $count; $i++ ) {
			$atts = $comps->response->properties->comparables->comp[$i]->attributes();
			$return['comps'][$i] = array(
				'score'			=> $atts['score'],
				'zpid' 			=> $comps->response->properties->comparables->comp[$i]->zpid,
				'homedetails' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->homedetails.'" title="Zillow Home Details" target="_blank">Zillow Home Details</a>',
				'graphsanddata' => '<a href="'.$comps->response->properties->comparables->comp[$i]->links->graphsanddata.'" title="Zillow Graphs And Data" target="_blank">Zillow Graphs And Data</a>',
				'mapthishome' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->mapthishome.'" title="Zillow Map This Home" target="_blank">Zillow Map This Home</a>',
				'myestimator' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->myestimator.'" title="Zillow Estimator" target="_blank">Zillow Estimator</a>',
				'myzestimator' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->myzestimator.'" title="Zillow Zestimator" target="_blank">Zillow Zestimator</a>',
				'comparables' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->comparables.'" title="Zillow Comparables" target="_blank">Zillow Comparables</a>',
				'street' 		=> $comps->response->properties->comparables->comp[$i]->address->street,
				'zip' 			=> $comps->response->properties->comparables->comp[$i]->address->zipcode,
				'city' 			=> $comps->response->properties->comparables->comp[$i]->address->city,
				'state' 		=> $comps->response->properties->comparables->comp[$i]->address->state,
				'lat' 			=> $comps->response->properties->comparables->comp[$i]->address->latitude,
				'lng' 			=> $comps->response->properties->comparables->comp[$i]->address->longitude,
				'zestimate' 	=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->zestimate->amount, 2) ),
				'updated' 		=> $comps->response->properties->comparables->comp[$i]->zestimate->$update,
				'change' 		=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->zestimate->valueChange, 2) ),
				'low' 			=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->zestimate->valuationRange->low, 2) ),
				'high' 			=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->zestimate->valuationRange->high, 2) ),
				'percentile' 	=> $comps->response->properties->comparables->comp[$i]->zestimate->percentile	
			);
		}
		return $return;
	}
}

/*
 * Zillow GetDeepComps API
 * http://www.zillow.com/howto/api/GetDeepComps.htm
 * @params Zillow Property ID, Comp Count
 * @return Array of comparables
 */
function zillow_deep_comps($zpid, $count) {
	$comps = get_zillow_deep_comps($zpid, $count);
	$update = 'last-updated';
	$return = array();
	if( $comps->message->code != 0 ) {
		echo $comps->message->text;
	} else {
		$return = array(
			'zpid' 			=> $comps->response->properties->principal->zpid,
			'homedetails' 	=> '<a href="'.$comps->response->properties->principal->links->homedetails.'" title="Zillow Home Details" target="_blank">Zillow Home Details</a>',
			'graphsanddata' => '<a href="'.$comps->response->properties->principal->links->graphsanddata.'" title="Zillow Graphs And Data" target="_blank">Zillow Graphs And Data</a>',
			'mapthishome' 	=> '<a href="'.$comps->response->properties->principal->links->mapthishome.'" title="Zillow Map This Home" target="_blank">Zillow Map This Home</a>',
			'myestimator' 	=> '<a href="'.$comps->response->properties->principal->links->myestimator.'" title="Zillow Estimator" target="_blank">Zillow Estimator</a>',
			'myzestimator' 	=> '<a href="'.$comps->response->properties->principal->links->myzestimator.'" title="Zillow Zestimator" target="_blank">Zillow Zestimator</a>',
			'comparables' 	=> '<a href="'.$comps->response->properties->principal->links->comparables.'" title="Zillow Comparables" target="_blank">Zillow Comparables</a>',
			'street' 		=> $comps->response->properties->principal->address->street,
			'zip' 			=> $comps->response->properties->principal->address->zipcode,
			'city' 			=> $comps->response->properties->principal->address->city,
			'state' 		=> $comps->response->properties->principal->address->state,
			'lat' 			=> $comps->response->properties->principal->address->latitude,
			'lng' 			=> $comps->response->properties->principal->address->longitude,
			'yearAssessed'	=> $comps->response->properties->principal->taxAssessmentYear,
			'taxAssessment'	=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->taxAssessment, 2) ),
			'yearBuilt'		=> $comps->response->properties->principal->yearBuilt,
			'lotSizesqft'	=> $comps->response->properties->principal->lotSizeSqFt,
			'finishedsqft'	=> $comps->response->properties->principal->finishedSqFt,
			'bathrooms'		=> $comps->response->properties->principal->bathrooms,
			'bedrooms'		=> $comps->response->properties->principal->bedrooms,
			'zestimate' 	=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->zestimate->amount, 2) ),
			'updated' 		=> $comps->response->properties->principal->zestimate->$update,
			'change' 		=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->zestimate->valueChange, 2) ),
			'low' 			=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->zestimate->valuationRange->low, 2) ),
			'high' 			=> '$' . str_replace('.00', '', number_format($comps->response->properties->principal->zestimate->valuationRange->high, 2) ),
			'percentile' 	=> $comps->response->properties->principal->zestimate->percentile,
			'comps'			=> array()
		);
		for( $i = 0; $i < $count; $i++ ) {
			$atts = $comps->response->properties->comparables->comp[$i]->attributes();
			$return['comps'][$i] = array(
				'score'			=> $atts['score'],
				'zpid' 			=> $comps->response->properties->comparables->comp[$i]->zpid,
				'homedetails' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->homedetails.'" title="Zillow Home Details" target="_blank">Zillow Home Details</a>',
				'graphsanddata' => '<a href="'.$comps->response->properties->comparables->comp[$i]->links->graphsanddata.'" title="Zillow Graphs And Data" target="_blank">Zillow Graphs And Data</a>',
				'mapthishome' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->mapthishome.'" title="Zillow Map This Home" target="_blank">Zillow Map This Home</a>',
				'myestimator' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->myestimator.'" title="Zillow Estimator" target="_blank">Zillow Estimator</a>',
				'myzestimator' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->myzestimator.'" title="Zillow Zestimator" target="_blank">Zillow Zestimator</a>',
				'comparables' 	=> '<a href="'.$comps->response->properties->comparables->comp[$i]->links->comparables.'" title="Zillow Comparables" target="_blank">Zillow Comparables</a>',
				'street' 		=> $comps->response->properties->comparables->comp[$i]->address->street,
				'zip' 			=> $comps->response->properties->comparables->comp[$i]->address->zipcode,
				'city' 			=> $comps->response->properties->comparables->comp[$i]->address->city,
				'state' 		=> $comps->response->properties->comparables->comp[$i]->address->state,
				'lat' 			=> $comps->response->properties->comparables->comp[$i]->address->latitude,
				'lng' 			=> $comps->response->properties->comparables->comp[$i]->address->longitude,
				'yearAssessed'	=> $comps->response->properties->comparables->comp[$i]->taxAssessmentYear,
				'taxAssessment'	=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->taxAssessment, 2) ),
				'yearBuilt'		=> $comps->response->properties->comparables->comp[$i]->yearBuilt,
				'lotSizesqft'	=> $comps->response->properties->comparables->comp[$i]->lotSizeSqFt,
				'finishedsqft'	=> $comps->response->properties->comparables->comp[$i]->finishedSqFt,
				'bathrooms'		=> $comps->response->properties->comparables->comp[$i]->bathrooms,
				'bedrooms'		=> $comps->response->properties->comparables->comp[$i]->bedrooms,
				'zestimate' 	=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->zestimate->amount, 2) ),
				'updated' 		=> $comps->response->properties->comparables->comp[$i]->zestimate->$update,
				'change' 		=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->zestimate->valueChange, 2) ),
				'low' 			=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->zestimate->valuationRange->low, 2) ),
				'high' 			=> '$' . str_replace('.00', '', number_format($comps->response->properties->comparables->comp[$i]->zestimate->valuationRange->high, 2) ),
				'percentile' 	=> $comps->response->properties->comparables->comp[$i]->zestimate->percentile	
			);
		}
		return $return;
	}
}

function list_zillow_cities($countystate) {
	global $zhood_list;
	$zhood_list = get_zillow_children($countystate);
	return $zhood_list->response->list->region;
}

function z_neighborhood_count() {
	global $zhood_list;
	echo $zhood_list->response->list->count;
}


/*
 * Zillow GetDemographics API
 * http://www.zillow.com/howto/api/GetDemographics.htm
 * @params either regionid, city/state, neighborhood/city, or zip
 * @returns an array of neighborhood details
 */
function get_zillow_neighborhood($neighborhood,$city) {
	global $zhood;
	$send = array( 'neighborhood' => $neighborhood, 'city' => $city );
	$zhood = get_zillow_demographics($send);
}

function get_zillow_region($regionid) {
	global $zhood;
	$send = array( 'z_region_id' => $regionid );
	$zhood = get_zillow_demographics($send);
}

function get_zillow_city($city,$state) {
	global $zhood;
	$send = array( 'city' => $city, 'state' => $state );
	$zhood = get_zillow_demographics($send);
}

function z_region_id() {
	global $zhood;
	echo $zhood->response->region->id;
}

function z_state() {
	global $zhood;
	echo $zhood->response->region->state;
}

function z_city() {
	global $zhood;
	echo $zhood->response->region->city;
}

function z_neighborhood() {
	global $zhood;
	echo $zhood->response->region->neighborhood;
}

function z_main_link() {
	global $zhood;
	echo $zhood->response->links->main;
}

function z_affordability_link() {
	global $zhood;
	echo $zhood->response->links->affordability;
}

function z_homes_and_real_estate_link() {
	global $zhood;
	echo $zhood->response->links->homesandrealestate;
}

function z_people_link() {
	global $zhood;
	echo $zhood->response->links->people;
}

function z_for_sale_link() {
	global $zhood;
	echo $zhood->response->links->forSale;
}

function z_fsbo_link() {
	global $zhood;
	echo $zhood->response->links->forSaleByOwner;
}

function z_foreclosure_link() {
	global $zhood;
	echo $zhood->response->links->foreclosures;
}

function z_recently_sold_link() {
	global $zhood;
	echo $zhood->response->links->recentlySold;
}

function z_avg_condo_value_chart() {
	global $zhood;
	echo '<img src="' . $zhood->response->charts->chart[0]->url . '" />';
}

function z_avg_home_value_chart() {
	global $zhood;
	echo '<img src="' . $zhood->response->charts->chart[1]->url . '" />';
}

function z_dollars_per_sqft_chart() {
	global $zhood;
	echo '<img src="' . $zhood->response->charts->chart[2]->url . '" />';
}

function z_zindex_distribution_chart() {
	global $zhood;
	echo '<img src="' . $zhood->response->charts->chart[3]->url . '" />';
}

function z_home_type_chart() {
	global $zhood;
	echo '<img src="' . $zhood->response->charts->chart[4]->url . '" />';
}

function z_owners_vs_renters_chart() {
	global $zhood;
	echo '<img src="' . $zhood->response->charts->chart[5]->url . '" />';
}

function z_home_size_sqft_chart() {
	global $zhood;
	echo '<img src="' . $zhood->response->charts->chart[6]->url . '" />';
}

function z_year_built_chart() {
	global $zhood;
	echo '<img src="' . $zhood->response->charts->chart[7]->url . '" />';
}

function z_for_sale_count() {
	global $zhood;
	echo number_format( $zhood->response->market->forSaleCount );
}

function z_fsbo_count() {
	global $zhood;
	echo number_format( $zhood->response->market->forSaleByOwnerCount );
}

function z_recently_sold_count() {
	global $zhood;
	echo number_format( $zhood->response->market->recentlySoldCount );
}

function z_new_construction_count() {
	global $zhood;
	echo number_format( $zhood->response->market->newConstructionCount );
}

function z_foreclosure_count() {
	global $zhood;
	echo number_format( $zhood->response->market->foreclosureCount );
}

function z_home_index_value($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[0]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[0]->values->city;
			//echo number_format( ($zhood->response->pages->page[0]->tables->table[0]->data->attribute[0]->values->city * 100), 2 ) . '%';
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[0]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[0]->values->city;
		break;
	}
}

function z_one_year_change($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[1]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[1]->values->city;
			//echo number_format( ($zhood->response->pages->page[0]->tables->table[0]->data->attribute[1]->values->city * 100), 2 ) . '%';
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[1]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[1]->values->city;
		break;
	}
}

function z_estimate_per_sqft($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[2]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[2]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[2]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[2]->values->city;
		break;
	}
}

function z_flips($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[3]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[3]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[3]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[3]->values->city;
		break;
	}
}

function z_turnover($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[4]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[4]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[4]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[4]->values->city;
		break;
	}
}

function z_property_tax($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[5]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[5]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[5]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[5]->values->city;
		break;
	}	
}

function z_median_condo_value($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[6]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[6]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[6]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[6]->values->city;
		break;
	}
}

function z_median_single_family($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[7]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[7]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[7]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[7]->values->city;
		break;
	}
}

function z_median_two_bed_home($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[8]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[8]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[8]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[8]->values->city;
		break;
	}
}

function z_median_three_bed_home($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[9]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[9]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[9]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[9]->values->city;
		break;
	}
}

function z_median_four_bed_home($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[10]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[10]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[10]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[0]->data->attribute[10]->values->city;
		break;
	}
}

function z_census_price_per_sqft($a) {
	global $zhood;
	switch($a) {
		case '100-200':
			echo $zhood->response->pages->page[0]->tables->table[1]->data->attribute[0]->value;
		break;
		case '200-300':
			echo $zhood->response->pages->page[0]->tables->table[1]->data->attribute[1]->value;
		break;
		case '300-400':
			echo $zhood->response->pages->page[0]->tables->table[1]->data->attribute[2]->value;
		break;
		case '400-500':
			echo $zhood->response->pages->page[0]->tables->table[1]->data->attribute[3]->value;
		break;
		case '600-800':
			echo $zhood->response->pages->page[0]->tables->table[1]->data->attribute[4]->value;
		break;
		default:
			echo $zhood->response->pages->page[0]->tables->table[1]->data->attribute[0]->value;
		break;
	}
}

function z_owners($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[0]->values->neighborhood->value;
		break;
		case 'city':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[0]->values->city->value;
		break;
		case 'nation':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[0]->values->nation->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[0]->values->city->value;
		break;
	}
}

function z_renters($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[1]->values->neighborhood->value;
		break;
		case 'city':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[1]->values->city->value;
		break;
		case 'nation':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[1]->values->nation->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[1]->values->city->value;
		break;
	}
}

function z_median_home_size($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo number_format( $zhood->response->pages->page[1]->tables->table[0]->data->attribute[2]->values->neighborhood->value );
		break;
		case 'city':
			echo number_format( $zhood->response->pages->page[1]->tables->table[0]->data->attribute[2]->values->city->value );
		break;
		case 'nation':
			echo number_format( $zhood->response->pages->page[1]->tables->table[0]->data->attribute[2]->values->nation->value );
		break;
		default:
			echo number_format( $zhood->response->pages->page[1]->tables->table[0]->data->attribute[2]->values->city->value );
		break;
	}
}

function z_avg_year_built($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[3]->values->neighborhood->value;
		break;
		case 'city':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[3]->values->city->value;
		break;
		case 'nation':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[3]->values->nation->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[3]->values->city->value;
		break;
	}
}

function z_single_family_home($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[4]->values->neighborhood->value;
		break;
		case 'city':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[4]->values->city->value;
		break;
		case 'nation':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[4]->values->nation->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[4]->values->city->value;
		break;
	}
}

function z_condos($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[5]->values->neighborhood->value;
		break;
		case 'city':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[5]->values->city->value;
		break;
		case 'nation':
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[5]->values->nation->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[0]->data->attribute[5]->values->city->value;
		break;
	}
}

function z_median_household_income($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[0]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[0]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[0]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[0]->values->city;
		break;
	}
}

function z_single_males($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[1]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[1]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[1]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[1]->values->city;
		break;
	}
}

function z_single_females($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[2]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[2]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[2]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[2]->values->city;
		break;
	}
}

function z_median_age($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[3]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[3]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[3]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[3]->values->city;
		break;
	}
}

function z_homes_with_kids($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[4]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[4]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[4]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[4]->values->city;
		break;
	}
}

function z_avg_household_size($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[5]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[5]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[5]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[5]->values->city;
		break;
	}
}

function z_avg_commute_time($a) {
	global $zhood;
	switch($a) {
		case 'neighborhood':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[6]->values->neighborhood;
		break;
		case 'city':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[6]->values->city;
		break;
		case 'nation':
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[6]->values->nation;
		break;
		default:
			echo $zhood->response->pages->page[2]->tables->table[0]->data->attribute[6]->values->city;
		break;
	}
}

function z_year_built($a) {
	global $zhood;
	switch($a) {
		case '1940-1959':
			echo $zhood->response->pages->page[1]->tables->table[1]->data->attribute[1]->value;
		break;
		case '1960-1979':
			echo $zhood->response->pages->page[1]->tables->table[1]->data->attribute[2]->value;
		break;
		case '1980-1999':
			echo $zhood->response->pages->page[1]->tables->table[1]->data->attribute[3]->value;
		break;
		case '2000+':
			echo $zhood->response->pages->page[1]->tables->table[1]->data->attribute[0]->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[1]->data->attribute[0]->value;
		break;
	}
}

function z_census_home_size($a) {
	global $zhood;
	switch($a) {
		case '1000':
			echo $zhood->response->pages->page[1]->tables->table[2]->data->attribute[0]->value;
		break;
		case '1000-1400':
			echo $zhood->response->pages->page[1]->tables->table[2]->data->attribute[2]->value;
		break;
		case '1400-1800':
			echo $zhood->response->pages->page[1]->tables->table[2]->data->attribute[3]->value;
		break;
		case '1800-2400':
			echo $zhood->response->pages->page[1]->tables->table[2]->data->attribute[4]->value;
		break;
		case '2400-3600':
			echo $zhood->response->pages->page[1]->tables->table[2]->data->attribute[5]->value;
		break;
		case '3600+':
			echo $zhood->response->pages->page[1]->tables->table[2]->data->attribute[1]->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[2]->data->attribute[0]->value;
		break;
	}
}

function z_census_home_type($a) {
	global $zhood;
	switch($a) {
		case 'condo':
			echo $zhood->response->pages->page[1]->tables->table[3]->data->attribute[0]->value;
		break;
		case 'other':
			echo $zhood->response->pages->page[1]->tables->table[3]->data->attribute[1]->value;
		break;
		case 'single_family':
			echo $zhood->response->pages->page[1]->tables->table[3]->data->attribute[2]->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[3]->data->attribute[2]->value;
		break;
	}
}

function z_census_occupancy($a) {
	global $zhood;
	switch($a) {
		case 'own':
			echo $zhood->response->pages->page[1]->tables->table[4]->data->attribute[0]->value;
		break;
		case 'rent':
			echo $zhood->response->pages->page[1]->tables->table[4]->data->attribute[1]->value;
		break;
		default:
			echo $zhood->response->pages->page[1]->tables->table[4]->data->attribute[0]->value;
		break;
	}
}



?>