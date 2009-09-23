/**
 * ListingPress TinyMCE Plugin
 */

(function() {
	var DOM = tinymce.DOM;
	
	tinymce.create('tinymce.plugins.ListingPress', {
		init: function(ed, url) {
			ed.addButton('listingpress', {
				title: 'listingpress',
				image: url + '/img/listingpress.png',
				onclick: function() {
					jQuery('#listingpress_shortcode').dialog('destroy');
					
					jQuery('#listingpress_shortcode').dialog({
						buttons: {
							"Embed": function() {
								var shortcode = '[listingpress ';
								shortcode += 'citystate="' + jQuery('#citystate').val() + '" ';
								shortcode += 'beds="' + jQuery('#beds').val() + '" ';
								shortcode += 'baths="' + jQuery('#baths').val() + '" ';
								shortcode += ']';
								ed.execCommand('mceInsertContent', 0, shortcode);
								jQuery(this).dialog('close');
							},
							"Cancel": function() {
								jQuery(this).dialog('close');
							}
						},
						height: 400,
						modal: true,
						position: 'center',
						resizable: false,
						title: '<img src="' + url + '/img/listingpress.png" width="20" height="20" /> ListingPress Embed Listings',
						width: 600
					});
				}
			});
		},
		getInfo: function() {
			return {
				longname: 'ListingPress Plugin',
				author: 'Jason Benesch',
				authorurl: 'http://listingpress.com',
				infourl: 'http://listingpress.com',
				version: '3.0'
			};
		}
	});
	
	tinymce.PluginManager.add('listingpress', tinymce.plugins.ListingPress);

})();