<?php

function lp_template() {
	global $wp;
	query_listings($wp->query_string);
		
	if( is_lp_media_rss() && file_exists( dirname(__FILE__) . "/includes/mediarss.php" ) ) {
		include( dirname(__FILE__) . "/includes/mediarss.php" );
		exit;
	}	
	else if( is_lp_single() && file_exists(TEMPLATEPATH . "/listing.php") ) {
		include(TEMPLATEPATH . "/listing.php");
		exit;
	}
	else if( is_lp_search() && file_exists(TEMPLATEPATH . "/listings.php") ) {
		include(TEMPLATEPATH . "/listings.php");
		exit;
	}
}
add_action( 'template_redirect', 'lp_template' );

global $lpvars;	
if( !empty($lpvars['lp_maps']) && !is_admin() ) {
	$path = 'http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key='. $lpvars['lp_maps'];
	$jmaps = plugins_url('ListingPress/resources/js/jquery.jmap.min.js');

	wp_enqueue_script( 'LP_GMaps', $path, '', '2.0' );
	wp_enqueue_script( 'jmaps', $jmaps, '', '0.72' );

	function lp_footer(){
		if( is_lp_single() || is_lp_search() ) {
			$json = lp_json_results(); 
			
			//lp_ajax_login_form();

			echo "<script type=\"text/javascript\">
			
			function addCommas(nStr) {
				nStr += '';
				x = nStr.split('.');
				x1 = x[0];
				x2 = x.length > 1 ? '.' + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + ',' + '$2');
				}
				return x1 + x2;
			}
			
			jQuery(document).ready(function($){
				
				var map = $('#lp_google_map');
				var listings = " . $json . ";
				
				map.jmap('init', {
					'mapType': 'map',
					'mapCenter': [listings[0].OB_LATITUDE, listings[0].OB_LONGITUDE],
					'mapZoom': 13,
					'mapControl': 'none',
					'mapEnableType': false,
					'mapEnableOverview': false,
					'mapEnableDragging': true,
					'mapEnableInfoWindows': true,
					'mapEnableDoubleClickZoom': true,
					'mapEnableScrollZoom': true,
					'mapEnableSmoothZoom': true,
					'mapEnableGoogleBar': false,
					'mapEnableScaleControl': false,
					'mapShowjMapsIcon': false,
					'mapUI': true,
					'debugMode': false
				},function(thisMap){
					thisMap.setUIToDefault();
				});
				
				map.jmap('CreateMarkerManager', { 'borderPadding': 10 });
				
				for( var i = 0; i < listings.length; i++ ) {
					
					var d = listings[i].SALE_PRICE.indexOf('.');
					var p = addCommas( listings[i].SALE_PRICE.substring(0,d) );
					
					var myhtml = '<div class=\"gmap_bubble\"><img src=\"http://betaImages.brokerdigest.com/listings/' + listings[i].FEED + '/photos/p123_82/' + listings[i].MLS_LISTING_ID + '_01t.jpg\" /><ul><li><strong>$' + p + '</strong></li><li>' + listings[i].OB_ADDRESS + '</li><li>' + listings[i].OB_CITY + ', ' + listings[i].OB_STATE + ' ' + listings[i].OB_ZIP + '</li><li>' + listings[i].BEDROOMS + ' beds, ' + listings[i].BATHS_TOTAL + ' baths</li><li>' + listings[i].STANDARDPROPERTYTYPE + '</li></ul></div>'; 
					map.jmap('AddMarker', {
						'pointLatLng': [listings[i].OB_LATITUDE, listings[i].OB_LONGITUDE],
						'pointHTML': myhtml,
						'pointMinZoom': 12
					});
				
				}
				
				$('a#pop_lp_google_map').click(function(){
					
					var preWidth = $('#lp_google_map').width();
					var preHeight = $('#lp_google_map').height();
					
					var thisMap = Mapifies.MapObjects.Get('#lp_google_map');
					
					var listen = GEvent.addListener(thisMap, 'moveend', function(){
						var center = this.getCenter();
						var lat = center.lat(); 
						var lng = center.lng();
						//GLog.write( 'lat: ' + lat + 'lng: ' + lng );
					});
					
					$('#lp_google_map').dialog({
						width: 800,
						height: 500,
						buttons: {
							'Pop In': function() {
								$(this).dialog('destroy');
								$(this).appendTo('#lp_google_map_box').css({
									'height':preHeight,
									'width':preWidth
								}).show();
								GEvent.removeListener(listen);
								
							}
						},
						resizeStop: function() {
							$('#lp_google_map').jmap('CheckResize');
						},
						beforeclose: function() {
							$(this).dialog('destroy');
							$(this).appendTo('#lp_google_map_box').css({
								'height':preHeight,
								'width':preWidth
							}).show();
							GEvent.removeListener(listen);
						}
					});
					
				});
				
				
			});
			window.onunload = GUnload;
		</script>\n";
		}
	}
	add_action('wp_footer','lp_footer');
}

?>