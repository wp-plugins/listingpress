<?php

/* Listings Search */
function the_address() {
	global $listing;
	echo $listing['ADDRESS'];
}

function the_listing_id() {
	global $listing;
	echo $listing['OB_ID_PROP'];
}

function the_city() {
	global $listing;
	echo $listing['OB_CITY'];
}

function the_state() {
	global $listing;
	echo $listing['OB_STATE'];
}

function the_zip_code() {
	global $listing;
	echo $listing['OB_ZIP'];
}

function the_match_code() {
	global $listing;
	echo $listing['OB_MATCH_CODE_OUT'];
}

function the_property_type_description() {
	global $listing;
	echo $listing['PROPERTY_TYPE_DESCRIPTION'];
}

function the_property_type() {
	global $listing;
	echo $listing['STANDARDPROPERTYTYPE'];
}

function the_sqft() {
	global $listing;
	echo $listing['SQUARE_FOOTAGE_BUILDING'];
}

function the_sales_price($return = false) {
	global $listing;
	if($return)
		return '$' . str_replace( '.00', '', number_format($listing['SALE_PRICE'], 2) );
	else 
		echo '$' . str_replace( '.00', '', number_format($listing['SALE_PRICE'], 2) );
}

function the_feed_id() {
	global $listing;
	echo $listing['FEED'];
}

function get_the_feed_id() {
	global $listing;
	return $listing['FEED'];
}

function the_mls_id() {
	global $listing;
	echo $listing['MLS_LISTING_ID'];
}

function the_status() {
	global $listing;
	echo $listing['STATUS'];
}

function the_display_status() {
	global $listing;
	echo $listing['DISPSTATUS'];
}

function the_bedrooms() {
	global $listing;
	echo $listing['BEDROOMS'];
}

function the_bathrooms() {
	global $listing;
	echo $listing['BATHS_TOTAL'];
}

function the_lot_description() {
	global $listing;
	echo $listing['FTR_LOT_DESC'];
}

function the_view() {
	global $listing;
	if( is_lp_single() )
		echo $listing['FTR_VIEWS_DESC'];
	else
		echo $listing['VIEWS_DESC'];
}

function the_agent_name() {
	global $listing;
	echo $listing['MLS_AGENT_NAME'];
}

function the_office() {
	global $listing;
	echo $listing['MLS_OFFICE_NAME']; 
}

function the_photo_count() {
	global $listing;
	echo $listing['OB_PHOTO_COUNT'];
}

function get_the_photo_count() {
	global $listing;
	return $listing['OB_PHOTO_COUNT'];
}

function listing_has_photos() {
	global $listing;
	return ( $listing['OB_PHOTO_COUNT'] > 0 ) ? true : false;
}

function the_primary_photo($class, $thumb = false) {
	global $listing, $lp_feed;
	$img = 'http://images.obiwebservices.com/listings/' . $lp_feed . '/';
	$img .= ($thumb) ? 'thumbs/' : 'photos/'; 
	$img .= $listing['OB_PHOTO_PRIMARY'];
	$class = (!empty($class)) ? $class : 'lp_primary_photo';
	$default = plugins_url('listingpress/resources/images/emptyhouse.jpg');
	if( listing_has_photos() ) {
		echo '<div class="' . $class . '"><img src="' . $img . '" alt="' . $listing['OB_ADDRESS'] . '" /></div>';
	} else {
		echo '<div class="' . $class . '"><img src="' . $default . '" alt="' . $listing['OB_ADDRESS'] . '" /></div>';
	}
}

function get_the_primary_photo() {
	global $listing, $lp_feed;
	$img = 'http://images.obiwebservices.com/listings/' . $lp_feed . '/';
	$img .= ($thumb) ? 'thumbs/' : 'photos/'; 
	$img .= $listing['OB_PHOTO_PRIMARY'];
	return $img;
}

