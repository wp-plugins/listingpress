<?php

function lp_gmaps() {
	
	if( is_lp_single() || is_lp_search() )
			$json = lp_json_results(); 

?>

<script type="text/javascript">

	var LPMaps;
	if (!LPMaps) LPMaps = {};
	LPMaps.map = {};
	
	LPMaps.listings = <?php echo $json; ?>;
		
	/**
	* Different Google Map Panes in order from lowest to highest
	* G_MAP_MAP_PANE, G_MAP_OVERLAY_LAYER_PANE, G_MAP_MARKER_SHADOW_PANE, G_MAP_MARKER_PANE, G_MAP_FLOAT_SHADOW_PANE, G_MAP_MARKER_MOUSE_TARGET_PANE, G_MAP_FLOAT_PANE 
	**/ 
	
	LPMaps.resize = function() {
		LPMaps.map.checkResize();
	};
	
	LPMaps.addCommas = function(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	};
		
	LPMaps.latlng = function(lat,lng) {
		return new google.maps.LatLng(lat,lng);
	};
		
	LPMaps.latlngbounds = function(sw,ne) {
		return new google.maps.LatLngBounds(sw,ne);
	};
		
	LPMaps.size = function(width,height) {
		return new google.maps.Size(width,height);
	};
		
	LPMaps.point = function(x,y) {
		return new google.maps.Point(x,y);
	};
		
	LPMaps.tab = function(label,html) {
		return new google.maps.InfoWindowTab(label,html);
	};
	
	LPMaps.createMarker = function(latlng, myhtml) {
		var marker = new google.maps.Marker(latlng);
		 google.maps.Event.addListener( marker, "click", function(){
			LPMaps.map.openInfoWindowHtml( latlng, myhtml );
		});
		return marker;
	};
	
		
	LPMaps.init = function() {
		if( google.maps.BrowserIsCompatible() ) {
			LPMaps.map = new google.maps.Map2( document.getElementById('lp_google_map') );
			LPMaps.map.enableContinuousZoom();
			LPMaps.map.enableScrollWheelZoom();
			LPMaps.map.setUIToDefault();
			LPMaps.map.setCenter( LPMaps.latlng(LPMaps.listings[0].OB_LATITUDE, LPMaps.listings[0].OB_LONGITUDE), 13 );
			
			for( var i = 0; i < LPMaps.listings.length; i++ ) {
				var latlng = LPMaps.latlng( LPMaps.listings[i].OB_LATITUDE, LPMaps.listings[i].OB_LONGITUDE );
				var img = 'http://images.obiwebservices.com/listings/' + LPMaps.listings[i].FEED + '/thumbs/' + LPMaps.listings[i].OB_PHOTO_PRIMARY;
				
				var myhtml = '<div style="width:250px;height:150px;"><div style="float:left;margin-right:10px;"><img src="' + img + '" /></div><p><strong>Sales Price: ' + LPMaps.listings[i].SALE_PRICE + '</strong><br />Address: ' + LPMaps.listings[i].ADDRESS + '<br />City: ' + LPMaps.listings[i].CITY + '<br />State: ' + LPMaps.listings[i].STATE_ABBREV + '<br />Zip Code: ' + LPMaps.listings[i].ZIP5 + '<br />Bedrooms: ' + LPMaps.listings[i].BEDROOMS + '<br />Bathrooms: ' + LPMaps.listings[i].BATHS_TOTAL + '</p><div style="clear:both;"></div></div>';
				
				LPMaps.map.addOverlay( LPMaps.createMarker( latlng, myhtml ) );
			}
			
	
			/*
			var geo = new google.maps.ClientGeocoder();
			geo.getLatLng('6713 Cowles Mountain Blvd San Diego, CA',function(latlng){
				LPMaps.map.setCenter( latlng, 13 );
			});
			
			GLog.write();
			*/	
			//LPMaps.mgr = new google.maps.MarkerManager(LPMaps.map);
				
			//GEvent.addListener(LPMaps.map, 'moveend', function(){
				/*
				GLog.write(LPMaps.map.getCenter());
				GLog.write(LPMaps.map.getBounds());
				GLog.write(LPMaps.map.getSize());
				GLog.write(LPMaps.map.getZoom());
				*/
			
				/*
				if( LPMaps.map.getZoom() > 13 ) {
					var center = LPMaps.map.getCenter();
					var lat = center.lat(); 
					var lng = center.lng();
					$.get('/',
						{
							center_lat: lat,
							center_lon: lng,
							distance: 2,
							showlistings: 100,
							limit: 100,
							display: 'json'
						}, function(d){
								
							LPMaps.mgr.clearMarkers();
							var markers = [];
							for( var i = 0; i < d.length; i++ ) {
								markers.push( new google.maps.Marker( new google.maps.LatLng( d[i].OB_LATITUDE, d[i].OB_LONGITUDE ) ) );
							}
							GLog.write(markers.length);
							LPMaps.mgr.addMarkers(markers, 13);
							//LPMaps.mgr.refresh();
						}, 'json');
				}
				*/
			//});
			
			//LPMaps.bounds = new google.maps.Bounds(points);
									
		} else {
			jQuery('#googleMap').text('Your browser does not support Google Maps.');
		}
			
		window.onunload = google.maps.Unload;
	};
		//LPMaps.markerManager();
			/*
			LPMaps.listen = google.maps.Event.addListener(LPMaps.map, 'moveend', function(){
				var center = LPMaps.map.getCenter();
				var lat = center.lat(); 
				var lng = center.lng();
				LPMaps.fetchListings(lat,lng,10,100);	
					
			});
			*/
		/*
		LPMaps.fetchListings = function(lat,lng,dis,num) {
			$.get('/index.php',
				{
					center_lat: lat,
					center_lon: lng,
					distance: dis,
					proptype: 'Single Family',
					showlistings: num,
					limit: num,
					display: 'json'
				}, function(d){
					console.log(d);
					LPMaps.markers = [];
					for( var i = 0; i < d.length; i++ ) {
						GLog.write(d[i].OB_LATITUDE + ', ' + d[i].OB_LONGITUDE);
						LPMaps.markers.push( LPMaps.createMarker( LPMaps.latLng( d[i].OB_LATITUDE, d[i].OB_LONGITUDE ) ) );
					}
					LPMaps.clearMarkers();
					LPMaps.addMarkers();
				}, 'json');
		};
		
		
		

		
		LPMaps.addMarkers = function() {
			LPMaps.mgr.addMarkers(LPMaps.markers, 13);
			LPMaps.refresh();
		};
		

			
		
		
		LPMaps.markerManager = function() {
			LPMaps.mgr = new MarkerManager(LPMaps.map);	
		};
		
		LPMaps.clearMarkers = function() {
			LPMaps.mgr.clearMarkers();
		};
		
		LPMaps.refresh = function() {
			LPMaps.mgr.refresh();
		 	return true;
		};
		
		LPMaps.removeListener = function() {
			google.maps.Event.removeListener(LPMaps.listen);
		};
		*/
		/*
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
		
		function loadScript() {
			var script = document.createElement("script");
			script.src = "<?php echo $js; ?>";
			script.type = "text/javascript";
			document.getElementsByTagName("head")[0].appendChild(script);
		}
		
		
		function openMap() {
			jQuery('#googleMap').dialog('open');
			LPMaps.resize();
		}
		
		function closeMap() {
			jQuery('#googleMap').dialog('close');
		}
		
		jQuery(document).ready(function($){
			
			loadScript();
			$('#menu_bar_map_search').click(openMap);
			$('#googleMap').dialog({
				autoOpen: false,
				width: 600,
				height: 400,
				resizeStop: LPMaps.resize
			}).css({ 'margin': '1px', 'margin-top': '2px' });
			$('.ui-dialog-titlebar').removeClass('ui-corner-all').addClass('ui-corner-top');
		});

*/


	google.load("maps", "2");
	google.setOnLoadCallback(LPMaps.init);

</script>

<?php
	
}
add_action('wp_footer','lp_gmaps');

