jQuery(function($) {
	/*
	$('#searchCityClick').click(function(){
		$('.searchMenuTab').removeClass('current');
		$(this).addClass('current');
		$('.advSearchBox').hide();
		$('#citySearch').show();
	});
	$('#searchZipClick').click(function(){
		$('.searchMenuTab').removeClass('current');
		$(this).addClass('current');
		$('.advSearchBox').hide();
		$('#zipSearch').show();
	});
	$('#searchNeighborhoodClick').click(function(){
		$('.searchMenuTab').removeClass('current');
		$(this).addClass('current');
		$('.advSearchBox').hide();
		$('#neighborhoodSearch').show();
	});
	$('#refineSearchClick').click(function(){
		$('.searchMenuTab').removeClass('current');
		$(this).addClass('current');
		$('.advSearchBox').hide();
		$('#refineSearch').show();
	});
	
	


	$("#zip_search_input").tokenInput("/wp-content/themes/ListingPressArtemis/template/lookup_ajax.php?in=zip", {
		hintText: "Searching for homes is easy! Just start typing the zip codes you want to search in.",
	    noResultsText: "Unfortunately, there aren't any listings in this zip code.",
	    searchingText: "Searching...",
	    classes: {
	        tokenList: "token-input-list-facebook",
	        token: "token-input-token-facebook",
	        tokenDelete: "token-input-delete-token-facebook",
	        selectedToken: "token-input-selected-token-facebook",
	        highlightedToken: "token-input-highlighted-token-facebook",
	        dropdown: "token-input-dropdown-facebook",
	        dropdownItem: "token-input-dropdown-item-facebook",
	        dropdownItem2: "token-input-dropdown-item2-facebook",
	        selectedDropdownItem: "token-input-selected-dropdown-item-facebook",
	        inputToken: "token-input-input-token-facebook"
	    }
	 });
	
	$("#neighborhood_search_input").tokenInput("/wp-content/themes/ListingPressArtemis/template/lookup_ajax.php?in=areas", {
		hintText: "Searching for homes is easy! Just start typing the neighborhood you want to search in.",
	    noResultsText: "Unfortunately, there aren't any listings in this neighborhood.",
	    searchingText: "Searching...",
		minChars: 3,
	    classes: {
	        tokenList: "token-input-list-facebook",
	        token: "token-input-token-facebook",
	        tokenDelete: "token-input-delete-token-facebook",
	        selectedToken: "token-input-selected-token-facebook",
	        highlightedToken: "token-input-highlighted-token-facebook",
	        dropdown: "token-input-dropdown-facebook",
	        dropdownItem: "token-input-dropdown-item-facebook",
	        dropdownItem2: "token-input-dropdown-item2-facebook",
	        selectedDropdownItem: "token-input-selected-dropdown-item-facebook",
	        inputToken: "token-input-input-token-facebook"
	    }
	 });

	$("#property_type_input").tokenInput("/wp-content/themes/ListingPressArtemis/template/lookup_ajax.php?in=props", {
		hintText: "Select the types of properties you would like to include.",
	    noResultsText: "Unfortunately, there aren't any properties that type.",
	    searchingText: "Searching...",
	    classes: {
	        tokenList: "token-input-list-facebook",
	        token: "token-input-token-facebook",
	        tokenDelete: "token-input-delete-token-facebook",
	        selectedToken: "token-input-selected-token-facebook",
	        highlightedToken: "token-input-highlighted-token-facebook",
	        dropdown: "token-input-dropdown-facebook",
	        dropdownItem: "token-input-dropdown-item-facebook",
	        dropdownItem2: "token-input-dropdown-item2-facebook",
	        selectedDropdownItem: "token-input-selected-dropdown-item-facebook",
	        inputToken: "token-input-input-token-facebook"
	    }
	 });


	
	$('a#search_homes_submit').click(function(){
		
		
		var features = '';
		$('.checkbox').each(function(){
			if( $(this).children('span').hasClass('lpchecked') ) {
				features += $(this).text().replace(/^\s*|\s*$/g,'') + '|';
			}
		});
		
		var img = '<img src="/wp-content/themes/ListingPressArtemis/images/ajax.gif" id="waitingImage" />';
		$('div#listingAjaxContainer').empty().append(img);
		$('img#waitingImage').css({
			'position': 'relative',
			'top': '50px',
			'left': '100px'
		});
		
		$.get('/wp-content/themes/ListingPressArtemis/template/search_ajax.php',
		{
			'citystate': $('#city_search_input').val(),
			'zipstate': $('#zip_search_input').val(),
			'searchable': $('#neighborhood_search_input').val(),
			'proptype': $('#property_type_input').val(),
			'minprice': $('#minprice').val(),
			'maxprice': $('#maxprice').val(),
			'beds': $('#beds').val(),
			'baths': $('#baths').val(),
			'minsize': $('#minsize').val(),
			'maxsize': $('#maxsize').val(),
			'minyear': $('#minyear').val(),
			'maxyear': $('#maxyear').val(),
			'features': features
		}, function(r){
			$('div.listingsHeader').html('<h2>Listings</h2><span id="viewOptions"><span id="thumbview" class="changeListingView"></span><span id="listview" class="changeListingView"></span></span>');
			$('#thumbview').bind('click',listingsView);
			$('#listview').bind('click',listingsView);
			$('div#listingAjaxContainer').attr('class','');
			$('div#listingAjaxContainer').empty().append(r).addClass('thumbViewLayout');
		});
		

	});
	
	
	$('#priceSlider').slider({
	 	range: true,
	 	values: [0,10000000],
		step: 1000,
	 	min: 0,
	 	max: 10000000,
		orientation: 'horizontal',
	 	slide: function(e,ui) {
			$("#minprice").val('$' + addCommas(ui.values[0]) );
			$("#maxprice").val('$' + addCommas(ui.values[1]) );
		}
	 });
	 
	$('#bedsSlider').slider({
	 	range: 'min',
	 	value: 0,
	 	step: 1,
	 	min: 0,
	 	max: 10,
	 	orientation: 'horizontal',
		slide: function(e,ui) {
			if( ui.value == 10 ) {
				$("#beds").val('10+');
			}
			else {
				$("#beds").val(ui.value);
			}
		}
	});
	 
	$('#bathsSlider').slider({
	 	range: 'min',
	 	value: 0,
	 	step: 1,
	 	min: 0,
	 	max: 10,
	 	orientation: 'horizontal',
		slide: function(e,ui) {
			if( ui.value == 10 ) {
				$("#baths").val('10+');
			}
			else {
				$("#baths").val(ui.value);
			}
		}
	 });
	 
	$('#sizeSlider').slider({
	 	range: true,
	 	values: [0,5000],
	 	step: 100,
	 	min: 0,
	 	max: 5000,
	 	orientation: 'horizontal',
		slide: function(e,ui) {
			$('#minsize').val( addCommas(ui.values[0]) );
			$('#maxsize').val( addCommas(ui.values[1]) );
		}
	 });
	 
	$('#yearSlider').slider({
	 	range: true,
	 	values: [1920,2009],
 		step: 1,
	 	min: 1920,
	 	max: 2009,
	 	orientation: 'horizontal',
		slide: function(e,ui) {
			$('#minyear').val(ui.values[0]);
			$('#maxyear').val(ui.values[1]);
		}
	 });
	
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

  	$('.check').click(function(){
  		$(this).toggleClass('lpchecked');
	 });
	*/
	
	$("#city_search_input").tokenInput("/wp-content/themes/ListingPressArtemis/template/lookup_ajax.php?in=city", {
		hintText: "Searching for homes is easy! Just start typing the cities you want to search in.",
        noResultsText: "Unfortunately, there aren't any listings in this city.",
        searchingText: "Searching...",
        classes: {
        	tokenList: "token-input-list-facebook",
            token: "token-input-token-facebook",
            tokenDelete: "token-input-delete-token-facebook",
            selectedToken: "token-input-selected-token-facebook",
            highlightedToken: "token-input-highlighted-token-facebook",
            dropdown: "token-input-dropdown-facebook",
            dropdownItem: "token-input-dropdown-item-facebook",
            dropdownItem2: "token-input-dropdown-item2-facebook",
            selectedDropdownItem: "token-input-selected-dropdown-item-facebook",
            inputToken: "token-input-input-token-facebook"
        }
	});
  	
	function listingsView() {
		var v = $(this);
	 	var bg = v.css('background-position');
	 	if( v.attr('id') === 'thumbview' ) {
	 		if( bg === '0px -16px' ) {
	 			v.css('background-position','0px 0px');
  				$('#listview').css('background-position','0px -16px');
				$('#listingAjaxContainer').removeClass('listViewLayout').addClass('thumbViewLayout');
	 		}
	 	}
	 	else if ( v.attr('id') === 'listview' ) {
	 		if( bg === '0px -16px' ) {
	 			v.css('background-position','0px 0px');
  				$('#thumbview').css('background-position','0px -16px');
				$('#listingAjaxContainer').removeClass('thumbViewLayout').addClass('listViewLayout');
	 		}
	 	}
	}
	$('.changeListingView').click(listingsView);
	
});