function the_listing_photos($num, $class, $thumb = false) {
	global $listing, $lp_feed;
	$class = (!empty($class)) ? $class : 'lp_listing_photos';
	$num = ( !empty($num) && $num != 0 ) ? $num : $listing['OB_PHOTO_COUNT'];
	$imgs = explode('|',$listing['OB_PHOTO_FILENAMES']);
	for( $i = 0; $i < $num; $i++ ) {
		$img = 'http://images.obiwebservices.com/listings/' . $lp_feed . '/';
		$img .= ($thumb) ? 'thumbs/' : 'photos/'; 
		$img .= $imgs[$i];
		echo '<div class="'.$class.'"><img src="'.$img.'" alt="'.$listing['OB_ADDRESS'].'" /></div>';
	}
}

function get_the_listing_photos($num, $class, $thumb = false) {
	global $listing, $lp_feed;
	$class = (!empty($class)) ? $class : 'lp_listing_photos';
	$num = ( !empty($num) && $num != 0 ) ? $num : $listing['OB_PHOTO_COUNT'];
	$imgs = explode('|',$listing['OB_PHOTO_FILENAMES']);
	$return = array();
	for( $i = 0; $i < $num; $i++ ) {
		$img = 'http://images.obiwebservices.com/listings/' . $lp_feed . '/';
		$img .= ($thumb) ? 'thumbs/' : 'photos/'; 
		$img .= $imgs[$i];
		$return[$i] = '<div class="'.$class.'"><img src="'.$img.'" alt="'.$listing['OB_ADDRESS'].'" /></div>';
	}
	return $return;
}

function the_agent_id() {
	global $listing;
	echo $listing['MLS_AGENT_ID'];
}

function the_office_id() {
	global $listing;
	echo $listing['MLS_OFFICE_ID'];
}

function show_address() {
	global $listing;
	echo $listing['OB_SHOW_ADDRESS'];
}

function display_internet() {
	global $listing;
	echo $listing['OB_DISPLAY_INTERNET'];
}

function the_latitude() {
	global $listing;
	echo $listing['OB_LATITUDE'];
}

function the_longitude() {
	global $listing;
	echo $listing['OB_LONGITUDE'];
}

function the_lot_size() {
	global $listing;
	echo $listing['FTR_LOTSIZE'];
}

function the_listing_date() {
	global $listing;
	echo substr( $listing['OB_LISTING_DATE'], 0, strrpos($listing['OB_LISTING_DATE'],'T') );
}



/* Single Listing Search */
function the_original_sales_price() {
	global $listing;
	echo '$' . str_replace( '.00', '', number_format($listing['ORIGINALLISTINGPRICE'], 2) );
}

function the_year_built() {
	global $listing;
	echo $listing['YEAR_BUILT'];
}

function the_remarks() {
	global $listing;
	echo $listing['MARKETING_REMARKS'];
}

function the_region_desc() {
	global $listing;
	echo $listing['FTR_REGION_DESC'];
}

function the_subdistrict_desc() {
	global $listing;
	echo $listing['FTR_SUBDIST_DESC'];
}

function the_construction() {
	global $listing;
	echo $listing['FTR_CONSTRUCTION_DESC'];
}

function the_exterior() {
	global $listing;
	echo $listing['FTR_EXTERIOR_DESC'];
}

function the_floors() {
	global $listing;
	echo $listing['FTR_FLOORS_DESC'];
}

function the_foundation() {
	global $listing;
	echo $listing['FTR_FOUNDATION_DESC'];
}

function the_main_level() {
	global $listing;
	echo $listing['FTR_MAIN_LEVEL_DESC'];
}

function the_lower_level() {
	global $listing;
	echo $listing['FTR_LOWER_LEVEL_DESC'];
}

function the_upper_level() {
	global $listing;
	echo $listing['FTR_UPPER_LEVEL_DESC'];
}

function the_sewer() {
	global $listing;
	echo $listing['FTR_WATER_SEWER_DESC'];
}

function the_sprinklers() {
	global $listing;
	echo $listing['FTR_SPRINKLERS_DESC'];
}

function the_water() {
	global $listing;
	echo $listing['FTR_WATERSOURCE_DESC'];
}

function the_utilities() {
	global $listing;
	echo $listing['FTR_UTILITIES_DESC'];
}