if( !is_admin() ) {
	$gmaps = 'http://www.google.com/jsapi?key=' . LP_GMAP_API;
	wp_enqueue_script( 'gmaps', $gmaps, '', '2.0' );
}


/*
global $lpvars;	
if( !empty($lpvars['lp_maps']) && !is_admin() ) {
	$path = 'http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key='. $lpvars['lp_maps'];
	$jmaps = plugins_url('listingpress/resources/js/jquery.jmap.min.js');

	wp_enqueue_script( 'LP_GMaps', $path, '', '2.0' );
	wp_enqueue_script( 'jmaps', $jmaps, '', '0.72' );

	function lp_footer(){
		if( is_lp_single() || is_lp_search() ) {
			$json = lp_json_results(); 
			
			//lp_ajax_login_form();
			echo '<p class="credits">Listings Powered By ListingPress and Onboard Informatics &copy; 2009</p>';
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
*/

/*
global $lpvars;	
if( !empty($lpvars['lp_maps']) && !is_admin() ) {
	$path = 'http://maps.google.com/maps?file=api&v=2&sensor=true&key='. $lpvars['lp_maps'];
	wp_enqueue_script( 'LP_GMaps', $path, '', '2.0' );
	$jmaps = plugins_url('listingpress/resources/js/jquery.jmap.min.js');
	wp_enqueue_script( 'jmaps', $jmaps, '', '0.72' );
	
	//$google = 'http://www.google.com/jsapi?key=' . $lpvars['lp_maps'];
	//wp_enqueue_script( 'google', $google, '', '2.0' );
}
*/
/*
function lp_header() {
	$js = plugins_url('listingpress/resources/js/markermanager.js');
?>

	<script type="text/javascript">
		var LPMaps;
		if (!LPMaps) LPMaps = {};
		LPMaps.map = {};
		
		/**
		* Different Google Map Panes in order from lowest to highest
		* G_MAP_MAP_PANE, G_MAP_OVERLAY_LAYER_PANE, G_MAP_MARKER_SHADOW_PANE, G_MAP_MARKER_PANE, G_MAP_FLOAT_SHADOW_PANE, G_MAP_MARKER_MOUSE_TARGET_PANE, G_MAP_FLOAT_PANE 
		**/ 
		/*
		LPMaps.resize = function() {
			LPMaps.map.checkResize();
		};
		
		LPMaps.latlng = function(lat,lng) {
			return new google.maps.LatLng(lat,lng);
		};
		
		LPMaps.latlngbounds = function(sw,ne) {
			return new google.maps.LatLngBounds(sw,ne);
		};
		
		LPMaps.size = function(width,height) {
			return new google.maps.Size(width,height);
		};
		
		LPMaps.point = function(x,y) {
			return new google.maps.Point(x,y);
		};
		
		LPMaps.tab = function(label,html) {
			return new google.maps.InfoWindowTab(label,html);
		};
	
		
		LPMaps.init = function() {
			if( google.maps.BrowserIsCompatible() ) {
				LPMaps.map = new google.maps.Map2( document.getElementById('googleMap') );
				LPMaps.map.enableContinuousZoom();
				LPMaps.map.enableScrollWheelZoom();
				LPMaps.map.setUIToDefault();

				var geo = new google.maps.ClientGeocoder();
				geo.getLatLng('6713 Cowles Mountain Blvd San Diego, CA',function(latlng){
					LPMaps.map.setCenter( latlng, 13 );
				});
				
				LPMaps.mgr = new google.maps.MarkerManager(LPMaps.map);
				
				GEvent.addListener(LPMaps.map, 'moveend', function(){
					/*
					GLog.write(LPMaps.map.getCenter());
					GLog.write(LPMaps.map.getBounds());
					GLog.write(LPMaps.map.getSize());
					GLog.write(LPMaps.map.getZoom());
					*/
					/*
					if( LPMaps.map.getZoom() > 13 ) {
						var center = LPMaps.map.getCenter();
						var lat = center.lat(); 
						var lng = center.lng();
						$.get('/',
							{
								center_lat: lat,
								center_lon: lng,
								distance: 2,
								showlistings: 100,
								limit: 100,
								display: 'json'
							}, function(d){
								
								LPMaps.mgr.clearMarkers();
								var markers = [];
								for( var i = 0; i < d.length; i++ ) {
									markers.push( new google.maps.Marker( new google.maps.LatLng( d[i].OB_LATITUDE, d[i].OB_LONGITUDE ) ) );
								}
								GLog.write(markers.length);
								LPMaps.mgr.addMarkers(markers, 13);
								//LPMaps.mgr.refresh();
							}, 'json');
					}
				});

				
				//LPMaps.bounds = new google.maps.Bounds(points);
									
			} else {
				jQuery('#googleMap').text('Your browser does not support Google Maps.');
			}
			
			window.onunload = google.maps.Unload;
		};
		//LPMaps.markerManager();
			/*
			LPMaps.listen = google.maps.Event.addListener(LPMaps.map, 'moveend', function(){
				var center = LPMaps.map.getCenter();
				var lat = center.lat(); 
				var lng = center.lng();
				LPMaps.fetchListings(lat,lng,10,100);	
					
			});
			*/
		/*
		LPMaps.fetchListings = function(lat,lng,dis,num) {
			$.get('/index.php',
				{
					center_lat: lat,
					center_lon: lng,
					distance: dis,
					proptype: 'Single Family',
					showlistings: num,
					limit: num,
					display: 'json'
				}, function(d){
					console.log(d);
					LPMaps.markers = [];
					for( var i = 0; i < d.length; i++ ) {
						GLog.write(d[i].OB_LATITUDE + ', ' + d[i].OB_LONGITUDE);
						LPMaps.markers.push( LPMaps.createMarker( LPMaps.latLng( d[i].OB_LATITUDE, d[i].OB_LONGITUDE ) ) );
					}
					LPMaps.clearMarkers();
					LPMaps.addMarkers();
				}, 'json');
		};
		
		
		
		LPMaps.createMarker = function(point) {
			return new google.maps.Marker(point); 
		};
		
		LPMaps.addMarkers = function() {
			LPMaps.mgr.addMarkers(LPMaps.markers, 13);
			LPMaps.refresh();
		};
		

			
		
		
		LPMaps.markerManager = function() {
			LPMaps.mgr = new MarkerManager(LPMaps.map);	
		};
		
		LPMaps.clearMarkers = function() {
			LPMaps.mgr.clearMarkers();
		};
		
		LPMaps.refresh = function() {
			LPMaps.mgr.refresh();
		 	return true;
		};
		
		LPMaps.removeListener = function() {
			google.maps.Event.removeListener(LPMaps.listen);
		};
		*/
		/*
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
		
		function loadScript() {
			var script = document.createElement("script");
			script.src = "<?php echo $js; ?>";
			script.type = "text/javascript";
			document.getElementsByTagName("head")[0].appendChild(script);
		}
		
		
		function openMap() {
			jQuery('#googleMap').dialog('open');
			LPMaps.resize();
		}
		
		function closeMap() {
			jQuery('#googleMap').dialog('close');
		}
		
		jQuery(document).ready(function($){
			
			loadScript();
			$('#menu_bar_map_search').click(openMap);
			$('#googleMap').dialog({
				autoOpen: false,
				width: 600,
				height: 400,
				resizeStop: LPMaps.resize
			}).css({ 'margin': '1px', 'margin-top': '2px' });
			$('.ui-dialog-titlebar').removeClass('ui-corner-all').addClass('ui-corner-top');
		});
		
		google.load("maps", "2");
		google.setOnLoadCallback(LPMaps.init);
	</script>
	
<?php	
}	
//add_action('wp_head','lp_header');



function lp_footer_test() {
?>

<div id="googleMap" style="width:600px;height:400px;display:none;"></div>

<?php	
}
//add_action('wp_footer','lp_footer_test');

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
//add_action('wp_footer','lp_footer');
*/

?>