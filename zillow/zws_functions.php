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

/*
 * Zillow GetDemographics API
 * http://www.zillow.com/howto/api/GetDemographics.htm
 * @params either regionid, city/state, neighborhood/city, or zip
 * @returns an array of neighborhood details
 */
function zillow_neighborhood($neighborhood,$city) {
	$send = array( 'neighborhood' => $neighborhood, 'city' => $city );
	$dem = get_zillow_demographics($send);
	return compile_zillow_data($dem);
}

function zillow_region($regionid) {
	$send = array( 'z_region_id' => $regionid );
	$dem = get_zillow_demographics($send);
	return compile_zillow_data($dem);
}

function zillow_city($city,$state) {
	$send = array( 'city' => $city, 'state' => $state );
	$dem = get_zillow_demographics($send);
	return compile_zillow_data($dem);
}

function compile_zillow_data($obj) {
	$return = array(
		'region_id' => $obj->response->region->id,
		'state' => $obj->response->region->state,
		'city' => $obj->response->region->city,
		'neighborhood' => $obj->response->region->neighborhood,
		'links' => array(
			'main' => $obj->response->links->main,
			'affordability' => $obj->response->links->affordability,
			'homes_and_real_estate' => $obj->response->links->homesandrealestate,
			'people' => $obj->response->links->people,
			'for_sale' => $obj->response->links->forSale,
			'for_sale_by_owner' => $obj->response->links->forSaleByOwner,
			'foreclosures' => $obj->response->links->foreclosures,
			'recently_sold' => $obj->response->links->recentlySold
		),
		'avg_condo_value' => $obj->response->charts->chart[0]->url,
		'avg_home_value' => $obj->response->charts->chart[1]->url,
		'dollars_per_sqft' => $obj->response->charts->chart[2]->url,
		'zindex_distribution' => $obj->response->charts->chart[3]->url,
		'home_type' => $obj->response->charts->chart[4]->url,
		'owners_vs_renters' => $obj->response->charts->chart[5]->url,
		'home_size_sqft' => $obj->response->charts->chart[6]->url,
		'year_built' => $obj->response->charts->chart[7]->url,
		'for_sale_count' => $obj->response->market->forSaleCount,
		'for_sale_by_owner_count' => $obj->response->market->forSaleByOwnerCount,
		'recently_sold_count' => $obj->response->market->recentlySoldCount,
		'new_construction_count' => $obj->response->market->newConstructionCount,
		'foreclosure_count' => $obj->response->market->foreclosureCount,
		'zillow_home_index_value' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[0]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[0]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[0]->values->nation
		),
		'one_year_change' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[1]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[1]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[1]->values->nation
		),
		'zestimate_per_sqft' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[2]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[2]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[2]->values->nation
		),
		'flips' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[3]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[3]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[3]->values->nation
		),
		'turnover' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[4]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[4]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[4]->values->nation
		),
		'property_tax' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[5]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[5]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[5]->values->nation
		),
		'median_condo_value' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[6]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[6]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[6]->values->nation
		),
		'median_single_family' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[7]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[7]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[7]->values->nation
		),
		'median_two_bed_home' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[8]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[8]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[8]->values->nation
		),
		'median_three_bed_home' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[9]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[9]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[9]->values->nation
		),
		'median_four_bed_home' => array(
			'neighborhood' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[10]->values->neighborhood,
			'city' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[10]->values->city,
			'nation' => $obj->response->pages->page[0]->tables->table[0]->data->attribute[10]->values->nation
		),
		'census_price_per_sqft' => array(
			'100-200' => $obj->response->pages->page[0]->tables->table[1]->data->attribute[0]->value,
			'200-300' => $obj->response->pages->page[0]->tables->table[1]->data->attribute[1]->value,
			'300-400' => $obj->response->pages->page[0]->tables->table[1]->data->attribute[2]->value,
			'400-500' => $obj->response->pages->page[0]->tables->table[1]->data->attribute[3]->value,
			'600-800' => $obj->response->pages->page[0]->tables->table[1]->data->attribute[4]->value
		),
		'owners' => array(
			'neighborhood' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[0]->values->neighborhood->value,
			'city' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[0]->values->city->value,
			'nation' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[0]->values->nation->value
		),
		'renters' => array(
			'neighborhood' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[1]->values->neighborhood->value,
			'city' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[1]->values->city->value,
			'nation' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[1]->values->nation->value
		),
		'median_home_size' => array(
			'neighborhood' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[2]->values->neighborhood->value,
			'city' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[2]->values->city->value,
			'nation' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[2]->values->nation->value
		),
		'avg_year_built' => array(
			'neighborhood' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[3]->values->neighborhood->value,
			'city' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[3]->values->city->value,
			'nation' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[3]->values->nation->value
		),
		'single_family_home' => array(
			'neighborhood' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[4]->values->neighborhood->value,
			'city' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[4]->values->city->value,
			'nation' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[4]->values->nation->value
		),
		'condos' => array(
			'neighborhood' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[5]->values->neighborhood->value,
			'city' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[5]->values->city->value,
			'nation' => $obj->response->pages->page[1]->tables->table[0]->data->attribute[5]->values->nation->value
		),
		'year_built' => array(
			'1940-1959' => $obj->response->pages->page[1]->tables->table[1]->data->attribute[1]->value,
			'1960-1979' => $obj->response->pages->page[1]->tables->table[1]->data->attribute[2]->value,
			'1980-1999' => $obj->response->pages->page[1]->tables->table[1]->data->attribute[3]->value,
			'2000' => $obj->response->pages->page[1]->tables->table[1]->data->attribute[0]->value
		),
		'census_home_size' => array(
			'1000' => $obj->response->pages->page[1]->tables->table[2]->data->attribute[0]->value,
			'1000-1400' => $obj->response->pages->page[1]->tables->table[2]->data->attribute[2]->value,
			'1400-1800' => $obj->response->pages->page[1]->tables->table[2]->data->attribute[3]->value,
			'1800-2400' => $obj->response->pages->page[1]->tables->table[2]->data->attribute[4]->value,
			'2400-3600' => $obj->response->pages->page[1]->tables->table[2]->data->attribute[5]->value,
			'3600' => $obj->response->pages->page[1]->tables->table[2]->data->attribute[1]->value
		),
		'census_home_type' => array(
			'condo' => $obj->response->pages->page[1]->tables->table[3]->data->attribute[0]->value,
			'other' => $obj->response->pages->page[1]->tables->table[3]->data->attribute[1]->value,
			'single_family' => $obj->response->pages->page[1]->tables->table[3]->data->attribute[2]->value
		),
		'census_occupancy' => array(
			'own' => $obj->response->pages->page[1]->tables->table[4]->data->attribute[0]->value,
			'rent' => $obj->response->pages->page[1]->tables->table[4]->data->attribute[1]->value
		),
		'median_household_income' => array(
			'neighborhood' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[0]->values->neighborhood,
			'city' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[0]->values->city,
			'nation' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[0]->values->nation
		),
		'single_males' => array(
			'neighborhood' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[1]->values->neighborhood,
			'city' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[1]->values->city,
			'nation' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[1]->values->nation
		),
		'single_females' => array(
			'neighborhood' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[2]->values->neighborhood,
			'city' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[2]->values->city,
			'nation' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[2]->values->nation
		),
		'median_age' => array(
			'neighborhood' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[3]->values->neighborhood,
			'city' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[3]->values->city,
			'nation' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[3]->values->nation
		),
		'homes_with_kids' => array(
			'neighborhood' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[4]->values->neighborhood,
			'city' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[4]->values->city,
			'nation' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[4]->values->nation
		),
		'avg_household_size' => array(
			'neighborhood' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[5]->values->neighborhood,
			'city' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[5]->values->city,
			'nation' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[5]->values->nation
		),
		'avg_commute_time' => array(
			'neighborhood' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[6]->values->neighborhood,
			'city' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[6]->values->city,
			'nation' => $obj->response->pages->page[2]->tables->table[0]->data->attribute[6]->values->nation
		)
	);
	return $return;
}

?>