function the_roof() {
	global $listing;
	echo $listing['FTR_ROOF_DESC'];
}

function the_pool() {
	global $listing;
	echo $listing['FTR_POOL_DESC'];
}

function the_recreation() {
	global $listing;
	echo $listing['FTR_RECREATION_DESC'];
}

function the_rent_type() {
	global $listing;
	echo $listing['FTR_RENT_TYPE_DESC'];
}

function the_rent_source() {
	global $listing;
	echo $listing['FTR_RENT_SOURCE_DESC'];
}

function the_shopping() {
	global $listing;
	echo $listing['FTR_SHOPPING_DESC'];
}

function the_transportation() {
	global $listing;
	echo $listing['FTR_TRANSPORTATION_DESC'];
}

function the_special_features() {
	global $listing;
	echo $listing['FTR_SPECIAL_FEATURE_DESC'];
}

function the_style() {
	global $listing;
	echo $listing['FTR_STYLE_DESC'];
}

function the_type() {
	global $listing;
	echo $listing['FTR_TYPE_DESC'];
}

function the_fireplace() {
	global $listing;
	echo $listing['FTR_FIREPLACE_DESC'];
}

function the_master_bed() {
	global $listing;
	echo $listing['FTR_MASTER_BED_DESC'];
}

function the_master_bath() {
	global $listing;
	echo $listing['FTR_MASTER_BATH_DESC'];
}

function the_bath_description() {
	global $listing;
	echo $listing['FTR_BATH_DESC'];
}

function the_kitchen() {
	global $listing;
	echo $listing['FTR_KITCHEN_DESC'];
}

function the_microwave() {
	global $listing;
	echo $listing['FTR_MICROWAVE_DESC'];
}

function the_trash() {
	global $listing;
	echo $listing['FTR_TRASH_COMPACTOR_DESC'];
}

function the_oven() {
	global $listing;
	echo $listing['FTR_RANGE_OVEN_DESC'];
}

function the_refrigerator() {
	global $listing;
	echo $listing['FTR_REFRIG_DESC'];
}

function the_stove() {
	global $listing;
	echo $listing['FTR_STOVE_INSERT_DESC'];
}

function the_laundry() {
	global $listing;
	echo $listing['FTR_LAUNDRY_DESC'];
}

function the_other_rooms() {
	global $listing;
	echo $listing['FTR_OTHER_ROOM_DESC'];
}

function the_misc() {
	global $listing;
	echo $listing['FTR_MISCELLANEOUS_DESC'];
}

function the_topography() {
	global $listing;
	echo $listing['FTR_TOPOGRAPHY_DESC'];
}

function the_structure() {
	global $listing;
	echo $listing['FTR_OTHER_STRUCTURE_DESC'];
}

function the_garage() {
	global $listing;
	echo $listing['FTR_GARAGE_DESC'];
}

function the_parking() {
	global $listing;
	echo $listing['FTR_PARKING_DESC'];
}

function the_sales_conditions() {
	global $listing;
	echo $listing['FTR_SALE_CONDITIONS_DESC'];
}

function the_hoa_fees() {
	global $listing;
	echo $listing['FTR_HOAFEEINCLUDESDESC'];
}

function the_restrictions() {
	global $listing;
	echo $listing['FTR_RESTRICTIONSDESC'];
}


function the_dom() {
	global $listing;
	echo $listing['DOM'];
}

