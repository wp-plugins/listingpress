<?php

function the_google_map($width, $height) {
	$width = ( !empty($width) ) ? $width : 500;
	$height = ( !empty($height) ) ? $height : 300;
	echo '<a href="javascript:;" id="pop_lp_google_map">Pop Out Map</a><div id="lp_google_map_box"><div id="lp_google_map" style="display:block;width:'.$width.'px;height:'.$height.'px;"></div></div>';
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

function listing_has_images() {
	global $listing;
	$bool = false;
	$bool = ( $listing['OB_PHOTO_COUNT'] > 0 ) ? true : false;
	return $bool;
}

function the_photo_count() {
	global $listing;
	echo $listing['OB_PHOTO_COUNT'];
}

function the_listing_id() {
	global $listing;
	if( is_lp_single() )
		echo $listing['PROPERTYID'];
	else
		echo $listing['OB_ID_PROP'];
}

function the_address() {
	global $listing;
	echo $listing['OB_ADDRESS'];
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

function the_bedrooms() {
	global $listing;
	echo $listing['BEDROOMS'];
}

function the_bathrooms() {
	global $listing;
	echo $listing['BATHS_TOTAL'];
}

function the_sales_price() {
	global $listing;
	echo '$' . number_format($listing['SALE_PRICE'], 2);
}

function the_mls_id() {
	global $listing;
	echo $listing['MLS_LISTING_ID'];
}

function the_property_type() {
	global $listing;
	echo $listing['STANDARDPROPERTYTYPE'];
}

function the_property_type_description() {
	global $listing;
	echo $listing['PROPERTY_TYPE_DESCRIPTION'];
}

function the_sqft() {
	global $listing;
	echo $listing['SQUARE_FOOTAGE_BUILDING'];
}

function the_lot_size() {
	global $listing;
	echo $listing['SQUARE_FOOTAGE_LOT'];
}

function the_year_built() {
	global $listing;
	echo $listing['YEAR_BUILT'];
}

function the_remarks() {
	global $listing;
	echo $listing['MARKETING_REMARKS'];
}

function the_status() {
	global $listing;
	echo $listing['STATUS'];
}

function the_view() {
	global $listing;
	echo $listing['FTR_VIEWS_DESC'];
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

function the_sewer() {
	global $listing;
	echo $listing['FTR_WATER_SEWER_DESC'];
}

function the_water() {
	global $listing;
	echo $listing['FTR_WATERSOURCE_DESC'];
}

function the_roof() {
	global $listing;
	echo $listing['FTR_ROOF_DESC'];
}

function the_pool() {
	global $listing;
	echo $listing['FTR_POOL_DESC'];
}

function the_type() {
	global $listing;
	echo $listing['FTR_TYPE_DESC'];
}

function the_kitchen() {
	global $listing;
	echo $listing['FTR_KITCHEN_DESC'];
}

function the_laundry() {
	global $listing;
	echo $listing['FTR_LAUNDRY_DESC'];
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

function the_restrictions() {
	global $listing;
	echo $listing['FTR_RESTRICTIONSDESC'];
}

function the_office() {
	global $listing;
	echo $listing['MLS_OFFICE_NAME']; 
}

function the_dom() {
	global $listing;
	echo $listing['DOM'];
}

function the_listing_date() {
	global $listing;
	echo $listing['OB_LISTING_DATE'];
}

function the_hoa_fees() {
	global $listing;
	echo $listing['FTR_HOAFEEINCLUDESDESC'];
}

function the_sales_conditions() {
	global $listing;
	echo $listing['FTR_SALE_CONDITIONS_DESC'];
}

function the_special_features() {
	global $listing;
	echo $listing['FTR_SPECIAL_FEATURE_DESC'];
}

function the_style() {
	global $listing;
	echo $listing['FTR_STYLE_DESC'];
}

function the_fireplace() {
	global $listing;
	echo $listing['FTR_FIREPLACE_DESC'];
}

function the_other_rooms() {
	global $listing;
	echo $listing['FTR_OTHER_ROOM_DESC'];
}

function the_latitude() {
	global $listing;
	echo $listing['OB_LATITUDE'];
}

function the_longitude() {
	global $listing;
	echo $listing['OB_LONGITUDE'];
}

function the_listing_permalink() {
	global $listing;
	echo site_url('/listing/' . $listing['OB_ID_PROP'] . '/');
}

function get_the_feed_id() {
	global $listing;
	return $listing['FEED'];
}

function get_the_office_id() {
	global $listing;
	return $listing['MLS_OFFICE_ID'];
}

function get_the_agent_id() {
	global $listing;
	return $listing['MLS_AGENT_ID'];
}

function get_the_photo_count() {
	global $listing;
	return $listing['OB_PHOTO_COUNT'];
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

function bookmark_this_listing($str) {
	global $listing;
	$id = get_the_listing_id();
	echo '<a href="javascript:;" class="lp_bookmark_listing listing_icons" id="'.$id.'">' . $str . '</a>';
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

function get_the_listing_photos($num,$size) {
	$mls = get_the_mls_id();
	$feed = get_the_feed_id();
	$c = get_the_photo_count();
	$count = ( !empty($num) && $num <= $c && $num != 0 ) ? $num : $c;
	switch( $size ) {
		case 'small':
			$s = 'p123_82';
		break;
		case 'medium':
			$s = 'p279_186';
		break;
		case 'large':
			$s = 'raw';
		break;
		default:
			$s = 'p279_186';
		break;
	}
	
	$images = array();
	for( $i = 0; $i < $count; $i++ ) {
		$images[$i] = 'http://betaImages.brokerdigest.com/listings/' . $feed . '/photos/' . $s . '/' . $mls . '_';
		$thumb = ($s == 'p123_82') ? 't' : '';
		if( $i < 9 )
			$images[$i] .= '0' . ($i + 1) . $thumb . '.jpg';
		else 
			$images[$i] .= ($i + 1) . $thumb . '.jpg';
	}
	return $images;
}

function the_listing_photos($num,$size) {
	$photos = get_the_listing_photos($num,$size);
	if( is_array($photos) ) {
		foreach( $photos as $photo ) {
			echo '<img src="'.$photo.'" class="listing-photo" />';
		}
	}
}

function previous_listings($str) {
	$current_page = lp_current_page();
	$pos = strpos($_SERVER["REQUEST_URI"], 'page');
	$uri = substr($_SERVER["REQUEST_URI"], 0, $pos);
	if( $current_page > 1 ) {
		$min = $current_page - 1;
		$path = ( $min > 1 ) ? $uri . 'page/' . $min . '/' : $uri;
		echo '<a href="' . site_url($path) . '">' . $str . '</a>';
	} 
}

function next_listings($str) {
	$total_pages = lp_max_num_pages();
	$current_page = lp_current_page();
	$pos = strpos($_SERVER["REQUEST_URI"], 'page');
	$uri = ( $pos ) ? substr($_SERVER["REQUEST_URI"], 0, $pos) : $_SERVER["REQUEST_URI"];
	if( $current_page < $total_pages ) {
		$add = $current_page + 1;
		$path = $uri . 'page/' . $add . '/';
		echo '<a href="' . site_url($path) . '">' . $str . '</a>';
	}
}

/** Look Ups **/

function prop_types_select_menu() {
	$props = lp_lookup_property_types();
	foreach( $props as $v ) {
		echo "<option value='" . $v['LISTING_TYPE'] . "'>" . $v['LISTING_TYPE'] . "</option>\n";
	}
}

?>