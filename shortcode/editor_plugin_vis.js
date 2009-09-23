/**
 * ListingPress TinyMCE Plugin
 */

(function() {
	var DOM = tinymce.DOM;
	
	tinymce.create('tinymce.plugins.ListingPressVis', {
		init: function(ed, url) {
			ed.addButton('listingpress_vis', {
				title: 'listingpress_vis',
				image: url + '/img/chart_bar.png',
				onclick: function() {
					jQuery('#listingpress_visualizations').dialog('destroy');
					
					jQuery('#listingpress_visualizations').dialog({
						buttons: {
							"Embed": function() {
								var shortcode = '[lp_vis ';
								shortcode += 'name="' + jQuery('#lp_vis_select').val() + '" ]';
								ed.execCommand('mceInsertContent', 0, shortcode);
								jQuery(this).dialog('close');
							},
							"Cancel": function() {
								jQuery(this).dialog('close');
							}
						},
						height: 200,
						modal: true,
						position: 'center',
						resizable: false,
						title: '<img src="' + url + '/img/chart_bar.png" width="20" height="20" /> ListingPress Embed Visualizations',
						width: 300
					});
					
					
				}
			});
		},
		getInfo: function() {
			return {
				longname: 'ListingPress Visualization Plugin',
				author: 'Jason Benesch',
				authorurl: 'http://listingpress.com',
				infourl: 'http://listingpress.com',
				version: '3.0'
			};
		}
	});

	tinymce.PluginManager.add('listingpress_vis', tinymce.plugins.ListingPressVis);

})();