function list_all_details() {
	global $listing;
	echo '<p>';
	if( !empty($listing['FTR_REGION_DESC']) )
		echo 'Region Description: <strong>' . $listing['FTR_REGION_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_SUBDIST_DESC']) )
		echo 'Sub District: <strong>' . $listing['FTR_SUBDIST_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_CONSTRUCTION_DESC']) )
		echo 'Construction: <strong>' . $listing['FTR_CONSTRUCTION_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_EXTERIOR_DESC']) )
		echo 'Exterior: <strong>' . $listing['FTR_EXTERIOR_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_FLOORS_DESC']) )
		echo 'Floors: <strong>' . $listing['FTR_FLOORS_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_FOUNDATION_DESC']) )
		echo 'Foundation: <strong>' . $listing['FTR_FOUNDATION_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_MAIN_LEVEL_DESC']) )
		echo 'Main Level Description: <strong>' . $listing['FTR_MAIN_LEVEL_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_LOWER_LEVEL_DESC']) )
		echo 'Lower Level Description: <strong>' . $listing['FTR_LOWER_LEVEL_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_UPPER_LEVEL_DESC']) )
		echo 'Upper Level Description: <strong>' . $listing['FTR_UPPER_LEVEL_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_WATER_SEWER_DESC']) )
		echo 'Sewer Description: <strong>' . $listing['FTR_WATER_SEWER_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_SPRINKLERS_DESC']) )
		echo 'Sprinklers: <strong>' . $listing['FTR_SPRINKLERS_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_WATERSOURCE_DESC']) )
		echo 'Water: <strong>' . $listing['FTR_WATERSOURCE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_UTILITIES_DESC']) )
		echo 'Utilities: <strong>' . $listing['FTR_UTILITIES_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_ROOF_DESC']) )
		echo 'Roof: <strong>' . $listing['FTR_ROOF_DESC'] . '</strong><br />';
	
	if( !empty($listing['FTR_POOL_DESC']) )
		echo 'Pool: <strong>' . $listing['FTR_POOL_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_RECREATION_DESC']) )
		echo 'Recreation Area: <strong>' . $listing['FTR_RECREATION_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_RENT_TYPE_DESC']) )
		echo 'Rent Description: <strong>' . $listing['FTR_RENT_TYPE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_RENT_SOURCE_DESC']) )
		echo 'Rent Source: <strong>' . $listing['FTR_RENT_SOURCE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_SHOPPING_DESC']) )
		echo 'Shopping Description: <strong>' . $listing['FTR_SHOPPING_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_TRANSPORTATION_DESC']) )
		echo 'Transportation Description: <strong>' . $listing['FTR_TRANSPORTATION_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_SPECIAL_FEATURE_DESC']) )
		echo 'Special Features: <strong>' . $listing['FTR_SPECIAL_FEATURE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_STYLE_DESC']) )
		echo 'Style of Home: <strong>' . $listing['FTR_STYLE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_TYPE_DESC']) )
		echo 'Type: <strong>' . $listing['FTR_TYPE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_FIREPLACE_DESC']) )
		echo 'Fireplace Description: <strong>' . $listing['FTR_FIREPLACE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_MASTER_BED_DESC']) )
		echo 'Master Bedroom: <strong>' . $listing['FTR_MASTER_BED_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_MASTER_BATH_DESC']) )
		echo 'Master Bathroom: <strong>' . $listing['FTR_MASTER_BATH_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_BATH_DESC']) )
		echo 'Bathroom: <strong>' . $listing['FTR_BATH_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_KITCHEN_DESC']) )
		echo 'Kitchen: <strong>' . $listing['FTR_KITCHEN_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_MICROWAVE_DESC']) )
		echo 'Microwave: <strong>' . $listing['FTR_MICROWAVE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_TRASH_COMPACTOR_DESC']) )
		echo 'Trash Compactor: <strong>' . $listing['FTR_TRASH_COMPACTOR_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_RANGE_OVEN_DESC']) )
		echo 'Range Oven: <strong>' . $listing['FTR_RANGE_OVEN_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_REFRIG_DESC']) )
		echo 'Refrigerator: <strong>' . $listing['FTR_REFRIG_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_STOVE_INSERT_DESC']) )
		echo 'Stove: <strong>' . $listing['FTR_STOVE_INSERT_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_LAUNDRY_DESC']) )
		echo 'Laundry: <strong>' . $listing['FTR_LAUNDRY_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_OTHER_ROOM_DESC']) )
		echo 'Other Rooms: <strong>' . $listing['FTR_OTHER_ROOM_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_MISCELLANEOUS_DESC']) )
		echo 'Misc: <strong>' . $listing['FTR_MISCELLANEOUS_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_TOPOGRAPHY_DESC']) )
		echo 'Topography: <strong>' . $listing['FTR_TOPOGRAPHY_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_OTHER_STRUCTURE_DESC']) )
		echo 'Other Structures: <strong>' . $listing['FTR_OTHER_STRUCTURE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_GARAGE_DESC']) )
		echo 'Garage: <strong>' . $listing['FTR_GARAGE_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_PARKING_DESC']) )
		echo 'Parking: <strong>' . $listing['FTR_PARKING_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_SALE_CONDITIONS_DESC']) )
		echo 'Sales Conditions: <strong>' . $listing['FTR_SALE_CONDITIONS_DESC'] . '</strong><br />';

	if( !empty($listing['FTR_HOAFEEINCLUDESDESC']) )
		echo 'HOA Fees: <strong>' . $listing['FTR_HOAFEEINCLUDESDESC'] . '</strong><br />';

	if( !empty($listing['FTR_RESTRICTIONSDESC']) )
		echo 'Restrictions: <strong>' . $listing['FTR_RESTRICTIONSDESC'] . '</strong><br />';

	echo '</p>';
}

function list_all_the_details($before,$between,$after) {
	global $listing;

	if( !empty($listing['FTR_REGION_DESC']) )
		echo $before . 'Region Description: ' . $between . $listing['FTR_REGION_DESC'] . $after;

	if( !empty($listing['FTR_SUBDIST_DESC']) )
		echo $before . 'Sub District: ' . $between . $listing['FTR_SUBDIST_DESC'] . $after;

	if( !empty($listing['FTR_CONSTRUCTION_DESC']) )
		echo $before . 'Construction: ' . $between . $listing['FTR_CONSTRUCTION_DESC'] . $after;

	if( !empty($listing['FTR_EXTERIOR_DESC']) )
		echo $before . 'Exterior: ' . $between . $listing['FTR_EXTERIOR_DESC'] . $after;

	if( !empty($listing['FTR_FLOORS_DESC']) )
		echo $before . 'Floors: ' . $between . $listing['FTR_FLOORS_DESC'] . $after;

	if( !empty($listing['FTR_FOUNDATION_DESC']) )
		echo $before . 'Foundation: ' . $between . $listing['FTR_FOUNDATION_DESC'] . $after;

	if( !empty($listing['FTR_MAIN_LEVEL_DESC']) )
		echo $before . 'Main Level Description: ' . $between . $listing['FTR_MAIN_LEVEL_DESC'] . $after;

	if( !empty($listing['FTR_LOWER_LEVEL_DESC']) )
		echo $before . 'Lower Level Description: ' . $between . $listing['FTR_LOWER_LEVEL_DESC'] . $after;

	if( !empty($listing['FTR_UPPER_LEVEL_DESC']) )
		echo $before . 'Upper Level Description: ' . $between . $listing['FTR_UPPER_LEVEL_DESC'] . $after;

	if( !empty($listing['FTR_WATER_SEWER_DESC']) )
		echo $before . 'Sewer Description: ' . $between . $listing['FTR_WATER_SEWER_DESC'] . $after;

	if( !empty($listing['FTR_SPRINKLERS_DESC']) )
		echo $before . 'Sprinklers: ' . $between . $listing['FTR_SPRINKLERS_DESC'] . $after;

	if( !empty($listing['FTR_WATERSOURCE_DESC']) )
		echo $before . 'Water: ' . $between . $listing['FTR_WATERSOURCE_DESC'] . $after;

	if( !empty($listing['FTR_UTILITIES_DESC']) )
		echo $before . 'Utilities: ' . $between . $listing['FTR_UTILITIES_DESC'] . $after;

	if( !empty($listing['FTR_ROOF_DESC']) )
		echo $before . 'Roof: '  . $between . $listing['FTR_ROOF_DESC'] . $after;
	
	if( !empty($listing['FTR_POOL_DESC']) )
		echo $before . 'Pool: ' . $between . $listing['FTR_POOL_DESC'] . $after;

	if( !empty($listing['FTR_RECREATION_DESC']) )
		echo $before . 'Recreation Area: ' . $between . $listing['FTR_RECREATION_DESC'] . $after;

	if( !empty($listing['FTR_RENT_TYPE_DESC']) )
		echo $before . 'Rent Description: ' . $between . $listing['FTR_RENT_TYPE_DESC'] . $after;

	if( !empty($listing['FTR_RENT_SOURCE_DESC']) )
		echo $before . 'Rent Source: ' . $between . $listing['FTR_RENT_SOURCE_DESC'] . $after;

	if( !empty($listing['FTR_SHOPPING_DESC']) )
		echo $before . 'Shopping Description: ' . $between . $listing['FTR_SHOPPING_DESC'] . $after;

	if( !empty($listing['FTR_TRANSPORTATION_DESC']) )
		echo $before . 'Transportation Description: ' . $between . $listing['FTR_TRANSPORTATION_DESC'] . $after;

	if( !empty($listing['FTR_SPECIAL_FEATURE_DESC']) )
		echo $before . 'Special Features: ' . $between . $listing['FTR_SPECIAL_FEATURE_DESC'] . $after;

	if( !empty($listing['FTR_STYLE_DESC']) )
		echo $before . 'Style of Home: ' . $between . $listing['FTR_STYLE_DESC'] . $after;

	if( !empty($listing['FTR_TYPE_DESC']) )
		echo $before . 'Type: ' . $between . $listing['FTR_TYPE_DESC'] . $after;

	if( !empty($listing['FTR_FIREPLACE_DESC']) )
		echo $before . 'Fireplace Description: ' . $between . $listing['FTR_FIREPLACE_DESC'] . $after;

	if( !empty($listing['FTR_MASTER_BED_DESC']) )
		echo $before . 'Master Bedroom: ' . $between . $listing['FTR_MASTER_BED_DESC'] . $after;

	if( !empty($listing['FTR_MASTER_BATH_DESC']) )
		echo $before . 'Master Bathroom: ' . $between . $listing['FTR_MASTER_BATH_DESC'] . $after;

	if( !empty($listing['FTR_BATH_DESC']) )
		echo $before . 'Bathroom: ' . $between . $listing['FTR_BATH_DESC'] . $after;

	if( !empty($listing['FTR_KITCHEN_DESC']) )
		echo $before . 'Kitchen: ' . $between . $listing['FTR_KITCHEN_DESC'] . $after;

	if( !empty($listing['FTR_MICROWAVE_DESC']) )
		echo $before . 'Microwave: ' . $between . $listing['FTR_MICROWAVE_DESC'] . $after;

	if( !empty($listing['FTR_TRASH_COMPACTOR_DESC']) )
		echo $before . 'Trash Compactor: ' . $between . $listing['FTR_TRASH_COMPACTOR_DESC'] . $after;

	if( !empty($listing['FTR_RANGE_OVEN_DESC']) )
		echo $before . 'Range Oven: ' . $between . $listing['FTR_RANGE_OVEN_DESC'] . $after;

	if( !empty($listing['FTR_REFRIG_DESC']) )
		echo $before . 'Refrigerator: ' . $between . $listing['FTR_REFRIG_DESC'] . $after;

	if( !empty($listing['FTR_STOVE_INSERT_DESC']) )
		echo $before . 'Stove: ' . $between . $listing['FTR_STOVE_INSERT_DESC'] . $after;

	if( !empty($listing['FTR_LAUNDRY_DESC']) )
		echo $before . 'Laundry: ' . $between . $listing['FTR_LAUNDRY_DESC'] . $after;

	if( !empty($listing['FTR_OTHER_ROOM_DESC']) )
		echo $before . 'Other Rooms: ' . $between . $listing['FTR_OTHER_ROOM_DESC'] . $after;

	if( !empty($listing['FTR_MISCELLANEOUS_DESC']) )
		echo $before . 'Misc: ' . $between . $listing['FTR_MISCELLANEOUS_DESC'] . $after;

	if( !empty($listing['FTR_TOPOGRAPHY_DESC']) )
		echo $before . 'Topography: ' . $between . $listing['FTR_TOPOGRAPHY_DESC'] . $after;

	if( !empty($listing['FTR_OTHER_STRUCTURE_DESC']) )
		echo $before . 'Other Structures: ' . $between . $listing['FTR_OTHER_STRUCTURE_DESC'] . $after;

	if( !empty($listing['FTR_GARAGE_DESC']) )
		echo $before . 'Garage: ' . $between . $listing['FTR_GARAGE_DESC'] . $after;

	if( !empty($listing['FTR_PARKING_DESC']) )
		echo $before . 'Parking: ' . $between . $listing['FTR_PARKING_DESC'] . $after;

	if( !empty($listing['FTR_SALE_CONDITIONS_DESC']) )
		echo $before . 'Sales Conditions: ' . $between . $listing['FTR_SALE_CONDITIONS_DESC'] . $after;

	if( !empty($listing['FTR_HOAFEEINCLUDESDESC']) )
		echo $before . 'HOA Fees: ' . $between . $listing['FTR_HOAFEEINCLUDESDESC'] . $after;

	if( !empty($listing['FTR_RESTRICTIONSDESC']) )
		echo $before . 'Restrictions: ' . $between . $listing['FTR_RESTRICTIONSDESC'] . $after;


}



/* Permalink */
function the_listing_permalink($return = false) {
	global $listing;
	//$permalink = get_option('permalink_structure');
	if( $return )
		return site_url('/?listing=' . $listing['OB_ID_PROP'] );
	else
		echo site_url('/?listing=' . $listing['OB_ID_PROP'] );
}



/* Deprecated */
function get_the_office_id() {
	global $listing;
	return $listing['MLS_OFFICE_ID'];
}

function get_the_address() {
	global $listing;
	return $listing['ADDRESS'];
}

function get_the_agent_id() {
	global $listing;
	return $listing['MLS_AGENT_ID'];
}

function get_the_mls_id() {
	global $listing;
	return $listing['MLS_LISTING_ID'];
}

function get_the_listing_id() {
	global $listing;
	if( is_lp_single() )
		return $listing['PROPERTYID'];
	else
		return $listing['OB_ID_PROP'];
}





/* Call to action links and icons */
function bookmark_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	$mls = get_the_mls_id();
	echo '<a href="javascript:;" class="lp_bookmark_listing listing_icons" id="'.$id.'" title="'.$mls.'">' . $str . '</a>';
}

function email_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	echo '<a href="javascript:;" class="lp_email_listing listing_icons" id="'.$id.'">' . $str . '</a>';
}

function print_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	echo '<a href="javascript:;" class="lp_print_listing listing_icons" id="'.$id.'">' . $str . '</a>';
}

function text_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	echo '<a href="javascript:;" class="lp_text_listing listing_icons" id="'.$id.'">' . $str . '</a>';
}

function slideshow_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	echo '<a href="javascript:;" class="lp_slideshow_listing listing_icons" id="'.$id.'">' . $str . '</a>';
}

function map_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	echo '<a href="javascript:;" class="lp_map_listing listing_icons" id="'.$id.'">' . $str . '</a>';
}

function link_to_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	echo '<a href="javascript:;" class="lp_link_listing listing_icons" id="'.$id.'">' . $str . '</a>';
}

function detail_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	echo '<a href="javascript:;" class="lp_details_listing listing_icons" id="'.$id.'">' . $str . '</a>';
}



/* Paging */
function previous_listings($str) {
	//$permalink = get_option('permalink_structure');
	$current_page = lp_current_page();
	$req = substr( $_SERVER["REQUEST_URI"], stripos($_SERVER["REQUEST_URI"], '/?'), strlen($_SERVER["REQUEST_URI"]) );
	$qv = array();
	parse_str( ltrim($req, '/?'), $qv);
	unset($qv['lpage']);
	$path = '/?';
	foreach($qv as $k => $v){ $path .= $k . '=' . $v . '&'; }
	if( $current_page > 1 ) {
		$min = $current_page - 1;
		if( $min > 1 ) { $path .= 'lpage=' . $min; }
		echo '<a href="' . site_url($path) . '">' . $str . '</a>';
	} 
}

function next_listings($str) {
	//$permalink = get_option('permalink_structure');
	$total_pages = lp_max_num_pages();
	$current_page = lp_current_page();
	$req = substr( $_SERVER["REQUEST_URI"], stripos($_SERVER["REQUEST_URI"], '/?'), strlen($_SERVER["REQUEST_URI"]) );
	$qv = array();
	parse_str( ltrim($req, '/?'), $qv);
	unset($qv['lpage']);
	$path = '/?';
	foreach($qv as $k => $v){ $path .= $k . '=' . $v . '&'; }
	if( $current_page < $total_pages ) {
		$add = $current_page + 1;
		$path .= 'lpage=' . $add;
		echo '<a href="' . site_url($path) . '">' . $str . '</a>';
	}
}



/* Google map and cooliris wall */
function the_google_map($width, $height) {
	$width = ( !empty($width) ) ? $width : 500;
	$height = ( !empty($height) ) ? $height : 300;
	echo '<div id="lp_google_map_box"><div id="lp_google_map" style="display:block;width:'.$width.'px;height:'.$height.'px;"></div></div>';
}

function the_image_wall($width, $height) {
	global $lp_query;
	$q = $lp_query->query;
	$q .= '&showlistings=1000&display=mediarss';
	$url = site_url( 'index.php?' . $q );
	$url = urlencode( $url );
	
	$width = ( !empty($width) ) ? $width : 500;
	$height = ( !empty($height) ) ? $height : 300;
	echo '<a href="javascript:;" id="pop_lp_image_wall">Pop Out The Wall</a><div id="lp_image_wall_box"><div id="lp_image_wall" style="display:block;width:'.$width.'px;height:'.$height.'px;"></div></div>';
	echo '<script type="text/javascript">
			jQuery(document).ready(function($){
				var flashvars = {
    				feed: "'.$url.'",
					style: "light"
				};
				var params = {
    				allowscriptaccess: "always",
					allowFullScreen: "true",
					wmode: "transparent"
				};

				swfobject.embedSWF("http://apps.cooliris.com/embed/cooliris.swf",
                   "lp_image_wall", "'.$width.'", "'.$height.'", "9.0.0", "", 
                   flashvars, params);
			});
			</script>';
}



/* Look Ups */
function city_state_select_menu() {
	$cities = lp_lookup_cities();
	foreach( $cities as $city ){
		echo "<option value='" . urlencode($city['CITY_STATE']) . "'>" . $city['CITY_STATE'] . "</option>\n";
	}
}

function prop_types_select_menu() {
	$props = lp_lookup_property_types();
	foreach( $props as $v ) {
		echo "<option value='" . $v['LISTING_TYPE'] . "'>" . $v['LISTING_TYPE'] . "</option>\n";
	}
}

function prop_types_checkboxes() {
	$props = lp_lookup_property_types(); 
	$html = '<ul>';
	foreach( $props as $prop ) {
		$html .= '<li><input type="checkbox" name="property_types[]" id="lp_' . sanitize_title($prop['LISTING_TYPE']) . '" value="lp_' . sanitize_title($prop['LISTING_TYPE']) . '" /> <label for="lp_' . sanitize_title($prop['LISTING_TYPE']) . '">' . $prop['LISTING_TYPE'] . '</label></li>';
	}
	$html .= '</ul>';
	echo $html;
}

function features_select_menu() {
	$feats = lp_lookup_searchable_features();
	foreach( $feats as $feat ) {
		echo "<option value='" . $feat['FEATURENAME'] . "'>" . $feat['FEATURENAME'] . "</option>\n";
	}
}

function features_checkboxes() {
	$feats = lp_lookup_searchable_features(); 
	$html = '<ul>';
	foreach( $feats as $feat ) {
		$html .= '<li><input type="checkbox" name="property_types[]" id="lp_' . sanitize_title($feat['FEATURENAME']) . '" value="lp_' . sanitize_title($feat['FEATURENAME']) . '" /> <label for="lp_' . sanitize_title($feat['FEATURENAME']) . '">' . $feat['FEATURENAME'] . '</label></li>';
	}
	$html .= '</ul>';
	echo $html;
}

?>